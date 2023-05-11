<?php
        session_start();
        if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
        {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('location: login.php');
        }
        $logado = $_SESSION['email'];

        include_once('config.php');   
        $sq = "SELECT * FROM usuario";
        $res = $conexao -> query($sq);
        while($prods = mysqli_fetch_array($res)){
            if($logado == $prods['email']){
                $cargoteste = $prods['admin'];
                if($cargoteste == '0'){
                    header("Location: dashboardusuario.php");
                }
            }
        }
    
    
    

    if(isset($_POST['submit']))
    {

        include_once('config.php');

        $nome= $_POST['curso'];
        $descricao = $_POST['descricao'];
        $validade = $_POST['validade'];

        $result = mysqli_query($conexao, "INSERT INTO curso (nome_curso, validade, descricao) VALUES ('$nome','$validade', '$descricao')");
        header('Location: dashboard.php');


    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="cadastro.css">
    <title>Cadastro de treinamento</title>
</head>
<body style="background: url(cargos.png);">
<header>
        <div class="icone">
            <img src="iconev.webp"></img>
            <div id="nomelogos" style=" color: white; font-weight:bold;">
                <h4>Gestão de Certificações</h4>
            </div>
        </div>
        <div style="display: flex; align-items: center;">
                <a href="dashboard.php">Dashboard</a>
                <a href="sair.php">Sair</a></li>
        </div>
    </header>
        <div id="login-container" >
            <h1>Cadastro de novo treinamento</h1>
            <span class="subtitulo">Informe nome, descrição e validade do treinamento.</span>
            <form action="novocurso.php" method="POST">
                <label for="curso" style="margin-top: 0px;">Nome do treinamento</label>
                <input name="curso" type="text" placeholder="Escreva..." required></input>
                <label for="descricao" style="margin-top: 0px;">Descrição do treinamento</label>
                <input name="descricao" type="text" placeholder="Descrição..." required></input>
                <label for="validade" style="margin-top: 0px;">Validade do treinamento (em meses)</label>
                <input name="validade" type="number" min="1" placeholder="Validade..." required></input>
                <input name="submit" type="submit" value="Cadastrar"></input>
                
            </form>  
        </div>         
</body>
</html>