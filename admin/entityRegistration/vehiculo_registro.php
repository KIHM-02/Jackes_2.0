<?php include("../template/header_registro.php"); ?>
    <?php
        require_once("../config/conexion.php");

        $conection = new Conexion(); //var para instanciar clase usuario
        $arrayVehi = [];
        $arrayWorker =[];
        $arrayValues = [];
        $voidValues = false;

        if($_POST)
        {
            $fecha     = (!empty($_POST['txtDate']))? trim($_POST['txtDate']): null;
            $carId     = (!empty($_POST['txtCarId']))? trim($_POST['txtCarId']): null;
            $usrId     = (!empty($_POST['txtWorkerId']))? trim($_POST['txtWorkerId']): null;
            $distancia = (!empty($_POST['txtDistance']))? trim($_POST['txtDistance']): null;
            $dia = null;
            $mes = null; 
            $anio = null;

            if($fecha !== null)
            {
                list($anio, $mes, $dia) = explode('-', $fecha);
            }
            
            $arrayValues = [
                "dia" => $dia,
                "mes" => $mes,
                "anio" => $anio,
                "distanciaCond" => $distancia,
                "idUsr" => $usrId,
                "idVehi" => $carId 
            ];

            foreach($arrayValues as $camp => $value)
            {
                if($value === null)
                {
                    $voidValues = true;
                    break;
                }
            }
    
            if($voidValues === false)
            {
                $conection->useInsert("conduce", $arrayValues);
            }
        }
    ?>
    <header>
        <h2 class ="subtitle">Agregar recorrido</h2>
    </header>

    <?php  //Mostrar advertencia de campos vacios
        if($voidValues)
        { ?>
            <div class ="warning-box">
                <p>Hay campos de informacion vacios, no se pudo procesar la peticion</p>
            </div>
    <?php } ?>

    <form method="post" class="form-register">
        <section class ="divider">
            <div class ="section-title"><h2>Fecha</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="txtDate">Dia / Mes / Año</label>
                    <input type="date" id="txtDate" name = "txtDate">
                </article>                
            </div>
        </section>

        <section class ="divider">
            <div class ="section-title"><h2>Recorrido</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="txtCarId">Id vehiculo</label>
                    <select name="txtCarId" id="txtCarId">
                    <?php 
                        $arrayVehi = ["idVehi" => null];
                        $vehiData = $conection->getData("vehiculo", $arrayVehi);

                        foreach($vehiData as $vehiculo)
                        {
                    ?>
                        <option value="<?php echo htmlspecialchars($vehiculo['idVehi']); ?>">
                            <?php echo htmlspecialchars($vehiculo['idVehi']."-".$vehiculo['modeloVehi']); ?>
                        </option>            
                <?php   } ?>
                    </select>
                </article>

                <article class ="inputs">
                    <label for="txtWorkerId">Id trabajador</label>
                    <select name="txtWorkerId" id="txtWorkerId">
                    <?php 
                        $arrayWorker = ["idUsr" => null];
                        $userData = $conection->getData("trabajador", $arrayWorker);

                        foreach($userData as $user)
                        {
                    ?>
                        <option value="<?php echo htmlspecialchars($user['idUsr']); ?>">
                            <?php echo htmlspecialchars($user['idUsr']."-".$user['nombreUsr']); ?>
                        </option>            
                <?php   } ?>
                    </select>
                </article>

                <article class ="inputs">
                    <label for="txtDistance">Distancia</label>
                    <input type="text" id="txtDistance" name = "txtDistance">
                </article>
            </div>
        </section>

        <section>
            <div class ="aligner-center">
                <input type="submit" class = "btn-black-header space-top" value ="Registrar">
            </div>
        </section>

    </form>

<?php include("../template/footer.php") ?>