<?php

/* 
 * 
 * Author: omerfarukucuk.com - Ömer Faruk Küçük 
 * github.com/omerfarukucuk
 * 
 * */

error_log(E_ALL);

require 'streamlabs.class.php';

/* 
 * Please fill that Streamlabs config.
*/
$streamLabsConfig = [
    'client_id' => 'pW5B50g2DKewbxWQqEFtTLAZpPcuZkBmNgcBGLAB', // YOUR APP CLIENT ID
    'client_secret' => 'oLDp1oB3SoAAH2qRGd7qrBxaGmqqUe20GUeyJ90o', // YOUR APP CLIENT SECRET
    'redirect_url' => 'http://localhost:3333/', // YOUR APP REDIRECT URL
    'app_name' => 'OFKTEST', // OPTIONAL
    'api_version' => 'v1.0'
];

$streamLabs = new StreamLabs($streamLabsConfig);

if (!isset($_GET['code'])) {

    $authorizeLink = $streamLabs->authorize('legacy.token donations.create donations.read');

    echo '<a href="' . $authorizeLink . '">Log-in with StreamLabs!</a>';

} else {

    $token = $streamLabs->token($_GET['code']);

    print_r($streamLabs);
    print_r($token);
    print_r($streamLabs);

}