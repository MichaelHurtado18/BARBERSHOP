<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;


class Email
{

    public $nombre;
    public $email;
    public $token;

    public function __construct($nombre, $email, $token)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }

    // Esta function es para confirmar la cuenta del usuario
    public function enviarConfirmacion()
    {

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '1075e608d59e16';
        $mail->Password = '12a6e46f363476';
        $mail->setFrom('michael.hurtado1218@gmail.com', 'ADMIN Barbershop');
        $mail->addAddress('michael.michaelito@gmail.com', 'Michael Hurtado');



        //Content
        $mail->isHTML(true);
        $mail->Subject = "Barbershop -- Confirma tu cuenta";
        $contenido = "<html>";
        $contenido .= "<p> Hola, <strong> $this->nombre </strong>. Creaste una cuenta con nosotros y nos gustaria que confirmara su cuenta. <br>";
        $contenido .= "Asi que por favor, presione el sigiente enlace para confirmar su cuenta en BarberShop.com <a  class='btn' href=' localhost:3000/confirmar-cuenta?token=$this->token '> Confirmar Mi Cuenta</a>. <br> Si usted no ha sido omita este mensaje. </p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;

        $mail->send();
    }

    // Esta function es para recuperar la contraseña del usuario
    public function ReestablecerContra()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '1075e608d59e16';
        $mail->Password = '12a6e46f363476';
        $mail->setFrom('hola@barbershop.com', 'Barbershop');
        $mail->addAddress('michael.michaelito@gmail.com', 'Michael Hurtado');

        //Content
        $mail->isHTML(true);
        $mail->Subject = "Barbershop -- Reestablece tu cuenta";
        $contenido = "<html>";
        $contenido .= "<p> Hola, <strong> $this->nombre </strong>. Has solicitado reestablecer tu cuenta. <br>";
        $contenido .= "Asi que por favor, presione el sigiente enlace para reestablecer su password en BarberShop.com <a  class='btn' href=' localhost:3000/recuperar-cuenta?token=$this->token '> Reestablcer Mi Cuenta</a>. <br> Si usted no ha sido omita este mensaje. </p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;

        $mail->send();
    }
}
