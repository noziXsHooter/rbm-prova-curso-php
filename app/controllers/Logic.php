<?php
//LOGA
 /*    public function login(string $cpf, string $password): array
    {
        try {

            $result = array();
            $sql = "SELECT * FROM users WHERE cpf = '$cpf'";

            $prepare = $this->conn->prepare($sql);
            $result = $prepare->execute();
            $result = $prepare->fetchAll();

            $verifyPass = password_verify($password, $result[0]['password']);

            if($verifyPass){
    
                $_SESSION['logged'] = true;
                $_SESSION['name'] = $result[0]['name'];
                $_SESSION['autho'] = $result[0]['autho'];
                $_SESSION['id'] = $result[0]['id'];
                $_SESSION['cpf'] = $result[0]['cpf'];

                //SALVA NO LOG
                $this->saveLogs('loginSuccess');
                 
                header('Location: ./views/dashboardHome.php?');

            }else {
    
                return [
                    'success' => false,
                    'message'=> 'Dados inválidos!'
                ];
            }

        }catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }


    } */

    //REGISTRA USUARIO
    public function userRegister(string $name, string $born_in, string $sex, string $cpf, string $password): array
    {

        try {

            $sqlSelect = "SELECT * from users WHERE cpf = '$cpf'";
            $selectResult = $this->conn->query($sqlSelect);
            $selectCount = $selectResult->rowCount();

            if($selectCount > 0){

                return [
                    "success" => false,
                    "message" => 'Esse cpf já existe!'
                ];

            }else{

                $sqlInsert = "INSERT INTO users (name, born_in, autho, sex, cpf, password) 
                        VALUES (:name, :born_in, :autho, :sex, :cpf, :password)";
    
                $prepare = $this->conn->prepare($sqlInsert);
                $prepare->bindValue(":name", $name);
                $prepare->bindValue(":born_in", $born_in);
                $prepare->bindValue(":autho", 1);
                $prepare->bindValue(":sex", $sex);
                $prepare->bindValue(":cpf", $cpf);
                $prepare->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
                
                $result = $prepare->execute();

                if($result){

                    //SALVA NO LOG
                    $this->saveLogs('userRegisterSuccess', $cpf);

                    return [
                        "success" => true,
                        "message" => 'O cadastro foi um sucesso!'
                    ];

                }else{

                    return [
                        "success" => false,
                        "message" => 'Deu ruim aí!'
                    ];
                }

            }


        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    
        return [
            "success" => true,
            "message" => "Pessoa cadastrada com sucesso!"
        ];
    }

    // REGISTRA O CUPOM
    public function couponRegister(int $code, int $id, string $cpf, float $valor, string $store, string $date_time, string $status, string $session_cpf): int|array
    {

        $cpValidation = $this->couponValidation($code, $cpf, $session_cpf);

        if($cpValidation === 'true'){

            try {
    
                $sql = "INSERT INTO coupons (code, user_id, cpf, valor, store, date_time, status) 
                        VALUES (:code, :user_id, :cpf, :valor, :store, :date_time, :status)";
    
                $prepare = $this->conn->prepare($sql);
                $prepare->bindValue(":code", $code);
                $prepare->bindValue(":user_id", $id);
                $prepare->bindValue(":cpf", $cpf);
                $prepare->bindValue(":valor", $valor);
                $prepare->bindValue(":store", $store);
                $prepare->bindValue(":date_time", $date_time);
                $prepare->bindValue(":status", $status);
                $prepare->execute();

            } catch (Exception $e) {

                return [
                    "success" => false,
                    "message" => $e->getMessage()
                ];
            }

            $total = (int)$this->get_user_valid_coupons($id); 

            if($total >= 300){
                $numbers = floor($total/300);
                $number= 0;

                for ($i=0; $i < $numbers; $i++) { 
                    $number=$number +1;
                    $myuuid = $this->guidv4();
                    $this->create_luck_numbers($myuuid, $id);
                }

                $this->deactive_coupons($id);
            }

            //SALVA NO LOG
            $this->saveLogs('couponRegisterSuccess', array($code,$cpf));

            return [

                "success" => true,
                "message" => "Cupom cadastrado com sucesso!",
            ];


        }elseif($cpValidation['success'] === 'false') {

            return [

                "success" =>  false,
                "message" => $cpValidation['message']
            ];
        }

    }

    // FAZ A VALIDAÇAO DO CUPOM
    public function couponValidation(int $code, string $cpf, string $session_cpf): array|string
    {

        if(!$this->couponCodeValidation($code)){

            return [
                 "success" => 'false',
                 "message" => "Código do cupom já cadastrado!",
             ];

        } elseif(!$this->couponUserSessionCpfValidation($cpf, $session_cpf)){

            return [
                "success" => 'false',
                "message" => "O CPF deve ser o seu!",
            ];

        }else{

            return 'true';

        }
    }
    

    //VERIFICA SE O CPF DO CUPOM É O MESMO DO USUARIO LOGADO
    public function couponUserSessionCpfValidation(string $cpf, string $session_cpf): bool
    {
        
        if($cpf == $session_cpf) {
            return true;
        }else{
            return false;
        }
    }

    // LISTA USUARIOS
    public function listUsers(): array
    {

        try {

            $result = array();
            $sql = "SELECT id, name, sex, born_in FROM users";
            $query = $this->conn->query($sql);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }

    }
    //LISTA OS COUPONS DO USUARIO
    public function listUserCoupons(int $id): array
    {

        try {

            $result = array();
            $sql = "SELECT code, valor, store, date_time, status FROM coupons WHERE user_id = $id ORDER BY status ASC";
            $query = $this->conn->query($sql);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;

        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    //LISTA OS NUMEROS DA SORTE
    public function listLuckNumbers(int $id): array
    {

        try {

            $result = array();
            $sql = "SELECT code, valor, store, date_time, status FROM coupons WHERE user_id = $id";
            $query = $this->conn->query($sql);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;

        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }

    }

    //PEGA OS CUPONS VALIDOS E SOMA O TOTAL DELES
    public function get_user_valid_coupons(int $id): int|float
    {

        try {

            $result = array();
            $sql = "SELECT SUM(valor) AS total FROM coupons WHERE user_id = $id and status = '1'";
            $query = $this->conn->query($sql);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $totalResult = (float)$result[0]['total'];

            return $totalResult;

        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    //CRIA OS NUMEROS DA SORTE
/*     public function create_luck_numbers($guid, $id): int|array
    {

        try {

            $sql = "INSERT INTO luck_numbers (hash, user_id) VALUES (:hash, :user_id)";
            $prepare = $this->conn->prepare($sql);
            $prepare->bindValue(":hash", $guid);
            $prepare->bindValue(":user_id", $id);
            $prepare->execute();

            return $prepare->rowCount();

            } catch (Exception $e) {
                return [
                    "success" => false,
                    "message" => $e->getMessage()
            ];
        }


    } */

    //DESATIVA OS CUPONS QUE JA FORAM PROCESSADOS
    public function deactive_coupons(int $id): int|array
    {

        try {

            $sql = "UPDATE coupons SET status = :status WHERE user_id = :id";
            $prepare = $this->conn->prepare($sql);
            $prepare->bindValue(":status", 0);
            $prepare->bindValue(":id", $id);
            $prepare->execute();

            return $prepare->rowCount();

        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    // GERA O GUID
    function guidv4($data = null) 
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
    
        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    
        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

/*     //VERIFICA ESTADO DO SORTEIO
    public function verifySweepstakeStatus(): bool|array
    {

        try {

            $result = array();
            $sql = "SELECT status FROM sweepstake_status";
            $query = $this->conn->query($sql);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            $boolResultTransform = (bool)$result[0]['status'];

            return $boolResultTransform;

        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    //REALIZA O SORTEIO (SORTEIO TEÓRICO - PODE SER REALIZADO UM NOVO SORTEIO SEM DETRIMENTO DOS COUPONS E DOS NUMEROS DA SORTE)
    public function raffle(): array
    {
        
        try {

            $result = array();
            $sql = "SELECT hash FROM luck_numbers";
            $query = $this->conn->query($sql);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);


        } catch (Exception $e){
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }

        if(!empty($result)){
            
            $hashList = array();
            foreach($result as $key=>$value){
                foreach ($value as $key2 => $value2) {
                    array_push($hashList, $value2);
                }
            }
            $raffled = array_rand($hashList, 2);
    
            $winnerName = $this->search_for_hash_owner($hashList[$raffled[0]]);
    
            //MUDA O STATUS DO SORTEIO
            $query = $this->conn->query("UPDATE sweepstake_status SET status = 1");
            
            //SALVA NO LOG
            $this->saveLogs('enableRaffleSuccess', array($winnerName[0]['name'], $hashList[$raffled[0]]));


            return [
                "winnerNumber" => $hashList[$raffled[0]],
                "winnerName" => $winnerName[0]['name'],
            ];

        }else{
            return [
                "success" =>  false,
                "message" => 'Não há números a serem sorteados!'
            ];
        }


    } */

    //MUDA STATUS DO SORTEIO PARA FALSE NO DB PARA HABILITAR NOVO SORTEIO (SORTEIO NÃO REALIZADO)
    public function enableSweepstake()
    {

        try {

            //MUDA O STATUS DO SORTEIO
            $query = $this->conn->query("UPDATE sweepstake_status SET status = 0");

            //SALVA NO LOG
            $this->saveLogs('enableSweepstake');

        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }

    }

    //PROCURA PELO NOME DO GANHADOR DO SORTEIO PELO HASH SORTEADO
/*     public function search_for_hash_owner($hash): string|array
    {

        try {

            $sql = "SELECT n.hash, u.name FROM luck_numbers AS n INNER JOIN users AS u ON n.user_id=u.id WHERE n.hash='$hash'";
            $query = $this->conn->query($sql);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;

        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }

    } */

    //FINALIZA SORTEIO E LIMPA OS NUMEROS
    public function endRaffle()/* : bool|array */
    {
        try {

            $sql = "DELETE FROM luck_numbers";
            $result = $this->conn->query($sql);

            //SALVA NO LOG
            $this->saveLogs('endRaffleSuccess');

            return $result;

        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    //DESLOGA
    public function logout(): void
    {
        unset($_SESSION['logged']);
        unset($_SESSION['name']);
        unset($_SESSION['autho']);
       /*  session_unset(); */
        session_destroy();

        header('Location: ../index.php');
    }

    //REGISTRA OS LOGS
    public function saveLogs($logType, $identifier = null)
    {

        try{

            $log = new Log;
            $return_value = match ($logType) {
    
                'loginSuccess' => $log->loginLog(),
                'userRegisterSuccess' => $log->userRegisterSuccessLog($identifier),
                'couponRegisterSuccess' => $log->couponRegisterSuccessLog($identifier),
                'enableRaffleSuccess' => $log->enableRaffleSuccessLog($identifier),
                'endRaffleSuccess' => $log->endRaffleSuccessLog(),
                'enableSweepstake' => $log->enableSweepstakeSuccessLog(),
                /* 'login' => $this->registerLog() */

                default => throw new InvalidArgumentException("Utilize um argumento válido.")
            };

        }catch (\UnhandledMatchError $e) {

            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        };

    }



?>