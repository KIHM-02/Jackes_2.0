<?php 
    class Conexion
    {
        private $conection;

        function __construct()
        {
            $this->conection = $this->connect("localhost", "jackes", "root", "");
        }

        public function connect($host, $db, $usr, $pass)
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
    }
?>