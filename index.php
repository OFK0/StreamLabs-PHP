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
    'client_id' => '', // YOUR APP CLIENT ID
    'client_secret' => '', // YOUR APP CLIENT SECRET
    'redirect_url' => 'http://localhost:3333/', // YOUR APP REDIRECT URL
    'app_name' => 'OFKTEST', // OPTIONAL
    'api_version' => 'v1.0'
];

$streamLabs = new StreamLabs($streamLabsConfig);

if (!isset($_GET['code'])) {

    $authorizeLink = $streamLabs->authorize('donations.create donations.read');

    echo '<a href="' . $authorizeLink . '">Log-in with StreamLabs!</a>';

} else {

    $initialToken = $streamLabs->token($_GET['code']);

    //$refreshToken = $streamLabs->token(null, 'refresh_token', $streamLabs->token->refresh_token);

    //$user = $streamLabs->user();

    $sendDonate = $streamLabs->post_donate('Ömer', 'Selamlarrrr!', 'kucukomerf@gmail.com', 1.01);

    $donations = $streamLabs->donations();

    print_r($donations);

}