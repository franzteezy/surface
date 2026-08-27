<?php

header("Access-Control-Allow-Headers", "Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");
$fields = json_decode(file_get_contents('php://input'), true);
$tenant = $fields['tenant'] ?? '';
$tenant_key = $fields['tenant_key'] ?? '';
$tenant_id = md5($tenant);
$file_string = guidv4();

$hash = "8bc88cf3d8f32ab24d46b0fe24671ff7";
$iv = "4d46b0fe24671ff7";
$decifered_key = openssl_decrypt($tenant_key, "AES-256-CBC", md5($tenant . $hash), 0, $iv);
$now = new DateTime();
$validity = new DateTime($decifered_key);

if (!$tenant) {
    $data = [
        'success' => true
    ];
    echo json_encode($data);
    die();
}

if ($validity > $now) {
    if(!isset($fields["file"]['base64'])){
        $data = [
            'success' => false,
            'data' => [
                'file' => null
            ]
        ];
        echo json_encode($data);
        die();
    }

    if (!file_exists('/usr/share/nginx/html/bucket/' . $tenant_id)) {
        mkdir('/usr/share/nginx/html/bucket/' . $tenant_id, 0777, true);
    }

    $ifp = fopen('/usr/share/nginx/html/bucket/' . $tenant_id . '/' . $file_string, 'wb');
    $data = explode(',', $fields["file"]['base64']);
    fwrite($ifp, base64_decode($data[1]));
    fclose($ifp);

    $data = [
        'success' => true,
        'data' => [
            'file' => $file_string
        ]
    ];
    echo json_encode($data);
    die();
} else {
    header("HTTP/1.1 422 Unprocessable Entity");
    $data = [
        'success' => false,
        'data' => [
            'message' => 'Invalid key.'
        ]
    ];
    echo json_encode($data);
    die();
}

function getRealPOST()
{
    $pairs = explode("&", file_get_contents("php://input"));
    $vars = array();
    foreach ($pairs as $pair) {
        $nv = explode("=", $pair);
        $name = urldecode($nv[0]);
        $value = urldecode($nv[1]);
        $vars[$name] = $value;
    }
    return $vars;
}

function guidv4($data = null)
{
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
