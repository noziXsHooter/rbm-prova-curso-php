<?PHP


if (isset($_GET['sucesso'])) {

    $tituloMensagem = "Ops!";
    $mensagem = $_GET['mensagem'];
    $classeAlerta = 'alertaErro';

    if ($_GET['sucesso']) {
        $tituloMensagem = "Sucesso!";
        $classeAlerta = 'alertaSucesso';
    }

    echo "
        <div class='alerta'>
            <div class='nortification animateOpen $classeAlerta'>
            <span><b> $tituloMensagem </b> </span><br>
            <span>  $mensagem  </span>
            </div>
        </div>
    ";

}

?>
