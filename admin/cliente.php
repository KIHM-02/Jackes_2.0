<?php include("template/header.php") ?>

<?php
        require_once("config/conexion.php");

        $conection = new Conexion(); //var para instanciar clase usuario
        $accion = ($_POST)? $_POST['accion']: "all";

        $idClie  = ($_POST) && !empty($_POST['txtClientId'])? intval($_POST['txtClientId']): null;
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

            case "delete_cliente":
                    $arrayFilters = ["idClie" => $idClie];
                    $conection->useDelete("cliente", $arrayFilters);
                    $accion = "all"; //reseteamos la variable accion para mostrar los registros usuario
                break;

            case "add_municipio":
                    $tipo = (!empty($_POST['txtTipoMuni']))? trim($_POST['txtTipoMuni']): null;
                    if($tipo === null)
                    {
                        $voidCamp = true;
                    }
                    else
                    {
                        $arrayMunicipio = ["municipio" => $tipo];
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
            <label for="inputMunicipio">Id de municipio</label>
            <input class ="text-inputs" type="text" name="txtIdMuni" id="inputMunicipio">
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

        <form method="post" class ="space-top form-table">
            <div class ="div-form-inputs">
                <label for="txtTipoMuni">Tipo de municipio: </label>
                <input type="text" class="text-inputs" name="txtTipoMuni" id="txtTipoMuni">
            <div>

            <button type="submit" class="btn-black" name ="accion" value ="add_municipio">Agregar municipio</button>            
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
                $arrayFilters = ["idClie" => null]; //Arreglo de filtros en null para que se arregle una consulta select sin condiciones
                $clieData = $conection->getData("cliente", $arrayFilters);

                foreach($clieData as $data)
                {   ?>
                    <article class ="card">
                        <p><span class="negritas">Id Cliente: </span> <?php echo htmlspecialchars($data['idClie']); ?></p>
                        <p><span class = "negritas">Nombres: </span> <?php echo htmlspecialchars($data['nombreClie']." ".$data['apePatClie']." ".$data['apeMatClie']); ?></p>
                        <p><span class = "negritas">Colonia: </span> <?php echo htmlspecialchars($data['coloniaClie']); ?></p>
                        <p><span class = "negritas">Dirección: </span> <?php echo htmlspecialchars($data['direccionClie']); ?></p>
                        <p><span class = "negritas">Telefono: </span> <?php echo htmlspecialchars($data['telefonoClie']); ?></p>
                        <p><span class = "negritas">Num interior: </span> <?php echo htmlspecialchars($data['numInteriorClie']); ?></p>
                        <p><span class = "negritas">Num exterior: </span> <?php echo htmlspecialchars($data['numExteriorClie']); ?></p>
                        <p><span class = "negritas">Id municipio: </span> <?php echo htmlspecialchars($data['idMunicipio']); ?></p>

                        <div>
                            <form method="post">
                                <input type="hidden" name="txtClientId" value ="<?php echo htmlspecialchars($data['idClie']); ?>">
                                <button type="submit" class ="btn-black-width" name = "accion" value ="delete_cliente">Eliminar</button>
                            </form>

                            <form action="entityModification/cliente_modificar.php" method="post">
                                <input type="hidden" name="txtClientId" value ="<?php echo htmlspecialchars($data['idClie']);?>">
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
                        "nombreClie" => $name,
                        "idMunicipio" => $municipio
                    ];

                    $clieData = $conection->getData("cliente", $arrayFilters);

                    foreach($clieData as $data)
                    {   ?>
                        <article class ="card">
                            <p><span class="negritas">Id Cliente: </span> <?php echo htmlspecialchars($data['idClie']); ?></p>
                            <p><span class = "negritas">Nombres: </span> <?php echo htmlspecialchars($data['nombreClie']." ".$data['apePatClie']." ".$data['apeMatClie']); ?></p>
                            <p><span class = "negritas">Colonia: </span> <?php echo htmlspecialchars($data['coloniaClie']); ?></p>
                            <p><span class = "negritas">Dirección: </span> <?php echo htmlspecialchars($data['direccionClie']); ?></p>
                            <p><span class = "negritas">Telefono: </span> <?php echo htmlspecialchars($data['telefonoClie']); ?></p>
                            <p><span class = "negritas">Num interior: </span> <?php echo htmlspecialchars($data['numInteriorClie']); ?></p>
                            <p><span class = "negritas">Num exterior: </span> <?php echo htmlspecialchars($data['numExteriorClie']); ?></p>
                            <p><span class = "negritas">Id municipio: </span> <?php echo htmlspecialchars($data['idMunicipio']); ?></p>

                            <div>
                                <form method="post">
                                    <input type="hidden" name="txtClientId" value ="<?php echo htmlspecialchars($data['idClie']);?>">
                                    <button type="submit" class ="btn-black-width" name = "accion" value ="delete_cliente">Eliminar</button>
                                </form>

                                <form action="entityModification/cliente_modificar.php" method="post">
                                    <input type="hidden" name="txtClientId" value ="<?php echo htmlspecialchars($data['idClie']);?>">
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
