<?php
    session_start();
    if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha']))
    {
        include_once('config.php');
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        

        $sql = "SELECT * FROM usuario WHERE email = '$email' and senha = '$senha'";
        $result = $conexao->query($sql);

        if(mysqli_num_rows($result)<1)
        {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('Location: login.php');
        } 
        else
        {
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
            $sql = "SELECT * FROM usuario WHERE email = '$email' and senha = '$senha' and admin = 1";
            $result = $conexao->query($sql);
            if(mysqli_num_rows($result)<1){
                $sql = "SELECT * FROM usuario";
                $resultado = $conexao->query($sql);
                while($prod = mysqli_fetch_array($resultado)){ 
                    $emailatual = $prod['email'];
                    if($email == $emailatual){
                        
                        $id_funcionario=$prod['id'];
                        $acss = $prod['arquivo'];
                        
                    }

                }   

                if($acss == '1'){
                    header("Location: perfilusuario.php?id=$id_funcionario");
                }else{
                    
                header('Location: dashboardusuario.php');
            }
            }
            else {
                header('Location: dashboard.php');   
            }
        }
    }
    else{
        echo 'erro';
        header('Location: login.php');
    }

?>