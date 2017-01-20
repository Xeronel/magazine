<?php
require 'PHPMailer/PHPMailerAutoload.php'; // https://github.com/PHPMailer/PHPMailer

/**
* Email client
*/
class Email
{
    private $mail;

    function __construct()
    {
        // Config should be a copy of config-exmaple.ini
        // all entries are assumed to exist and be correct
        $config = parse_ini_file('config.ini');

        $mail = new PHPMailer;

        // Configure SMTP
        $mail->SMTPOptions = array (
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->isSMTP();
        $mail->Host = $config['mail_host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['mail_user'];
        $mail->Password = $config['mail_pass'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = $config['mail_port'];

        // Setup mail client
        $mail->setFrom($config['mail_from'], $config['mail_name']);
        $mail->addAddress('ripster@ratio.ninja');
        $mail->isHTML(true);
        $this->mail = $mail;
    }

    public function send($from, $name, $subject, $body)
    {
        // Set the reply_to address to the person trying to contact us
        $this->mail->addReplyTo($from, $name);
        $this->mail->Subject = $subject;
        $this->mail->Body = $body;

        if(!$this->mail->send()) {
            return $this->mail->ErrorInfo;
        } else {
            return 'Message sent!';
        }
    }
}
?>
