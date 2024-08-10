<?php include("../template/header_registro.php"); ?>
    
<?php
        require_once("../config/conexion.php");

        $conection = new Conexion(); //var para instanciar clase usuario
        $arrayMuni = [];
        $arrayValues = [];
        $voidValues = false;
        $maqData = "";
        $IdClie = null;

        $accion = isset($_POST['accion'])? $_POST['accion'] : header("Location:../maquina.php"); //Evitamos que el usuario acceda a esta zona por url
        
        switch($accion)
        {
            case "envio":
                $idMaq = $_POST['txtIdMaq'];
                $arrayValues = ["idMaq" => $idMaq];
                $maqData = $conection->getData("maquina", $arrayValues);
                $maqData = $maqData[0] ?? null;
                $accion = ""; //reseteamos la variable
                break;

            case "modificar":
                
                $idMaq     = $_POST['txtIdMaq'];
                $idModelo  = (!empty($_POST['txtIdModelo']))? trim($_POST['txtIdModelo']): null;
                $idClie    = (!empty($_POST['txtClientId']))? trim($_POST['txtClientId']): null;
                $status    = (!empty($_POST['txtStatus']))? trim($_POST['txtStatus']): null;

                $arrayValues = [
                    "estatusMaq" => $status,
                    "idModelo" => $idModelo,
                    "idClie"=> $idClie
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
                        $identifier = ["idMaq" => $idMaq];
                        $conection->useUpdate("maquina", $identifier, $arrayValues);    
                        header("Location:../cliente.php");
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
        <h2 class ="subtitle">Modificar cliente</h2>
    </header>

    <?php  //Mostrar advertencia de campos vacios
        if($voidValues)
        { ?>
            <div class ="warning-box">
                <p>Hay campos de informacion vacios, no se pudo procesar la petición</p>
            </div>
    <?php 
        } 

    //var_dump($maqData); //Sirve para debuguear

    if($maqData !== null && !empty($maqData))
    {
    ?>

    <form method="post" class="form-register">
        <section class ="divider">
            <div class ="section-title"><h2>Identificadores</h2></div>
            <div class ="section-inputs">
            <article class ="inputs">
                    <label for="txtIdModelo">Id modelo</label>
                    <input type="hidden" id="txtIdMaq" name = "txtIdMaq" value ="<?php echo htmlspecialchars($maqData['idMaq']); ?>">
                    <select name="txtIdModelo" id="txtIdModelo">
                    <?php 
                        $arrayModelo = ["idModelo" => null];
                        $modeloData = $conection->getData("modelo", $arrayModelo);

                        foreach($modeloData as $data)
                        {
                            $selected = ($data['idModelo'] === $maqData['idModelo'])? 'selected':'';
                    ?>
                        <option value="<?php echo htmlspecialchars ($data['idModelo']); ?>" <?php echo $selected; ?>>
                            <?php echo htmlspecialchars ($data['idModelo']); ?>-
                            <?php echo htmlspecialchars ($data['modelo']); ?>
                        </option>
                    <?php } ?>
                    </select>
                </article>

                <article class ="inputs">
                    <label for="txtClientId">Id cliente</label>
                    <select name="txtClientId" id="txtClientId">
                    <?php 
                        $arrayClie = ["idClie" => null];
                        $clieData = $conection->getData("cliente", $arrayClie);

                        foreach($clieData as $data)
                        {
                            $selected = ($data['idClie'] === $maqData['idClie'])? 'selected':'';
                    ?>
                        <option value="<?php echo htmlspecialchars ($data['idClie']); ?>" <?php echo $selected; ?>>
                            <?php echo htmlspecialchars ($data['idClie']); ?>-
                            <?php echo htmlspecialchars ($data['nombreClie']); ?>
                        </option>
                    <?php } ?>
                    </select>
                </article>

                <article class ="inputs">
                    <label for="txtStatus">Estatus</label>
                    <input type="text" id="txtStatus" name = "txtStatus" value ="<?php echo htmlspecialchars($maqData['estatusMaq']); ?>">
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