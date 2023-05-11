<?php
    if(isset($_POST['submit']))
    {

        include_once('config.php');

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cargo = $_POST['cargo'];

        $result = mysqli_query($conexao, "INSERT INTO email(nome,email,datanas,cargo,msg) VALUES ('$nome', '$email', '$cargo')");
        header('Location: login.php');

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
    <script src="styless.js" defer></script>
    <title>Solicitação</title>
</head>
<body>
    <header>
        <div class="icone">
            <img src="iconev.webp"></img>
            <div id="nomelogos" style=" color: white; font-weight:bold;">
                <h4>Gestão de Certificações</h4>
            </div>
        </div>
        <div>
                
                <a href="login.php">Login</a></li>
        </div>
    </header>
        <div id="login-container"  >
            <h1 >Recuperação de conta</h1>
            <span class="subtitulo">Preencha as informações corretamente.</span>
            <form action="email.php" method="POST">
                <label for="nome" style="margin-top: 0px;">Nome completo</label>
                <input name="nome" type="text" placeholder="Insira seu nome completo" required></input>
                <label for="email">E-mail</label>
                <input name="email" type="email" placeholder="Insira o seu E-mail" required></input>            
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
                
                <input name="submit" type="submit" value="Enviar"></input>
            </form>  
        </div>         
</body>
</html>