<?php include("template/header.php") ?>

    <?php 
        require_once("config/conexion.php");
        require_once("interface/boundary.php");

        $conection = new Conexion(); //var para instanciar clase usuario
        $boundary = new Boundary();
        $accion = ($_POST)? $_POST['accion']: "all";

        $idUsr  = ($_POST) && !empty($_POST['txtIdUsr'])? intval($_POST['txtIdUsr']): null;
        $idVehi = ($_POST) && !empty($_POST['txtCarId'])? intval($_POST['txtCarId']): null;

        $firstDate = ($_POST) && !empty($_POST['firstDate'])? $_POST['firstDate']: null;
        $lastDate = ($_POST) && !empty($_POST['lastDate'])? $_POST['lastDate']: null;

        $voidCamp = false;

        switch($accion)
        {
            case 'delete_model':
                $params = [
                    'table' =>'vehiculo',
                    'filter'=>['idVehi' => $idVehi]
                ];
                $accion = $boundary->actionHandler($conection, 'delete', $params);
                break;
            
            case 'delete_cond':
                $idCond = $_POST['txtIdCond'];
                $params = [
                    'table' =>'conduce',
                    'filter'=>['idCond'=> $idCond]
                ];
                $accion = $boundary->actionHandler($conection, 'delete', $params);
                break;
            
            case 'add_model':
                $model = (!empty($_POST['txtModelo']))? trim($_POST['txtModelo']): null;
                if($model === null)
                {
                    $voidCamp = true;
                    $accion = 'all';
                }
                else
                {
                    $params = [
                        'table' =>'vehiculo',
                        'filter'=>['modeloVehi' => $model]
                    ];
                    $accion = $boundary->actionHandler($conection, 'add', $params);
                }
                break;
        }
    ?>

    <header>
        <h2 class="subtitle header-elements">Panel Vehiculos</h2>

        <div>
            <a class ="header-elements" href="entityRegistration/vehiculo_registro.php"><button class="btn-black-header header-buttons">Agregar</button></a>
        </div>
    </header>

    <form method="POST" class="form-search">
        <div class ="div-form-inputs">
            <label for="inputWorkerId">Id de trabajador</label>
            <input class ="text-inputs" type="text" name="txtIdUsr" id="inputWorkerId">
        </div>

        <div class ="div-form-inputs">
            <label for="inputCarId">Id del vehiculo</label>
            <input class ="text-inputs" type="text" name="txtCarId" id="inputCarId">
        </div>

        <div class ="div-form-inputs space-top">
            <button type="submit" class ="btn-black-header" name ="accion" value ="filtrar">Filtrar</button>
        </div>
    </form>

    <section class = "section-table">            
        <label for = "chkTable" class ="btn-black-header table-buttons">Desplegar</label>
        <input type="checkbox" name="chkTable" id="chkTable" class ="chkTable table-buttons">

        <div class ="hide-component space-top">
            <table class = "table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Modelo del auto</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>
                <?php 
                    $params = [
                        'table' =>'vehiculo',
                        'filter'=>['idVehi' => null]
                    ];
                    $vehiculoData = $boundary->searchHandler($conection, $params);

                    foreach($vehiculoData as $vehiculo)
                    {
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars ($vehiculo['idVehi']); ?></td>
                        <td><?php echo htmlspecialchars ($vehiculo['modeloVehi']); ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="txtCarId" value = "<?php echo htmlspecialchars ($vehiculo['idVehi']); ?>">
                                <button type ="submit" name = "accion" value ="delete_model">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        
        <form method ="POST" class ="space-top form-table">
            <div class ="div-form-inputs">
                <label for="txtModelo">Modelo: </label>
                <input type="text" class="text-inputs" name="txtModelo" id="txtModelo">
                <label><?php $msg = ($voidCamp=== true)? "No se ingreso ningun modelo": ""; echo $msg;?></label>
            </div>

            <button type="submit" class="btn-black" name ="accion" value ="add_model">Agregar modelo</button>
        </form>

    </section>

    <section class = "section-title">
        <h2 class ="subtitle">Datos</h2>
        
        <form method ="post" class ="date-container">
            <article>
                <label class="firsDate" for="firstDate">Fecha inicio</label>
                <input type="date" name="firstDate" id="firstDate">
            </article>

            <article>
                <label for="lastDate">Fecha final</label>
                <input type="date" name="lastDate" id="lastDate">
            </article>

            <article class ="table-buttons">
                <button type="submit" class ="btn-black-header header-buttons" name = "accion" value ="fecha">Filtrar</button>
            </article>
        </form>

    </section>

    <section class ="info-container">
        
        <?php 
        switch($accion)
        {
            case "all":
                
                $diaFinal = date('d');
                $mesFinal = date('m');
                $anio = date('Y');

                $params = [
                    'table' => 'conduce',
                    'fechaFin' => [
                        'dia'=>$diaFinal,
                        'mes'=>$mesFinal,
                        'anio'=>$anio
                    ]
                ];

                $conduceData = $boundary->searchByDate($conection, 'all', $params);
                break;

            case "filtrar":

                $params = [
                    'table' => 'conduce',
                    'filter' => [
                        'idUsr' => $idUsr,
                        'idVehi' => $idVehi
                    ]
                ];

                $conduceData = $boundary->searchHandler($conection, $params);
                break;
                    
            case "fecha":
                
                if($firstDate === null || $lastDate === null)
                {
                    echo "Alguna de las fechas no fue indicada, favor de indicar todas las fechas";
                    $accion = null;
                }
                else
                {
                    list($anioInicio, $mesInicio, $diaInicio) = explode('-', $firstDate);
                    list($anioFinal, $mesFinal, $diaFinal) = explode('-', $lastDate);

                    $params = [
                    'table' => 'conduce',
                    'fechaInicio'=> [
                        'dia'=>$diaInicio,
                        'mes'=>$mesInicio,
                        'anio'=>$anioInicio
                        ],
                    'fechaFin' => [
                        'dia'=>$diaFinal,
                        'mes'=>$mesFinal,
                        'anio'=>$anioFinal
                        ]
                    ];

                    $conduceData = $boundary->searchByDate($conection, 'none', $params);
                }

                break;
        }

        if($accion !== null)
        {
            foreach($conduceData as $conduce)
            {  
                $diaCond  = $conduce['dia'];
                $mesCond  = $conduce['mes'];
                $anioCond = $conduce['anio'];

                $fecha_html = sprintf("%04d-%02d-%02d", $anioCond, $mesCond, $diaCond);
                ?>
                    <article class ="card">
                        <p><span class="negritas">Id Conduccion: </span><?php echo htmlspecialchars($conduce['idCond']);?></p>
                        <label class="negritas" for="txtFecha">Fecha</label>
                        <input type="date" name="txtFecha" id="txtFecha" value ="<?php echo $fecha_html; ?>">
                        <p><span class="negritas">Recorrido: </span><?php echo htmlspecialchars($conduce['distanciaCond']);?></p>
                        <p><span class="negritas">Id trabajador: </span><?php echo htmlspecialchars($conduce['idUsr']);?></p>
                        <p><span class="negritas">Id vehiculo: </span><?php echo htmlspecialchars($conduce['idVehi']); ?></p>
        
                                        
                        <form method="post">
                            <input type="hidden" name="txtIdCond" value ="<?php echo htmlspecialchars($conduce['idCond']);?>">
                            <button type="submit" class ="btn-black-width" name = "accion" value ="delete_cond">Eliminar</button>
                        </form>
        
                        <form action="entityModification/vehiculo_modificar.php" method="post">
                            <input type="hidden" name="txtIdCond" value ="<?php echo htmlspecialchars($conduce['idCond']);?>">
                            <input type="hidden" name="accion" value ="envio">
                            <button type="submit" class ="btn-black-width">Modificar</button>
                        </form>
        
                    </article>
                <?php
            }
        }
            ?>
    </section>

<?php include("template/footer.php") ?>
