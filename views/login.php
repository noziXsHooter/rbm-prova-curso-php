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

<?PHP

    session_start();

    include("alerta.php");

?>

<div class ='centralizado'>
    <h1>Login</h1>

    <form class ='centralizado' id="logar" name="logar" action="../controladores/controladorIndex.php" method="post">                      
         
        <input class ='InputTextForm'  name="login" id="login" type="text" size="20" maxlength="100" placeholder='CPF'>

        <input class ='InputTextForm' name="senha" id="senha" type="password" size="20" maxlength="100" placeholder='Senha'>       
    
        <input class ='botaoAzul' type="submit" id="logarSistema" name="logarSistema" value="Entrar no Sistema" onclick="return validarDadosLogin();">
    </form>

    <a href='../index.php'>
        <input class ='botaoAmarelo' type="submit" id="telaInicial" name="telaInicial" value="Voltar para início">
    </a>

</div>