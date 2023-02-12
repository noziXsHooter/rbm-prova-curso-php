
<?PHP
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once("../inc/conecta.php");


if(isset($_POST['tipoConsulta']) and $_POST['tipoConsulta'] == 'cpf'){

    $cpf = $_POST['cpf'];

    $retorno = consultarClientePorCpf($cpf);

    $sucesso  = $retorno['sucesso'];
    $mensagem = $retorno['mensagem'];
}

if(isset($_POST['tipoConsulta']) and $_POST['tipoConsulta'] == 'nome'){
    $nome = $_POST['nome'];

    $retorno = consultarClientePorNome($nome);

    $sucesso  = $retorno['sucesso'];
    $mensagem = $retorno['mensagem'];

}

if(isset($_POST['tipoConsulta']) and $_POST['tipoConsulta'] == 'todos'){

    $dados = listarClientes($dados = null);
   $retorno =  $dados;

} 


if (isset($_POST['logarSistema'])) {
    $retorno = logarSistema($_POST);

    $sucesso  = $retorno['sucesso'];
    $mensagem = $retorno['mensagem'];

    if ($sucesso) {
        $url = "Location: ../views/menu.php?sucesso=$sucesso&mensagem=$mensagem";        
    }else{
        $url = "Location: ../views/login.php?sucesso=$sucesso&mensagem=$mensagem";
    }
    
    header($url);
}

if (isset($_POST['cadastrarCliente'])) {

    $retorno = cadastrarCliente();

    $sucesso  = $retorno['sucesso'];
    $mensagem = $retorno['mensagem'];

    $url = "Location: ../views/cadastroClientes.php?sucesso=$sucesso&mensagem=$mensagem";
    header($url);
}

if (isset($_POST['consultarCliente'])) {

    $tipoConsulta = isset($_POST['tipoConsulta']) ? $_POST['tipoConsulta'] : null;

    $cpf  = isset($_POST['cpf']) ? $_POST['cpf'] : null;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : null;

    if ($tipoConsulta == 'cpf') {
        $retorno = consultarClientePorCpf($cpf);
    } else if ($tipoConsulta == 'nome') {
        $retorno = consultarClientePorNome($nome);
    }else if($tipoConsulta == 'todos'){
        $retorno = listarClientes();
    }

    $sucesso  = $retorno['sucesso'];
    $mensagem = $retorno['mensagem'];
    $resultado = $retorno['resultado'];

    $url = "Location: ../views/consultaClientes.php?sucesso=$sucesso&mensagem=$mensagem&resultado=$resultado";

    header($url);

    exit;
}

if (isset($_POST['consultarEmprestimo'])) {

    $tipoConsulta = isset($_POST['tipoConsulta']) ? $_POST['tipoConsulta'] : null;

    $cpf  = isset($_POST['cpf']) ? $_POST['cpf'] : null;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : null;

    if ($tipoConsulta == 'cpf') {
        $retorno = consultarEmprestimoPorCpf($cpf);
    } else if ($tipoConsulta == 'nome') {
        $retorno = consultarEmprestimoPorNome($nome);
    }else if($tipoConsulta == 'todos'){
        $retorno = listarEmprestimos();
    }

    $sucesso  = $retorno['sucesso'];
    $mensagem = $retorno['mensagem'];
    $resultado = $retorno['resultado'];

    $url = "Location: ../views/consultaEmprestimo.php?sucesso=$sucesso&mensagem=$mensagem&resultado=$resultado";

    header($url);

    exit;
}

if (isset($_POST['lancarEmprestimo'])) {

    $retorno = lancarEmprestimo();

    $sucesso  = $retorno['sucesso'];
    $mensagem = $retorno['mensagem'];

    $url = "Location: ../views/lancamentoEmprestimo.php?sucesso=$sucesso&mensagem=$mensagem";
    header($url);
}


function logarSistema($dados)
{
    global $conexao;

    $cpf = isset($dados['login']) ? $dados['login'] : null;
    $senha = isset($dados['senha']) ? $dados['senha'] : null;

    $sql = "SELECT NOME FROM usuarios WHERE CPF = '$cpf' AND SENHA = '$senha'";
    $consulta = mysqli_query($conexao, $sql);
    $qtdPessoas = mysqli_num_rows($consulta);

    if ($qtdPessoas > 0) {
        $pessoa = mysqli_fetch_assoc($consulta);

        $_SESSION['logado'] = 'OK';
        $_SESSION['nome'] =  $pessoa['NOME'];

        return [
            "sucesso" => true,
            "mensagem" => "Login realizado.",
            "resultado" => json_encode(array($pessoa))
        ];
    }

    return [
        "sucesso" => false,
        "mensagem" => "Login inválido."
    ];
}

function cadastrarCliente(): array
{
    global $conexao;

    if (!validarDadosObrigatorios($_POST)) {
        return [
            "sucesso" => false,
            "mensagem" => "Dados informados incompletos."
        ];
    }

    $cpf            = $_POST['cpfCliente'];
    $nome           = $_POST['nomeCliente'];
    $dataNascimento = $_POST['dataNascimentoCliente'];
    $celular        = $_POST['celularCliente'];
    $rendaMensal    = $_POST['rendaMensalCliente'];

    $sqlSelect = "SELECT ID FROM clientes WHERE CPF = '$cpf'";

    $retornoSelect = mysqli_query($conexao, $sqlSelect);
    $quantidadeClientes = mysqli_num_rows($retornoSelect);

    if ($quantidadeClientes > 0) {
        return [
            "sucesso" => false,
            "mensagem" => "Cliente já cadastrado."
        ];
    }

    try {
        $sqlInsert = "INSERT INTO clientes (CPF, NOME, DATA_NASCIMENTO, CELULAR, RENDA_MENSAL) 
                      VALUES ('$cpf', '$nome', '$dataNascimento', '$celular', '$rendaMensal')";

        $retornoInsert = mysqli_query($conexao, $sqlInsert);

        if (!$retornoInsert) {
            throw new Exception(mysqli_error($conexao));
        }
    } catch (Exception $e) {
        return [
            "sucesso" => false,
            "mensagem" => $e->getMessage()
        ];
    }

    return [
        "sucesso" => true,
        "mensagem" => "Cliente cadastrado."
    ];
}

function lancarEmprestimo(): array
{
    global $conexao;

    if (!validarDadosObrigatorios($_POST)) {
        return [
            "sucesso" => false,
            "mensagem" => "Dados informados incompletos."
        ];
    }

    $cpf = $_POST['cpfCliente'];
    $valorSolicitado  = (float)$_POST['valorSolicitado'];
    $quantidadeParcelas = $_POST['quantidadeParcelas'];

    $sqlSelect = "SELECT ID FROM clientes WHERE CPF = '$cpf'";
    
    $retornoSelect = mysqli_query($conexao, $sqlSelect);

    $idCliente = mysqli_fetch_assoc($retornoSelect);

    $quantidadeClientes = mysqli_num_rows($retornoSelect);

    if ($quantidadeClientes = 0) {
        return [
            "sucesso" => false,
            "mensagem" => "Esse CPF não existe. Coloque um CPF já cadastrado!"
        ];
    }

    $valorTarifaCadastro = $valorSolicitado*(5/100);

    if($valorTarifaCadastro > 110){
        $valorTarifaCadastro = 110;
    }

    $idCliente = $idCliente['ID'];

    $valorIof = ((0.38/100) * $valorSolicitado) + ((0.0082/100) * $valorSolicitado * $quantidadeParcelas * 30);

    $valorTotalFinanciado =  $valorSolicitado + $valorTarifaCadastro + $valorIof;

    $valorParcela = $valorTotalFinanciado / $quantidadeParcelas;

    //INSERT EMPRESTIMO NO DB
    try {
        $sqlInsertEmp = "INSERT INTO emprestimos (ID_CLIENTE, VALOR_TOTAL_FINANCIADO, VALOR_SOLICITADO, QUANTIDADE_PARCELAS, VALOR_PARCELA, VALOR_IOF, VALOR_TARIFA_CADASTRO) 
                        VALUES ('$idCliente','$valorTotalFinanciado','$valorSolicitado','$quantidadeParcelas','$valorParcela','$valorIof','$valorTarifaCadastro')";

        $retornoInsertEmp = mysqli_query($conexao, $sqlInsertEmp);

        if (!$retornoInsertEmp) {
            throw new Exception(mysqli_error($conexao));
        }
    } catch (Exception $e) {

        return [
            "sucesso" => false,
            "mensagem" => $e->getMessage()
        ];
    }

    //PEGA O ID DA ULTMA INSERÇÃO DE EMPRESTIMO PARA CRIAR AS PARCELAS
    try{
            $sql = "SELECT ID FROM emprestimos ORDER BY ID DESC";
            $retornoUltimoEmprestimo = mysqli_query($conexao, $sql);

            $idUltimoEmprestimo = mysqli_fetch_assoc($retornoUltimoEmprestimo);
            $idUltimoEmprestimo = $idUltimoEmprestimo['ID'];


        } catch (Exception $e) {

            return [
                "sucesso" => false,
                "mensagem" => $e->getMessage()
            ];
        }

    //INSERT PARCELAS
    try {
  
        $date = new DateTime();
        for ($i=0; $i < $quantidadeParcelas; $i++) { 

            $dataVencimento = $date->modify('+1 month');
            $dataVencimento = $date->format("Y-m-11");

            $sqlInsertParc = "INSERT INTO parcelas (ID_EMPRESTIMO, VALOR_PARCELA, STATUS_PAGAMENTO, VENCIMENTO) VALUES ('$idUltimoEmprestimo','$valorParcela','EM ABERTO','$dataVencimento')";

            $retornoInsertParc = mysqli_query($conexao, $sqlInsertParc);
        }

        if (!$retornoInsertParc) {
            throw new Exception(mysqli_error($conexao));
        }
    } catch (Exception $e) {

        exit();
        return [
            "sucesso" => false,
            "mensagem" => $e->getMessage()
        ];
    }

    return [
        "sucesso" => true,
        "mensagem" => "Emprestimo cadastrado."
    ];
}

function listarClientes($dados = null)
{
    global $conexao;    

    $sql = "SELECT * FROM clientes";   

    $consulta = mysqli_query($conexao, $sql);

    $resultado = array();

    while ($dados = mysqli_fetch_assoc($consulta)) {
        $resultado[] = $dados;
    }


    if (count($resultado) == 0) {
        return [
            "sucesso" => false,
            "mensagem" => "Base de pessoas está limpa."
        ];
    }

    return [
        "sucesso" => true,
        "mensagem" => "Dados listados com sucesso!",
        "resultado" => json_encode($resultado)
    ];
}

function consultarClientePorCpf($cpf)
{
    global $conexao;

    //consultar pessoa
    $sql = "SELECT * FROM clientes WHERE CPF = '$cpf'";
    $consulta = mysqli_query($conexao, $sql);
    $qtdPessoas = mysqli_num_rows($consulta);

    if ($qtdPessoas > 0) {
        $pessoa = mysqli_fetch_assoc($consulta);

        return [
            "sucesso" => true,
            "mensagem" => "Pessoa consultada.",
            "resultado" => json_encode(array($pessoa))
        ];
    } else {
        return [
            "sucesso" => false,
            "mensagem" => "Pessoa não localizada."
        ];
    }
}

function consultarClientePorNome($nome)
{
    global $conexao;

    //consultar pessoa
    $sql = "SELECT * FROM clientes WHERE NOME LIKE '%$nome%'"; 
    $consulta = mysqli_query($conexao, $sql);
    $qtdPessoas = mysqli_num_rows($consulta);

    if ($qtdPessoas > 0) {
        $pessoa = mysqli_fetch_assoc($consulta);

        return [
            "sucesso" => true,
            "mensagem" => "Pessoa consultada.",
            "resultado" => json_encode(array($pessoa))
        ];
    } else {
        return [
            "sucesso" => false,
            "mensagem" => "Pessoa não localizada."
        ];
    }
}

function listarEmprestimos($dados = null)
{
    global $conexao;    

    $sql = "SELECT e.ID, c.NOME, e.VALOR_TOTAL_FINANCIADO, e.VALOR_SOLICITADO, e.QUANTIDADE_PARCELAS, e.VALOR_PARCELA, e.VALOR_IOF, e.VALOR_TARIFA_CADASTRO 
            FROM emprestimos AS e INNER JOIN clientes AS c ON e.ID_CLIENTE=c.ID";

    $consulta = mysqli_query($conexao, $sql);

    $resultado = array();

    while ($dados = mysqli_fetch_assoc($consulta)) {
        $resultado[] = $dados;
    }

    if (count($resultado) == 0) {
        return [
            "sucesso" => false,
            "mensagem" => "Base de pessoas está limpa."
        ];
    }

    return [
        "sucesso" => true,
        "mensagem" => "Dados listados com sucesso!",
        "resultado" => json_encode($resultado)
    ];
}

function consultarEmprestimoPorCpf($cpf)
{
    global $conexao;

    //consultar emprestimo
    $sql = "SELECT e.ID, c.NOME, e.VALOR_TOTAL_FINANCIADO, e.VALOR_SOLICITADO, e.QUANTIDADE_PARCELAS, e.VALOR_PARCELA, e.VALOR_IOF, e.VALOR_TARIFA_CADASTRO 
            FROM emprestimos AS e INNER JOIN clientes AS c ON e.ID_CLIENTE=c.ID WHERE c.CPF='$cpf'";
    $consulta = mysqli_query($conexao, $sql);
    $qtdPessoas = mysqli_num_rows($consulta);

    if ($qtdPessoas > 0) {
        $pessoa = mysqli_fetch_assoc($consulta);

        return [
            "sucesso" => true,
            "mensagem" => "Empréstimo consultado.",
            "resultado" => json_encode(array($pessoa))
        ];
    } else {
        return [
            "sucesso" => false,
            "mensagem" => "Empréstimo não localizado."
        ];
    }
}

function consultarEmprestimoPorNome($nome)
{
    global $conexao;

    //consultar emprestimo
    $sql = "SELECT e.ID, c.NOME, e.VALOR_TOTAL_FINANCIADO, e.VALOR_SOLICITADO, e.QUANTIDADE_PARCELAS, e.VALOR_PARCELA, e.VALOR_IOF, e.VALOR_TARIFA_CADASTRO 
    FROM emprestimos AS e INNER JOIN clientes AS c ON e.ID_CLIENTE=c.ID WHERE c.NOME LIKE '%$nome%'"; 
    $consulta = mysqli_query($conexao, $sql);
    $qtdEmprestimos = mysqli_num_rows($consulta);

    if ($qtdEmprestimos > 0) {
        $pessoa = mysqli_fetch_assoc($consulta);

        return [
            "sucesso" => true,
            "mensagem" => "Emprestimo consultado.",
            "resultado" => json_encode(array($pessoa))
        ];
    } else {
        return [
            "sucesso" => false,
            "mensagem" => "Empréstimo não localizado."
        ];
    }
}


/**
 * Valida dados do formulário que são obrigatórios
 *
 * @param array $dadosFormulario
 *
 * @return bool
 */
function validarDadosObrigatorios(array $dadosFormulario): bool
{

    foreach ($dadosFormulario as $dado) {
        if (!isset($dado)) {
            return false;
        }

        if (empty($dado)) {
            return false;
        }
    }

    return true;
}


/* 

echo"<pre>";
print_r($_POST);
exit();

*/