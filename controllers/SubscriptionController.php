<?php
require_once '../models/UserModel.php';
include('../config/config.php');
include('../config/functions.php');

class SubscriptionController {
    public function update() {
        if (!isset($_SESSION['admin_username']) || $_SESSION['role'] !== 'admin') {
            header("Location: ./login_admin/login.php");
            exit;
        }

        $userModel = new UserModel();
        $message = "";
        $user = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = intval($_POST['user_id']);
            $subscription = sanitizeInput($_POST['subscription']);
            $end_date = match ($subscription) {
                '1_week' => date("Y-m-d H:i:s", strtotime("+1 week")),
                '2_weeks' => date("Y-m-d H:i:s", strtotime("+2 weeks")),
                '1_month' => date("Y-m-d H:i:s", strtotime("+1 month")),
                default => null
            };
            $start_date = date("Y-m-d H:i:s");

$success = $userModel->updateSubscription($user_id, $subscription, $end_date, $start_date);

            $message = $success
                ? ($subscription === 'none'
                    ? "L'abonnement a été retiré. L'utilisateur est désormais un utilisateur normal."
                    : "Subscription updated successfully. New subscription ends on $end_date.")
                : "Error updating subscription.";

            $user = $userModel->getUserById($user_id);
        } elseif (isset($_GET['user_id'])) {
            $user_id = intval($_GET['user_id']);
            $user = $userModel->getUserById($user_id);
            if (!$user) {
                die("User not found.");
            }
        } else {
            die("User ID not provided.");
        }

        include '../views/update_subscription_view.php';
    }
}
