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
        }

    }
if(!empty($_GET['id_curso']))
{

    include_once('config.php');
    $idcurso = $_GET['id_curso'];

}
else
{
    header('Location: dashboardusuario.php');
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
        
        
        
        
           $validad = date('d-m-Y', strtotime("+{$validade} months", strtotime($data)));
        

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
            

           $sqlcode = mysqli_query($conexao, "INSERT INTO arquivo_envio (id_usuario,id_curso, nome_arquivo,data_feito, data_envio, validade_arquivo) VALUES ('$id_funcionario', '$curso', '$nome_arquivo','$data', NOW(), '$validad')");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="dashboardusuario2.css">
    <style>
        th{
            color: gray;

        }
        td{
            color: gray;
        }
    </style>
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
                <a href="solicitacoes.php">Solitações</a>
                <a href="perfilusuario.php?id=<?php echo $id_funcionario; ?>">Perfil</a></li>
                <a href="sair.php">Sair</a></li>
        </div>
    </header>
        <div id="login-container">
            <h1>Envio de certificação</h1>
                    <p for="arquivo" style="margin-bottom: 5vh;">Anexe suas certificações</p>
                

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
                                            if($idcurso == $prod['id_curso']){
                                                $valida = $prod['validade'];
                                                $hoje = date('Y-m-d');
                                                $data_inicio = NEW DateTime("$hoje");
                                                $valid = date('Y-m-d', strtotime("-$valida months", strtotime($hoje)));
                                            ?>  <form action="dashboardusuario.php" enctype="multipart/form-data" method="POST" class="form">
                                                <label for="curso_1">Certificação: <?php echo $prod['nome_curso'] ?></label> 
                                                <input style="width:100%; color: white" type="file" name="arquivo" accept="image/*, application/pdf" value=" <?php echo $prod['nome_curso'] ?>" require>
                                                <label style="margin-top:2vh"for="curso">Data de realização</label> 
                                                <input style="width:100%" type="date" name="data" min="<?php echo $valid ?>" max="<?php echo $hoje ?>" id="inputdata" require>
                                                <input style= "display:none;" type="text" name="idcurso" value=" <?php echo $prod['id_curso'] ?>" require>
                                                <input style= "display:none;" type="text" name="validade" value=" <?php echo $prod['validade'] ?> " require>
                                                <input style="width:100%" type="submit" value="Enviar">
                                            </form>
                                        <?php                                         
                                    }}  ?> 
                                    
                
                                    <?php } ?>



               
            </form>


            <h7 style=" margin-top:7vh; color: white">Última versão enviada:</h7>
            <table class="table" style="width:80%; font-size:0.7rem">
                <thead>
                  <tr>
                    
                    <th scope="col">Arquivo</th>
                    <th scope="col">Realizado</th>
                    <th scope="col">Data de envio</th>
                    <th scope="col">Stauts da solicitação</th>
                    <th scope="col">Validade</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                        $sqla = "SELECT * FROM arquivo_envio a
                        INNER JOIN usuario u on (u.id = a.id_usuario)
                        INNER JOIN curso c on (c.id_curso = a.id_curso)";
                        $results = $conexao -> query($sqla);

                        while($user_data = mysqli_fetch_assoc($results))
                        {   
                            $nome_arquivo = $user_data['nome_arquivo'];
                            $nomedocurso = $user_data['nome_curso'];
                            $idatual = $user_data['id'];
                            $feito = $user_data['data_feito'];
                            $envio = $user_data['data_envio'];
                            $stat = $user_data['status'];
                            $val= $user_data['validade_arquivo'];
                        }
                            echo "<tr>";
                            if($id_funcionario == $idatual){
                                if($nomedocurso == $verificacao){
                                
                                if($nome_arquivo != '-'){
                                
                                echo "<td><a style=\"font-size: 1rem;\" target=\"_blank\" href = \"upload/$nome_arquivo\">
                                
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-file-earmark-text' viewBox='0 0 16 16'>
                                <path d='M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z'/>
                                <path d='M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z'/>
                                </svg> Vizualizar</a>
                              
                              
                                </td>"; 
                                echo "<td>$feito</td>";
                                echo "<td>$envio</td>";
                                echo "<td>$stat</td>";
                                echo "<td>$val</td>";
                                }else{
                                    echo "<td>Não há envios </td>";
                                    echo "<td> - </td>";
                                    echo "<td> - </td>";
                                    echo "<td> - </td>";
                                    echo "<td> - </td>";
                                }
                            }
                        }
                            
                            echo "</tr>";
                        
                        
                    ?>
                </tbody>
              </table>
        </div>         
</body>
</html>