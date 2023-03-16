<?php

namespace scMVC\Models;

use Exception;
use scMVC\Models\BaseModel;

class Sweepstakes extends BaseModel
{

    public function get_sweepstakes(){
            $params = [];
            
            $this->db_connect();
            $result = $this->query("SELECT name, hash, created_at FROM sweepstakes ORDER BY id DESC", $params);

            return [
                'status' => 'success',
                'data' => $result->results
            ];
    }

    //
    public function sweepstake_status(){

            $params = [];
            $this->db_connect();
            $results = $this->query(
                "SELECT status FROM sweepstake_status",
                 $params);

                return [
                    'status' => 'success',
                    'data' => $results->results
                ];
    }

    //
    public function get_all_hashs(){
            $params = [];

            $this->db_connect();
            $results = $this->query(
                "SELECT hash FROM luck_numbers",
                 $params);

                return $results;
    }

    //
    public function get_client_coupons($client_id){
            $params = [
                ':client_id' => $client_id
            ];

            $this->db_connect();
            $results = $this->query(
                "SELECT " . 
                "u.name, ". 
                "c.code, " . 
                "c.valor, ". 
                "c.store, " .
                "c.date_time, " .
                "c.status " .
                "FROM coupons AS c " .
                "RIGHT JOIN users AS u " .
                "ON c.user_id = u.id " .
                "WHERE c.user_id = :client_id " .
                "ORDER BY status ASC",
                 $params);

                /* printData($results); */
          /*   SELECT n.hash, u.name FROM luck_numbers AS n INNER JOIN users AS u ON n.user_id=u.id WHERE n.hash='$hash' */

            return [
                'status' => 'success',
                'data' => $results->results
            ];
    }

    //PROCURA PELO NOME DO GANHADOR DO SORTEIO PELO HASH SORTEADO
    public function search_for_hash_owner($hash)
    {
        $params = [':hash' => $hash];

        try {

            $this->db_connect();
            $results = $this->query(
                "SELECT " . 
                "u.id, " .
                "n.hash, " . 
                "u.name " . 
                "FROM luck_numbers AS n " .
                "INNER JOIN users AS u " .
                "ON n.user_id = u.id " .
                "WHERE n.hash = :hash",
                 $params);
    
            return $results;

        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    //
    function delete_luck_numbers()
    {
        $params = [];
        $this->db_connect();
        $results = $this->non_query("DELETE FROM luck_numbers"
        , $params);

    }
    
    //
    function deactivate_sweepstake()
    {
        $params = [];
        $this->db_connect();
        $results = $this->non_query("UPDATE sweepstake_status SET status = 0"
        , $params);

    }

    //
    function activate_sweepstake()
    {
        $params = [];
        $this->db_connect();
        $results = $this->non_query("UPDATE sweepstake_status SET status = 1"
        , $params);

    }

    //REGISTRA O SORTEIO NO BANCO DE DADOS
    function insert_sweepstake_to_database($params)
    {
        
        $formData = [
            ':user_id'   => $params['user_id'],
            ':hash'      => $params['hash'],
            ':name'       => $params['name']
        ];

        $this->db_connect();
        $result = $this->non_query("INSERT INTO sweepstakes (user_id, hash, name) 
        VALUES (:user_id, :hash, :name)", $formData);
        //SALVA NO LOG
        logger("Sorteio registrado na base de dados. ", 'info');
        return $result->status;

    }

    //DESATIVA TODOS O STATUS DE TODOS OS CUPONS (CHAMADO APÓS ANUNCIAR O VENCEDOR DO SORTEIO)
    public function deactivate_all_coupons()
    {
        $params = [];
    
        try {
            $this->db_connect();
            $resultTotal = $this->non_query("UPDATE coupons SET status = 0", $params);
    
        } catch (Exception $e) {
            return [
                "status" => false,
                "errors" => $e->getMessage()
            ];
        }
    }   

   //APAGA TODOS OS COUPONS CRIADOS
   public function clean_all_coupons()
   {
       $params = [];
   
       try {
           $this->db_connect();
           $resultTotal = $this->non_query("DELETE FROM coupons", $params);
   
       } catch (Exception $e) {
           return [
               "status" => false,
               "errors" => $e->getMessage()
           ];
       }
   }     

/*      public function set_user_last_login($id){
            
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
    } */
    

}