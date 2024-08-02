<?php include("../template/header_registro.php"); ?>

    <header>
        <h2 class ="subtitle">Agregar Cliente</h2>
    </header>

    <form action="post" class="form-register">
        <section class ="divider">
            <div class ="section-title"><h2>Datos Personales</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="txtName">Nombre completo</label>
                    <input type="text" id="txtName" name = "txtName">
                </article>
                <article class ="inputs">
                    <label for="txtPat">Apellido paterno</label>
                    <input type="text" id="txtPat" name = "txtPat">
                </article>
                <article class ="inputs">
                    <label for="txtMat">Apellido materno</label>
                    <input type="text" id="txtMat" name = "txtMat">
                </article>
                <article class ="inputs">
                    <label for="txtTel">Telefono</label>
                    <input type="text" id="txtTel" name = "txtTel">
                </article>
            </div>
        </section>

        <section class ="divider">
            <div class ="section-title"><h2>Ubicación</h2></div>
            <div class ="section-inputs">  
                <article class ="inputs">
                    <label for="">Domicilio</label>
                    <input type="text" id="" name = "">
                </article>
                
                <article class ="inputs">
                    <label for="">Numero Exterior</label>
                    <input type="text" id="" name = "">
                </article>

                <article class ="inputs">
                    <label for="">Numero Interior</label>
                    <input type="text" id="" name = "">
                </article>

                <article class ="inputs">
                    <label for="">Colonia</label>
                    <input type="text" id="" name = "">
                </article>

                <article class ="inputs">
                    <label for="txtMunicipioId">Id Municipio</label>
                    <select name="txtMunicipioId" id="txtMunicipioId">
                        <option value="Hello">1-Tlaquepaque</option>
                    </select>
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