<?php include("../template/header_registro.php"); ?>
    
    <?php
        require_once("../config/conexion.php");

        $conection = new Conexion(); //var para instanciar clase usuario
        $arrayModelo = [];
        $arrayValues = [];
        $voidValues = false;

        if($_POST)
        {
            $idModelo      = (!empty($_POST['txtIdModelo']))? trim($_POST['txtIdModelo']): null;
            $idClie        = (!empty($_POST['txtClientId']))? trim($_POST['txtClientId']): null;
            $status        = (!empty($_POST['txtStatus']))? trim($_POST['txtStatus']): null;
            $identificador = (!empty($_POST['txtIdentificador']))? trim($_POST['txtIdentificador']): null;
            

            $arrayValues = [
                "estatusMaq" => $status,
                "idClie" => $idClie,
                "idModelo"=> $idModelo,
                "identificador" => $identificador
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
                $conection->useInsert("maquina", $arrayValues);
            }
        }
    ?>

    <header>
        <h2 class ="subtitle">Agregar Maquina</h2>
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
            <div class ="section-title"><h2>Identificadores</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="txtIdModelo">Id modelo</label>
                    <select name="txtIdModelo" id="txtIdModelo">
                    <?php 
                        $arrayModelo = ["idModelo" => null];
                        $modeloData = $conection->getData("modelo", $arrayModelo);

                        foreach($modeloData as $data)
                        {
                    ?>
                        <option value="<?php echo htmlspecialchars ($data['idModelo']); ?>">
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
                    ?>
                        <option value="<?php echo htmlspecialchars ($data['idClie']); ?>">
                            <?php echo htmlspecialchars ($data['idClie']); ?>-
                            <?php echo htmlspecialchars ($data['nombreClie']); ?>
                        </option>
                    <?php } ?>
                    </select>
                </article>

                <article class="inputs">
                    <label for="txtIdentificador">Identificador</label>
                    <input type="text" id="txtIdentificador" name="txtIdentificador">
                </article>

                <article class ="inputs">
                    <label for="txtStatus">Estatus</label>
                    <input type="text" id="txtStatus" name = "txtStatus">
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