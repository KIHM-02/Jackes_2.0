<?php include("../template/header_registro.php"); ?>
    
    <?php
        require_once("../config/conexion.php");

        $conection = new Conexion(); //var para instanciar clase usuario
        $arrayRol = [];
        $arrayValues = [];
        $incorrectPwd = false;
        $voidValues = false;

        if($_POST)
        {
            $name      = (!empty($_POST['txtName']))? trim($_POST['txtName']): null;
            $apePat    = (!empty($_POST['txtPaterno']))? trim($_POST['txtPaterno']): null;
            $apeMat    = (!empty($_POST['txtMaterno']))? trim($_POST['txtMaterno']): null;
            $tel       = (!empty($_POST['txtTel']))? trim($_POST['txtTel']): null;
            $rol       = (!empty($_POST['txtRol']))? trim($_POST['txtRol']): null;
            $pwd       = (!empty($_POST['txtPass']))? trim($_POST['txtPass']): null;
            $pwdCon    = (!empty($_POST['txtConPass']))? trim($_POST['txtConPass']): null;
            $domicilio = (!empty($_POST['txtUbication']))? trim($_POST['txtUbication']): null;

            if(strcmp($pwd, $pwdCon) || $pwd === null || $pwdCon === null)
            { 
                $incorrectPwd = true; 
            }
            else
            {
                $voidValues = false;

                $arrayValues = [
                    "nombreUsr" => $name,
                    "apePatUsr" => $apePat,
                    "apeMatUsr" => $apeMat,
                    "direccionUsr" => $domicilio,
                    "telefonoUsr" => $tel,
                    "contraUsr" => $pwd, //password_hash($pwd, PASSWORD_DEFAULT),
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
                    $conection->useInsert("trabajador", $arrayValues);
                }
            }
        }
    ?>

    <header>
        <h2 class ="subtitle">Agregar usuarios</h2>
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
                    <label for="txtName">Nombre</label>
                    <input type="text" id="txtName" name = "txtName">
                </article>

                <article class ="inputs">
                    <label for="txtPaterno">Apellido Paterno</label>
                    <input type="text" id="txtPaterno" name = "txtPaterno">
                </article>

                <article class ="inputs">
                    <label for="txtMaterno">Apellido Materno</label>
                    <input type="text" id="txtMaterno" name = "txtMaterno">
                </article>

                <article class ="inputs">
                    <label for="txtTel">Telefono</label>
                    <input type="text" id="txtTel" name = "txtTel">
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
                    ?>
                        <option value="<?php echo htmlspecialchars ($roles['idRol']); ?>">
                            <?php echo htmlspecialchars ($roles['idRol']); ?>-
                            <?php echo htmlspecialchars ($roles['tipoRol']); ?>
                        </option>
                    <?php } ?>
                    </select>
                </article>

                <?php //Mostrar advertencia de contraseñas diferentes
                    if($incorrectPwd){ ?>
                    <article class ="inputs warning-box">
                        <label>Las contraseñas son incorretas</label>
                    </article>    
                <?php } ?>

                <article class ="inputs">
                    <label for="txtTel">Contraseña</label>
                    <input type="password" id="txtPass" name = "txtPass">
                </article>

                <article class ="inputs">
                    <label for="txtTel">Confirmar contraseña</label>
                    <input type="password" id="txtConPass" name = "txtConPass">
                </article>
            </div>
        </section>

        <section class ="divider">
            <div class ="section-title"><h2>Ubicación</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="txtUbication">Domicilio</label>
                    <input type="text" name="txtUbication" id="txtUbication">
                </article>
            </div>
        </section>

        <section>
            <div class ="aligner-center">
                <input type="submit" class = "btn-black-header space-top" name ="accion" value ="Registrar">
            </div>
        </section>

    </form>

<?php include("../template/footer.php") ?>