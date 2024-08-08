<?php include("template/header.php") ?>

    <?php
        require_once("config/conexion.php");

        $conection = new Conexion(); //var para instanciar clase usuario
        $accion = ($_POST)? $_POST['accion']: "all";

        $idUsr  = ($_POST) && !empty($_POST['txtId'])? intval($_POST['txtId']): null;
        $name   = ($_POST) && !empty($_POST['txtName'])? $_POST['txtName']: null;
        $rol    = ($_POST) && !empty($_POST['txtIdRol'])? intval($_POST['txtIdRol']): null;

        $arrayFilters = [];
        $arrayRol = [];

        $voidCamp = false;

        switch($accion)
        {
            case "delete_rol":
                    $arrayRol = ["idRol" => $rol];
                    $conection->useDelete("rol", $arrayRol);
                    $accion = "all"; //reseteamos la variable accion para mostrar los registros usuario
                break;

            case "delete_user":
                    $arrayFilters = ["idUsr" => $idUsr];
                    $conection->useDelete("trabajador", $arrayFilters);
                    $accion = "all"; //reseteamos la variable accion para mostrar los registros usuario
                break;

            case "add_rol":
                    $tipo = (!empty($_POST['txtTipoRol']))? trim($_POST['txtTipoRol']): null;
                    if($tipo === null)
                    {
                        $voidCamp = true;
                    }
                    else
                    {
                        $arrayRol = ["tipoRol" => $tipo];
                        $conection->useInsert("rol", $arrayRol);
                    }
                    $accion = "all"; //reseteamos la variable accion para mostrar los registros usuario
                break;
        }
        
    ?>

    <header>
        <h2 class="subtitle header-elements">Panel Usuarios</h2>

        <div>
            <a class ="header-elements" href="entityRegistration/usuario_registro.php"><button class="btn-black-header header-buttons">Agregar</button></a>
        </div>
    </header>

    <form method="POST" class="form-search">
        <div class ="div-form-inputs">
            <label for="inputId">Id de usuario</label>
            <input class ="text-inputs" type="number" name="txtId" id="inputId">
        </div>

        <div class ="div-form-inputs">
            <label for="inputName">Nombre</label>
            <input class ="text-inputs" type="text" name="txtName" id="inputName">
        </div>

        <div class ="div-form-inputs">
            <label for="txtIdRol">Id rol de usuario</label>
            <input class="text-inputs" type="text" name="txtIdRol" id="txtIdRol">
        </div>

        <div class ="div-form-inputs space-top">
            <button class ="btn-black-header" type="submit" value="filtrar" name ="accion">Filtrar</button>
        </div>
    </form>

    <section class = "section-table">
        <label for = "chkTable" class ="btn-black-header table-buttons">Desplegar</label>
        <input type="checkbox" name="chkTable" id="chkTable" class ="chkTable table-buttons">

        <div class ="hide-component space-top">
            <table class = "table">
                <thead>
                    <tr>
                        <th>ID rol</th>
                        <th>Tipo rol</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>

                <?php 
                    $arrayRol = ["idRol" => null];
                    $rolesData = $conection->getData("rol", $arrayRol);

                    foreach($rolesData as $roles)
                    {
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars ($roles['idRol']); ?></td>
                        <td><?php echo htmlspecialchars ($roles['tipoRol']); ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="txtIdRol" value = "<?php echo htmlspecialchars ($roles['idRol']); ?>">
                                <button type ="submit" name = "accion" value ="delete_rol">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <form method ="POST" class ="space-top form-table">
            <div class ="div-form-inputs">
                <label for="txtTipoRol">Tipo de rol: </label>
                <input type="text" class="text-inputs" name="txtTipoRol" id="txtTipoRol" <?php $msg = ($voidCamp=== true)? "No se ingreso ningun rol": ""; echo $msg;?> >
            </div>

            <button type="submit" class="btn-black" name ="accion" value ="add_rol">Agregar rol</button>
        </form>

    </section>

    <section class = "section-title">
        <h2 class ="subtitle">Datos</h2>
    </section>

    <section class ="info-container">

        <?php
        switch($accion)
        {
            case "all":
                $arrayFilters = ["idUsr" => null]; //Arreglo de filtros en null para que se ejecute una consulta select sin condiciones
                $userData = $conection->getData("trabajador", $arrayFilters);

                foreach($userData as $data)
                {   ?>
                    <article class ="card">
                        <p><span class="negritas">Id Usuario: </span><?php echo htmlspecialchars($data['idUsr']);?></p>
                        <p><span class="negritas">Nombre: </span><?php echo htmlspecialchars($data['nombreUsr']. " ".$data['apePatUsr']." ".$data['apeMatUsr']);?></p>
                        <p><span class="negritas">Direccion: </span><?php echo htmlspecialchars($data['direccionUsr']);?></p>
                        <p><span class="negritas">telefono: </span><?php echo htmlspecialchars($data['telefonoUsr']);?></p>
                        <p><span class="negritas">Rol: </span><?php echo htmlspecialchars($data['idRol']); ?></p>

                        <div>
                            <form method="post">
                                <input type="hidden" name="txtId" value ="<?php echo htmlspecialchars($data['idUsr']);?>">
                                <button type="submit" class ="btn-black-width" name = "accion" value ="delete_user">Eliminar</button>
                            </form>
    
                            <form action="entityModification/usuario_modificar.php" method="post">
                                <input type="hidden" class ="btn-black-header" name="txtIdUsr" value ="<?php echo htmlspecialchars($data['idUsr']);?>">
                                <input type="hidden" name="accion" value ="envio">
                                <button type="submit" class ="btn-black-width">Modificar</button>
                            </form>
                        </div>

                    </article>
                     <?php
                }

                break;

            case "filtrar":

                $arrayFilters = [
                    "idUsr" => $idUsr,
                    "nombreUsr" => $name,
                    "idRol" => $rol
                ];

                $userData = $conection->getData("trabajador", $arrayFilters);

                foreach($userData as $data)
                {   ?>
                    <article class ="card">
                    <p><span class="negritas">Id Usuario: </span><?php echo htmlspecialchars($data['idUsr']);?></p>
                        <p><span class="negritas">Nombre: </span><?php echo htmlspecialchars($data['nombreUsr']. " ".$data['apePatUsr']." ".$data['apeMatUsr']);?></p>
                        <p><span class="negritas">Direccion: </span><?php echo htmlspecialchars($data['direccionUsr']);?></p>
                        <p><span class="negritas">telefono: </span><?php echo htmlspecialchars($data['telefonoUsr']);?></p>
                        <p><span class="negritas">Rol: </span><?php echo htmlspecialchars($data['idRol']); ?></p>

                        
                        <form method="post">
                            <input type="hidden" name="txtId" value ="<?php echo htmlspecialchars($data['idUsr']);?>">
                            <button type="submit" class ="btn-black-width" name = "accion" value ="delete_user">Eliminar</button>
                        </form>

                        <form action="entityModification/usuario_modificar.php" method="post">
                            <input type="hidden" name="txtIdUsr" value ="<?php echo htmlspecialchars($data['idUsr']);?>">
                            <button type="submit" class ="btn-black-width">Modificar</button>
                        </form>

                    </article>
                     <?php
                }

                break;
        }
    ?>
    </section>

<?php include("template/footer.php") ?>
