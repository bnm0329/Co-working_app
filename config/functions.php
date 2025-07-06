<?php
if (session_status() === PHP_SESSION_NONE) {
    include('config.php');
}


function getUserCountByType($conn, $user_type) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE user_type = ?");
    if ($stmt) {
        $stmt->bind_param("s", $user_type);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return (int)$data['count'];
    }
    return 0;
}


function generateCoupon($conn, $first_name, $last_name, $user_type) {
    $first_name = strtolower(trim($first_name));
    $last_name  = strtolower(trim($last_name));
    $first_name = str_replace(' ', '-', $first_name);
    $last_name  = str_replace(' ', '-', $last_name);
    
    switch (strtolower($user_type)) {
        case 'freelancer':
        case 'free-lancer':
            $type_letter = 'F';
            break;
        case 'etudiant':
            $type_letter = 'E';
            break;
        case 'lyceen':
        case 'lycéen':
            $type_letter = 'L';
            break;
        default:
            $type_letter = 'X';
            break;
    }
    
    $currentCount = getUserCountByType($conn, $user_type);
    $nextCount = $currentCount + 1;
    $number = str_pad($nextCount, 2, '0', STR_PAD_LEFT);
    
    return strtoupper("{$first_name}-{$last_name}-{$type_letter}{$number}");
}


function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
function sendEmail($to, $subject, $message) {
        require_once 'PHPMailer/src/PHPMailer.php';
        require_once 'PHPMailer/src/SMTP.php';
        require_once 'PHPMailer/src/Exception.php';
        
      
    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->Port = SMTP_PORT;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_ENCRYPTION;
        
        $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->isHTML(false);

        return $mail->send();
    } catch (Exception $e) {
        error_log("Erreur d'envoi d'email: " . $e->errorMessage());
        return false;
    }
}
?>
