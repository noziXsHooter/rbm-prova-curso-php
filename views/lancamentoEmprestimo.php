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
    <script src="../js/validacaoLoginOtimizado.js"></script>

</head>

<body>

    <div class ='centralizado'>

        <h1>Lançamento de empréstimos</h1>
        <div class ='centralizado'>

            <form class ='centralizado' id="lancamentoEmprestimo" name="lancamentoEmprestimo" action="../controladores/controladorIndex.php" method="post">
                <div class ='inputComLabel'>
                    <label class ='titulosInputs'>CPF Cliente</label>
                    <input class ='InputTextForm' name="cpfCliente" id="cpfCliente" type="text" size="30" maxlength="100">
                </div>

                <div class ='inputComLabel'>
                    <label class ='titulosInputs'>Valor solicitado</label>
                    <input class ='InputTextForm' name="valorSolicitado" id="valorSolicitado" type="number" min="0.00" max="1000000.00" step="0.01" >
                </div>

                <div class ='inputComLabel'>
                    <label class ='titulosInputs'>Quantidade de parcelas</label>
                    <input class ='InputTextForm' name="quantidadeParcelas" id="quantidadeParcelas" type="number" min="0" max="300">
                </div>

                <input class ='botaoAzul' type="submit" id="lancarEmprestimo" name="lancarEmprestimo" value="Cadastrar">
            </form>

            <a href='menu.php'>
                <input class ='botaoAmarelo' type="submit" id="telaInicial" name="telaInicial" value="Voltar">
            </a>

        </div>

    </div>