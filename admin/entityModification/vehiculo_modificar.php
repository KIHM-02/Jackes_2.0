<?php include("../template/header_registro.php"); ?>
    
<?php
        require_once("../config/conexion.php");

        $conection = new Conexion(); //var para instanciar clase usuario
        $arrayVehi = [];
        $arrayValues = [];
        $voidValues = false;
        $condData = "";
        $idCond = null;

        $accion = isset($_POST['accion'])? $_POST['accion'] : header("Location:../vehiculo.php"); //Evitamos que el usuario acceda a esta zona por url
        
        switch($accion)
        {
            case "envio":
                $idCond = $_POST['txtIdCond'];
                $arrayValues = ["idCond" => $idCond];
                $condData = $conection->getData("conduce", $arrayValues);
                $condData = $condData[0] ?? null;
                $accion = ""; //reseteamos la variable
                break;

            case "modificar":
                
                $idCond    = $_POST['txtIdCond'];
                $fecha     = (!empty($_POST['txtDate']))? trim($_POST['txtDate']): null;
                $idUsr     = (!empty($_POST['txtWorkerId']))? trim($_POST['txtWorkerId']): null;
                $idVehi    = (!empty($_POST['txtCarId']))? trim($_POST['txtCarId']): null;
                $recorrido = (!empty($_POST['txtDistance']))? trim($_POST['txtDistance']): null;

                if($fecha !== null)
                {
                    list($anio, $mes, $dia) = explode('-', $fecha);

                    $arrayValues = [
                        "dia" => $dia,
                        "mes" => $mes,
                        "anio" => $anio,
                        "distanciaCond" => $recorrido,
                        "idUsr" => $idUsr,
                        "idVehi" => $idVehi
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
                        try
                        {
                            $identifier = ["idCond" => $idCond];
                            $conection->useUpdate("conduce", $identifier, $arrayValues);
    
                            header("Location:../vehiculo.php");
                        }
                        catch(Exception $er)
                        {
                            echo $er->getMessage();
                        }
                    }
                }
                else
                {
                    $voidValues = true;
                }

                break;
        }
        

    ?>

    <header>
        <h2 class ="subtitle">Modificar recorrido</h2>
    </header>

    <?php  //Mostrar advertencia de campos vacios
        if($voidValues)
        { ?>
            <div class ="warning-box">
                <p>Hay campos de informacion vacios, no se pudo procesar la petición</p>
            </div>
    <?php 
        } 

    //var_dump($condData); Sirve para debuguear

    if($condData !== null && !empty($condData))
    {
        $mesCond = $condData['mes'];
        $diaCond = $condData['dia'];
        $anioCond = $condData['anio'];

        $fecha_html = sprintf("%04d-%02d-%02d", $anioCond, $mesCond, $diaCond);
    ?>

    <form method="post" class="form-register">
        <section class ="divider">
            <div class ="section-title"><h2>Fecha</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="txtDate">Dia / Mes / Año</label>
                    <input type="date" id="txtDate" name = "txtDate" value ="<?php echo $fecha_html; ?>">
                    <input type="hidden" name="txtIdCond" value ="<?php echo $condData['idCond']; ?>">
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
                            $selected = ($vehiculo['idVehi'] === $condData['idVehi'])? 'selected':'';
                    ?>
                        <option value="<?php echo htmlspecialchars($vehiculo['idVehi']); ?>" <?php echo $selected; ?>>
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
                            $selected = ($user['idUsr'] === $condData['idUsr'])? 'selected':'';
                    ?>
                        <option value="<?php echo htmlspecialchars($user['idUsr']); ?>" <?php echo $selected; ?>>
                            <?php echo htmlspecialchars($user['idUsr']."-".$user['nombreUsr']); ?>
                        </option>            
                <?php   } ?>
                    </select>
                </article>

                <article class ="inputs">
                    <label for="txtDistance">Distancia</label>
                    <input type="text" id="txtDistance" name = "txtDistance" value ="<?php echo $condData['distanciaCond']; ?>">
                </article>
            </div>
        </section>
        <section>
            <div class ="aligner-center">
                <button type="submit" class = "btn-black-header space-top" name ="accion" value ="modificar">Modificar</button>
            </div>
        </section>
    <?php 
    } ?>
    
    </form>

<?php include("../template/footer.php") ?>