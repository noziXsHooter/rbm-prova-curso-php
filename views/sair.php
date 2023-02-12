<?PHP

$sucesso = true;
$mensagem = "Deslogado.";

$url = "Location: login.php?sucesso=$sucesso&mensagem=$mensagem&resultado=$resultado";

unset($_SESSION['logado']);
unset($_SESSION['nome']);
session_destroy();

header($url);
