<?php 
    class Conexion
    {
        private $conection;

        function __construct()
        {
            $this->conection = $this->connect("localhost", "jackes", "root", "");
        }
        
        private function connect($host, $db, $usr, $pass)
        {
            try
            {
                $con = new PDO("mysql:host=$host;dbname=$db", $usr, $pass);
            }
            catch(Exception $er)
            {
                echo $er->getMessage();
            }
            
            return $con;
        }

        public function verifyUserExistence($idUser, $pwdUser)
        {
            $userFound = false;

            try
            {
                $select;   //consulta
                $userData; //Almacen de fila

                if($this->conection)
                {
                    $select = $this->conection->prepare("SELECT idUsr, nombreUsr, contraUsr FROM trabajador WHERE idUsr = :id AND contraUsr = :pwd");

                    $select->execute([":id"=>$idUser, ":pwd"=>$pwdUser]);

                    $userData = $select->fetch(PDO::FETCH_LAZY);

                    if($userData){
                        $_SESSION['userId'] = $userData['idUsr'];
                        $_SESSION['userName'] = $userData['nombreUsr'];
                        
                        $userFound = true;

                        header("Location:inicio.php");
                    }
                }
                else{ $userFound = false; }
            }
            catch(Exception $er)
            {
                echo $er->getMessage();
            }
            
            return $userFound;
        }

        /** CRUD SELECT */

        private function select($statement)
        {
            $rows = "";

            try
            {
                $select = $this->conection->prepare($statement);
                $select->execute();
                $rows = $select->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(Exception $er)
            {
                echo $er->getMessage();
            }

            return $rows;
        }

        private function selectFiltered($table, $arrayFilters)
        {    
            $sql = "SELECT * FROM ".$table." WHERE 1=1";

            foreach($arrayFilters as $key => $value)
            {
                if($value !== null)
                {
                    $sql.= " AND ".$key." = '".$value."'";
                }
            }

            return $sql;
        }

        public function getData($table, $arrayFilters)
        {
            $statement = $this->selectFiltered($table, $arrayFilters);
            $rows = $this->select($statement);
            return $rows;
        }
    }
?>