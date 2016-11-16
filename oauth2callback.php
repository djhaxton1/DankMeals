<?php
require_once __DIR__.'\google-api-php-client-2.1.0\vendor\autoload.php';
session_start();

$client = new Google_Client();
$client->setAuthConfigFile(__DIR__.'\google-api-php-client-2.1.0\oauth-credentials.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/DankMeals/oauth2callback.php');
$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . 'DankMeals/';
  echo $redirect_uri;
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
