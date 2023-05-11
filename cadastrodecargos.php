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

        $curso = $_POST['curso'];

        $sqlcargo = "SELECT * FROM role ORDER BY id_cargo ASC";
        $resultado = $conexao -> query($sqlcargo);
        while($prod = mysqli_fetch_array($resultado)){ 
            $idcargo = $prod['id_cargo'];
        }

        $resultado = mysqli_query($conexao, "INSERT INTO cargo_curso (id_cargo, id_curso) VALUES ('$idcargo','$curso' )");
        $sqlUpdate = "UPDATE curso SET contagem ='1' WHERE id_curso ='$curso'";
        $result = $conexao -> query($sqlUpdate);

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

    <title>Cadastro</title>
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
            <span class="subtitulo">Cargo e treinamento cadastrados com sucesso!</span>
            <form action="cadastrodecargos.php" method="POST">                
                <label for="curso">Adicionar novo treinamento para o cargo</label>
             
                    <select name="curso" required><option>Selecione...</option>
                    <?php
                                        include_once('config.php');
                                        $sqlcargo = "SELECT * FROM curso";
                                        $resultado = $conexao -> query($sqlcargo);
                                        while($prod = mysqli_fetch_array($resultado)){ 
                                            
                                            $idcurso = $prod['id_curso'];
                                            $nomecurso = $prod['nome_curso'];
                                            $contagem = $prod['contagem'];
                                            
                                           if($contagem == '0'){?>
                                            <option value=" <?php echo $idcurso ?>">
                                                <?php echo $nomecurso ?>
                                            </option>

                    
                                        <?php } } ?>
                                    </select>
                <input name="submit" type="submit" value="Próximo"></input>
                <a href="dashboard.php" style="margin-top: 5vh; color:white; font-size: 15px">Clique aqui para finalizar</a>
            </form>  
        </div>         
</body>
</html>