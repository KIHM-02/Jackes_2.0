<?php include("template/header.php") ?>

<?php
        require_once("config/conexion.php");

        $conection = new Conexion(); //var para instanciar clase usuario
        $accion = ($_POST)? $_POST['accion']: "all";

        $idClie  = ($_POST) && !empty($_POST['txtClientId'])? intval($_POST['txtClientId']): null;
        $name      = ($_POST) && !empty($_POST['txtName'])? $_POST['txtName']: null;
        $modelo = ($_POST) && !empty($_POST['txtIdModelo'])? intval($_POST['txtIdModelo']): null;

        $arrayFilters = [];
        $arrayModelo = [];

        $voidCamp = false;

        switch($accion)
        {
            case "delete_modelo":
                    $arrayModelo = ["idModelo" => $modelo];
                    $conection->useDelete("modelo", $arrayModelo);
                    $accion = "all"; //reseteamos la variable accion para mostrar los registros usuario
                break;

            case "delete_cliente":
                    $arrayFilters = ["idClie" => $idClie];
                    $conection->useDelete("cliente", $arrayFilters);
                    $accion = "all"; //reseteamos la variable accion para mostrar los registros usuario
                break;

            case "add_modelo":
                    $tipo = (!empty($_POST['txtModelo']))? trim($_POST['txtModelo']): null;
                    if($tipo === null)
                    {
                        $voidCamp = true;
                    }
                    else
                    {
                        $arrayModelo = ["modelo" => $tipo];
                        $conection->useInsert("modelo", $arrayModelo);
                    }
                    $accion = "all"; //reseteamos la variable accion para mostrar los registros usuario
                break;
        }
        
    ?>


    <header>
        <h2 class="subtitle header-elements">Panel Maquinas</h2>

        <div>
            <a class ="header-elements" href="entityRegistration/maquina_registro.php"><button class="btn-black-header header-buttons">Agregar</button></a>
        </div>
    </header>

    <form method="POST" class="form-search">
        <div class ="div-form-inputs">
            <label for="inputMachineId">Id de maquina</label>
            <input class ="text-inputs" type="text" name="txtMachineId" id="inputMachineId">
        </div>

        <div class ="div-form-inputs">
            <label for="inputModel">Modelo</label>
            <input class ="text-inputs" type="text" name="txtModel" id="inputModel">
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
                        <th>Modelo Maquina</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                    $arrayModelo = ["idModelo" => null];
                    $ModeloData = $conection->getdata("modelo", $arrayModelo);

                    foreach($ModeloData as $Modelo)
                    {
                 ?>
                    <tr>
                        <td><?php echo htmlspecialchars($Modelo['idModelo']); ?></td>
                        <td><?php echo htmlspecialchars($Modelo['modelo']);?></td>

                        <td>

                            <form method="POST">
                                <input type="hidden" name="txtIdModelo" value = "<?php echo htmlspecialchars ($Modelo ['idModelo']); ?>">
                                <button type ="submit" name = "accion" value ="delete_modelo">Eliminar</button>
                            </form>    
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <form method="post" class ="space-top form-table">
            <div class ="div-form-inputs">
                <label for="txtModelo">Modelo de maquina: </label>
                <input type="text" class="text-inputs" name="txtModelo" id="txtModelo">
            <div>

            <button type="submit" class="btn-black" name ="accion" value ="add_modelo">Agregar municipio</button>            
        </form>


    </section>

    <section class = "section-title">
        <h2 class ="subtitle">Datos</h2>
    </section>

    <section class ="info-container">
        <article class ="card">
            <p><span class="negritas">Id Maquina;</span> <?php echo htmlspecialchars($data['id Maquina']); ?></p>
            <p><span class="negritas">Id Modelo;</span> <?php echo htmlspecialchars($data[' modelo']); ?></p>
            <p><span class="negritas">Id Estatus;</span> <?php echo htmlspecialchars($data[' Estatus']); ?></p>
            <p><span class="negritas">Id Cliente;</span> <?php echo htmlspecialchars($data['Cliente']); ?></p>
            <p>Aqui va la imagen</p>
        </article>
    </section>

<?php include("template/footer.php") ?>
