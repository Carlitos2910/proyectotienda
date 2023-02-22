<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require '../PHPMailer/Exception.php';
    require '../PHPMailer/PHPMailer.php';
    require '../PHPMailer/SMTP.php';


    //Load Composer's autoloader
    // require 'vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'test.carlos.321@gmail.com';                     //SMTP username
        $mail->Password   = 'kphuoxdkpntgaymw';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('test.carlos.321@gmail.com', 'Zapatos');
        $email = $_SESSION['identity']->email;
        $mail->addAddress($email);
        // $mail->addAddress('carloslobu6@gmail.com');


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Pedido Zapatos';

        $cuerpo = '';
        foreach($_SESSION['pedido'] as $pedido){
            $cuerpo .= '<div class="order-item">
                <div class="order-item-header">
                    <h2>En Proceso</h2>
                    <h4>Pedido efectuado el: '.$pedido["fecha"].'</h4>
                </div>
                <div class="order-item-content">
                    <div class="order-item-info">
                        <h3>'.$pedido["nombre"].'</h3>
                        <p> Descripción: '.$pedido["descripcion"].'</p>
                        <p>Unidades: '.$pedido["unidades"].'</p>
                        <p>Precio unidad: '.$pedido["precio"].'€</p>
                        <h4>Total: '.$pedido["precio"]*$pedido["unidades"].'€</h4>
                    </div>
                </div>
            </div>';
        }
        $mail->Body    = $cuerpo;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }

?>