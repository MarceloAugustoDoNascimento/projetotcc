<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="login.css">
    <script src="styless.js" defer></script>
    <title>Login</title>
</head>
<body>
        <div class="saibamais" >
            <a href="email.php" style="font-size: 1.5rem; text-decoration:none;">Precisa de ajuda? >></a>
            </div>
        </div>
        <div id="login-container">
            <h1 style="font-size: 60px; color: #58d0ff; font-weight: bold;">
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
        </svg>
        

</h1>
<h1>Login</h1>
            <form action="configLogin.php" method="POST" class="form">
                <label for="E-mail">E-mail</label>
                <input class="marginInput" name="email" type="email" placeholder="Insira o seu E-mail"></input>
                <label for="senha">Senha</label>
                <input name="senha" type="password" placeholder="Insira sua senha..."></input>
                <input type="submit" name="submit" value="Entrar"></input>
            </form>  
        </div> 
        

</body>

</html>