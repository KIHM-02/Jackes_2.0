<?php include("../template/header_registro.php"); ?>
    <header>
        <h2 class ="subtitle">Agregar vehiculo</h2>
    </header>

    <form action="post" class="form-register">
        <section class ="divider">
            <div class ="section-title"><h2>Fecha</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="txtDate">Dia / Mes / Año</label>
                    <input type="date" id="txtDate" name = "txtDate">
                </article>                
            </div>
        </section>

        <section class ="divider">
            <div class ="section-title"><h2>Recorrido</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="txtCarId">Id vehiculo</label>
                    <select name="txtCarId" id="txtCarId">
                        <option value="Hello">GTR</option>
                    </select>
                </article>

                <article class ="inputs">
                    <label for="txtWorkerId">Id trabajador</label>
                    <select name="txtWorkerId" id="txtWorkerId">
                        <option value="Hello">1-Ana</option>
                    </select>
                </article>

                <article class ="inputs">
                    <label for="txtDistance">Distancia</label>
                    <input type="text" id="txtDistance" name = "txtDistance">
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