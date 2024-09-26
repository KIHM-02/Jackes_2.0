<?php include("../template/header_registro.php"); ?>
    <?php
        require_once("../config/conexion.php");

        $conection = new Conexion(); //var para instanciar clase usuario
        $arrayMaq = [];
        $arrayWorker =[];
        $arrayValues = [];
        $voidValues = false;
        $valuesVerified = true;

        if($_POST)
        {
            $fecha     = (!empty($_POST['txtDate']))? trim($_POST['txtDate']): null;
            $carId     = (!empty($_POST['txtCarId']))? trim($_POST['txtCarId']): null;
            $usrId     = (!empty($_POST['txtWorkerId']))? trim($_POST['txtWorkerId']): null;
            $distancia = (!empty($_POST['txtDistance']))? trim($_POST['txtDistance']): null;
            $dia = null;
            $mes = null; 
            $anio = null;

            if($fecha !== null)
            {
                list($anio, $mes, $dia) = explode('-', $fecha);
            }
            
            $arrayValues = [
                "dia" => $dia,
                "mes" => $mes,
                "anio" => $anio,
                "distanciaCond" => $distancia,
                "idUsr" => $usrId,
                "idVehi" => $carId 
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
                $conection->useInsert("conduce", $arrayValues);
            }
        }
    ?>
    <header>
        <h2 class ="subtitle">Agregar Corte</h2>
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
            <div class ="section-title"><h2>Identificadores</h2></div>

            <div class ="section-inputs">

                <article class ="inputs">
                    <label for="txtMaqId">Id Maquina</label>
                    <select name="txtMaqId" id="txtMaqId">
                        <?php 
                        $arrayMaq = ["idVehi" => null];
                        $maqData = $conection->getData("maquina", $arrayMaq);
                        
                        foreach($maqData as $maquina)
                        {
                            ?>
                        <option value="<?php echo htmlspecialchars($maquina['idMaq']);?>">
                            <?php echo htmlspecialchars($maquina['idMaq']);?>
                        </option>            
                        <?php   } ?>
                    </select>
                </article>

                <article class ="inputs">
                    <label for="txtWorkerId">Id trabajador</label>
                    <select name="txtWorkerId" id="txtWorkerId">
                    <?php 
                        $arrayWorker = ["idUsr" => null];
                        $userData = $conection->getData("trabajador", $arrayWorker);

                        foreach($userData as $user)
                        {
                    ?>
                        <option value="<?php echo htmlspecialchars($user['idUsr']); ?>">
                            <?php echo htmlspecialchars($user['idUsr']."-".$user['nombreUsr']); ?>
                        </option>            
                <?php   } ?>
                    </select>
                </article>
                
                <article class ="inputs">
                    <label for="txtDate">Dia / Mes / Año</label>
                    <input type="date" id="txtDate" name = "txtDate">
                </article>
            </div>
        </section>

        <section class ="divider">
            <div class ="section-title"><h2>Datos numericos</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="txtEntrada">Entrada</label>
                    <input type="text" id ="txtEntrada" name = "txtEntrada">
                </article>

                <article class ="inputs">
                    <label for="txtSalida">Salida</label>
                    <input type="text" id ="txtSalida" name = "txtSalida">
                </article>

                <article class ="inputs">
                    <label for="txtDigital">Digital</label>
                    <input type="text" id="txtDigital" name = "txtDigital">
                </article>

                <article class ="inputs">
                    <label for="txtTotalFisico">Totl Fisico</label>
                    <input type="text" id="txtTotalFisico" name = "txtTotalFisico">
                </article>
            </div>
        </section>

        <?php if($valuesVerified === true) 
        { ?>
        <section class ="divider">
            <div class ="section-title"><h2>Datos calculados</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="txtResultado">Resultado</label>
                    <input type="text" readonly id="txtResultado" name = "txtResultado">
                </article>

                <article class ="inputs">
                    <label for="txtReal">Fichaje Real</label>
                    <input type="text" readonly id="txtReal" name = "txtReal">
                </article>
            </div>
        </section>

        <section>
            <div class ="aligner-center">
                <input type="submit" class = "btn-black-header space-top" value ="Registrar">
            </div>
        </section>
        <?php 
        } else{ ?>
        
        <section>
            <div class ="aligner-center">
                <input type="submit" class = "btn-black-header space-top" value ="Verificar">
            </div>
        </section>

        <?php }?>

    </form>

<?php include("../template/footer.php") ?>