<?php
include('../config/config.php');
include('../config/functions.php');

$user = null;
$error = '';
$requestMessage = '';
$activeSeatNumber = 'N/A';
$affiliate = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = sanitizeInput($_POST['username']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['user_id'];
        $name = $user['full_name'] ?? $user['username'];

        // Optional: check session
        $activeQuery = "
            SELECT s.*, st.seat_number 
            FROM sessions s 
            JOIN seats st ON s.seat_id = st.seat_id 
            WHERE s.user_id = ? AND s.end_time IS NULL 
            LIMIT 1";
        $sessionStmt = $conn->prepare($activeQuery);
        $sessionStmt->bind_param("i", $user_id);
        $sessionStmt->execute();
        $activeResult = $sessionStmt->get_result();
        $seatMsg = "";
        if ($activeResult && $activeResult->num_rows > 0) {
            $activeSession = $activeResult->fetch_assoc();
            $seatMsg = "Vous êtes déjà connecté à la place <strong>{$activeSession['seat_number']}</strong>.";
        }

        // Optional: check affiliate
        $affQuery = "SELECT * FROM affiliate WHERE owner_user_id = ?";
        $affStmt = $conn->prepare($affQuery);
        $affStmt->bind_param("i", $user_id);
        $affStmt->execute();
        $affResult = $affStmt->get_result();
        $affMsg = "";
        if ($affResult && $affResult->num_rows > 0) {
            $affiliate = $affResult->fetch_assoc();
            $affMsg = "<br>Vous êtes affilié à: <strong>{$affiliate['affiliate_name']}</strong>";
        }

        echo "✅ Bienvenue, <strong>$name</strong>!<br>$seatMsg$affMsg";
    } else {
        echo "<span style='color:red;'>❌ Utilisateur introuvable. Veuillez vérifier le nom d'utilisateur ou l'e-mail.</span>";
    }
} else {
    echo "<span style='color:red;'>Requête invalide.</span>";
}



$limit = 5;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;
$totalPages = 0;
$resultSessions = false;

if ($user) {
    $user_id = $user['user_id'];

    // Count total rows
    $countQuery = "SELECT COUNT(*) as total FROM sessions WHERE user_id = $user_id AND end_time IS NOT NULL";
    $countResult = $conn->query($countQuery);
    $totalRows = $countResult ? (int)$countResult->fetch_assoc()['total'] : 0;
    $totalPages = ceil($totalRows / $limit);

    // Fetch paginated sessions
    $querySessions = "SELECT * FROM sessions WHERE user_id = $user_id AND end_time IS NOT NULL ORDER BY start_time DESC LIMIT $limit OFFSET $offset";
    $resultSessions = $conn->query($querySessions);

    $services = [];
    $queryServices = "SELECT * FROM services";
    $resultServices = $conn->query($queryServices);
    if ($resultServices) {
        while ($row = $resultServices->fetch_assoc()) {
            $services[] = $row;
        }
    }
}
?>
