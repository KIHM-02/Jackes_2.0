<?php include("template/header.php") ?>

    <?php 
        require_once("config/conexion.php");

        $conection = new Conexion(); //var para instanciar clase usuario
        $accion = ($_POST)? $_POST['accion']: "all";

        $idUsr  = ($_POST) && !empty($_POST['txtIdUsr'])? intval($_POST['txtIdUsr']): null;
        $idVehi = ($_POST) && !empty($_POST['txtCarId'])? intval($_POST['txtCarId']): null;

        $arrayFilters = [];
        $arrayVehiculo = [];

        $voidCamp = false;

        switch($accion)
        {
            case "delete_model":
                    $arrayVehiculo = ["idVehi" => $idVehi];
                    $conection->useDelete("vehiculo", $arrayVehiculo);
                    $accion = "all"; //reseteamos la variable accion para mostrar los registros usuario
                break;

            case "delete_user":
                    $arrayFilters = ["idUsr" => $idUsr];
                    $conection->useDelete("trabajador", $arrayFilters);
                    $accion = "all"; //reseteamos la variable accion para mostrar los registros usuario
                break;

            case "add_model":
                    $model = (!empty($_POST['txtModelo']))? trim($_POST['txtModelo']): null;
                    if($model === null)
                    {
                        $voidCamp = true;
                    }
                    else
                    {
                        $arrayVehiculo = ["modeloVehi" => $model];
                        $conection->useInsert("vehiculo", $arrayVehiculo);
                    }
                    $accion = "all"; //reseteamos la variable accion para mostrar los registros usuario
                break;
        }
    ?>

    <header>
        <h2 class="subtitle header-elements">Panel Vehiculos</h2>

        <div>
            <a class ="header-elements" href="entityRegistration/vehiculo_registro.php"><button class="btn-black-header header-buttons">Agregar</button></a>
        </div>
    </header>

    <form method="POST" class="form-search">
        <div class ="div-form-inputs">
            <label for="inputWorkerId">Id de trabajador</label>
            <input class ="text-inputs" type="text" name="txtIdUsr" id="inputWorkerId">
        </div>

        <div class ="div-form-inputs">
            <label for="inputCarId">Id del vehiculo</label>
            <input class ="text-inputs" type="text" name="txtCarId" id="inputCarId">
        </div>

        <div class ="div-form-inputs space-top">
            <input class ="btn-black-header" type="submit" value="Buscar">
        </div>
    </form>

    <section class = "section-table">            
        <label for = "chkTable" class ="btn-black-header table-buttons">Desplegar</label>
        <input type="checkbox" name="chkTable" id="chkTable" class ="chkTable table-buttons">

        <div class ="hide-component space-top">
            <table class = "table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Modelo del auto</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>
                <?php 
                    $arrayVehiculo = ["idVehi" => null];
                    $vehiculoData = $conection->getData("vehiculo", $arrayVehiculo);

                    foreach($vehiculoData as $vehiculo)
                    {
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars ($vehiculo['idVehi']); ?></td>
                        <td><?php echo htmlspecialchars ($vehiculo['modeloVehi']); ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="txtCarId" value = "<?php echo htmlspecialchars ($vehiculo['idVehi']); ?>">
                                <button type ="submit" name = "accion" value ="delete_model">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        
        <form method ="POST" class ="space-top form-table">
            <div class ="div-form-inputs">
                <label for="txtModelo">Modelo: </label>
                <input type="text" class="text-inputs" name="txtModelo" id="txtModelo">
            </div>

            <button type="submit" class="btn-black" name ="accion" value ="add_model">Agregar modelo</button>
        </form>

    </section>

    <section class = "section-title">
        <h2 class ="subtitle">Datos</h2>
        
        <form method ="post" class ="date-container">
            <article>
                <label class="firsDate" for="firstDate">Fecha inicio</label>
                <input type="date" name="firstDate" id="firstDate">
            </article>

            <article>
                <label for="LastDate">Fecha final</label>
                <input type="date" name="LasttDate" id="LastDate">
            </article>

            <article class ="table-buttons">
                <input type="submit" value="Buscar" class ="btn-black-header header-buttons">
            </article>
        </form>

    </section>

    <section class ="info-container">
        <article class ="card">
            <p>Id Conduccion</p>
            <label for="txtDateView">Fecha</label>
            <input type="date" name="txtDateView" id="txtDateView">
            <p>Distancia</p>
            <p>Id usuario</p>
            <p>Id vehiculo</p>
        </article>
    </section>

<?php include("template/footer.php") ?>
