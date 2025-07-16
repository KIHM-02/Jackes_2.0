<?php include("../template/header_registro.php"); ?>
    <?php
        require_once("../admin/config/conexion.php");


        $conection = new Conexion(); //var para instanciar clase usuario
        $arrayMaq = [];
        $arrayWorker =[];
        $arrayValues = [];
        $voidValues = null;
        $valuesVerified = null;
        $identifierVerified = null;
        $accion = $_POST ? $_POST['accion']: null;
        $resultadoActual = 0;

        $identifierMaq = (!empty($_POST['txtIdentifierMaq']))? trim($_POST['txtIdentifierMaq']): null;
        $usrId         = (!empty($_POST['txtWorkerId']))? trim($_POST['txtWorkerId']): null;
        $fecha         = (!empty($_POST['txtDate']))? trim($_POST['txtDate']): null;
        $entrada       = (!empty($_POST['txtEntrada']))? trim($_POST['txtEntrada']): null;
        $resultado     = (!empty($_POST['txtResultado']))? trim($_POST['txtResultado']): null;
        $real          = (!empty($_POST['txtReal']))? trim($_POST['txtReal']): null;
        $salida        = (!empty($_POST['txtSalida']))? trim($_POST['txtSalida']): null;
        $digital       = (!empty($_POST['txtDigital'])) ?trim($_POST['txtDigital']): null;
        $fisico        = (!empty($_POST['txtTotalFisico'])) ?trim($_POST['txtTotalFisico']): null;
            
        if($identifierMaq === null 
        OR $usrId === null
        OR $fecha === null
        OR $entrada === null 
        OR $salida === null 
        OR $digital === null 
        OR $fisico === null
        ){
            $voidValues = true;
        }
        else{
            $voidValues = false;
            list($anio, $mes, $dia) = explode('-', $fecha);
        }

        if($_POST and $voidValues === false)
        {
            switch($accion)
            {
                case "Verificar":
                    $valuesVerified = true;
                    $corteValues = [
                        "idCorte" => 0,
                        "idMaq" => null,
                        "idUsr" => $usrId,
                        "dia" => $dia,
                        "mes" => $mes,
                        "anio" => $anio,
                        "entrada" => $entrada,
                        "salida" => $salida,
                        "resultado" => $resultado,
                        "ficReal" => $real,
                        "digital" => $digital,
                        "totalFisico" => $fisico
                    ];

                    $arrayFilters = [
                        "identificador" => $identifierMaq
                    ];

                    $maqId = $conection->getData('maquina', $arrayFilters);

                    if(!empty($maqId))
                    {
                        $identifierVerified = true;
                        $arrayFilters = null; //Limpiamos el arreglo para evitar conflictos y volver a usarlo
                        $arrayFilters = [
                            "idMaq" => $maqId[0]['idMaq']
                        ];

                        //Array asociativo de los datos arrojados por el SELECT. NO DEBE SER MAYOR A 5 ELEMENTOS
                        $cortesData = $conection->getData('corte', $arrayFilters);
                        
                        if(!empty($cortesData))
                        {
                            $cortesLength = count($cortesData)-1;
    
                            if($cortesLength == 4)
                            {
                                $_SESSION['firstCorte'] = $cortesData[0]['idCorte'];
                            }
    
                            $resultadoActual = $entrada - $salida;
                            $resultAnterior = $cortesData[$cortesLength]['resultado'];
    
                            $real = $resultadoActual - $resultAnterior;
                        }
                        else
                        {
                            $real = 0;
                            $resultadoActual = $entrada - $salida;
                        }
    
                        $corteValues['idMaq'] = $maqId[0]['idMaq'];
                        $corteValues['resultado'] = $resultadoActual;
                        $corteValues['ficReal'] = $real;
    
                        //print_r($corteValues);
                        $_SESSION['cortesValues'] = $corteValues;
                    }
                    else
                    {
                        $valuesVerified = false;
                        $identifierVerified = false;
                    }
                    break;
                
                case "Registrar":
                    if(isset($_SESSION['firstCorte']) && !empty($_SESSION['firstCorte']))
                    {
                        $arrayFilters = ["idCorte" => $_SESSION['firstCorte']];
                        $conection->useDelete('corte', $arrayFilters);
                        unset($_SESSION['firstCorte']);
                    }
                    
                    $conection->useInsert('corte', $_SESSION['cortesValues']);

                    unset($_SESSION['corteValues']);

                    break;
            }

        }
    ?>
    <header>
        <h2 class ="subtitle">Agregar Corte</h2>
    </header>

    <?php  //Mostrar advertencia de campos vacios
        if($voidValues === true)
        { ?>
            <div class ="warning-box">
                <p>Hay campos de informacion vacios. Favor de ingresar la informacion correspondiente.</p>
            </div>
    <?php }
        else if($identifierVerified === false)
        {?>
            <div class ="warning-box">
                <p>Error en identificador de maquina. No existe coincidencia con ninguna maquina.</p>
            </div>
    <?php }

        if($valuesVerified === true AND $identifierVerified === true AND $voidValues === false)
        {
            ?>
            <form method="post" class="form-register">
                
                <section class ="divider">
                    <div class ="section-title"><h2>Identificadores</h2></div>

                    <div class ="section-inputs">

                        <article class ="inputs">
                            <label for="txtIdentifierMaq">Identificador Maquina</label>
                            <input type="text" name="txtIdentifierMaq" id="txtIdentifierMaq" value="<?php echo htmlspecialchars($identifierMaq); ?>" readonly>
                        </article>

                        <article class ="inputs">
                            <label for="txtWorkerId">Id trabajador</label>
                            <select name="txtWorkerId" id="txtWorkerId">
                                <option value="<?php echo htmlspecialchars($usrId); ?>">
                                    <?php echo htmlspecialchars($usrId);?>
                                </option>
                            </select>
                        </article>
                        
                        <article class ="inputs">
                            <label for="txtDate">Dia / Mes / Año</label>
                            <input type="date" id="txtDate" name = "txtDate" value = "<?php echo $fecha; ?>">
                        </article>
                    </div>
                </section>

                <section class ="divider">
                    <div class ="section-title"><h2>Datos numericos</h2></div>
                    <div class ="section-inputs">
                        <article class ="inputs">
                            <label for="txtEntrada">Entrada</label>
                            <input type="number" id ="txtEntrada"  readonly name = "txtEntrada" value ="<?php echo $entrada; ?>">
                        </article>

                        <article class ="inputs">
                            <label for="txtSalida">Salida</label>
                            <input type="number" id ="txtSalida" readonly name = "txtSalida" value ="<?php echo $salida; ?>">
                        </article>

                        <article class ="inputs">
                            <label for="txtDigital">Digital</label>
                            <input type="number" id="txtDigital" readonly name = "txtDigital" value ="<?php echo $digital; ?>">
                        </article>

                        <article class ="inputs">
                            <label for="txtTotalFisico">Total Fisico</label>
                            <input type="number"  id="txtTotalFisico" readonly name = "txtTotalFisico" value ="<?php echo $fisico; ?>">
                        </article>
                    </div>
                </section>

                <section class ="divider">
                    <div class ="section-title"><h2>Revisar Datos calculados</h2></div>
                    <div class ="section-inputs">
                        <article class ="inputs">
                            <label for="txtResultado">Resultado: Entrada - Salida</label>
                            <input type="text" readonly id="txtResultado" name = "txtResultado" value ="<?php echo $resultadoActual; ?>">
                        </article>

                        <article class ="inputs">
                            <label for="txtReal">Fichaje Real</label>
                            <input type="text" readonly id="txtReal" name = "txtReal" value ="<?php echo $real ?>">
                        </article>

                        <article class ="inputs">
                            <label for="txtCoincide">Coincide: Fisico - Digital</label>
                            <input type="text" readonly id="txtCoincide" name = "txtCoincide" value ="<?php echo htmlspecialchars($fisico - $digital); ?>">
                        </article>
                    </div>
                </section>

                <section>
                    <div class ="aligner-center">
                        <input type="submit" class = "btn-black-header space-top" name ="accion" value ="Registrar">
                    </div>
                </section> 
            </form>
            
            <?php
        }
        else
        {   ?>
            <form method="post" class="form-register">    
                <section class ="divider">
                    <div class ="section-title"><h2>Identificadores</h2></div>

                    <div class ="section-inputs">

                        <article class ="inputs">
                            <label for="txtIdentifierMaq">Identificador Maquina</label>
                            <input type="text" name="txtIdentifierMaq" id="txtIdentifierMaq">
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
                            <input type="date" id="txtDate" name = "txtDate" value ="<?php echo date("Y-m-d");?>">
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
                            <label for="txtTotalFisico">Total Fisico</label>
                            <input type="text" id="txtTotalFisico" name = "txtTotalFisico">
                        </article>
                    </div>
                </section>

                <section>
                    <div class ="aligner-center">
                        <input type="submit" class = "btn-black-header space-top" name = "accion" value ="Verificar">
                    </div>
                </section>
            </form>
        <?php
        } ?>
        
<?php include("../template/footer.php") ?>