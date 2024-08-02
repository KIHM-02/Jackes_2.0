

<?php include("../template/header_registro.php"); 

/**Revisar la base de datos, observa si necesitas una tabla para guardar los modelos de las maquinas y 
 * termina la vista de cliente */

?>
    <header>
        <h2 class ="subtitle">Agregar Maquina</h2>
    </header>

    <form action="post" class="form-register">
        <section class ="divider">
            <div class ="section-title"><h2>Imagen</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="fileImage">Subir imagen de la maquina</label>
                    <input type="file" id="fileImage" name = "fileImage">
                </article>                
            </div>
        </section>

        <section class ="divider">
            <div class ="section-title"><h2>Identificadores</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="txtModelId">Id modelo</label>
                    <select name="txtModelId" id="txtModelId">
                        <option value="Hello">1-Fruits</option>
                    </select>
                </article>

                <article class ="inputs">
                    <label for="txtClientId">Id cliente</label>
                    <select name="txtClientId" id="txtClientId">
                        <option value="Hello">0-ninguno</option>
                        <option value="Hello">1-Ana</option>
                    </select>
                </article>

                <article class ="inputs">
                    <label for="txtStatus">Estatus</label>
                    <input type="text" id="txtStatus" name = "txtStatus">
                </article>
            </div>
        </section>

        <section>
            <div class ="aligner-center">
                <input type="submit" class = "btn-black-header space-top" value ="Registrar">
            </div>
        </section>

    </form>

<?php include("../template/footer.php") ?>