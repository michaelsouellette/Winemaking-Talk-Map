<?php
if($_POST['problemsubmit']){

$your_email = 'michaelsouellette@gmail.com';  // Email to send message to

// quick way clean up incoming fields
foreach($_POST as $key => $value) $_POST[$key] = urldecode(trim($value));

// get form data into shorter variables
// each $_POST variable is named based on the form field's id value
$name    = $_POST['sender_name'];
$email   = $_POST['sender_email'];
$message = $_POST['message'];
$code    = $_POST['code'];

$errors  = array(); // array of errors

// basic validation
if ($name == '') {
  $errors[] = "Please enter your name";
}

if ($email == '') {
  $errors[] = "Please enter your email address";
} else if (strpos($email, '@') === false) {
  $errors[] = "Please enter a valid email address";
}

if ($message == '') {
  $errors[] = "Please enter a message to send";
}

if (sizeof($errors) == 0) {
  // only check the code if there are no other errors
  require_once 'securimage/securimage.php';
  $img = new Securimage;
  if ($img->check($code) == false) {
    $errors[] = "Incorrect security code entered";
  } // if the code checked is correct, it is destroyed to prevent re-use
}

if (sizeof($errors) > 0) {
  // if errors, send the error message
  echo'<div id="statusdisplay">
		<a href="index.php"><img src="images/btnclose.png" alt="Close Error Panel" class="button" align="right" /></a>
		<p>There was an error with your submission!  Please correct the following:<br />';
		foreach ($errors as $msg) { // Print each error.
		echo " - $msg<br />\n";
	}
		echo '</p><p>Please try again.</p><br />
		</div>';
} else {

$time = date('r');
$body = <<<EOD
Hi!

A message was sent to you from $name on $time.

Here is their message:

$message
EOD;

// send email
mail($your_email, "Wine Map Form Submission", $body, "From: $your_email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=ISO-8859-1\r\nMIME-Version: 1.0");

echo'<div id="statusdisplay">
		<a href="index.php"><img src="images/btnclose.png" alt="Close Error Panel" class="button" align="right" /></a>
		<p>The problem/suggestion has been sent to the map administrator.<br />
		</div>'; // send success indicator
}}
?>