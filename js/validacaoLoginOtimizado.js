function validarDadosLogin() {

    var retorno = true;          

    retorno = validaDadosIteracao("login","senha");   
    
    if(!retorno){
        alert('Preencha os dados obrigatórios!');            
    }

    return retorno;

}

function validarDadosCadastroCliente() {

    var retorno = true;          

    retorno = validaDadosIteracao("cpfCliente","nomeCliente", "dataNascimentoCliente", "celularCliente", "rendaMensalCliente");   
    
    if(!retorno){
        alert('Preencha os dados obrigatórios!');            
    }

    return retorno;

}

function validarDadosEmprestimo() {

    var retorno = true;          

    retorno = validaDadosIteracao("cpfCliente","valorSolicitado", "quantidadeParcelas");   
    
    if(!retorno){
        alert('Preencha os dados obrigatórios!');            
    }

    return retorno;  

}
    

function validaDadosIteracao() {

    var i;
    var retorno = true;   
    for(i=0 ; i<arguments.length ; i++) {
        var elemento = document.getElementById(arguments[i]);
        var conteudo = elemento.value;
        if(conteudo == '' || conteudo == "0") {
            elemento.style.borderColor = "red";
            retorno = false;
        }else{
            elemento.style.borderColor = "";
        }
    }
    return retorno;

}