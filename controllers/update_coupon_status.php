<?php
include('../config/config.php');
include('../config/functions.php');

if (!isset($_SESSION['admin_username'])) {
    header("Location: ./login_admin/login.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./login_admin/login.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $coupon_id = intval($_POST['coupon_id']);
    $new_status = $conn->real_escape_string($_POST['new_status']);

    $sql = "UPDATE coupons SET status = '$new_status' WHERE coupon_id = $coupon_id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: bulk_add_coupons.php?status_updated=1");
        exit;
    } else {
        echo "Error updating coupon status: " . $conn->error;
    }
}
?>
