<?PHP

if(!isset($_SESSION['logado'])){

    $sucesso = false;
    $mensagem = "Usuário não logado!";

    $url = "Location: login.php?sucesso=$sucesso&mensagem=$mensagem&resultado=$resultado";

    header($url);

}