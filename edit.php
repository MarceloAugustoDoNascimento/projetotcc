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
    
    
    


    if(!empty($_GET['id']))
    {

        include_once('config.php');

        $id = $_GET['id'];

        $sqlSelect = "SELECT * FROM role r
        INNER JOIN usuario u on (u.cargo =r.id_cargo) WHERE id=$id";
        $result = $conexao -> query($sqlSelect);
        if($result->num_rows>0){
           
            while($user_data = mysqli_fetch_assoc($result))
            {
                $nome = $user_data['nome'];
                $email = $user_data['email'];
                $senha = $user_data['senha'];
                $datanas = $user_data['datanas'];
                $cargo = $user_data['cargo'];
                $nomecargo = $user_data['nome_cargo'];
                $admin = $user_data['admin'];
                $notificacoes = $user_data['notificacoes'];
            } 
    
            
        }
        else
        {
            header('Location: dashboard.php');
        }

    }
    else
    {
        header('Location: dashboard.php');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cadastro.css">
    <style>
            .olho {
            cursor: pointer;
            width: 2.5rem;
            height: 2.5rem;
            position:absolute;
            

          }
    </style>
    <script src="cadastrar.js" defer></script>

    <title>Editar</title>

</head>
<body>
    <header>
        <div class="icone">
            <img src="iconev.webp"></img>
            <div id="nomelogos" style="padding-top: 1px;">
                <h4>Gestão de Certificações</h4>
            </div>
        </div>
        <div>
                <a href="dashboard.php">Dashboard</a>
                <a href="sair.php">Sair</a></li>
        </div>
    </header>
        <div id="login-container" >
            <h1>Cadastro de usuário</h1>
            <span class="subtitulo"> Conta de usuário de acordo com função.</span>
            <form action="salvar.php" method="POST">
                <label id="labelnome" for="nome" style="margin-top: 0px;">Nome completo</label>
                <input id="nome" name="nome" type="text" placeholder="Insira seu nome completo" value="<?php echo $nome ?>" required></input>
                <label id="labelemail" for="email">E-mail</label>
                <input id="email" name="email" type="email" placeholder="Insira o seu E-mail" value="<?php echo $email ?>" required></input>
                <label id="labelsenha1" for="senha">Senha provisória</label>
                <input id="senha1" name="senha1" type="password" value="<?php echo $senha ?>" required></input>
                <span id="leftspanpadrao">Use ao menos 8 caracteres contendo letras, numeros e caracter especial.</span>
                <label id="labelsenha2" for="senha">Confirme a senha</label>
                <div style="width: 80%; display:flex; align-items: center; justify-content:end;">
                <input style="width: 100%;" id="senha" name="senha" type="password" value="<?php echo $senha ?>" placeholder="Digite uma senha..." required></input>
                <img src="http://i.stack.imgur.com/H9Sb2.png" id="olho" class="olho" alt="">
                </div>
                <span id="leftspan" class="leftspan">Senhas não conferem ou exigência 1 não foi atendida</span> 
                <input id="verif" name="verif" style="display: none;"  type="text" required></input>  
                <label for="datanas">Data de nascimento</label>
                <input name="datanas" type="date" value="<?php echo $datanas ?>" required></input>
                <label for="admin">Administrador (1 para usuário admin)</label>
                <input name="admin" type="number" max="1" min="0" value="<?php echo $admin ?>" required></input>
                <label for="notificacoes">Observação</label>
                <input name="notificacoes" type="text" value="<?php echo $notificacoes ?>" required></input>
                <input type="hidden" name="id" value="<?php echo $id ?>"></input>                
                <label for="cargo">Cargo</label>
                <select name="cargo" required><option value=" <?php echo $cargo ?>">
                                            <?php echo $nomecargo ?>
                                        </option>
                <?php
                                    include_once('config.php');
                                    $sqlcargo = "SELECT * FROM role";
                                    $resultado = $conexao -> query($sqlcargo);
                                    while($prod = mysqli_fetch_array($resultado)){ 
                                        $idcargo =  $prod['id_cargo'];?>
                                    
                                        <option value=" <?php echo $idcargo ?>">
                                            <?php echo $prod['nome_cargo'] ?>
                                        </option>
                
                                    <?php } ?>
                                </select>

                <input name="update" type="submit" value="Salvar" style="width: 100px;"></input>
            </form>  
        </div>         
</body>
<script>
        var input = document.querySelector('#senha');
        var input2 = document.querySelector('#senha1');
        var img = document.querySelector('#olho');
        var visivel = false;
        img.addEventListener('mousedown', function () {
        visivel = true;
        input.type = 'text';
        input2.type = 'text';
        });
        window.addEventListener('mouseup', function (e) {
        if (visivel) visivel = !visivel;
        input.type = 'password';
        input2.type = 'password';
        });
    </script>
</html>