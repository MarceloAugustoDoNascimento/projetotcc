<?php
        if(!empty($_GET['email']))
        {

            include_once('config.php');

            $email = $_GET['email'];

            $sqlSelect = "SELECT * FROM usuario";
            $result = $conexao -> query($sqlSelect);
            while($user_data = mysqli_fetch_assoc($result))
            {   
                $emailat = $user_data['email'];
                if($email == $emailat){
                    $id = $user_data['id'];
                    $cargo = $user_data['cargo'];

                }
            }
            $sqlSelect = "SELECT * FROM usuario u
            INNER JOIN cargo_curso cc on (u.cargo = cc.id_cargo)
            INNER JOIN curso c on (cc.id_curso = c.id_curso)";
            $result = $conexao -> query($sqlSelect);
            while($user_data = mysqli_fetch_assoc($result))
            {   
                $validade = $user_data['validade'];
                $curso = $user_data['id_curso'];
                if($email == $emailat){
                    $sqlcode = mysqli_query($conexao, "INSERT INTO arquivo_envio (id_usuario,id_curso, nome_arquivo, data_feito, data_envio, validade_arquivo) VALUES ('$id', '$curso', 'não enviado','-', NOW(), '$validade')"); 

                }
            }

        }
        else
        {
            echo 'não achou nada';
        }

        echo 'foi mas não fou';

?>