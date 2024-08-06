<?php
    require_once("conexion.php");

    class Usuario
    {
        private $conectionClass;
        private $conection;

        function __construct()
        {
            $this->conectionClass = new Conexion();
            $this->conection = $this->conectionClass->getConection();
        }
        
        private function getAllUsers()
        {
            $select;
            $userData = "";

            try
            {
                $select = $this->conection->prepare("SELECT * FROM trabajador");
                $select->execute();
                $userData = $select->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(Exception $er)
            {
                echo $er->getMessage();
            }

            return $userData;
        }

        public function getUserData()
        {
            $userData = $this->getAllUsers();
            return $userData;
        }

    }

?>