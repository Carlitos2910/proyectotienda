<?php

    namespace Lib;

    use PHPMailer\PHPMailer\PHPMailer;

    class Email{

        public $email;

        public $token;

        public function __construct($email, $token){
            $this->email = $email;
            $this->token = $token;

        }
        
        public function enviarConfirmacion(){

            // Creamos una instancia.
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail -> Username = 'c2d6701c6df877';
            $mail -> Password = '4899e17fe0ebc7';

            $mail->setFrom('test.carlos.321@gmail.com');
            $mail->addAddress($this->email);
            $mail->Subject = 'Confirma tu Cuenta';

            //Ponemos el HTML.
            $mail->isHTML(TRUE);
            $mail->CharSet = 'UTF-8';

            $contenido = '<html>';
            $contenido .= "<p><strong>Hola " . $this->email . "</strong>Has creado tu cuenta en ProyectoCarlos.com, solo debes confirmarla presionando el siguiente enlace</p>";
            $contenido .= "<p>Presiona aquí: <a href='http://localhost:8012/proyectopelicula/public/confirmarCuenta/". $this->token . "'>Confirmar Cuenta</a></p>";
            $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje.</p>";
            $contenido .= '</html>';
            $mail->Body = $contenido;

            // Enviar el mail.
            $mail->send();

        }

    }

?>

