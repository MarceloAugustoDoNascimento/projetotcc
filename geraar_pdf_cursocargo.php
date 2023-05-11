<?php

// Carregar o Composer
require './vendor/autoload.php';

// Incluir conexao com BD
include_once 'config.php';

// QUERY para recuperar os registros do banco de dados
include_once('config.php');
$sqlSelect = "SELECT * FROM role r
INNER JOIN cargo_curso cc on (cc.id_cargo=r.id_cargo)
INNER JOIN curso c on (c.id_curso=cc.id_curso)";
$result = $conexao -> query($sqlSelect);

// Informacoes para o PDF
$dados = "<!DOCTYPE html>";
$dados .= "<html lang='pt-br'>";
$dados .= "<head>";
$dados .= "<meta charset='UTF-8'>";
$dados .= "<link rel='stylesheet' href='custom.css'>";
$dados .= "<title>Relatorio</title>";
$dados .= "</head>";
$dados .= "<body>";
$dados .= "<h1>Relatório de cargos e cursos relacionados  </h1>";
$dados .= "<p>Informação dos usuários cadastrados </p>";
$dados .= "<hr>";
$dados .= "<table class='table'>";
$dados .= "<thead>";
$dados .= "<tr>";
$dados .= "<th scope=\"col\">ID</th>";
$dados .= "<th scope=\"col\">Nome</th>";
$dados .= "<th scope=\"col\">Descrição</th>";
$dados .= "<th scope=\"col\">Treinamentos</th>";
$dados .= "<th scope=\"col\">Validade</th>";

$dados .= "</tr>";
$dados .= "</thead>";
$dados .= "<tbody>";

// Ler os registros retornado do BD
$dados .= "<hr>";
while($user_data = mysqli_fetch_assoc($result)){
    extract($user_data);
    $dados .= "<tr>";
    $dados .= "<td> $id_cargo </td>";
    $dados .= "<td> $nome_cargo </td>";
    $dados .= "<td> $descricao </td>";
    $dados .= "<td> $nome_curso </td>";
    $dados .= "<td> $validade meses</td>";

    
    //$dados .= "Nome: $nome <br>";
    //$dados .= "E-mail: $email <br>";
    //$dados .= "Arquivo $nome_curso:<a target=\"_blank\" href = \"upload/$nome_arquivo\">$nome_arquivo</a> <br>";
    ////$dados .= "Validade do treinamento: $validade_arquivo <br>";
    //$dados .= "Data do envio: $data_envio <br>";
    //$dados .= "id: $id <br>";
    $dados .= "</tr>";

    
}
$dados .= "</tbody>";
$dados .= "</table>";






$dados .= "<hr>";
$dados .= "Relatório de cargos cadastrados e seus devidos treinamentos mandatórios.";
$dados .= "</body>";


// Referenciar o namespace Dompdf
use Dompdf\Dompdf;

// Instanciar e usar a classe dompdf
$dompdf = new Dompdf(['enable_remote' => true]);

// Instanciar o metodo loadHtml e enviar o conteudo do PDF
$dompdf->loadHtml($dados);

// Configurar o tamanho e a orientacao do papel
// landscape - Imprimir no formato paisagem
//$dompdf->setPaper('A4', 'landscape');
// portrait - Imprimir no formato retrato
$dompdf->setPaper('A4', 'portrait');

// Renderizar o HTML como PDF
$dompdf->render();

// Gerar o PDF
$dompdf->stream();

