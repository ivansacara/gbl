<?php
if (
  isset($_POST['name']) &&
  isset($_POST['email']) &&
  isset($_POST['phone']) &&
  isset($_POST['solution']) &&
  isset($_POST['message']) &&
  filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
) {
  $test = "/(content-type|bcc:|cc:|to:)/i";
  foreach ($_POST as $key => $val) {
    if (preg_match($test, $val)) {
      http_response_code(400);
      exit;
    }
  }

  $name = htmlspecialchars($_POST['name']);
  $fromEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $phone = htmlspecialchars($_POST['phone']);
  $solution = htmlspecialchars($_POST['solution']);
  $message = nl2br(htmlspecialchars($_POST['message']));

  $subject = "New Inquiry: $solution";
  $headers =
    'MIME-Version: 1.0' . "\r\n" .
    'Content-type: text/html; charset=UTF-8' . "\r\n" .
    'From: ' . $name . ' <' . $fromEmail . '>' . "\r\n" .
    'Sender: ' . $fromEmail . "\r\n" .
    'Reply-To: ' . $fromEmail . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

  $messageContent = "
    <strong>Name:</strong> $name<br>
    <strong>Email:</strong> $fromEmail<br>
    <strong>Phone:</strong> $phone<br>
    <strong>Solution:</strong> $solution<br><br>
    <strong>Message:</strong><br>$message
  ";

  mail("ivansacara@gmail.com", $subject, $messageContent, $headers);
} else {
  http_response_code(400);
}
?>