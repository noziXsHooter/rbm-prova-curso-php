<?PHP

    session_start();

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

<div class ='menu'>    
    <div class ='centralizado'>
          <img src="../imagens/icone_dinheiro.png" width="150px" height="190px">

        <?=renderizarMenu()?>       
    </div>
</div>

<?php

    function renderizarMenu(){
        if (!isset($_SESSION['logado'])) {
            return "            
                <a href='login.php'>
                    <input class ='botaoAzul' type='submit' id='entrar' name='entrar' value='Logar'>
                </a>
            ";
        }

        return "
            <a href='cadastroClientes.php'>
                <input class ='botaoAzul' type='submit' id='cadastrarClientes' name='cadastrar' value='Cadastrar clientes'>
            </a>
        
            <a href='consultaClientes.php'>
                <input class ='botaoAzul' type='submit' id='consultarClientes' name='consultar' value='Consultar clientes'>
            </a>

            <a href='lancamentoEmprestimo.php'>
                <input class ='botaoAzul' type='submit' id='lancarEmprestimo' name='lancarEmprestimo' value='Lançar empréstimos'>
            </a>

            <a href='consultaEmprestimo.php'>
                <input class ='botaoAzul' type='submit' id='consultarEmprestimos' name='consultarEmprestimos' value='Consultar empréstimos'>
            </a>
               
            <a href='sair.php'>
                <input class ='botaoAmarelo' type='submit' id='sair' name='sair' value='Logout'>
            </a>
        ";        
    }

?>