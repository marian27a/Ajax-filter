<?php

$name_field = check_input($_POST["name_field"]);
$mail_field = check_input($_POST["mail_field"]);
$phone_field = check_input($_POST["phone_field"]);
$prod_list = check_input($_POST["prCode_field"]);
$subject_field = check_input($_POST["subject_field"]);
$message_field = check_input($_POST["message"]);
$skil_field = check_input($_POST["skil"]);
$form_field = check_input($_POST["form_field"]);

$to = "easycodekharkov@gmail.com";


if ($phone_field!=="") {
    $subject = "Заявка на звонок";
    $message = file_get_contents('templates/message.html');

    // Fill form
    $message = str_replace('{{ subject }}', $subject_field, $message);
    $message = str_replace('{{ name }}', $name_field, $message);
    $message = str_replace('{{ phone }}', $phone_field, $message);
    $message = str_replace('{{ message }}', $message_field, $message);
    $message = str_replace('{{ mail }}', $mail_field, $message);
    $message = str_replace('{{ skil }}', $skil_field, $message);
    $message = str_replace('{{ form }}', $form_field, $message);
} else {
    $subject = "Заявка на звонок";
    $message = file_get_contents('templates/message.html');
    $message = str_replace('{{ subject }}', $subject_field, $message);
    $message = str_replace('{{ name }}', $name_field, $message);
    $message = str_replace('{{ phone }}', $phone_field, $message);
    $message = str_replace('{{ message }}', $message_field, $message);
    $message = str_replace('{{ mail }}', $mail_field, $message);
    $message = str_replace('{{ skil }}', $skil_field, $message);
    $message = str_replace('{{ form }}', $form_field, $message);
}

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; UTF-8\r\n";


mail($to, $subject, $message, $headers);

function check_input($data, $problem = ""){
    $data = htmlentities(trim(strip_tags(stripslashes($data))), ENT_NOQUOTES, "UTF-8");

    if ($problem && strlen($data) == 0){
        show_error($problem);
    }

    return $data;
};

function show_error($myError) {
    echo $myError;
    exit();
}
$email;$comment;$captcha;
        if(isset($_POST['name_field'])){
            $email=$_POST['name_field'];
        }if(isset($_POST['phone_field'])){
    $email=$_POST['phone_field'];
}if(isset($_POST['g-recaptcha-response'])){
    $captcha=$_POST['g-recaptcha-response'];
}
        if(!$captcha){
            echo '<h2>Please check the the captcha form.</h2>';
            exit;
        }
        $secretKey = "6LcPIBoTAAAAAA1PPlXgvHgfbZ6EUOzywMRj8rB7";
        $ip = $_SERVER['REMOTE_ADDR'];
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
        $responseKeys = json_decode($response,true);
        if(intval($responseKeys["success"]) !== 1) {
            echo '<h2>You are spammer ! Get the @$%K out</h2>';
        } else {
            echo '<h2>Thanks for posting comment.</h2>';
        }
?>