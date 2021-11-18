<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

//Load Composer's autoloader
require 'vendor/autoload.php';

$errorMSG = "";
if ($_POST["form"] == "contactForm"){
    $form = "Contact Form";
} elseif ($_POST["form"] == "careerForm") {
    $form = "Career Form";
} elseif ($_POST["form"] == "appointmentRequestForm") {
    $form = "Appointment Request";
}

$mail = new PHPMailer();

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    // $mail->isSMTP();                                            //Send using SMTP
    // $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    // $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    // $mail->Username   = 'tlentz1008@gmail.com';                     //SMTP username
    // $mail->Password   = 'C7Ltf3q7Vn2p';                               //SMTP password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    // $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->SetFrom('tlentz1008@gmail.com', 'Complete Dentistry'); //Name is optional
    $mail->AddAddress('tlentz1008@gmail.com');
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == UPLOAD_ERR_OK) {
        $mail->AddAttachment($_FILES['resume']['tmp_name'], $_FILES['resume']['name']);
    }

    // NAME
    if (empty($_POST["name"])) {
        $errorMSG = "Name is required ";
    } else {
        $name = $_POST["name"];
    }

    // EMAIL
    if (empty($_POST["email"])) {
        $errorMSG .= "Email is required ";
    } else {
        $email = $_POST["email"];
    }

    // MSG SUBJECT
    if ($form == "Contact Form") {
        if (empty($_POST["msg_subject"])) {
            $errorMSG .= "Subject is required ";
        } else {
            $msg_subject = $_POST["msg_subject"];
        }
    }

    // Phone Number
    if (empty($_POST["phone_number"])) {
        $errorMSG .= "Phone Number is required ";
    } else {
        $phone_number = $_POST["phone_number"];
    }

    // Position
    if ($form == "Career Form") {
        if (empty($_POST["position"])) {
            $errorMSG .= "Position is required ";
        } else {
            $position = $_POST["position"];
        }
    }

    $message = $_POST["message"];
    $resume = $_POST["resume"];

    // Appointment Request Form Fields
    $patient_status = $_POST["patient_status"];
    $dob = $_POST["dob"];
    $insurance_name = $_POST["insurance_name"];
    $subscriber_name = $_POST["subscriber_name"];
    $subscriber_id = $_POST["subscriber_id"];
    $group_number = $_POST["group_number"];
    $preferred_date = $_POST["preferred_date"];
    $preferred_time = $_POST["preferred_time"];

    // prepare email body text
    $Body = "<html>";
    $Body .= "<strong>Name: </strong>";
    $Body .= $name;
    $Body .= "<br/>";
    $Body .= "<strong>Email: </strong>";
    $Body .= $email;
    $Body .= "<br/>";
    $Body .= "<strong>Phone Number: </strong>";
    $Body .= $phone_number;
    $Body .= "<br/>";
    if ($dob) {
        $Body .= "<strong>Date of Birth: </strong>";
        $Body .= $dob;
        $Body .= "<br/>";
    }
    if ($patient_status) {
        $Body .= "<strong>Patient Status: </strong>";
        $Body .= $patient_status;
        $Body .= "<br/>";
    }
    if ($position) {
        $Body .= "<strong>Position of Interest: </strong>";
        $Body .= $position;
        $Body .= "<br/>";
    }
    if ($msg_subject) {
        $Body .= "<strong>Subject: </strong>";
        $Body .= $msg_subject;
        $Body .= "<br/>";
    }
    if ($insurance_name) {
        $Body .= "<strong>Insurance Name: </strong>";
        $Body .= $insurance_name;
        $Body .= "<br/>";
    }
    if ($subscriber_name) {
        $Body .= "<strong>Subscriber Name: </strong>";
        $Body .= $subscriber_name;
        $Body .= "<br/>";
    }
    if ($subscriber_id) {
        $Body .= "<strong>Subscriber ID: </strong>";
        $Body .= $subscriber_id;
        $Body .= "<br/>";
    }
    if ($group_number) {
        $Body .= "<strong>Group Number: </strong>";
        $Body .= $group_number;
        $Body .= "<br/>";
    }
    if ($preferred_date) {
        $Body .= "<strong>Preffered Date: </strong>";
        $Body .= $preferred_date;
        $Body .= "<br/>";
    }
    if ($preferred_time) {
        $Body .= "<strong>Preffered Time: </strong>";
        $Body .= $preferred_time;
        $Body .= "<br/>";
    }
    if ($message) {
        $Body .= "<strong>Message: </strong>";
        $Body .= $message;
        $Body .= "<br/>";
    }

    $Body .= "</html>";

    //Content
    $mail->isHTML(true);
    $mail->Subject = $form . " Submission";
    $mail->Body = $Body;

    if($errorMSG == ""){
        $success = $mail->Send();
        if ($success) {
            echo "success";
        }
    } else {
        echo $errorMSG;
    }

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>