<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';

    $mail = new PHPMailer(true);
    $mail->Charset = 'UTF-8';
    $mail->setLanguage('ru', 'phpmailer/language/');
    $mail->IsHTML(true);

    // Ot kogo pisma
    $mail->setFrom('notalonew9@gmail.com', 'wearenotalone');
    // Komu otpravit
    $mail->addAddress('notalonew9@gmail.com');
    // Tema pisma
    $mail->Subject = 'Privet! Eto "Frilanser po jizni"';

    // Ruka
    $hand = "Pravaya";
    if($_POST['hand'] == "left") {
        $hand = "Levaya";
    }

    // Telo pisma
    $body = '<h1>Vstrechayte super pisma!</h1>';

    if(trim(!empty($_POST['name']))){
        $body.='<p><strong>Imya:</strong> '.$_POST['name'].'</p>';
    }
    if(trim(!empty($_POST['email']))){
        $body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
    }
    if(trim(!empty($_POST['hand']))){
        $body.='<p><strong>Ruka:</strong> '.$hand.'</p>';
    }
    if(trim(!empty($_POST['age']))){
        $body.='<p><strong>Vozrast:</strong> '.$_POST['age'].'</p>';
    }
    if(trim(!empty($_POST['message']))){
        $body.='<p><strong>Soobshenie:</strong> '.$_POST['message'].'</p>';
    }

    // Prikrepit fayl
    if(!empty($_FILES['image']['tmp_name'])){
        // Put zagruzki fayla
        $filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
        // gruzim fayl
        if(copy($_FILES['image']['tmp_name'], $filePath)){
            $fileAttach = $filePath;
            $body.='<p><strong>Foto v prilojenii</strong></p>';
            $mail->addAttachment($fileAttach);
        }
    }

    $mail->Body = $body;

    // Otpravlyaem
    if(!$mail->send()){
        $message = 'Oshibka';
    } else {
        $message = 'Dannie otpravleni!';
    }

    $response = ['message' => $message];

    header('Content-type: application/json');
    echo json_encode($response);
?>