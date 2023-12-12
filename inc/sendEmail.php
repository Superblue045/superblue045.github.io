<?php

// Replace this with your own email address
$siteOwnersEmail = 'bluemoun1113@gmail.com';

if ($_POST) {

   $name = trim(stripslashes($_POST['contactName']));
   $email = trim(stripslashes($_POST['contactEmail']));
   $subject = trim(stripslashes($_POST['contactSubject']));
   $contact_message = trim(stripslashes($_POST['contactMessage']));

   $error = array(); // Initialize an array to collect validation errors

   // Check Name
   if (strlen($name) < 2) {
      $error['name'] = "Your name must be at least 2 characters long. Please enter a valid name.";
   }

   // Check Email
   if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
      $error['email'] = "Please enter a valid email address.";
   }

   // Check Message
   if (strlen($contact_message) < 15) {
      $error['message'] = "Please enter a message with at least 15 characters.";
   }

   // Subject
   if ($subject == '') {
      $subject = "Contact Form Submission";
   }

   // Set Message
   $message = "Email from: " . $name . "<br />";
   $message .= "Email address: " . $email . "<br />";
   $message .= "Message: <br />";
   $message .= $contact_message;
   $message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

   // Set From: header
   $from =  $name . " <" . $email . ">";

   // Email Headers
   $headers = "From: " . $from . "\r\n";
   $headers .= "Reply-To: " . $email . "\r\n";
   $headers .= "MIME-Version: 1.0\r\n";
   $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

   if (empty($error)) {
      ini_set("sendmail_from", $siteOwnersEmail); // for Windows server
      $mail = mail($siteOwnersEmail, $subject, $message, $headers);

      if ($mail) {
         echo '<script>
                  Swal.fire({
                     title: "Success!",
                     text: "Your message has been sent successfully.",
                     icon: "success",
                     confirmButtonText: "OK"
                  });
               </script>';
      } else {
         echo '<script>
                  Swal.fire({
                     title: "Error!",
                     text: "Something went wrong. Please try again.",
                     icon: "error",
                     confirmButtonText: "OK"
                  });
               </script>';
      }
   } else {
      $response = "";
      foreach ($error as $errorMsg) {
         $response .= $errorMsg . "<br /> \n";
      }
      echo '<script>
               Swal.fire({
                  title: "Validation Error",
                  html: "' . $response . '",
                  icon: "error",
                  confirmButtonText: "OK"
               });
            </script>';
   }
}
?>
