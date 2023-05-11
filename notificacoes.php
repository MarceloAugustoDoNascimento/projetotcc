<?php
    session_start();
    include_once('config.php');
    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('location: login.php');
    }
    $logado = $_SESSION['email'];
    include_once('config.php');   
    $sq = "SELECT * FROM usuario u
    INNER JOIN role r on (u.cargo=r.id_cargo)";
    $res = $conexao -> query($sq);
    while($prods = mysqli_fetch_array($res)){
        if($logado == $prods['email']){
            $cargoteste = $prods['admin'];
            if($cargoteste == '0'){
                header("Location: dashboardusuario.php");
            }
        }
    }






    $sql = "SELECT * FROM email e
    INNER JOIN role r on (r.id_cargo = e.cargo) ORDER BY id_email ASC";   
    $result = $conexao -> query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="notificacoes.css">
    
    <title>Notificações</title>
</head>
<body >
<header>
        <a href="dashboard.php">
        <div class="icone">
            <img src="iconev.webp"></img>
            <div id="nomelogos" style=" color: white; font-weight:bold;">
                <h4>Gestão de Certificações</h4>
            </div>
        </div></a>
        <div>
                <a href="dashboard.php">Dashboard</a>
                <a href="sair.php">Sair</a></li>
        </div>
    </header>
    

        <h1 style="font-size: 3rem; color: #58d0ff; margin-bottom: 2vh; margin-top: 2vh;">Notificações</h1>
        

        <div id="login-container">
            

            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Id Solicitação</th>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Ações</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                        while($user_data = mysqli_fetch_assoc($result))
                        {
                            $id = $user_data['id_email'];
                            echo "<tr>";
                            echo "<td>".$user_data['id_email']."</td>";
                            echo "<td>".$user_data['nome']."</td>";
                            echo "<td>".$user_data['email']."</td>";
                            echo "<td>".$user_data['nome_cargo']."</td>";
                            echo "<td>
                                <a class='btn btn-sm btn-danger' onclick='exclusao($id)'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                              </svg> Excluir
                                </a>
                            </td>";

                            echo "</tr>";
                        }
                    ?>
                </tbody>
              </table>
        </div>
</body>
<script>
                               function exclusao(id) {
                            var msgs = confirm("Atenção: Deseja Excluir esse Registro?" )
                            if (msgs){

                                alert("Arquivo excluido com sucesso!");
                                window.location.href=("deletenot.php?id="+id);

                            }
                            else{
                                alert("Operação Cancelada, o Registro não será Excluído!");


                            }
                        }
</script>
                        
</html>