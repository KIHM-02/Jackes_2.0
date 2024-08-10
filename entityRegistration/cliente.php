<?php include("../template/header_registro.php"); ?>
<head>
<link rel="stylesheet" href="../css/main.css">
</head>
<?php
        require_once("../admin/config/conexion.php");

        $conection = new Conexion(); //var para instanciar clase usuario
        $accion = ($_POST)? $_POST['accion']: "all";

        $idClie  = ($_POST) && !empty($_POST['txtClientId'])? intval($_POST['txtClientId']): null;
        $name      = ($_POST) && !empty($_POST['txtName'])? $_POST['txtName']: null;
        $municipio = ($_POST) && !empty($_POST['txtIdMuni'])? intval($_POST['txtIdMuni']): null;

        $arrayFilters = [];
        $arrayMunicipio = [];
        
    ?>

    <header>
        <h2 class="subtitle header-elements">Panel Clientes</h2>
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
                        </article>
                        <?php
    
                    }
    
                    break;
        }
        
        ?>

    </section>

<?php include("../template/footer.php") ?>
