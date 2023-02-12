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

        <h1>Cadastro de clientes</h1>
        <div class ='centralizado'>

            <form class ='centralizado' id="cadastroCliente" name="cadastroCliente" action="../controladores/controladorIndex.php" method="post">
                <div class ='inputComLabel'>
                    <label class ='titulosInputs'>CPF</label>
                    <input class ='InputTextForm' name="cpfCliente" id="cpfCliente" type="text" size="30" maxlength="100">
                </div>

                <div class ='inputComLabel'>
                    <label class ='titulosInputs'>Nome</label>
                    <input class ='InputTextForm' name="nomeCliente" id="nomeCliente" type="text" size="30" maxlength="100">
                </div>

                <div class ='inputComLabel'>
                    <label class ='titulosInputs'>Data de Nascimento</label>
                    <input class ='InputTextForm' name="dataNascimentoCliente" id="dataNascimentoCliente" type="date">
                </div>

                <div class ='inputComLabel'>
                    <label class ='titulosInputs'>Celular</label>
                    <input class ='InputTextForm' name="celularCliente" id="celularCliente" type="number" min="11111111" max="99999999999">
                </div>

                <div class ='inputComLabel'>
                    <label class ='titulosInputs'>Renda mensal</label>
                    <input class ='InputTextForm' name="rendaMensalCliente" id="rendaMensalCliente" type="number" min="0.00" max="1000000.00" step="0.01" >
                </div>

                <input class ='botaoAzul' type="submit" id="cadastrarCliente" name="cadastrarCliente" value="Cadastrar" onclick="return validarDadosCadastroCliente();">
            </form>

            <a href='menu.php'>
                <input class ='botaoAmarelo' type="submit" id="telaInicial" name="telaInicial" value="Voltar">
            </a>

        </div>

    </div>