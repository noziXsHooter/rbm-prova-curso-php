<?php

namespace scMVC\Controllers;
use scMVC\Controllers\BaseController;
use scMVC\Models\Agents;
use scMVC\Models\Users;

class Main extends BaseController
{

    public function index()
    {

        if(!check_session())
        {
            $this->login_frm();
            return;
        }
        
        $data['user'] = $_SESSION['user'];

        $this->view('layouts/html_header');
        $this->view('navbar', $data);
        $this->view('homepage', $data);
        $this->view('footer');
        $this->view('layouts/html_footer');

    }
    
    public function login_submit()
    {

        if(check_session()){
            $this->index();
            return;
        }

        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            $this->index();
            return;
        }    
        
        $validation_errors = [];
        if(empty($_POST['text_username']) || empty($_POST['text_password'])){
            $validation_errors[] = "Usuário e senha são obrigatórios";
        }
        
        $cpf = $_POST['text_username'];
        $password = $_POST['text_password'];

       /*  if(!filter_var($cpf, FILTER_VALIDATE_EMAIL)){
            $validation_errors[] = "O usuário tem que ser um email válido";
        }

        if(strlen($cpf) < 5 || strlen($cpf) > 50){
            $validation_errors[] = "O usuário deve ter entre 5 e 50 caracteres";
        }
        if(strlen($password) < 6 || strlen($password) > 12){
            var_dump(strlen($password));
            $validation_errors[] = "O senha deve ter entre 6 e 12 caracteres";
        } */

        if(!empty($validation_errors)){
            $_SESSION['validation_errors'] = $validation_errors;
            $this->login_frm();
            return;
        }

        $model = new Users();
        $result = $model->check_login($cpf, $password);

        if(!$result['status']){
           

            logger("$cpf - login inválido", 'error');

            $_SESSION['server_error'] = 'Login inválido';
            $this->login_frm();
            return;
        }
 
        logger("$cpf - logou com successo");

        $results = $model->get_user_data($cpf);

        $_SESSION['user'] = $results['data'];

        //SETA O ULTIMO LOGIN DO USUARIO
        /* $results = $model->set_user_last_login($_SESSION['user']->id); */

        $this->index();

    }


   //////    LOGIN

    public function login_frm()
    {
        if(check_session())
        {
            $this->index();
            return;
        }

        $data = [];
        if(!empty($_SESSION['validation_errors'])){
            $data['validation_errors'] = $_SESSION['validation_errors'];
            unset($_SESSION['validation_errors']);
        }

        $this->view('layouts/html_header');
        $this->view('login_frm', $data);
        $this->view('layouts/html_footer');
      /*   $this->view('layouts/html_header'); */

        // login
       /*  $this->view('login_frm'); */

        // esqueci-me da password (formulário)
        // $this->view('reset_password_frm');

        // esqueci-me da password - email enviado
        // $this->view('reset_password_email_sent');

        // esqueci-me da password - introduza o código
        // $this->view('reset_password_insert_code');
        
        // esqueci-me da password - definir nova password
        // $this->view('reset_password_define_password_frm');
        
        // esqueci-me da password - definir nova password
        // $this->view('reset_password_define_password_success');
        
        // nav bar
       /*  $this->view('navbar'); */
        
        // homepage
        // $this->view('homepage');
        
        // meus clientes
        // $this->view('agent_clients');
        
        // inserir novo cliente
        // $this->view('insert_client_frm');
        
        // upload de ficheiro de clientes
        // $this->view('upload_file_with_clients_frm');

        // editar cliente
        // $this->view('edit_client_frm');

        // confirmar eliminação de cliente
        // $this->view('delete_client_confirmation');
        
        // perfil - alterar a password
        // $this->view('profile_change_password_frm');
        
        // perfil - password alterada com sucesso
        // $this->view('profile_change_password_success'); 
        
        // global clientes - para visualização dos clientes pelo admin
        // $this->view('global_clients');
        
        // ---------------
        // gestão de agentes - quadro inicial
        // $this->view('agents_managment');
        
        // gestão de agentes - adicionar agente formulário
        // $this->view('agents_add_new_frm');

        // envio de email para conclusão da password
        // $this->view('agents_email_sent');    
        
        // gestão de agentes - editar agente formulário
        // $this->view('agents_edit_frm');
        
        // gestão de agentes - confirmar eliminação
        // $this->view('agents_delete_confirmation');

        // gestão de agentes - confirmar reativação
        // $this->view('agents_recover_confirmation'); 

        // stats
        // $this->view('stats'); 

/*         $this->view('footer');
        $this->view('layouts/html_footer'); */
    }

    //////    REGISTRAR USUÁRIO

    public function register_frm()
    {
        if(check_session())
        {
            $this->index();
            return;
        }

        $data = [];
        if(!empty($_SESSION['validation_errors'])){
            $data['validation_errors'][] = $_SESSION['validation_errors'];
            unset($_SESSION['validation_errors']);
        }

        $this->view('layouts/html_header');
        $this->view('register_frm', $data);
        $this->view('layouts/html_footer');
    }

    //ENVIAR FORMULARIO DE REGISTRO
    public function register_submit()
    {

        if(check_session()){
            $this->index();
            return;
        }

        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            $this->index();
            return;
        }    
        
        $postParams = [
            'name' => $_POST['name'],
            'born_in' => $_POST['born_in'],
            'gender' => $_POST['gender'],
            'cpf' => $_POST['cpf'],
            'password' => $_POST['password'],
        ];

/*         if(strlen($cpf) < 5 || strlen($cpf) > 50){
            $validation_errors[] = "O usuário deve ter entre 5 e 50 caracteres";
        }
        if(strlen($password) < 6 || strlen($password) > 12){
            var_dump(strlen($password));
            $validation_errors[] = "O senha deve ter entre 6 e 12 caracteres";
        }  */

        if(!empty($validation_errors)){
            $_SESSION['validation_errors'] = $validation_errors;
            $this->login_frm();
            return;
        }

        $model = new Users();
        $result = $model->check_register($_POST['cpf']);

        if(!$result['status']){
           
            logger("Falha de registro de usuário. O CPF: " . $_POST['cpf'] . "já existe do banco", 'error');

            $_SESSION['validation_errors'] = 'Registro inválido';
            $this->register_frm();
            return;
        }

        $result = $model->user_register($postParams);

        if(!$result['status']){

            logger("Falha de registro de usuário - Query Error.", 'critical');

            $_SESSION['validation_errors'] = $result['message'];
            $this->register_frm();
            return;
        }

        logger("O cpf: " . $_POST['cpf'] . " - acabou de se registrar",);

        $data['register_success'] = $result['message'];
        $this->view('layouts/html_header');
        $this->view('register_frm', $data);
        $this->view('layouts/html_footer');

    }

    //   DESLOGAR
    public function logout(){

                if(!check_session()){
                    $this->index();
                    return;
                }
        
                logger($_SESSION['user']->name . "- fez logout");
        
                unset($_SESSION['user']);
        
                $this->index();
            }

}