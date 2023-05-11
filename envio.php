
<?php

    session_start();
    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('location: login.php');
    }
    include_once('config.php');
    $logado = $_SESSION['email'];
    echo $logado;
    $sql = "SELECT * FROM usuario";
    $result = $conexao -> query($sql);
    while($prod = mysqli_fetch_array($result)){ 
        $emailatual = $prod['email'];
        if($logado == $emailatual){
            
            $id_funcionario=$prod['id'];
    

    }
}

?>
<?php
    include_once('config.php');
    $msg = false;
    if(isset($_FILES['arquivo'])){
        $data = $_GET['data'];
        $extensao = strtolower(substr($_FILES['arquivo']['name'],-4));
        $nome_arquivo = md5(time()).$extensao;
        $diretorio = "upload/";
        move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio.$nome_arquivo);
        
       $sqlcode = mysqli_query($conexao, "INSERT INTO arquivo_envio (id_usuario, id_curso, nome_arquivo,data_feito data_envio) VALUES ('$id_funcionario', '$nome_arquivo','$data', NOW())");
        header('Location: dashboardusuario.php');
    }


    ?>
