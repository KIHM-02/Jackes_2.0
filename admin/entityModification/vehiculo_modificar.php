<?php include("../template/header_registro.php"); ?>
    
<?php
        require_once("../config/conexion.php");

        $conection = new Conexion(); //var para instanciar clase usuario
        $arrayVehi = [];
        $arrayValues = [];
        $voidValues = false;
        $condData = "";

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
                
                $voidValues = false;
                
                $idCond     = $_POST['txtIdCond'];
                $name      = (!empty($_POST['txtName']))? trim($_POST['txtName']): null;
                $apePat    = (!empty($_POST['txtPaterno']))? trim($_POST['txtPaterno']): null;
                $apeMat    = (!empty($_POST['txtMaterno']))? trim($_POST['txtMaterno']): null;
                $tel       = (!empty($_POST['txtTel']))? trim($_POST['txtTel']): null;
                $rol       = (!empty($_POST['txtRol']))? trim($_POST['txtRol']): null;
                $domicilio = (!empty($_POST['txtUbication']))? trim($_POST['txtUbication']): null;

                $arrayValues = [
                    "nombreUsr" => $name,
                    "apePatUsr" => $apePat,
                    "apeMatUsr" => $apeMat,
                    "direccionUsr" => $domicilio,
                    "telefonoUsr" => $tel,
                    "idRol" => $rol
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
                        $conection->useUpdate("trabajador", $identifier, $arrayValues);

                        header("Location:../usuario.php");
                    }
                    catch(Exception $er)
                    {
                        echo $er->getMessage();
                    }
                }

                break;
        }
        

    ?>

    <header>
        <h2 class ="subtitle">Agregar vehiculo</h2>
    </header>

    <?php  //Mostrar advertencia de campos vacios
        if($voidValues)
        { ?>
            <div class ="warning-box">
                <p>Hay campos de informacion vacios, no se pudo procesar la peticion</p>
            </div>
    <?php 
        } 

    if($condData !== null)
    {
        $diaCond = $condData['dia'];
        $mesCond = $condData['mes'];
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
    <?php 
    } ?>
        <section>
            <div class ="aligner-center">
            <button type="submit" class = "btn-black-header space-top" name ="accion" value ="modificar">Modificar</button>
            </div>
        </section>

    </form>

<?php include("../template/footer.php") ?>