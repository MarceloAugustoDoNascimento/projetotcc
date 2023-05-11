<?php

use Sabberworm\CSS\Value\Value;

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

    $nome = '';
    $email = '';
    $senha1 = '';
    $senha = '';
    $datanas = '';
    $cargo = '';
    $admin = '';

    $contemail = '0';
    if(isset($_POST['submit']))
    {

        include_once('config.php');

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha1 = $_POST['senha1'];
        $senha = $_POST['senha'];
        $datanas = $_POST['datanas'];
        $cargo = $_POST['cargo'];
        $admin = $_POST['admin'];
        $verif = $_POST['verif'];
        
        $sel = "SELECT * FROM usuario";
        $rex = $conexao -> query($sel);
        
        while($user_dats = mysqli_fetch_assoc($rex))
        {
             $emailjaexistente = $user_dats['email'];
             if($email == $emailjaexistente){
                $contemail = '1';
             }
        }
        if($contemail == '0'){
        $result = mysqli_query($conexao, "INSERT INTO usuario(nome,email,senha,datanas,cargo,admin,notificacoes, arquivo) VALUES ('$nome', '$email', '$senha', '$datanas', '$cargo', '$admin','ativo','1')");

        //arquivos esperados do usuario de acordo com o cargo
        $sqlSelectn = "SELECT * FROM usuario u
        INNER JOIN cargo_curso cc on (cc.id_cargo = u.cargo)
        INNER JOIN curso c on (c.id_curso=cc.id_curso)";
        $resultadon = $conexao -> query($sqlSelectn);
        while($user_data2 = mysqli_fetch_assoc($resultadon))
        { 

        $emailatual = $user_data2['email'];
        $id = $user_data2['id'];
        $id_curso= $user_data2['id_curso'];
        if($email == $emailatual){
            $sqlcode = mysqli_query($conexao, "INSERT INTO arquivo_envio (id_usuario,id_curso, nome_arquivo, data_feito, data_envio, validade_arquivo, status) VALUES ('$id', '$id_curso', '-','0000-00-00', '0000-00-00', '-', 'não enviado')"); 

        }
        }
        //envio de email para usuario confirmando cadastro

        header('Location: ind.php');





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
    <title>Cadastro</title>
</head>
<body>
    <header>
        <div class="icone">
            <img src="iconev.webp"></img>
            <div id="nomelogos" style=" color: white; font-weight:bold;">
                <h4>Gestão de certificações</h4>
            </div>
        </div>
        <div>
                <a href="dashboard.php">Dashboard</a>
                <a href="sair.php">Sair</a></li>
        </div>
    </header>
        <div id="login-container"  >
            <h1 >Cadastro de usuário</h1>
            <?php 
            if($contemail == '1'){
                echo '<h4 style="color: red;">Já existe um usuário cadastrado com este e-mail!</h4>';
                $nome = $_POST['nome'];
                $senha1 = $_POST['senha1'];
                $senha = $_POST['senha'];
                $datanas = $_POST['datanas'];
                $cargo = $_POST['cargo'];
                $admin = $_POST['admin'];
                $verif = $_POST['verif'];
             }
             ?>
            <span class="subtitulo">Preencha as informações corretamente.</span>
            <form action="cadastro.php" method="POST">
                <label id="labelnome" for="nome" style="margin-top: 0px;">Nome completo</label>
                <input id="nome" name="nome" type="text" placeholder="Insira seu nome completo" value="<?php echo $nome ?>" required></input>
                <label id="labelemail" for="email">E-mail</label>
                <input id="email" name="email" type="email" placeholder="Insira o seu E-mail" value="<?php echo $email ?>" required></input>
                <label id="labelsenha1" for="senha1">Senha provisória</label>
                <input id="senha1" name="senha1" type="password" placeholder="Digite uma senha..." value="<?php echo $senha ?>" required></input>
                <span id="leftspanpadrao">Use ao menos 8 caracteres contendo letras, numeros e caracter especial.</span>
                <label id="labelsenha2" for="senha">Confirme a senha</label>
                <div style="width: 80%; display:flex; align-items: center; justify-content:end;">
                <input style="width: 100%;" id="senha" name="senha" type="password" placeholder="Digite uma senha..." value="<?php echo $senha ?>" required></input>
                <img src="http://i.stack.imgur.com/H9Sb2.png" id="olho" class="olho" alt="">
                </div>
                <span id="leftspan" class="leftspan">Senhas não conferem ou exigência 1 não foi atendida</span> 
                <input id="verif" style="display: none;" name="verif"  type="text" required></input>
                <label for="datanas">Data de nascimento</label>
                <input name="datanas" type="date" required value="<?php echo $datanas ?>"></input>  
                <label for="admin">Administrador (1 para usuário admin)</label>
                <input name="admin" type="number" max="1" min="0" placeholder="Escreva 0 ou 1" value="<?php echo $admin ?>" required></input>               
                <label for="cargo">Cargo</label>
                <select name="cargo" required><option>Selecione...</option>
                <?php
                                    include_once('config.php');
                                    $sqlcargo = "SELECT * FROM role";
                                    $resultado = $conexao -> query($sqlcargo);
                                    while($prod = mysqli_fetch_array($resultado)){ ?>
                                        <option value=" <?php echo $prod['id_cargo'] ?>">
                                            <?php echo $prod['nome_cargo'] ?>
                                        </option>
                
                                    <?php } ?>
                                </select>
                

                <input name="submit" type="submit" value="Cadastrar"></input>
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