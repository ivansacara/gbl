<?php

$secret   = "6Leocg8aAAAAAI1rISpeD4qNYU64lXdH1fFXNTtg";
$response = null;

require_once './classes/recaptcha/src/autoload.php';

$recaptcha = new \ReCaptcha\ReCaptcha($secret);
$resp      = $recaptcha->setExpectedHostname('gbl-factory.com')
  ->verify($_POST["g-recaptcha-response"], $_SERVER["REMOTE_ADDR"]);
if (!$resp->isSuccess()) {
  $errors = $resp->getErrorCodes();
  echo '<div class="err">' . $errors[0] . '</div>';
  exit(0);
} else {
  $response = 'OK';
}
