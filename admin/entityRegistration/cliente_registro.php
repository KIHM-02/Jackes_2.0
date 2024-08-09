<?php include("../template/header_registro.php"); ?>

    <?php
        require_once("../config/conexion.php");

        $conection = new Conexion(); //var para instanciar clase usuario
        $arrayMuni = [];
        $arrayValues = [];
        $incorrectPwd = false;
        $voidValues = false;

        if($_POST)
        {
            $name          = (!empty($_POST['txtName']))? trim($_POST['txtName']): null;
            $apePat        = (!empty($_POST['txtPat']))? trim($_POST['txtPat']): null;
            $apeMat        = (!empty($_POST['txtMat']))? trim($_POST['txtMat']): null;
            $tel           = (!empty($_POST['txtTel']))? trim($_POST['txtTel']): null;
            $domicilio     = (!empty($_POST['txtDom']))? trim($_POST['txtDom']): null;
            $colonia       = (!empty($_POST['txtColonia']))? trim($_POST['txtColonia']): null;
            $numExterior   = (!empty($_POST['txtNumExt']))? trim($_POST['txtNumExt']): null;
            $numInterior   = (!empty($_POST['txtNumInt']))? trim($_POST['txtNumInt']): null;
            $municipio     = (!empty($_POST['txtMunicipioId']))? intval(trim($_POST['txtMunicipioId'])): null;

            $arrayValues = [
                "nombreClie" => $name,
                "apePatClie" => $apePat,
                "apeMatClie"=> $apeMat,
                "coloniaClie"=> $colonia,
                "direccionClie" => $domicilio,
                "telefonoClie" => $tel,
                "numInteriorClie" => $numInterior,
                "numExteriorClie" => $numExterior,
                "idMunicipio" => $municipio
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
                $conection->useInsert("cliente", $arrayValues);
            }
        }
    ?>

    <header>
        <h2 class ="subtitle">Agregar Cliente</h2>
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
            <div class ="section-title"><h2>Datos Personales</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="txtName">Nombre completo</label>
                    <input type="text" id="txtName" name = "txtName">
                </article>
                <article class ="inputs">
                    <label for="txtPat">Apellido paterno</label>
                    <input type="text" id="txtPat" name = "txtPat">
                </article>
                <article class ="inputs">
                    <label for="txtMat">Apellido materno</label>
                    <input type="text" id="txtMat" name = "txtMat">
                </article>
                <article class ="inputs">
                    <label for="txtTel">Telefono</label>
                    <input type="text" id="txtTel" name = "txtTel">
                </article>
            </div>
        </section>

        <section class ="divider">
            <div class ="section-title"><h2>Ubicación</h2></div>
            <div class ="section-inputs">  
                <article class ="inputs">
                    <label for="txtDom">Domicilio</label>
                    <input type="text" id="txtDom" name = "txtDom">
                </article>
                
                <article class ="inputs">
                    <label for="txtNumExt">Numero Exterior</label>
                    <input type="text" id="txtNumExt" name = "txtNumExt">
                </article>

                <article class ="inputs">
                    <label for="txtNumInt">Numero Interior</label>
                    <input type="text" id="txtNumInt" name = "txtNumInt" value="s/n">
                </article>

                <article class ="inputs">
                    <label for="txtColonia">Colonia</label>
                    <input type="text" id="txtColonia" name = "txtColonia">
                </article>

                <article class ="inputs">
                    <label for="txtMunicipioId">Id Municipio</label>
                    <select name="txtMunicipioId" id="txtMunicipioId">
                    <?php 
                        $arrayMuni = ["idMuni" => null];
                        $muniData = $conection->getData("municipio", $arrayMuni);

                        foreach($muniData as $data)
                        {
                    ?>
                        <option value="<?php echo htmlspecialchars ($data['idMuni']); ?>">
                            <?php echo htmlspecialchars ($data['idMuni']); ?>-
                            <?php echo htmlspecialchars ($data['municipio']); ?>
                        </option>
                    <?php } ?>
                    </select>
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