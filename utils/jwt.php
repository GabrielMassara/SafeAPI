<?php
// utils/jwt.php
function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data) {
    return base64_decode(strtr($data, '-_', '+/'));
}

function jwt_encode($payload, $key) {
    $header = ['alg' => 'HS256', 'typ' => 'JWT'];
    $segments = [];
    $segments[] = base64url_encode(json_encode($header));
    $segments[] = base64url_encode(json_encode($payload));
    $signing_input = implode('.', $segments);
    $signature = hash_hmac('sha256', $signing_input, $key, true);
    $segments[] = base64url_encode($signature);
    return implode('.', $segments);
}

function jwt_decode($token, $key) {
    $parts = explode('.', $token);
    if (count($parts) !== 3) return false;
    list($header64, $payload64, $sig64) = $parts;

    $signature = base64url_decode($sig64);
    $valid_sig = hash_hmac('sha256', "$header64.$payload64", $key, true);

    if (!hash_equals($signature, $valid_sig)) return false;
    $payload = json_decode(base64url_decode($payload64), true);

    if (isset($payload['exp']) && time() > $payload['exp']) return false;

    return $payload;
}
