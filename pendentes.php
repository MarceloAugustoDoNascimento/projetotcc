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
    
    
    
        include_once('config.php');

        $sqlSelect = "SELECT * FROM arquivo_envio a
        INNER JOIN usuario u on (u.id = a.id_usuario)
        INNER JOIN curso c on (c.id_curso = a.id_curso)";
        $result = $conexao -> query($sqlSelect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="cadastro.css">
    <link rel="stylesheet" href="todas.css">
    <style>
        .btn1{
            color:red;
        }
        .btn2{
            color: green;
        }

    </style>
    <title>Pendentes</title>
</head>
<body>
    <header>
    <a href="dashboard.php">
        <div class="icone">
            <img src="iconev.webp"></img>
            <div id="nomelogos" style="padding-top: 1px;">
                <h4>Gestão de Certificações</h4>
            </div>
        </div></a>
        <div>
                <a href="dashboard.php">Dashboard</a>
                <a href="sair.php">Sair</a></li>
        </div>
    </header>
        <div id="login-container" >
            <h1>Certificações do usuário</h1>
            <span class="subtitulo" style="margin-top: 5vh; margin-bottom: 5vh;">Confira as certificações enviadas</span>

            <table class="table">
                <thead>
                  <tr>
                    
                    <th scope="col">Nome</th>
                    <th scope="col">Treinamento</th>
                    <th scope="col">Arquivo</th>
                    <th scope="col">Realizado</th>
                    <th scope="col">Data de envio</th>
                    <th scope="col">Validade</th>
                    <th scope="col">Status</th>
                    <th scope="col">Avaliar</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                        while($user_data = mysqli_fetch_assoc($result))
                        {
                           
                            echo "<tr>";
                            $nome_arquivo = $user_data['nome_arquivo'];
                            $status = $user_data['status'];
                            $validadess = $user_data['validade_arquivo'];
                            if($status == 'pendente' || $status == 'não enviado'){
                            echo "<td>".$user_data['nome']."</td>";
                            echo "<td>".$user_data['nome_curso']."</td>";
                            if($validadess  != '-'){
                                echo "<td><a style=\"font-size: 1rem;\" target=\"_blank\" href = \"upload/$nome_arquivo\">
                                    
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-file-earmark-text' viewBox='0 0 16 16'>
                                <path d='M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z'/>
                                <path d='M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z'/>
                                </svg> Vizualizar</a></td>";
                                } else{
                                    echo "<td>- </td>";
                                }
                            echo "<td>".$user_data['data_feito']."</td>";
                            echo "<td>".$user_data['data_envio']."</td>";
                            echo "<td>".$user_data['validade_arquivo']."</td>";
                            if($validadess  != '-'){
                                $hoje = date('Y-m-d');
                                $data_inicio = NEW DateTime("$hoje");
                                $data_fim = new DateTime("$validadess");

                                // Resgata diferença entre as datas
                                $dateInterval = $data_inicio->diff($data_fim);
                                
                                //365
                                if($data_fim > $data_inicio){
                                    $status = $user_data['status'];
                                }else{
                                    $status =  'Vencido';
                                    
                                }
                            }
                            echo "<td> $status </td>";
                            if($status == 'pendente' || $status == 'indeferido' || $status == 'de acordo'){
                                echo "<td>
                                <a class='btn2' href='aprove.php?id_arquivo=$user_data[id_arquivo]'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-check-square-fill' viewBox='0 0 16 16'>
                                <path d='M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z'/>
                                </svg>
                                </a>
                                <a class='btn1' href='desaprove.php?id_arquivo=$user_data[id_arquivo]'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-x-square-fill' viewBox='0 0 16 16'>
                                <path d='M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z'/>
                                </svg>
                                </a>
                            </td>";
                                }else{
                                    echo "<td>- </td>";
                                }
                            }
                            echo "</tr>";
                        }
                    ?>
                </tbody>
              </table>
        </div>         
</body>
</html>