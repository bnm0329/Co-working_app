<?php
function emailExists($conn, $email) {
    $query = "SELECT username, email FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
function registerUser($conn, $first_name, $last_name, $phone_number, $email, $username, $user_type) {
    
    $query = "INSERT INTO users (first_name, last_name, phone_number, email, username, user_type)
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssss", $first_name, $last_name, $phone_number, $email, $username, $user_type);
    return $stmt->execute();
}
function getUserByIdentifier($conn, $identifier) {
    $query = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
function getUserByUsername($conn, $username) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function hasActiveSession($conn, $user_id) {
    $query = "SELECT * FROM sessions WHERE user_id = ? AND end_time IS NULL";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}
class UserModel {
    private $conn;

    public function __construct() {
        include '../config/config.php';
        $this->conn = $conn;
    }

    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

   public function updateSubscription($user_id, $subscription, $end_date, $start_date) {
    global $conn;

    $stmt = $conn->prepare("UPDATE users SET subscription_type = ?, subscription_start_date = ?, subscription_end_date = ? WHERE user_id = ?");
    $stmt->bind_param("sssi", $subscription, $start_date, $end_date, $user_id);

    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

}



