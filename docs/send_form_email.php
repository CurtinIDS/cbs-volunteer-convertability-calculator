<?php
if(isset($_POST['email_from'])) {
 
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
      
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
 
 
    // validation expected data exists
    if(!isset($_POST['sender_name']) ||
        !isset($_POST['email_from']) ||
        !isset($_POST['telephone']) ||
        !isset($_POST['subject']) ||
        !isset($_POST['message'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
 
 
    $sender_name = $_POST['sender_name']; // required
    $email_from = $_POST['email_from']; // required
    $telephone = $_POST['telephone']; // not required
    $subject = $_POST['subject']; // required
    $message = $_POST['message']; // required
 
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$sender_name)) {
    $error_message .= 'The Name you entered does not appear to be valid.<br />';
  }
 
  if(!preg_match($string_exp,$subject)) {
    $error_message .= 'The Subject you entered does not appear to be valid.<br />';
  }
 
  if(strlen($message) < 2) {
    $error_message .= 'The Comments you entered do not appear to be valid.<br />';
  }
 
  if(strlen($error_message) > 0) {
    died($error_message);
  }
 

// change variable to destination email
    $email_to = "research@angliss.edu.au";
    $email_subject = "Volunteer Calculator - Contact Form Submission";


//    $email_message = "A message has been submitted from the Volunteer Calculator project website.\n";
    
 
    $email_message .= "Name:  ".clean_string($sender_name)."\n";
    $email_message .= "Email:  ".clean_string($email_from)."\n";
  if(strlen($telephone) > 8) {
    $email_message .= "Tel:  ".clean_string($telephone)."\n";
  }
    $email_message .= "Subject:  ".clean_string($subject)."\n\n";
    $email_message .= "Message:\n".clean_string($message)."\n";
 
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  

// confirmation text


echo "<html>
<head>
  <title>Volunteer Convertibility Calculator</title>
  <meta name='keywords' content='Volunteer Calculator'>
  <meta http-equiv='content-type'
 content='text/html; charset=windows-1252'>
  <link rel='stylesheet' type='text/css'
 href='style/style.css' title='style'>
</head>
<body>
<div id='main'>
<div id='header'>
<div id='logo'>
<div id='logo_text'>
<h1><a href='index.html'><span class='logo_colour'>The
Volunteer Convertibility Calculator</span></a></h1>
<h2>Creating and sustaining a strong future for volunteering in
Australia</h2>
</div>
</div>
<div id='menubar'>
<ul id='menu'>
  <li><a href='index.html'>Home</a></li>
  <li><a href='calc.html'>The Calculator</a></li>
  <li><a href='faqs.html'>FAQS</a></li>
  <li class='selected'><a href='contact.html'>Contact
Us</a></li>
</ul>
</div>
</div>
<div id='content_header'></div>
<div id='site_content'><br>
<div id='content'>
<h1>Your message has been sent</h1>
<br>
<p>Thank you for contacting us. We will be in touch with you very
soon.</p>
</div>
</div>
<div id='content_footer'></div>
<div id='footer'> Australian Research Council (ARC) -
Creating and sustaining a strong future for volunteering in Australia </div>
</div>
</body>
</html>
";
 
}
?>