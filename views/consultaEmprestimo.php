<?PHP
session_start();

include "verifica.php";
include "alerta.php";

?>

<html>

<head>
    <title>
        Crédito fácil
    </title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../estilos/estiloGeral.css">

</head>

<body>

<div class ='centralizado'>
    <h1>Consulta de Empréstimo</h1>

    <form class ='centralizado' id="consultaEmprestimo" name="consultaEmprestimo" action="../controladores/controladorIndex.php" method="post">
        <div class ='inputComLabel'>
            <label class ='titulosInputs'>Consultar Por</label><br>


            <input name="tipoConsulta" id="tipoConsulta" type="radio" value="cpf">
            CPF 

            <input name="tipoConsulta" id="tipoConsulta" type="radio" value="nome">
            Nome             

            <input name="tipoConsulta" id="tipoConsulta" type="radio" value="todos">
            Todos 
        </div>

        <div class ='inputComLabel'>
            <label class ='titulosInputs'>CPF</label>
            <input class ='InputTextForm' name="cpf" id="cpf" type="text" size="30" maxlength="100">
        </div>

        <div class ='inputComLabel'>
            <label class ='titulosInputs'>NOME</label>
            <input class ='InputTextForm' name="nome" id="nome" type="text" size="30" maxlength="100">
        </div>

        <input class ='botaoAzul' type="submit" id="consultarEmprestimo" name="consultarEmprestimo" value="Consultar">
    </form>

    <a href='menu.php'>
        <input class ='botaoAmarelo' type="submit" id="telaInicial" name="telaInicial" value="Voltar">
    </a>
</div>

<br><br>
<?php

if (isset($_GET['resultado'])) {

    $resultado = json_decode($_GET['resultado'], true);

    if (!empty($resultado)) {

        $titulo = $resultado[0];

        echo "<table style='text-align: center;' width='100%'><tr>";
        foreach ($titulo as $chave => $valor) {
            echo "<th>$chave</th>";
        }
        echo "<th>AÇÕES</th>";
        echo '</tr>';


        foreach ($resultado as $chave => $valor) {
            echo '<tr>';
            foreach ($valor as $chave2 => $valor2) {
                echo "<td>$valor2</td>";
            }
            echo "<td>EDT  EXC</td>";
            echo '</tr>';
        }

        echo '</table>';
    }
}
?>