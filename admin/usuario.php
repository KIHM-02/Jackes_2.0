<?php include("template/header.php") ?>

    <?php
        require_once("config/conexion.php");

        $accion = ($_POST)? $_POST['accion']: "";

        $idUsr  = ($_POST) && !empty($_POST['txtId'])? $_POST['txtId']: null;
        $name   = ($_POST) && !empty($_POST['txtName'])? $_POST['txtName']: null; 
        $rol    = ($_POST) && !empty($_POST['txtIdRol'])? $_POST['txtIdRol']: null;

        $conection = new Conexion(); //var para instanciar clase usuario
        $arrayFilters = [];
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
            <input class ="text-inputs" type="text" name="txtId" id="inputId">
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
            <input class ="btn-black-header" type="submit" value="Filtrar" name ="accion">
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
                        <th>Modificar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                    </tr>
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
            case "":
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
            
            case "Filtrar":

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
