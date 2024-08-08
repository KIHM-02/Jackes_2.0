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

        switch($accion)
        {
            case "delete_rol":
                    $arrayRol = ["idRol" => $rol];
                    $conection->useDelete("rol", $arrayRol);
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
        <button class ="btn-black-header table-buttons">Agregar Rol</button>

        <label for = "chkTable" class ="btn-black-header table-buttons">Desplegar</label>
        <input type="checkbox" name="chkTable" id="chkTable" class ="chkTable table-buttons">

        <div class ="border-table space-top">
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
                        <p>Id Usuario: <?php echo htmlspecialchars($data['idUsr']);?></p>
                        <p>Nombre: <?php echo htmlspecialchars($data['nombreUsr']. " ".$data['apePatUsr']." ".$data['apeMatUsr']);?></p>
                        <p>Direccion: <?php echo htmlspecialchars($data['direccionUsr']);?></p>
                        <p>Telefono: <?php echo htmlspecialchars($data['telefonoUsr']);?></p>
                        <p>Rol: <?php echo htmlspecialchars($data['idRol']); ?></p>
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
                        <p>Id Usuario: <?php echo htmlspecialchars($data['idUsr']);?></p>
                        <p>Nombre: <?php echo htmlspecialchars($data['nombreUsr']. " ".$data['apePatUsr']." ".$data['apeMatUsr']);?></p>
                        <p>Direccion: <?php echo htmlspecialchars($data['direccionUsr']);?></p>
                        <p>Telefono: <?php echo htmlspecialchars($data['telefonoUsr']);?></p>
                        <p>Rol: <?php echo htmlspecialchars($data['idRol']); ?></p>
                    </article>
                     <?php
                }

                break;
        }
    ?>
    </section>

<?php include("template/footer.php") ?>
