<?php

namespace scMVC\Controllers;

use Exception;
use scMVC\Controllers\BaseController;
use scMVC\Models\LuckNumbers;

class LuckNumber extends BaseController
{
    //
    public function luck_numbers(){
        /* printData("luck numbers"); */
        if(!check_Session()){
            header('Location: index.php');
        }

        $user_id = $_SESSION['user']->id;
        $model = new LuckNumbers();
        $results = $model->get_luck_numbers();

        $data['user'] = $_SESSION['user'];
        $data['luck_numbers'] = $results['data'];

        $this->view('layouts/html_header');
        $this->view('navbar', $data);
        $this->view('list_luck_numbers', $data);
        $this->view('footer');
        $this->view('layouts/html_footer');

    }

    //
    public function client_luck_numbers()
    {
        if(!check_Session()){
            header('Location: index.php');
        }

        $user_id = $_SESSION['user']->id;
        $model = new LuckNumbers();
        $results = $model->get_client_luck_numbers($user_id);

        $data['user'] = $_SESSION['user'];
        $data['luck_numbers'] = $results['data'];

        $this->view('layouts/html_header');
        $this->view('navbar', $data);
        $this->view('list_my_luck_numbers', $data);
        $this->view('footer');
        $this->view('layouts/html_footer');
    
    }

}