<?php
require 'C:\Users\Matta\Desktop\XAMP\htdocs\article\client\assets\vendor\autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
$key = "this is my generated key asfasdasd5255"; // 32 bytes = 256-bit key
 // Change this to a strong secret key
// echo "Generated Secret Key: " . $key;

function generate_jwt($user_id, $user_name)
{
    global $key;
    $payload = [
        'iat' => time(),
        'exp' => time() + 3600, // 1 hour expiry
        'data' => [
            'user_id' => $user_id,
            'user_name' => $user_name
        ]
    ];
    return JWT::encode($payload, $key, 'HS256');
}

function validate_jwt($token)
{
    global $key;
    try {
        return JWT::decode($token, new Key($key, 'HS256'));
    } catch (Exception $e) {
        return false;
    }
}
