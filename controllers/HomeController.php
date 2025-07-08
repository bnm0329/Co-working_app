<?php
include('./config/config.php');
require_once 'models/MessageModel.php';

if (!isset($_SESSION['admin_username'])) {
    header("Location: ./login_app/login.php");
    exit;
}
class HomeController
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['callAdmin']) && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            global $telegramBotToken, $telegramChatId;

            $message = urlencode("🔔 Un utilisateur a demandé de l'assistance sur Co-villa.");
            $url = "https://api.telegram.org/bot$telegramBotToken/sendMessage?chat_id=$telegramChatId&text=$message";

            $response = @file_get_contents($url);
            $result = json_decode($response, true);

            if (isset($result['ok']) && $result['ok']) {
                echo "✅ Veuillez patienter un instant, un administrateur va vous rejoindre.";
            } else {
                $error = $result['description'] ?? 'Erreur inconnue';
                echo "❌ Erreur lors de l'envoi du message : $error";
            }

            exit(); // Don't load the full view
        }

        // Traditional GET flow for the view
        $statusMessage = '';
        if (isset($_SESSION['statusMessage'])) {
            $statusMessage = $_SESSION['statusMessage'];
            unset($_SESSION['statusMessage']);
        }

        require './views/index_view.php';
    }
}

$notice = getActiveMessage($conn);
$statusMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['callAdmin'])) {
    $statusMessage = notifyAdmin($telegramBotToken, $telegramChatId);
    $_SESSION['statusMessage'] = $statusMessage;
    header("Location: index.php");
    exit;
}

if (isset($_SESSION['statusMessage'])) {
    $statusMessage = $_SESSION['statusMessage'];
    unset($_SESSION['statusMessage']);
}
$hourly_pricing = [];
$subscription_pricing = [];

$pricing_result = $conn->query("SELECT * FROM pricing ORDER BY type, duration_minutes ASC, price ASC");
while ($pricing_result && $row = $pricing_result->fetch_assoc()) {
    if ($row['type'] === 'hourly') {
        $hourly_pricing[] = $row;
    } elseif ($row['type'] === 'subscription') {
        $subscription_pricing[] = $row;
    }
}
