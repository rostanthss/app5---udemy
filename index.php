<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App send mail</title>
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

    <div id="main">
        <form action="processa_envio.php" method="post">
            <h3 class="textosEntradas">Para</h3>
            <input class="entradas" type="email" name="email" id="email" placeholder="Digite o e-mail de destino"> <br>

            <h3 class="textosEntradas">Assunto</h3>
            <input class="entradas" type="text" name="assunto" id="assunto" placeholder="Assunto do e-mail"> <br>

            <h3 class="textosEntradas">Texto</h3>
            <textarea class="entradas" name="mensagem" id="mensagem" cols="30" rows="10" placeholder="Digite a mensagem do e-mail"></textarea> <br>

            <div>
                
            </div>
            <input type="submit" value="Enviar mensagem" id="botao">

        </form>
    </div>
    
</body>
</html>