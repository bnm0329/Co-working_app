<?php
function getActiveMessage($conn) {
    $query = "SELECT message FROM message WHERE active = 1 LIMIT 1";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function notifyAdmin($token, $chatId) {
    $text = urlencode("🔔 Un utilisateur a demandé de l'assistance sur Co-villa.");
    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatId&text=$text";
    $response = file_get_contents($url);
    $result = json_decode($response, true);

    if (isset($result['ok']) && $result['ok']) {
        return "Veuillez patienter un instant, un administrateur va vous rejoindre.";
    } else {
        $error = $result['description'] ?? 'Erreur inconnue';
        return "❌ Erreur lors de l'envoi du message : $error";
    }
}
