<?php
    require "./bibliotecas/php_mailer/Exception.php";
    require "./bibliotecas/php_mailer/OAuth.php";
    require "./bibliotecas/php_mailer/PHPMailer.php";
    require "./bibliotecas/php_mailer/POP3.php";
    require "./bibliotecas/php_mailer/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    session_start();

    class Mensagem{

        private $email = null;
        private $assunto = null;
        private $mensagem =null;
        public $status = ['codigo_status' => null,'descricao_status'=>''];
        public function __construct($email,$assunto,$mensagem){
            $this->email = $email;
            $this->assunto = $assunto;
            $this->mensagem = $mensagem;
        }
        public function __destruct(){
            
        }

        public function __get($atributo){
            return $this->$atributo;
        }

        public function __set($atributo, $value){
            $this->$atributo = $value;
        }

        public function mensagemValida(){
            if(empty($this->email) || empty($this->assunto) || empty($this->mensagem)){
                return false;
            }
            return true;
        }
    }

    $email = $_POST['email'];
    $assunto = $_POST['assunto'];
    $texto = $_POST['mensagem'];
    $mensagem = new Mensagem($email,$assunto,$texto);
    $_SESSION['mensagemValida'] = 'teste';

    if(!$mensagem->mensagemValida()){
        $_SESSION['mensagemValida'] = 'sim';
        echo 'não é valido';
        header('Location: index.php');
    } 

    //implementação da biblioteca PHPmailer para envio de emails
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = false;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        //OBS: em caso de uso da aplicação preencha os campos abaixo 
        $mail->Username   = '';                     //Observação: o email foi retirado por questão de segurança
        $mail->Password   = '';                     //Observação: a senha do email foi retirada por questão de segurança 

        $mail->SMTPSecure = 'tls';         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('rostanthsn@gmail.com', 'Email de teste - remetente');
        $mail->addAddress($mensagem->__get('email'), 'Email de teste - destinatario');     //Add a recipient
       // $mail->addAddress('ellen@example.com');               //Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $mensagem->__get('assunto');
        $mail->Body    = $mensagem->__get('mensagem');
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();

        $mensagem->status['codigo_status'] = 1;
        $mensagem->status['descricao_status'] = 'E-mail enviado com sucesso';
        
    } catch (Exception $e) {

        $mensagem->status['codigo_status'] = 2;
        $mensagem->status['descricao_status'] = "Não foi possivel enviar o e-mail, Detalhes do erro: {$mail->ErrorInfo}";
        
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envio realizado</title>
    <link rel="shortcut icon" href="./mail.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div id="logo">
            <img src="./email-icon.png" alt="" width="150em">
            <h1 class="textos">Send Mail</h1>
            <h3 class="textos">Seu app de envio de e-mails particular!</h3>
        </div>
    </header>

    <?php
        if($mensagem->status['codigo_status'] == 1){   
    ?>
        <div id="envioSucesso">
            Envio realizado !
        </div>
        <a href="index.php"><input type="button" value="Voltar" id="btnVoltar"></a>
    <?php } ?>
    
    <?php
        if($mensagem->status['codigo_status'] == 2){   
            echo $mensagem->status['descricao_status']
    ?>
        <div id="envioFalho">
            Envio Não realizado !
        </div>
        <a href="index.php"><input type="button" value="Voltar" id="btnVoltar"></a>
    <?php } ?>

</body>
</html>