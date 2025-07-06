<?php
include('../config/config.php');
include('../config/functions.php');

if (!isset($_SESSION['admin_username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./login_admin/login.php");
    exit;
}

function getCount($conn, $sql) {
    $result = $conn->query($sql);
    return ($result && $row = $result->fetch_assoc()) ? (int) array_values($row)[0] : 0;
}

// --- GET MONTH/YEAR FILTERS
$combined_month = $_GET['month_combined'] ?? date('n');
$combined_year  = $_GET['year_combined'] ?? date('Y');
$session_month  = $_GET['month_sessions'] ?? date('n');
$session_year   = $_GET['year_sessions'] ?? date('Y');
$service_month  = $_GET['month_services'] ?? date('n');
$service_year   = $_GET['year_services'] ?? date('Y');
$sub_month      = $_GET['month_subscriptions'] ?? date('n');
$sub_year       = $_GET['year_subscriptions'] ?? date('Y');

// --- DATE RANGES
$start_session  = "$session_year-" . str_pad($session_month, 2, '0', STR_PAD_LEFT) . "-01";
$end_session    = date("Y-m-t", strtotime($start_session));
$start_service  = "$service_year-" . str_pad($service_month, 2, '0', STR_PAD_LEFT) . "-01";
$end_service    = date("Y-m-t", strtotime($start_service));
$start_sub      = "$sub_year-" . str_pad($sub_month, 2, '0', STR_PAD_LEFT) . "-01";
$end_sub        = date("Y-m-t", strtotime($start_sub));
$start_combined = "$combined_year-" . str_pad($combined_month, 2, '0', STR_PAD_LEFT) . "-01";
$end_combined   = date("Y-m-t", strtotime($start_combined));

// --- SYSTEM VARIABLES
$today          = date('Y-m-d');
$seven_days_ago = date('Y-m-d', strtotime('-6 days'));

// --- OVERVIEW
$active_sessions    = getCount($conn, "SELECT COUNT(*) FROM sessions WHERE end_time IS NULL");
$completed_sessions = getCount($conn, "SELECT COUNT(*) FROM sessions WHERE end_time IS NOT NULL");
$avg_result         = $conn->query("SELECT AVG(total_time) as avg FROM sessions WHERE total_time IS NOT NULL");
$avg_duration       = ($avg_result && $r = $avg_result->fetch_assoc()) ? (int)$r['avg'] : 0;
$avg_duration_formatted = gmdate("H:i:s", $avg_duration);

// --- SESSION TIME BUCKETS
$less_30 = $between_30_60 = $more_60 = 0;
$dist = $conn->query("
  SELECT 
    SUM(CASE WHEN total_time < 1800 THEN 1 ELSE 0 END) as less_30,
    SUM(CASE WHEN total_time BETWEEN 1800 AND 3600 THEN 1 ELSE 0 END) as between_30_60,
    SUM(CASE WHEN total_time > 3600 THEN 1 ELSE 0 END) as more_60
  FROM sessions WHERE total_time IS NOT NULL
");
if ($dist && $row = $dist->fetch_assoc()) {
    $less_30       = $row['less_30'] ?? 0;
    $between_30_60 = $row['between_30_60'] ?? 0;
    $more_60       = $row['more_60'] ?? 0;
}

// --- SUBSCRIPTIONS
$new_subscribers = getCount($conn, "SELECT COUNT(*) FROM users WHERE subscription_start_date >= DATE_SUB(NOW(), INTERVAL 7 DAY) and subscription_type != 'none' ");
$active_subs     = getCount($conn, "SELECT COUNT(*) FROM users WHERE subscription_type != 'none' AND subscription_end_date > NOW()");
$expired_subs    = getCount($conn, "SELECT COUNT(*) FROM users WHERE subscription_type != 'none' AND subscription_end_date <= NOW()");
$subscription_types = [];
$res = $conn->query("SELECT subscription_type, COUNT(*) as count FROM users WHERE subscription_type != 'none' GROUP BY subscription_type");
while ($res && $r = $res->fetch_assoc()) {
    $subscription_types[] = $r;
}

// --- OCCUPANCY & PEAK HOURS
$total_seats = getCount($conn, "SELECT COUNT(*) FROM seats");
$occupancy_rate = $total_seats > 0 ? round(($active_sessions / $total_seats) * 100, 2) : 0;
$peak_usage = [];
$peak = $conn->query("SELECT HOUR(start_time) as hour, COUNT(*) as count FROM sessions GROUP BY HOUR(start_time)");
while ($peak && $p = $peak->fetch_assoc()) {
    $peak_usage[] = $p;
}

$selectedMonth = isset($_GET['selected_month']) ? (int)$_GET['selected_month'] : date('m');
$selectedYear = isset($_GET['selected_year']) ? (int)$_GET['selected_year'] : date('Y');

$startOfMonth = date("$selectedYear-$selectedMonth-01");
$endOfMonth = date("Y-m-t", strtotime($startOfMonth));

$start_session = $startOfMonth;
$end_session = $endOfMonth;
$start_service = $startOfMonth;
$end_service = $endOfMonth;
$start_sub = $startOfMonth;
$end_sub = $endOfMonth;

$isCurrentMonth = ($selectedYear == date('Y') && ($selectedMonth == date('m')));
$today = date('Y-m-d');
$seven_days_ago = date('Y-m-d', strtotime('-6 days'));

// --- SESSION REVENUE (FIXED WITH PROPER SUBSCRIPTION HANDLING) ---
$sessionByDate = [];
$sessionQuery = $conn->prepare("
    SELECT 
        DATE(s.end_time) as session_day,
        SUM(
            CASE 
                WHEN u.user_id IS NOT NULL 
                    AND u.subscription_type != 'none'
                    AND (s.end_time - INTERVAL s.total_time SECOND) >= u.subscription_start_date
                    AND (u.subscription_end_date IS NULL OR s.end_time <= u.subscription_end_date)
                THEN 0  -- Free session (covered by subscription)
                ELSE 
                    COALESCE(
                        (SELECT price 
                         FROM pricing 
                         WHERE type = 'hourly' 
                         AND duration_minutes <= CEIL(s.total_time / 60)
                         ORDER BY duration_minutes DESC 
                         LIMIT 1),
                        (SELECT price FROM pricing WHERE type = 'hourly' ORDER BY duration_minutes ASC LIMIT 1)
                    )
            END
        ) AS revenue
    FROM sessions s
    LEFT JOIN users u ON s.user_id = u.user_id
    WHERE s.end_time IS NOT NULL
        AND s.total_time IS NOT NULL
        AND s.end_time >= ?
        AND s.end_time < DATE_ADD(?, INTERVAL 1 DAY)
    GROUP BY session_day
");

$sessionQuery->bind_param("ss", $start_session, $end_session);
$sessionQuery->execute();
$q1 = $sessionQuery->get_result();

if (!$q1) {
    die("Session revenue query failed: " . $conn->error);
}

while ($r = $q1->fetch_assoc()) {
    $sessionByDate[$r['session_day']] = floatval($r['revenue']);
}

// Proper date filtering
$session_today = $sessionByDate[$today] ?? 0;
$session_7days = array_sum(array_filter($sessionByDate, 
    function($date) use ($seven_days_ago, $today) {
        return $date >= $seven_days_ago && $date <= $today;
    }, 
    ARRAY_FILTER_USE_KEY
));
$session_month_total = array_sum($sessionByDate);

// --- SERVICE REVENUE (WITH PREPARED STATEMENT) ---
$serviceByDate = [];
$serviceQuery = $conn->prepare("
    SELECT DATE(sr.requested_at) as day,
           SUM(sv.service_price * sr.quantity) as revenue
    FROM service_requests sr
    JOIN services sv ON sr.service_id = sv.service_id
    WHERE sr.status = 'approved'
        AND sr.requested_at >= ?
        AND sr.requested_at < DATE_ADD(?, INTERVAL 1 DAY)
    GROUP BY day
");

$serviceQuery->bind_param("ss", $start_service, $end_service);
$serviceQuery->execute();
$q2 = $serviceQuery->get_result();

while ($r = $q2->fetch_assoc()) {
    $serviceByDate[$r['day']] = floatval($r['revenue']);
}

$service_today = $serviceByDate[$today] ?? 0;
$service_7days = array_sum(array_filter($serviceByDate, 
    function($date) use ($seven_days_ago, $today) {
        return $date >= $seven_days_ago && $date <= $today;
    }, 
    ARRAY_FILTER_USE_KEY
));
$service_month_total = array_sum($serviceByDate);

// --- SUBSCRIPTION REVENUE (FIXED WITH PREPARED STATEMENT) ---
$subByDate = [];
$sub_month_total = 0;

$subQuery = $conn->prepare("
    SELECT 
        DATE(u.subscription_start_date) as signup_day,
        u.subscription_type,
        p.price
    FROM users u
    JOIN pricing p ON p.label = 
        CASE u.subscription_type
            WHEN '1_week' THEN '1 semaine'
            WHEN '2_weeks' THEN '2 semaines'
            WHEN '1_month' THEN '1 mois'
        END
    WHERE u.subscription_type != 'none'
        AND u.subscription_start_date >= ?
        AND u.subscription_start_date < DATE_ADD(?, INTERVAL 1 DAY)
");

$subQuery->bind_param("ss", $start_sub, $end_sub);
$subQuery->execute();
$q3 = $subQuery->get_result();

while ($row = $q3->fetch_assoc()) {
    $day = $row['signup_day'];
    $price = (float)$row['price'];
    
    if (!isset($subByDate[$day])) {
        $subByDate[$day] = 0;
    }
    $subByDate[$day] += $price;
    $sub_month_total += $price;
}

$sub_today = $subByDate[$today] ?? 0;
$sub_7days = array_sum(array_filter($subByDate, 
    function($date) use ($seven_days_ago, $today) {
        return $date >= $seven_days_ago && $date <= $today;
    }, 
    ARRAY_FILTER_USE_KEY
));

// --- COMBINED REVENUE (FIXED CALCULATIONS) ---
$combinedByDate = [];
$all_dates = array_unique(array_merge(
    array_keys($sessionByDate),
    array_keys($serviceByDate),
    array_keys($subByDate)
));

foreach ($all_dates as $date) {
    $combinedByDate[$date] = 
        ($sessionByDate[$date] ?? 0) + 
        ($serviceByDate[$date] ?? 0) + 
        ($subByDate[$date] ?? 0);
}

$combined_today = $combinedByDate[$today] ?? 0;
$combined_7days = array_sum(array_filter($combinedByDate, 
    function($date) use ($seven_days_ago, $today) {
        return $date >= $seven_days_ago && $date <= $today;
    }, 
    ARRAY_FILTER_USE_KEY
));
$combined_month_total = array_sum($combinedByDate);  // Fixed total calculation

// Update daily_revenue table
foreach ($all_dates as $date) {
    $session = $sessionByDate[$date] ?? 0;
    $service = $serviceByDate[$date] ?? 0;
    $subscription = $subByDate[$date] ?? 0;
    $total = $session + $service + $subscription;

    $stmt = $conn->prepare("
        INSERT INTO daily_revenue (revenue_date, session_revenue, service_revenue, subscription_revenue, total_revenue)
        VALUES (?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            session_revenue = VALUES(session_revenue),
            service_revenue = VALUES(service_revenue),
            subscription_revenue = VALUES(subscription_revenue),
            total_revenue = VALUES(total_revenue)
    ");
    $stmt->bind_param("sdddd", $date, $session, $service, $subscription, $total);
    $stmt->execute();
    $stmt->close();
}

include('../views/admin_statistique_view.php');
?>