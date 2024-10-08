<?php include("template/header.php") ?>

<?php
        require_once("config/conexion.php");

        $conection = new Conexion(); //var para instanciar clase usuario
        $accion = ($_POST)? $_POST['accion']: "all";

        $idMaq  = ($_POST) && !empty($_POST['txtIdMaq'])? intval($_POST['txtIdMaq']): null;
        $idClie = ($_POST) && !empty($_POST['txtClientId'])? intval($_POST['txtClientId']): null;
        $modelo = ($_POST) && !empty($_POST['txtIdModelo'])? intval($_POST['txtIdModelo']): null;

        $arrayFilters = [];
        $arrayModelo = [];

        $voidCamp = false;

        //var_dump($idMaq);
        switch($accion)
        {
            case "delete_modelo":
                    $arrayModelo = ["idModelo" => $modelo];
                    $conection->useDelete("modelo", $arrayModelo);
                    $accion = "all"; //reseteamos la variable accion para mostrar los registros usuario
                break;

            case "delete_maquina":
                    $arrayFilters = ["idMaq" => $idMaq];
                    $conection->useDelete("maquina", $arrayFilters);
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
            <label for="txtClientId">Id de cliente</label>
            <input class ="text-inputs" type="text" name="txtClientId" id="txtClientId">
        </div>

        <div class ="div-form-inputs">
            <label for="txtIdModelo">Id de Modelo</label>
            <input class ="text-inputs" type="text" name="txtIdModelo" id="txtIdModelo">
        </div>

        <div class ="div-form-inputs space-top">
            <button type="submit" class ="btn-black-header" name="accion" value="filtrar">Filtrar</button>
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
        <?php 
        switch($accion)
        {
            case "all":
                $arrayFilters = ["idMaq" => null]; //Arreglo de filtros en null para que se arregle una consulta select sin condiciones
                $maqData = $conection->getData("maquina", $arrayFilters);

                foreach($maqData as $data)
                {   ?>
                    <article class ="card">
                        <p><span class = "negritas">Id Maquina: </span> <?php echo htmlspecialchars($data['idMaq']); ?></p>
                        <p><span class = "negritas">Estatus: </span> <?php echo htmlspecialchars($data['estatusMaq']); ?></p>
                        <p><span class = "negritas">Id modelo: </span> <?php echo htmlspecialchars($data['idModelo']); ?></p>
                        <p><span class = "negritas">Id cliente: </span> <?php echo htmlspecialchars($data['idClie']); ?></p>

                        <div>
                            <form method="post">
                                <input type="hidden" name="txtIdMaq" value ="<?php echo htmlspecialchars($data['idMaq']); ?>">
                                <button type="submit" class ="btn-black-width" name = "accion" value ="delete_maquina">Eliminar</button>
                            </form>

                            <form action="entityModification/maquina_modificar.php" method="post">
                                <input type="hidden" name="txtIdMaq" value ="<?php echo htmlspecialchars($data['idMaq']);?>">
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
                        "idClie" => $idClie,
                        "idModelo" => $modelo
                    ];

                    $maqData = $conection->getData("maquina", $arrayFilters);

                    foreach($maqData as $data)
                    {   ?>
                        <article class ="card">
                            <p><span class = "negritas">Id Maquina: </span> <?php echo htmlspecialchars($data['idMaq']); ?></p>
                            <p><span class = "negritas">Estatus: </span> <?php echo htmlspecialchars($data['estatusMaq']); ?></p>
                            <p><span class = "negritas">Id modelo: </span> <?php echo htmlspecialchars($data['idModelo']); ?></p>
                            <p><span class = "negritas">Id cliente: </span> <?php echo htmlspecialchars($data['idClie']); ?></p>

                            <div>
                                <form method="post">
                                    <input type="hidden" name="txtIdMaq" value ="<?php echo htmlspecialchars($data['idMaq']); ?>">
                                    <button type="submit" class ="btn-black-width" name = "accion" value ="delete_maquina">Eliminar</button>
                                </form>

                                <form action="entityModification/maquina_modificar.php" method="post">
                                    <input type="hidden" name="txtIdMaq" value ="<?php echo htmlspecialchars($data['idMaq']);?>">
                                    <input type="hidden" name="accion" value ="envio">
                                    <button type="submit" class ="btn-black-width">Modificar</button>
                                </form>
                            </div>
                                                    
                        </article>
                        <?php
    
                    }
                    break;
        }
        ?>
    </section>

<?php include("template/footer.php") ?>
