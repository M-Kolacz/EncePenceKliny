<?php
if(!session_id()) {
	session_start();
}
error_reporting(0);

if (isset($_REQUEST['action'])) {
    if ($_REQUEST['action'] == "email_server_responce") {
        $ourMail = "encepencekliny@gmail.com"; //Insert your email address here
        $pre_messagebody_info = "";
        $errors = array();
        $data = array();
        parse_str($_REQUEST['values'], $data);
        
        $result = array(
            "is_errors" => 0,
            "info" => ""
        );
		
		if (!empty($errors)) {
            $result['is_errors'] = 1;
            $result['info'] = $errors;
            echo json_encode($result);
            exit;
        }

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers.= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers.= "From: ".$data['email']."\r\n";
		$pre_messagebody_info.="<strong>Imię i Nazwisko</strong>" . ": " . $data['name'] . "<br />";
        if (! empty($data['email']) ) {
            $pre_messagebody_info.="<strong>E-mail</strong>" . ": " . $data['email'] . "<br />";
        }
        if (! empty($data['phone']) ) {
            $pre_messagebody_info.="<strong>Telefon</strong>" . ": " . $data['phone'] . "<br />";
        }
        if (! empty($data['url']) ) {
			$pre_messagebody_info.="<strong>URL</strong>" . ": " . $data['url'] . "<br />";
		}
        if (empty($data['subject']) ) {
			$subject = "E-mail ze strony pence.pl";
		} else {
			$subject = $data['subject'];
		}
        $after_message = "\r\n<br />--------------------------------------------------------------------------------------------------\r\n<br /> E-mail został wysłany z formurza kontaktowego ze strony pence.pl.";

        if (mail($ourMail, $subject, $pre_messagebody_info .= $category . "<strong>Wiadomość</strong>" . ": " . $data['message'] .$after_message, $headers)) {
            $result["info"] = "success";
        } else {
            $result["info"] = "server_fail";
        }
        echo json_encode($result);
        exit;
    }
} ?>

