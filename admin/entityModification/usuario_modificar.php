<?php include("../template/header_registro.php"); ?>
    
    <?php
        require_once("../config/conexion.php");

        $conection = new Conexion(); //var para instanciar clase usuario
        $arrayRol = [];
        $arrayValues = [];
        $incorrectPwd = false;
        $voidValues = false;
        $userData = "";

        $accion = isset($_POST['accion'])? $_POST['accion'] : header("Location:../usuario.php"); //Evitamos que el usuario acceda a esta zona por url
        
        switch($accion)
        {
            case "envio":
                $idUsr = $_POST['txtIdUsr'];
                $arrayValues = ["idUsr" => $idUsr];
                $userData = $conection->getData("trabajador", $arrayValues);
                $userData = $userData[0] ?? null;
                $accion = ""; //reseteamos la variable
                break;

            case "modificar":
                
                $voidValues = false;
                
                $idUsr     = $_POST['txtIdUsr'];
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
                        $identifier = ["idUsr" => $idUsr];
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
        <h2 class ="subtitle">Modificar usuarios</h2>
    </header>    

    <?php  //Mostrar advertencia de campos vacios
        if($voidValues)
        { ?>
            <div class ="warning-box">
                <p>Hay campos de informacion vacios, no se pudo procesar la peticion</p>
            </div>
    <?php } ?>

<?php 
    if($userData !== null && !empty($userData))
    {
        ?>
    <form method="post" class="form-register">
        <section class ="divider">
            <div class ="section-title"><h2>Datos Personales</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="txtName">Nombre</label>
                    <input type="hidden" id="txtName" name = "txtIdUsr" value = "<?php echo htmlspecialchars($userData['idUsr']); ?>">
                    <input type="text" id="txtName" name = "txtName" value = "<?php echo htmlspecialchars($userData['nombreUsr']); ?>">
                </article>

                <article class ="inputs">
                    <label for="txtPaterno">Apellido Paterno</label>
                    <input type="text" id="txtPaterno" name = "txtPaterno" value = "<?php echo htmlspecialchars($userData['apePatUsr']); ?>">
                </article>

                <article class ="inputs">
                    <label for="txtMaterno">Apellido Materno</label>
                    <input type="text" id="txtMaterno" name = "txtMaterno" value = "<?php echo htmlspecialchars($userData['apeMatUsr']); ?>">
                </article>

                <article class ="inputs">
                    <label for="txtTel">Telefono</label>
                    <input type="text" id="txtTel" name = "txtTel" value = "<?php echo htmlspecialchars($userData['telefonoUsr']); ?>">
                </article>
                
            </div>
        </section>

        <section class ="divider">
            <div class ="section-title"><h2>Identificadores</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="txtRol">Rol de usuario</label>
                    <select name="txtRol" id="txtRol">
                    <?php 
                        $arrayRol = ["idRol" => null];
                        $rolesData = $conection->getData("rol", $arrayRol);

                        foreach($rolesData as $roles)
                        {
                            $selected = ($roles['idRol'] === $userData['idRol'])? 'selected': '';
                    ?>
                        <option value="<?php echo htmlspecialchars ($roles['idRol']); ?>" <?php echo $selected ?>>
                            <?php echo htmlspecialchars ($roles['idRol']); ?>-
                            <?php echo htmlspecialchars ($roles['tipoRol']); ?>
                        </option>
                    <?php } ?>
                    </select>
                </article>
            </div>
        </section>

        <section class ="divider">
            <div class ="section-title"><h2>Ubicación</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="txtUbication">Domicilio</label>
                    <input type="text" name="txtUbication" id="txtUbication" value = "<?php echo htmlspecialchars($userData['direccionUsr']); ?>">
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