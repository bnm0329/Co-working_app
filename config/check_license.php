<?php
function check_keygen_license($license_key) {
    // Allow login page to bypass
    $loginPath = 'admin/login_admin/login.php';
    $currentPath = str_replace('\\', '/', $_SERVER['PHP_SELF']);
    if (substr($currentPath, -strlen($loginPath)) === $loginPath) {
        return true;
    }

    // Define encryption key (keep this private and constant)
    $secret_key = 'mySuperSecretKey2024'; // CHANGE THIS and keep it hidden!
    $licenseFile = __DIR__ . '/license.json.enc';

    // Try API validation first (if online)
    $isOnline = @fsockopen("api.keygen.sh", 443, $errno, $errstr, 3);
    if ($isOnline) {
        fclose($isOnline);

        // Online: Validate with Keygen
        $account_id = '6679187c-84b7-4a22-80cc-2c5349b27b7f';
        $token = 'admin-37b0e2e8473543894006f047d5273195c70408496d0dc469036502ffb2f628f4v3';
        $domain = $_SERVER['SERVER_NAME'];

        $payload = json_encode([
            'meta' => [
                'key' => $license_key,
                'scope' => [
                    'fingerprint' => $domain
                ]
            ]
        ]);

        $headers = [
            "Authorization: Bearer $token",
            "Content-Type: application/vnd.api+json"
        ];

        $ch = curl_init("https://api.keygen.sh/v1/accounts/$account_id/licenses/actions/validate-key");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => true,
            CURLOPT_TIMEOUT => 10,
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result, true);

        if (!isset($response['data'])) {
            die("❌ Licence invalide. Contactez le support.");
        }

        $licenseData = $response['data']['attributes'];
        $expires_at = substr($licenseData['expiry'], 0, 10);
        $today = date('Y-m-d');

        if ($today >= $expires_at) {
            die("❌ Cette licence a expiré le $expires_at.");
        }

        // Save encrypted license info
        $plainData = json_encode([
            'key' => $license_key,
            'expires_at' => $expires_at,
            'hash' => hash_hmac('sha256', $license_key . $expires_at, $secret_key)
        ]);

        $encrypted = openssl_encrypt($plainData, 'AES-256-CBC', $secret_key, 0, substr(hash('sha256', $secret_key), 0, 16));
        file_put_contents($licenseFile, $encrypted);

        return true;
    }

    // Offline: fallback to encrypted license file
    if (!file_exists($licenseFile)) {
        die("❌ Vérification de licence impossible (hors ligne et aucune licence locale valide).");
    }

    $encrypted = file_get_contents($licenseFile);
    $decrypted = openssl_decrypt($encrypted, 'AES-256-CBC', $secret_key, 0, substr(hash('sha256', $secret_key), 0, 16));
    $data = json_decode($decrypted, true);

    if (!$data || !isset($data['key'], $data['expires_at'], $data['hash'])) {
        die("❌ Fichier de licence corrompu.");
    }

    // Verify integrity
    $expectedHash = hash_hmac('sha256', $data['key'] . $data['expires_at'], $secret_key);
    if ($data['hash'] !== $expectedHash) {
        die("❌ Licence falsifiée détectée.");
    }

    // Check expiry
    $today = date('Y-m-d');
    if ($today >= $data['expires_at']) {
        die("❌ Licence expirée le {$data['expires_at']}.");
    }

    return true;
}

