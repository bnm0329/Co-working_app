var telegramBotToken = "<?php echo $telegramBotToken; ?>";
var chatId = "<?php echo $telegramChatId; ?>";
function sendTelegramNotification(actionType, serviceName, quantity) {
    var activeSeat = document.getElementById("active-seat").value || "Seat not available";
    var username = "<?php echo htmlspecialchars($user['username']); ?>";
    var fullName = "<?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>";
    var message = "Seat: " + activeSeat + "\nUsername: " + username + "\nName: " + fullName;
    if (serviceName) {
        message += "\nService Requested: " + serviceName;
    }
    if (quantity) {
        message += "\nQuantity: " + quantity;
    }
    message += "\nAction: " + actionType;
    // ...rest of the JS logic...
}
