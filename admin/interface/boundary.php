<?php 

    class Boundary
    {

        public function actionHandler($conection, $accion, $params)
        {
            switch($accion)
            {
                case "delete":
                    $conection->useDelete($params['table'], $params['filter']);
                    $accion = "all"; //reseteamos la variable accion para mostrar los registros usuario
                    break;

                case "add":
                    $conection->useInsert($params['table'], $params['filter']);
                    $accion = "all";
                    break;
            }

            return $accion; //reseteamos la variable accion para mostrar los registros
        }

        public function searchHandler($conection, $params)
        {
            return $conection->getData($params['table'], $params['filter']);
        }

        public function searchByDate($conection, $accion, $params)
        {
            if($accion == 'all')
            {
                $diaFinal  = $params['fechaFin']['dia'];
                $mesFinal  = $params['fechaFin']['mes'];
                $anioFinal = $params['fechaFin']['anio']; 

                $diaInicio = ($diaFinal != 1)? intval($diaFinal)-1: 30;
                $mesInicio = ($mesFinal != 1)? intval($mesFinal)-1: 12;

                if($mesInicio > $mesFinal)
                    $anioInicio = $anioFinal - 1;
                else
                    $anioInicio = $anioFinal;  

                $diaInicio  = (string)$diaInicio;
                $mesInicio  = (string)$mesInicio;
                $anioInicio = (string)$anioInicio; 
                
                $params['fechaInicio'] = [
                    'dia'  => $diaInicio,
                    'mes'  => $mesInicio,
                    'anio' => $anioInicio
                ];
            }

            return $conection->getDataInRange($params['table'], 
                                $params['fechaInicio'],
                                $params['fechaFin']);
        }
    
    }

?>