<?php
    // Pear Mail Library
    require_once "Mail.php";

    $from = 'wyndy1968@gmail.com';
    $to = 'wyndy1968@gmail.com';
    $subject = 'Hi!';
    $body = "Hi,\n\nHow are you?";

    $headers = array(
        'From' => $from,
        'To' => $to,
        'Subject' => $subject
    );

    $smtp = Mail::factory('smtp', array(
            'host' => 'ssl://smtp.gmail.com',
            'port' => '465',
            'auth' => true,
            'username' => 'wyndy1968@gmail.com',
            'password' => 'ngaymai1968'
        ));

    $mail = $smtp->send($to, $headers, $body);

    if (PEAR::isError($mail)) {
        echo('<p>' . $mail->getMessage() . '</p>');
    } else {
        echo('<p>Message successfully sent!</p>');
    }
?>