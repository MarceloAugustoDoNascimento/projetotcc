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
    $sql = "SELECT * FROM usuario";
    $resultado = $conexao -> query($sql);
    while($prod = mysqli_fetch_array($resultado)){ 
        $emailatual = $prod['email'];
        if($logado == $emailatual){
            
            $id_funcionario=$prod['id'];
            $acss = $prod['arquivo'];
            
        }

}   

    if($acss == '1'){
        header("Location: perfilusuario.php?id=$id_funcionario");
    }
?>
<?php
    include_once('config.php');
    $msg = false;
    

    if(isset($_FILES['arquivo'])){
        $data = $_POST['data'];
        $curso = $_POST['idcurso'];
        $validade = $_POST['validade']; 

        $extensao = strtolower(substr($_FILES['arquivo']['name'],-4));
        $nome_arquivo = md5(time()).$extensao;
        $diretorio = "upload/";
        move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio.$nome_arquivo);
        
        
        
        if($validade == 24){
           $validade = date('d-m-Y', strtotime('+24 months', strtotime($data)));
        } else {
            $validade = date('d-m-Y', strtotime('+12 months', strtotime($data)));
        }

        if($_FILES['arquivo'] != ''){

            $sqlca = "SELECT * FROM arquivo_envio a
            INNER JOIN usuario u on (a.id_usuario = u.id) where id_curso = $curso";
            $resul = $conexao -> query($sqlca);
            while($produt = mysqli_fetch_array($resul)){

                if($id_funcionario == $produt['id']){
                    if($produt['nome_arquivo'] == '-'){
                        $idarquivo =$produt['id_arquivo'] ;
                        $sqlDelete = "DELETE FROM arquivo_envio WHERE id_arquivo = $idarquivo";
                        $resultDelete = $conexao -> query($sqlDelete);
                    }
                }
            }
            

           $sqlcode = mysqli_query($conexao, "INSERT INTO arquivo_envio (id_usuario,id_curso, nome_arquivo,data_feito, data_envio, validade_arquivo) VALUES ('$id_funcionario', '$curso', '$nome_arquivo','$data', NOW(), '$validade')");
                header('Location: dashboardusuario.php');
        }
    }


    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboardusuario2.css">
    <title>Dashboard</title>
</head>
<body>
    <header>
    <a href="dashboardusuario.php">
        <div class="icone">
            <img src="iconev.webp"></img>
            <div id="nomelogos" style=" color: white; font-weight:bold;">
                <h4>Gestão de Certificações</h4>
            </div>
        </div></a>

        <div>
                <a href="solicitacoes.php"> Solitações</a>
                <a href="perfilusuario.php?id=<?php echo $id_funcionario; ?>">Perfil</a></li>
                <a href="sair.php">Sair</a></li>
        </div>
    </header>
        <div id="login-container">
            <h1>Envio de certificação</h1>
                

                <?php
                                    include_once('config.php');
                                    $sqlcargo = "SELECT * FROM usuario u
                                    inner join cargo_curso c on (u.cargo = c.id_cargo)
                                    inner join curso cc on (cc.id_curso = c.id_curso)";
                                    $resultado = $conexao -> query($sqlcargo);
                                    while($prod = mysqli_fetch_array($resultado)){ 
                                        $emailatual = $prod['email'];
                                        $verificacao = $prod['nome_curso'];
                                        if($logado == $emailatual){
                                            
                                        ?>  
                                            <a class="corses" style="margin-right: 0px; width:40%;  padding:1vh;" href="enviocursos.php?id_curso=<?php echo $prod['id_curso'] ?>">
                                        <div>

                                            <h1><?php echo $prod['nome_curso'] ?></h1>
                                                <?php 
                                                $sqla = "SELECT * FROM arquivo_envio a
                                                INNER JOIN usuario u on (u.id = a.id_usuario)
                                                INNER JOIN curso c on (c.id_curso = a.id_curso)";
                                                $result = $conexao -> query($sqla);
                                                while($produ = mysqli_fetch_array($result))
                                                    if($prod['id_curso'] == $produ['id_curso']){
                                                        if($logado == $produ['email']){
                                                            $validadess = $produ['validade_arquivo'];
                                                            if($validadess  != '-'){
                                                                $hoje = date('Y-m-d');
                                                                $data_inicio = NEW DateTime("$hoje");
                                                                $data_fim = new DateTime("$validadess");

                                                                // Resgata diferença entre as datas
                                                                $dateInterval = $data_inicio->diff($data_fim);
                                                                
                                                                //365
                                                                if($data_fim > $data_inicio){
                                                                    $validadess = $produ['validade_arquivo'];
                                                                }else{
                                                                    $validadess =  ' vencido';
                                                                    
                                                                }
                                                            }
                                                            
                                                             
                                                            
                                                            $statuss = $produ['status'];
                                                        }
                                                    }
                                                
                                                ?>
                                            <h6>Validade: <?php echo $validadess ?></h6>
                                            <h6>Status: <?php echo $statuss ?></h6>

                                        </div>
                                        
                                        
                                        
                                        </a>
                                            
                                        
                                        
                                        
                                            <form style= "display:none;" action="dashboardusuario.php" enctype="multipart/form-data" method="POST" class="form">
                                                <label for="curso_1">Certificação: <?php echo $prod['nome_curso'] ?></label> 
                                                <input type="file" name="arquivo"value=" <?php echo $prod['nome_curso'] ?>" require>
                                                <label for="curso">Data de realização</label> 
                                                <input type="date" name="data" id="inputdata" require>
                                                <input style= "display:none;" type="text" name="idcurso" value=" <?php echo $prod['id_curso'] ?>" require>
                                                <input style= "display:none;" type="text" name="validade" value=" <?php echo $prod['validade'] ?> " require>
                                                <input type="submit" value="Enviar">
                                            </form>
                                        <?php                                         
                                    }  ?> 
                                    
                
                                    <?php } ?>



               
            </form>
        </div>         
</body>
</html>