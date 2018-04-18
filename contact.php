<?php
$name = $_POST['name'];
$visitor_email = $_POST['email'];
$message = $_POST['message'];

//Validate first
if(empty($name)||empty($visitor_email))
{
    echo "Please enter both your name and your email address into the form.";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Please re-enter your email.";
    exit;
}

$email_from = $visitor_email;//<== update the email address
$email_subject = "New Email from the contact page";
$email_body = "You have received an email from $name.\n".
    "Their message is:\n $message \n \n \n";

$to = "olyy.crook@gmail.com";//<== update the email address
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
header('Location: http://www.olyy.co.uk');


// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}

?>
