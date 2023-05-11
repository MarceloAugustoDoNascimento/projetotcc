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

    $sqlUpdate = "SELECT * FROM curso";
    $resultation = $conexao -> query($sqlUpdate);
    while($prod = mysqli_fetch_array($resultation)){ 
        $curso = $prod['id_curso'];
        $sqlUpdate = "UPDATE curso SET contagem ='0' WHERE id_curso ='$curso'";
        $result = $conexao -> query($sqlUpdate);


    }

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





    if(!empty($_GET['search']))
    {
        $data = $_GET['search'];
        $sql = "SELECT * FROM usuario u
        INNER JOIN role r on (u.cargo = r.id_cargo) WHERE id LIKE '%$data%' or nome LIKE '%$data%' or cargo LIKE '%$data%' or email LIKE '%$data%' ORDER BY id ASC";
    }
    else
    {
        $sql = "SELECT * FROM usuario u
        INNER JOIN role r on (u.cargo = r.id_cargo) ORDER BY id ASC";
    }
    
    $result = $conexao -> query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="dashboard.css">
    
    <title>Dashboard</title>
</head>
<body >
    <header>
        <a href="dashboard.php">
        <div class="icone">
            <img src="iconev.webp"></img>
            <div id="nomelogos" style=" color: white; font-weight:bold;">
                <h4>Gestão de Certificações</h4>
            </div>
        </div> </a>
        <div>
            
            <a href="notificacoes.php"> Notificações</a>
                <a href="todas.php">Relatórios</a>
            <a href="pendentes.php">Pendências</a> 
            <a href="sair.php">Sair</a>
        </div>
    </header>
    

        <h1 style="font-size: 3rem; color: #58d0ff; margin-bottom: 2vh; margin-top: 2vh;">Meus usuários
 

    
    </h1>
        <div class="box-search" style="display: flex; justify-content: center;">
            <input type="search" class="form-control" style="width: 20rem;" placeholder="Pesquisar..."id="pesquisa">
            <button class="btn btn-primary" onclick="searchpesuisa()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
</svg>

            </button>
        </div>
        <div id="login-container">
            

            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Id Funcionário</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Certificações</th>
                    <th scope="col">Ações</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                        while($user_data = mysqli_fetch_assoc($result))
                        {
                            echo "<tr>";
                            $id = $user_data['id'];
                            $nome = $user_data['nome'];
                            echo "<td>".$user_data['id']."</td>";
                            echo "<td>".$user_data['nome']."</td>";
                            echo "<td>".$user_data['nome_cargo']."</td>";
                            echo "<td><a class='btn btn-sm btn-primary' href='viewcertificados.php?id=$user_data[id]'>Vizualizar</a></td>";
                            echo "<td>
                                <a class='btn btn-sm btn-primary' href='edit.php?id=$user_data[id]'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                </svg> Editar
                                </a>
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
        <div class="fimpag">
            <a href="cadastro.php" class='btn btn-success'>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
            <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z"/>
            </svg> Novo usuário</a>

            <a href="novocargo.php" class="btn btn-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
             <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
             <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
            </svg> Novo cargo</a>

            <a href="novocurso.php" class="btn btn-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mortarboard-fill" viewBox="0 0 16 16">
            <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5Z"/>
            <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Z"/>
            </svg> Novo treinamento</a>




         <div>        
</body>
                        <script>
                            var search = document.getElementById('pesquisa');
                            search.addEventListener("keydown", function(event)
                            {
                                if (event.key === "Enter")
                                {
                                    searchpesuisa();
                                }
                            });
                            function searchpesuisa()
                            {
                                window.location = 'dashboard.php?search='+search.value;
                            }

                            function exclusao(id) {
                                
                            var msgs = confirm("Atenção: Deseja Excluir esse Registro?")
                            if (msgs){

                                alert("Arquivo excluido com sucesso!");
                                window.location.href=("delete.php?id="+id);

                            }
                            else{
                                alert("Operação Cancelada, o Registro não será Excluído!");


                            }
                        }
                        </script>

</html>