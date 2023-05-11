<?php
    if(!empty($_GET['id']))
    {
        include_once('config.php');

        $id = $_GET['id'];

        $sqlSelect = "SELECT * FROM email WHERE id_email=$id";
        $result = $conexao -> query($sqlSelect);
        if($result->num_rows>0){
           
            $sqlDelete = "DELETE FROM email WHERE id_email = '$id'";
            $resultDelete = $conexao -> query($sqlDelete);
        }
    }
    header('Location: dashboard.php');
?>