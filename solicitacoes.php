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
    $contador=0;
    while($prod = mysqli_fetch_array($resultado)){ 
        $emailatual = $prod['email'];
        if($logado == $emailatual){
            
            $id_funcionario=$prod['id'];
        }

    }
    $sqla = "SELECT * FROM arquivo_envio a
    INNER JOIN usuario u on (u.id = a.id_usuario)
    INNER JOIN curso c on (c.id_curso = a.id_curso)";
    $result = $conexao -> query($sqla);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="solicitacoes.css">
    <title>Solicitações</title>
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
        <div style="display: flex; align-items: center;">
                <a href="dashboardusuario.php">Dashboard</a>
                <a href="sair.php">Sair</a></li>
        </div>
    </header>
        <div id="login-container">
            <h1>Solicitações</h1>
            <span style="font-size: 25px;"></span>
            
                <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Treinamento</th>
                    <th scope="col">Arquivo</th>
                    <th scope="col">Realizado</th>
                    <th scope="col">Data de envio</th>
                    <th scope="col">Stauts da solicitação</th>
                    <th scope="col">Validade</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                        while($user_data = mysqli_fetch_assoc($result))
                        {   
                            $nome_arquivo = $user_data['nome_arquivo'];
                            echo "<tr>";
                            $idatual = $user_data['id'];
                            if($id_funcionario == $idatual){
                                $contador= $contador+1;
                                echo "<td>".$user_data['nome_curso']."</td>";
                                if($nome_arquivo != '-'){
                                echo "<td><a style=\"font-size: 1rem;\" target=\"_blank\" href = \"upload/$nome_arquivo\">
                                
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-file-earmark-text' viewBox='0 0 16 16'>
                                <path d='M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z'/>
                                <path d='M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z'/>
                                </svg> Vizualizar</a>
                              
                              
                                </td>";
                                }
                                else{
                                    echo "<td> - </td>"; 
                                }
                                echo "<td>".$user_data['data_feito']."</td>";
                                echo "<td>".$user_data['data_envio']."</td>";
                                echo "<td>".$user_data['status']."</td>";
                                echo "<td>".$user_data['validade_arquivo']."</td>";
                            }
                            
                            echo "</tr>";
                        }
                        
                    ?>
                </tbody>
              </table>
                
            
           
        </div>         
</body>
</html>