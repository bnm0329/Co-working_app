<?php
function displayMessage($title, $message) {
    echo "<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta name='viewport' content='width=device-width, initial-scale=0.85'>
    <meta charset='UTF-8'>
    <title>{$title}</title>
    <link rel='stylesheet' href='views/assets/css/main.css'>
    <style>
        li { list-style: none; }
        .confirm-btn {
            display: inline-block;
            background: #2A5CAA;
            color: white !important;
            padding: 15px 40px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            margin: 25px 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .confirm-btn:hover {
            background: #1a406b;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>
    <div class='logo-container'>
        <img class='logo' src='views/assets/images/logos.png' alt='Logo'>
    </div>
    <div class='container'>
        <div class='message-container success-message'>
            {$message}
        </div>
    </div>
</body>
</html>";
    exit;
}

function renderCouponBlock($coupons) {
    return "
    <div class='coupon-container'>
        <h4>🔑 Coupon d'accès Internet</h4>
        <div class='coupon-item'>
            <h4>💻 Ordinateur</h4>
            <strong>{$coupons[0]['code']}</strong>
        </div>
        <div class='coupon-item'>
            <h4>📱 Smartphone</h4>
            <strong>{$coupons[1]['code']}</strong>
        </div>
        <p class='warning-note'>⚠️ Chaque coupon est unique et valable pour un seul appareil</p>
    </div>";
}
