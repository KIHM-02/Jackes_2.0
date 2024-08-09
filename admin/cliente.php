<?php include("template/header.php") ?>

<?php
        require_once("config/conexion.php");

        $conection = new Conexion(); //var para instanciar clase usuario
        $accion = ($_POST)? $_POST['accion']: "all";

        $idUsr  = ($_POST) && !empty($_POST['txtId'])? intval($_POST['txtId']): null;
        $name      = ($_POST) && !empty($_POST['txtName'])? $_POST['txtName']: null;
        $municipio = ($_POST) && !empty($_POST['txtIdMuni'])? intval($_POST['txtIdMuni']): null;

        $arrayFilters = [];
        $arrayMunicipio = [];

        $voidCamp = false;

        switch($accion)
        {
            case "delete_muni":
                    $arrayMunicipio = ["idMuni" => $municipio];
                    $conection->useDelete("municipio", $arrayMunicipio);
                    $accion = "all"; //reseteamos la variable accion para mostrar los registros usuario
                break;

            case "delete_user":
                    $arrayFilters = ["idUsr" => $idUsr];
                    $conection->useDelete("trabajador", $arrayFilters);
                    $accion = "all"; //reseteamos la variable accion para mostrar los registros usuario
                break;

            case "add_municipio":
                    $tipo = (!empty($_POST['txtTipoMuni']))? trim($_POST['txtTipolmuni']): null;
                    if($tipo === null)
                    {
                        $voidCamp = true;
                    }
                    else
                    {
                        $arraymunicipio = ["tipomuni" => $tipo];
                        $conection->useInsert("municipio", $arrayMunicipio);
                    }
                    $accion = "all"; //reseteamos la variable accion para mostrar los registros usuario
                break;
        }
        
    ?>

    <header>
        <h2 class="subtitle header-elements">Panel Clientes</h2>

        <div>
            <a class ="header-elements" href="entityRegistration/cliente_registro.php"><button class="btn-black-header header-buttons">Agregar</button></a>
        </div>
    </header>

    <form method="POST" class="form-search">
        <div class ="div-form-inputs">
            <label for="inputClientId">Id de cliente</label>
            <input class ="text-inputs" type="text" name="txtClientId" id="inputClientId">
        </div>

        <div class ="div-form-inputs">
            <label for="inputName">Nombre</label>
            <input class ="text-inputs" type="text" name="txtName" id="inputName">
        </div>

        <div class ="div-form-inputs">
            <label for="inputMunicipio">Municipio</label>
            <input class ="text-inputs" type="text" name="txtMunicipio" id="inputMunicipio">
        </div>

        <div class ="div-form-inputs space-top">
            <input class ="btn-black-header" type="submit" value="Buscar">
        </div>
    </form>

    <section class = "section-table">
        <button class ="btn-black-header table-buttons">Agregar municipio</button>
            
        <label for = "chkTable" class ="btn-black-header table-buttons">Desplegar</label>
        <input type="checkbox" name="chkTable" id="chkTable" class ="chkTable table-buttons">

        <div class ="hide-component space-top">
            <table class = "table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Municipio</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                    $arrayMunicipio = ["idMuni" => null];
                    $municipioData = $conection->getdata("municipio", $arrayMunicipio);

                    foreach($municipioData as $municipios)
                    {
                 ?>
                    <tr>
                        <td><?php echo htmlspecialchars($municipios['idMuni']); ?></td>
                        <td><?php echo htmlspecialchars($municipios['municipio']);?></td>

                        <td>

                            <form method="POST">
                                <input type="hidden" name="txtIdMuni" value = "<?php echo htmlspecialchars ($municipios ['idMuni']); ?>">
                                <button type ="submit" name = "accion" value ="delete_muni">Eliminar</button>
                            </form>    
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <form method="post"> class ="space-top form-table">
            <div class ="div=form=inputs">

        </form>



    </section>

    <section class = "section-title">
        <h2 class ="subtitle">Datos</h2>
    </section>

    <section class ="info-container">
        <article class ="card">
            <p>Id Cliente</p>
            <p>Nombres</p>
            <p>Apellidos</p>
            <p>Colonia</p>
            <p>Dirección</p>
            <p>Telefono</p>
            <p>Num interior</p>
            <p>Num exterior</p>
            <p>Id Municipio</p>
        </article>
        <article class ="card">
            <p>Id Cliente</p>
            <p>Nombres</p>
            <p>Apellidos</p>
            <p>Colonia</p>
            <p>Dirección</p>
            <p>Telefono</p>
            <p>Num interior</p>
            <p>Num exterior</p>
            <p>Id Municipio</p>
        </article>
        <article class ="card">
            <p>Id Cliente</p>
            <p>Nombres</p>
            <p>Apellidos</p>
            <p>Colonia</p>
            <p>Dirección</p>
            <p>Telefono</p>
            <p>Num interior</p>
            <p>Num exterior</p>
            <p>Id Municipio</p>
        </article>
        <article class ="card">
            <p>Id Cliente</p>
            <p>Nombres</p>
            <p>Apellidos</p>
            <p>Colonia</p>
            <p>Dirección</p>
            <p>Telefono</p>
            <p>Num interior</p>
            <p>Num exterior</p>
            <p>Id Municipio</p>
        </article>
    </section>

<?php include("template/footer.php") ?>
