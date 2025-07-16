<?php include("template/header.php") ?>

    <?php 
        require_once("config/conexion.php");

        $conection = new Conexion(); //var para instanciar clase usuario
        $accion = ($_POST)? $_POST['accion']: "all";

        $idUsr  = ($_POST) && !empty($_POST['txtIdUsr'])? intval($_POST['txtIdUsr']): null;
        $idMaq  = ($_POST) && !empty($_POST['txtIdMaq'])? intval($_POST['txtIdMaq']): null;

        $firstDate = ($_POST) && !empty($_POST['firstDate'])? $_POST['firstDate']: null;
        $lastDate = ($_POST) && !empty($_POST['lastDate'])? $_POST['lastDate']: null;

        $arrayFilters = [];
        $arrayVehiculo = [];
        $corteData = null;

        $voidCamp = false;

        switch($accion)
        {
            case "delete_corte":
                    $idCorte = $_POST['txtIdCorte'];
                    $arrayFilters = ["idCorte" => $idCorte];
                    $conection->useDelete("corte", $arrayFilters);
                    $accion = "all"; //reseteamos la variable accion para mostrar los registros usuario
                break;
        }

    ?>

    <header>
        <h2 class="subtitle header-elements">Panel Cortes</h2>

        <div>
            <a class ="header-elements" href="entityRegistration/corte_registro.php"><button class="btn-black-header header-buttons">Agregar</button></a>
        </div>
    </header>

    <form method="POST" class="form-search">
        <div class ="div-form-inputs">
            <label for="inputWorkerId">Id de trabajador</label>
            <input class ="text-inputs" type="text" name="txtIdUsr" id="inputWorkerId">
        </div>

        <div class ="div-form-inputs">
            <label for="inputMaqId">Id de maquina</label>
            <input class ="text-inputs" type="text" name="txtIdMaq" id="inputMaqId">
        </div>

        <div class ="div-form-inputs space-top">
            <button type="submit" class ="btn-black-header" name ="accion" value ="filtrar">Filtrar</button>
        </div>
    </form>

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

                $diaInicio = ($diaFinal != 1)? intval($diaFinal)-1: 30;
                $mesInicio = ($mesFinal != 1)? intval($mesFinal)-1: 12;
                $diaInicio = (string)$diaInicio;
                $mesInicio = (string)$mesInicio;

                $fechaInicio =[
                    "dia" => $diaInicio,
                    "mes" => $mesInicio,
                    "anio" => $anio
                ];
                
                $fechaFin = [
                    "dia" => $diaFinal,
                    "mes" => $mesFinal,
                    "anio" => $anio
                ];

                $corteData = $conection->getDataInRange("corte", $fechaInicio, $fechaFin);
                break;

            case "filtrar":
                $arrayFilters = [
                    "idUsr" => $idUsr,
                    "idMaq" => $idMaq
                ];

                $corteData = $conection->getData("corte", $arrayFilters);
                break;

            case "fecha":
                if($firstDate === null || $lastDate === null)
                {
                    echo "Alguna de las fechas no fue indicada, favor de indicar todas las fechas";
                }
                else
                {
                    list($anioInicio, $mesInicio, $diaInicio) = explode('-', $firstDate);
                    list($anioFinal, $mesFinal, $diaFinal) = explode('-', $lastDate);

                    $fechaInicio =[
                        "dia" => $diaInicio,
                        "mes" => $mesInicio,
                        "anio" => $anioInicio
                    ];
                    
                    $fechaFin = [
                        "dia" => $diaFinal,
                        "mes" => $mesFinal,
                        "anio" => $anioFinal
                    ];
    
                    $corteData = $conection->getDataInRange("corte", $fechaInicio, $fechaFin);
                }
                break;
        }
                    
        foreach($corteData as $corte)
        {  
            $diaCorte  = $corte['dia'];
            $mesCorte  = $corte['mes'];
            $anioCorte = $corte['anio'];

            $fecha_html = sprintf("%04d-%02d-%02d", $anioCorte, $mesCorte, $diaCorte);
            ?>
                <article class ="card">
                    <p><span class="negritas">Id maquina: </span><?php echo htmlspecialchars($corte['idMaq']);?></p>
                    <p><span class="negritas">Id responsable: </span><?php echo htmlspecialchars($corte['idUsr']);?></p>
                    <label class="negritas" for="txtFecha">Fecha</label>
                    <input type="date" name="txtFecha" id="txtFecha" value ="<?php echo $fecha_html; ?>">
                    <p><span class="negritas">Entrada: </span><?php echo htmlspecialchars($corte['entrada']);?></p>
                    <p><span class="negritas">Salida: </span><?php echo htmlspecialchars($corte['salida']);?></p>
                    <p><span class="negritas">Resultado: </span><?php echo htmlspecialchars($corte['resultado']); ?></p>
                    <p><span class="negritas">Fichaje Real: </span><?php echo htmlspecialchars($corte['ficReal']); ?></p>
                    <p><span class="negritas">Digital: </span><?php echo htmlspecialchars($corte['digital']); ?></p>
                    <p><span class="negritas">Total Fisico: </span><?php echo htmlspecialchars($corte['totalFisico']); ?></p>
                    <p><span class="negritas">Coincide (Variacion): </span><?php echo htmlspecialchars($corte['totalFisico']-$corte['digital']); ?></p>

                                
                    <form method="post">
                        <input type="hidden" name="txtIdCorte" value ="<?php echo htmlspecialchars($corte['idCorte']);?>">
                        <button type="submit" class ="btn-black-width" name = "accion" value ="delete_corte">Eliminar</button>
                    </form>

                </article>
            <?php
        }     
        ?>

    </section>

<?php include("template/footer.php") ?>
