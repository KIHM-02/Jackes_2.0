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

        public function verifyUserExistence($idUser, $pwdUser, $rol)
        {
            $userFound = false;

            try
            {
                if($this->conection)
                {
                    //consulta
                    $select = $this->conection->prepare("SELECT idUsr, nombreUsr, contraUsr FROM trabajador WHERE idUsr = :id AND contraUsr = :pwd AND idRol = :rol");

                    $select->execute([":id"=>$idUser, ":pwd"=>$pwdUser, ":rol"=>$rol]);

                    //Almacena la fila
                    $userData = $select->fetch(PDO::FETCH_LAZY);

                    if($userData){
                        $_SESSION['userId'] = $userData['idUsr'];
                        $_SESSION['userName'] = $userData['nombreUsr'];
                        
                        $userFound = true;

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
                    if(is_int($value))
                    {
                        $sql.= " AND ".$key." = '".$value."'";
                    }
                    else
                    {
                        $sql.= " AND ".$key." LIKE '%".$value."%'";
                    }
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

        private function generateDateRangeQuery($tables, $fechaInicio, $fechaFin) 
        {
            // Aseguramos que los valores de mes y día tengan siempre dos dígitos
            $diaInicio = str_pad($fechaInicio['dia'], 2, '0', STR_PAD_LEFT);
            $mesInicio = str_pad($fechaInicio['mes'], 2, '0', STR_PAD_LEFT);
            $anioInicio = $fechaInicio['anio'];
            
            $diaFin = str_pad($fechaFin['dia'], 2, '0', STR_PAD_LEFT);
            $mesFin = str_pad($fechaFin['mes'], 2, '0', STR_PAD_LEFT);
            $anioFin = $fechaFin['anio'];
            
            // Concatenamos las partes de la fecha en el formato YYYYMMDD
            $fechaInicioConcat = "$anioInicio$mesInicio$diaInicio";
            $fechaFinConcat = "$anioFin$mesFin$diaFin";

            $sql = "SELECT * ";
            
            // FROM base table:
            $baseTable = $tables[0]['name'];
            $sql .= " FROM $baseTable ";

            // JOINs dinámicos:
            for ($i = 1; $i < count($tables); $i++) {
                $joinTable = $tables[$i]['name'];
                $on = $tables[$i]['on'];
                if (count($on) != 2) {
                    throw new Exception("Invalid join condition");
                }
                $sql .= " INNER JOIN $joinTable ON {$on[0]} = {$on[1]} ";
            }
        
            // Generamos la sentencia SQL
            $sql .= " WHERE (CAST(CONCAT(anio, LPAD(mes, 2, '0'), LPAD(dia, 2, '0')) AS UNSIGNED) >= $fechaInicioConcat)
                    AND (CAST(CONCAT(anio, LPAD(mes, 2, '0'), LPAD(dia, 2, '0')) AS UNSIGNED) <= $fechaFinConcat)";
        
            return $sql;
        }
        
        public function getDataInRange($table, $fechaInicio, $fechaFin)
        {
            $stmt = $this->generateDateRangeQuery($table, $fechaInicio, $fechaFin);
            $rows = $this->select($stmt);
            return $rows;
        }

        private function innerJoinData($tables, $filters, $conditionals)
        {
            $sql = "SELECT ";

            // Filtrado más limpio:
            $columns = array_filter($filters, fn($f) => $f !== null);
            $sql .= implode(", ", $columns);

            // FROM base table:
            $baseTable = $tables[0]['name'];
            $sql .= " FROM $baseTable ";

            // JOINs dinámicos:
            for ($i = 1; $i < count($tables); $i++) {
                $joinTable = $tables[$i]['name'];
                $on = $tables[$i]['on'];
                if (count($on) != 2) {
                    throw new Exception("Invalid join condition");
                }
                $sql .= " INNER JOIN $joinTable ON {$on[0]} = {$on[1]} ";
            }

            // Condicionales:
            if (!empty($conditionals)) {
                $sql .= " WHERE 1=1 ";
                foreach ($conditionals as $key => $value) {
                    if ($value !== null) {
                        if (is_int($value)) {
                            $sql .= " AND $key = $value ";
                        } else {
                            $escaped = addslashes($value); // simple protección
                            $sql .= " AND $key LIKE '%$escaped%' ";
                        }
                    }
                }
            }

            return $sql;
        }


        public function getInnerJoin($params)
        {
            $tables = $params['tables'];
            $filters = $params['filters'];
            $conditionals = $params['conditionals'];

            $stmt  = $this->innerJoinData($tables, $filters, $conditionals);
            $query = $this->select($stmt);
            return $query; 
        }


        private function delete($table, $arrayColumn)
        {
            $statement = "DELETE FROM ".$table;

            try
            {
                foreach($arrayColumn as $column => $value)
                {
                    $statement .= " WHERE ".$column." = ".$value;      
                }

                $query = $this->conection->prepare($statement);
                $query->execute();
            }
            catch(Exception $er)
            {
                echo $er->getMessage();
            }
        }

        public function useDelete($table, $arrayColumn)
        {
            $this->delete($table, $arrayColumn);
        }

        private function insert($table, $arrayColumn)
        {
            $columns = array_keys($arrayColumn);
            $values = array_values($arrayColumn);

            // Crear las partes de las columnas y valores de la consulta SQL
            $columnsPart = implode(", ", $columns);
            $placeholdersPart = implode(", ", array_fill(0, count($values), '?'));
            //array_fill crea un arreglo del mismo tamaño que values (los valores)
            //El ? es para indicar que seran puros ? los cuales sustituiremos al ejecutar la consulta

            $sql = "INSERT INTO " . $table . " ($columnsPart) VALUES ($placeholdersPart)";

            try {
                $stmt = $this->conection->prepare($sql);
                $stmt->execute($values);

            } catch (Exception $er) {
                echo $er->getMessage();
            }
        }

        public function useInsert($table, $arrayColumn)
        {
            $this->insert($table, $arrayColumn);
        }

        private function update($table, $identifier, $arrayColumn)
        {
            $columns = array_keys($arrayColumn);
            $values = array_values($arrayColumn);

            $columnsPart = implode(" = ?, ", $columns)." = ?";

            $sql = "UPDATE $table SET $columnsPart WHERE ".array_key_first($identifier)." = ?";

            try 
            {
                $stmt = $this->conection->prepare($sql);
                $values[] = reset($identifier); //Agrega el ultimo valor para saber identificar la clausula WHERE
                
                $stmt->execute($values);

            } catch (Exception $er) {
                echo $er->getMessage();
            }    
        }

        public function useUpdate($table, $identifier, $arrayColumn)
        {
            $this->update($table, $identifier, $arrayColumn);
        }
    }
?>