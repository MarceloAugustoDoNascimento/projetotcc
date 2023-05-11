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

        $cargo = $_POST['cargo'];
        $descricao = $_POST['descricao'];

        $result = mysqli_query($conexao, "INSERT INTO role (nome_cargo, descricao) VALUES ('$cargo', '$descricao')");

        $sqlcargo = "SELECT * FROM role WHERE nome_cargo = '$cargo'";
        $resultado = $conexao -> query($sqlcargo);
        while($prod = mysqli_fetch_array($resultado)){ 
            $idcargo = $prod['id_cargo'];
        }

        header('Location: cadastrodecargos.php');


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
    <title>Cadastro de cargo</title>
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
            <h1>Cadastro de novo cargo</h1>
            <span class="subtitulo">Informe nome e cursos atribuídos ao cargo.</span>
            <form action="novocargo.php" method="POST">
                <label for="cargo" style="margin-top: 0px;">Nome do cargo</label>
                <input name="cargo" type="text" placeholder="Escreva..." required></input>
                <label for="descricao" style="margin-top: 0px;">Descrição do cargo</label>
                <input name="descricao" type="text" placeholder="Descrição..." required></input>
                
                <input name="submit" type="submit" value="Próximo"></input>
                
            </form>  
        </div>         
</body>
</html>