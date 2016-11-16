<?php
require_once __DIR__.'\google-api-php-client-2.1.0\vendor\autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfig(__DIR__.'\google-api-php-client-2.1.0\oauth-credentials.json');
$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  $drive_service = new Google_Service_Drive($client);
  $files_list = $drive_service->files->listFiles(array())->getItems();
  echo json_encode($files_list);
} else {
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/DankMeals/oauth2callback.php';
  echo $redirect_uri;
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}