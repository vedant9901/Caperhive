<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../vendor/autoload.php";

$mail = new PHPMailer(true);
$repmail = new PHPMailer(true);

echo "<script>console.log('Debug Objects: ');</script>";


if(!empty($_POST)) {
	$name = $_POST["name"];
	$email = $_POST["email"];
	$subject = $_POST["subject"];
	$message = $_POST["message"];
	// $contact = $_POST["contact"];
	$messageDraft;
	$replymessage;
	$sendername = "Caperhive Technologies";
	// Form validation
	if(!empty($name) && !empty($email) && !empty($subject) && !empty($message)){

		// reCAPTCHA validation
		if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

			// Google secret API
			$secretAPIkey = '6LeiJNkbAAAAAHPazCPfm1mgBTWLMq34PDvbHBYG';

			// reCAPTCHA response verification
			$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretAPIkey.'&response='.$_POST['g-recaptcha-response']);

			// Decode JSON data
			$response = json_decode($verifyResponse);
				if($response->success){

					$toMail = "hello@caperhive.com";
					$header = "From: " . $name . "<". $email .">\r\n";
					$messageDraft = "Hey Team ! " .$name. " contacted us from website.Here is users message \n Message\n - " .$message. "\n\n\n Please reply back to this user on following details - \n " .$email. "Thanks";
					mail($toMail, $subject, $messageDraft, $header);

					$replyMail = $email;
					$replysubject = "Thank you for contacting us.";
					$replyheader = "From: <hello@caperhive.com>";
					$replymessage = "Hello , Thank you for contacting us someone from our team will get back to you soon.";
					mail($replyMail, $replysubject, $replymessage, $replyheader);

					// $response = array(
					// 	"status" => "alert-success",
					// 	"message" => "Your mail have been sent."
					// );
					echo "Your message is sent"; 
					header("Location: http://www.caperhive.com");
				} else {
					// $response = array(
					// 	"status" => "alert-danger",
					// 	"message" => "Robot verification failed, please try again."
					// );
					echo "Robot verification failed, please try again"; 

				}       
		} else{ 
			// $response = array(
			// 	"status" => "alert-danger",
			// 	"message" => "Plese check on the reCAPTCHA box."
			// );
			echo "Please check on the reCAPTCHA box"; 
		} 
	}  else{ 
		// $response = array(
		// 	"status" => "alert-danger",
		// 	"message" => "All the fields are required."
		// );
		echo "All the fields are required."; 
	}
} 
?>
