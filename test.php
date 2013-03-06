<?php

require_once 'Mail.php';

$wgSMTP = array(
		'host' => 'tls://smtp.sendgrid.net',
		'IDHost' => 'heroku.com',
		'port' => 587,
		'username' => getenv("SENDGRID_USERNAME"),
		'password' => getenv("SENDGRID_PASSWORD"),
		'auth' => true
);

$subject = 'Thanks for Registering!';

$message = "You've regestered for an account at Logos<br /><br />

Click this activation link and then login.<br /><br />

http://localhost:8080/Logos/functions/account.php?key=<br /><br />

Thanks!<br />
Site admin<br /><br />

This is an automated response, please do not reply!";

$from = 'admin@projectlogos.com';
$to = 'matkle414@gmail.com';

echo mail($to, $subject, $message, $from);

$url = 'http://sendgrid.com/';
$user = getenv("SENDGRID_USERNAME");
$pass = getenv("SENDGRID_PASSWORD");

$params = array(
    'api_user'  => $user,
    'api_key'   => $pass,
    'to'        => $to,
    'subject'   => $subject,
    'html'      => $message,
    'text'      => $message,
    'from'      => $from
  );

$request =  $url.'api/mail.send.json';

// Generate curl request
$session = curl_init($request);
// Tell curl to use HTTP POST
curl_setopt ($session, CURLOPT_POST, true);
// Tell curl that this is the body of the POST
curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
// Tell curl not to return headers, but do return the response
curl_setopt($session, CURLOPT_HEADER, false);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// obtain response
$response = curl_exec($session);
curl_close($session);

// print everything out
print_r($response);

?>