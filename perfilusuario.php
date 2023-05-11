<?php
        session_start();
        if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
        {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('location: login.php');
        }
        $logado = $_SESSION['email'];


    if(!empty($_GET['id']))
    {

        include_once('config.php');

        $id = $_GET['id'];

        $sqlSelect = "SELECT * FROM usuario WHERE id=$id";
        $result = $conexao -> query($sqlSelect);
        if($result->num_rows>0){
           
            while($user_data = mysqli_fetch_assoc($result))
            {
                $nome = $user_data['nome'];
                $email = $user_data['email'];
                $senha = $user_data['senha'];
                $datanas = $user_data['datanas'];
                $cargo = $user_data['cargo'];
                $admin = $user_data['admin'];
                $notificacoes = $user_data['notificacoes'];
                $acss = $user_data['arquivo'];
            } 
    
            
        }
        else
        {
            header('Location: dashboardusuario.php');
        }

    }
    else
    {
        header('Location: dashboardusuario.php');
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
    <title>Perfil</title>
    <script>
        window.onload()
    </script>
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
                <a href="dashboardusuario.php">Dashboard</a>
                <a href="sair.php">Sair</a></li>
        </div>
    </header>
        <div id="login-container" >
            <h1>Meu perfil</h1>
            <span class="subtitulo"> <?php if($acss == 1){
                echo 'Para sua segurança, altere a senha provisória que recebeu por e-mail!';
            } else{
                echo 'Seu perfil está pronto!';
            } ?> </span>
            <form action="salvarusuario.php" method="POST">
                <label id="labelnome" for="nome" style="margin-top: 0px;">Nome completo</label>
                <input id="nome" name="nomeim" style="color: white;" type="text" value="<?php echo $nome ?>" disabled=""></input>
                <input name="nome" style="color: white;" type="hidden" value="<?php echo $nome ?>" placeholder="Insira seu nome completo"></input>
                <label id="labelemail" for="email">E-mail</label>
                <input id="email" name="email" type="email" placeholder="Insira o seu E-mail" value="<?php echo $email ?>" required></input>
                <label id="labelsenha1" for="senha">Senha provisória</label>
                <input id="senha1" name="senha" type="password" value="<?php echo $senha ?>" required></input>
                <span id="leftspanpadrao">Use ao menos 8 caracteres contendo letras, numeros e caracter especial.</span> 
                <label id="labelsenha2" for="senha">Confirme a senha</label>
                <div style="width: 80%; display:flex; align-items: center; justify-content:end;">
                <input style="width: 100%;" id="senha" name="senha" type="password" value="<?php echo $senha ?>" placeholder="Digite uma senha..." required></input>
                <img src="http://i.stack.imgur.com/H9Sb2.png" id="olho" class="olho" alt="">
                </div>
                <span id="leftspan" class="leftspan">Senhas não conferem ou exigência 1 não foi atendida</span> 
                <input id="verif" name="verif" style="display: none;"  type="text" required></input> 
                <label for="datanas">Data de nascimento</label>
                <input name="datanascimento" type="date" value="<?php echo $datanas ?>" required disabled="" ></input>
                <input name="datanas" style="display: none;" type="date" value="<?php echo $datanas ?>" required ></input>
                <input type="hidden"  name="admin" type="number" max="1" min="0" value="<?php echo $admin ?>" required></input>
                <input type="hidden" name="notificacoes" type="text" value="<?php echo $notificacoes ?>" required></input>
                <input type="hidden" name="id" value="<?php echo $id ?>"></input>                
                <label for="cargo">Cargo</label>
                <input type="hidden" name="cargo" value="<?php echo $cargo ?>"></input> 
                    <?php 
                    $cargos = "SELECT * FROM role r
                    INNER JOIN usuario u on (u.cargo=r.id_cargo) WHERE id = $id ";
                    $resulta = $conexao -> query($cargos);
                    while($user_data = mysqli_fetch_assoc($resulta))
                    {
                        $nome_cargo = $user_data['nome_cargo'];
                    }
                    ?>
                <input style="color: white;" type="text" name="cargos" value="<?php echo $nome_cargo ?>" disabled=""></input>


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