<?PHP

//conexao com banco de dados mysql
$servidor = "localhost";
$usuario = "root";
$senha = "";
$bancoDeDados = "prova_curso_rbm_2023_1";
$porta = 3306;

$conexao = mysqli_connect($servidor, $usuario, $senha, $bancoDeDados, $porta);
