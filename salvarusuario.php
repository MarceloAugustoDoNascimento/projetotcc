<?php
    include_once('config.php');
    if(isset($_POST['update']))
    {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cargo = $_POST['cargo'];
        $senha = $_POST['senha'];
        $datanas = $_POST['datanas'];
        $admin = $_POST['admin'];
        $notificacoes = $_POST['notificacoes'];
        
        $sqlUpdates = "UPDATE usuario SET nome = '$nome', senha='$senha', email='$email', cargo='$cargo', datanas='$datanas',admin='$admin',notificacoes='$notificacoes', arquivo='0' WHERE id='$id'";
        $result= $conexao -> query($sqlUpdates);
        
        header('Location: login.php');
        

    }
    ?>
    