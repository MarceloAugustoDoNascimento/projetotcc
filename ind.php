<?php
require_once('src/PHPMailer.php');
require_once('src/SMTP.php');
require_once('src/Exception.php');
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
 
$mail = new PHPMailer(true);
 
try {
	$mail->SMTPDebug = SMTP::DEBUG_SERVER;
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'username';
	$mail->Password = 'senha';
	$mail->Port = 587;

        include_once('config.php');
        $sqlSelect = "SELECT * FROM usuario ORDER BY id ASC";
        $result = $conexao -> query($sqlSelect);
        while($user_data = mysqli_fetch_assoc($result))
        {   
            $email = $user_data['email'];
            $senha = $user_data['senha'];
            $nome = $user_data['nome'];
            $data = $user_data['datanas'];
            $cargo = $user_data['cargo'];
        
        }
	$mail->setFrom('remetente@gmail.com', 'Recursos humanos GC');
	$mail->addAddress($email, $nome);
 
	$mail->isHTML(true);
	$mail->Subject = 'Conta para acesso ao sistema de envios de certificados';
	$mail->Body = "Ola, {$nome}!<br><br>Sua conta de usuario foi criada, confira se as informacoes abaixo estao de acordo: <br>Nome: {$nome}<br>E-mail: {$email}<br>Data de nascimento: {$data}<br><br>Use a senha: <strong>{$senha}</strong> para o primeiro acesso! <br>Nao esqueca de fazer a alteracao da senha prvisoria para sua seguranca.<br>Acesso : https://gerenciadordecertificacoes.000webhostapp.com/login.php<br><br>Para qualquer divergencia, contate nossa equipe respondendo a este e-mail.<br><br><br>Att...<br>Recursos Humanos GC";
	$mail->AltBody = 'Erro';
    header('Location: dashboard.php');
 
	if($mail->send()) {
		echo 'Email enviado com sucesso';
	} else {
		echo 'Email nao enviado';
	}
} catch (Exception $e) {
	echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
}
    
?>