
<?php
        
include_once('config.php');
$id_arquivo = $_GET['id_arquivo'];
$sqlUpdate = "UPDATE arquivo_envio SET status ='indeferido' WHERE id_arquivo ='$id_arquivo'";
$result = $conexao -> query($sqlUpdate);

echo "<script language='javascript'>history.back()</script>";


?>