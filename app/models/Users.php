<?php

namespace scMVC\Models;

use Exception;
use scMVC\Models\BaseModel;

class Users extends BaseModel
{
    public function check_login($cpf, $password)
    {
        $params = [
            ':cpf' => $cpf
        ];

        $this->db_connect();
/*         $results = $this->query(
            "SELECT id, passwrd FROM users " .
            "WHERE AES_ENCRYPT(:username, '" . MYSQL_AES_KEY."') = name"
            , $params); */

        $results = $this->query(
                    "SELECT cpf, password FROM users WHERE :cpf = cpf"
                    , $params);


        if($results->affected_rows == 0){
             return [
                    'status' => false
                ];
            }

        if(!password_verify($password, $results->results[0]->password)){
            return [
             'status' => false
            ];
        }
        return [
            'status' => true
        ];
    }

    //
    public function check_register($cpf)
    {
        $params = [
            ':cpf' => $cpf
        ];

        $this->db_connect();
        $results = $this->query(
                    "SELECT cpf FROM users WHERE :cpf = cpf"
                    , $params);


        if($results->affected_rows > 0){
             return [
                    'status' => false
                ];
            }

        return [
            'status' => true
        ];
    }
    //
    public function user_register($params)
    {
        $params = [
            ':name' => $params['name'],
            ':gender' => $params['gender'],
            ':born_in' => $params['born_in'],
            ':cpf' => $params['cpf'],
            ':password' => password_hash($params['password'], PASSWORD_DEFAULT)
        ];


            $this->db_connect();
                $results = $this->non_query(
                    "INSERT INTO users (name, sex, born_in, cpf, password, profile) 
                    VALUES (:name, :gender, :born_in, :cpf, :password, 'agent')"
                        , $params);

                if($results->status == 'error'){
                    return [
                        'status' => false,
                        'message' => 'Ocorreu algum erro.'
                   ];
                }

                    return [
                        'status' => true,
                        'message' => 'Registrado com sucesso!'
                   ];
        }

    public function get_all_clients(){

        $params = [];

        $this->db_connect();
        $results = $this->query(
            "SELECT " .
            "id," . 
            "name, " . 
            "sex, " . 
            "born_in ". 
            "FROM users "
            , $params);

            return [
                'status' => 'success',
                'data' => $results->results
            ];
    }


    public function get_user_data($cpf){
        $params = [
            ':cpf' => $cpf
        ];
        $this->db_connect();
        $results = $this->query(
            "SELECT " . 
            "id, " . 
            "name, " . 
            "profile ". 
            "FROM users " .
            "WHERE cpf = :cpf"
            , $params);

            return [
                'status' => 'success',
                'data' => $results->results[0]
            ];
        }
        
        public function set_user_last_login($id){
            
            $params = [
                'id' => $id
            ];
        $this->db_connect();
        $results = $this->non_query(
            "UPDATE agents SET " . 
            "last_login = NOW() " .
            "WHERE id = :id"
            , $params);
            
            return $results;
        }
        
        public function get_clients(){
            
            $params = [

            ];
            
            $this->db_connect();
            $results = $this->query(
                "SELECT " .
                "id, " .
                "name, " .
                "cpf, " .
                "sex, " .
                "born_in, " .
                "FROM users " .
                "WHERE id_agent = :id_agent " .
                "AND deleted_at IS NULL",
                    $params
                );

            return [
                'status' => 'success',
                'data' => $results->results
            ];
        }
        
        public function add_new_client_to_database($post_data){

            $birthdate = new \DateTime($post_data['text_birthdate']);
            $params = [
                ':name'=> $post_data['text_name'],
                ':gender'=> $post_data['radio_gender'],
                ':birthdate'=> $birthdate->format('Y-m-d H:i:s'),
                ':email'=> $post_data['text_email'],
                ':phone'=> $post_data['text_phone'],
                ':interests'=> $post_data['text_interests'],
                ':id_agent'=> $_SESSION['user']->id
            ];
            
            $this->db_connect();
            $result = $this->non_query(
                "INSERT INTO persons VALUES(" .
                "0, " .
                "AES_ENCRYPT(:name, '" . MYSQL_AES_KEY . "'), " .
                ":gender, " .
                ":birthdate, " .
                "AES_ENCRYPT(:email, '" . MYSQL_AES_KEY . "'), " .
                "AES_ENCRYPT(:phone, '" . MYSQL_AES_KEY . "'), " .
                ":interests, " .
                ":id_agent,  " .
                "NOW(), " .
                "NOW(), " .
                "NULL" .
                ")", 
                $params);
    }

    public function get_client_data($id_client){
        $params = [
            ':id_client' => $id_client
        ];
        $this->db_connect();
        $results = $this->query(
            "SELECT " .
            "id, " .
            "AES_DECRYPT(name, '" . MYSQL_AES_KEY . "') name, " .
            "gender, " .
            "birthdate, " .
            "AES_DECRYPT(email, '" . MYSQL_AES_KEY . "') email, " .
            "AES_DECRYPT(phone, '" . MYSQL_AES_KEY . "') phone, " .
            "interests " .
            "FROM persons " .
            "WHERE id = :id_client"
            , $params);
            
            if($results->affected_rows == 0){
                return [
                    'status' => 'error'
                ];
            }

            return [
                'status' => 'success',
                'data' => $results->results[0]
            ];
    }
    
    public function delete_agent_client($id_client){
        
        $params = [
            ':id' => $id_client,
        ];
        $this->db_connect();
        return $this->non_query("DELETE FROM persons WHERE id = :id", $params);
    } 
    /*     public function get_results(){
            $params = [
                'profile' => 'admin'
            ];
            $this->db_connect();
            return $this->query("SELECT * FROM agents WHERE profile =:profile", $params);
        } */

}