<?php include("template/header_registro.php"); ?>
    <header>
        <h2 class ="subtitle">Agregar usuarios</h2>
    </header>

    <form action="post" class="form-register">
        <section class ="divider">
            <div class ="section-title"><h2>Datos Personales</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="txtName">Nombre</label>
                    <input type="text" id="txtName" name = "txtName">
                </article>

                <article class ="inputs">
                    <label for="txtPaterno">Apellido Paterno</label>
                    <input type="text" id="txtPaterno" name = "txtPaterno">
                </article>

                <article class ="inputs">
                    <label for="txtMaterno">Apellido Materno</label>
                    <input type="text" id="txtMaterno" name = "txtMaterno">
                </article>

                <article class ="inputs">
                    <label for="txtTel">Telefono</label>
                    <input type="text" id="txtTel" name = "txtTel">
                </article>
                
            </div>
        </section>

        <section class ="divider">
            <div class ="section-title"><h2>Identificadores</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="txtRol">Rol de usuario</label>
                    <select name="txtRol" id="txtRol">
                        <option value="Hello">Hola</option>
                    </select>
                </article>

                <article class ="inputs">
                    <label for="txtTel">Contraseña</label>
                    <input type="text" id="txtPass" name = "txtPass">
                </article>

                <article class ="inputs">
                    <label for="txtTel">Confirmar contraseña</label>
                    <input type="text" id="txtConPass" name = "txtConPass">
                </article>
            </div>
        </section>

        <section class ="divider">
            <div class ="section-title"><h2>Ubicación</h2></div>
            <div class ="section-inputs">
                <article class ="inputs">
                    <label for="txtUbication">Domicilio</label>
                    <input type="text" name="txtUbication" id="txtUbication">
                </article>
            </div>
        </section>

        <section>
            <div class ="aligner-center">
                <input type="submit" class = "btn-black-header space-top" value ="Registrar">
            </div>
        </section>

    </form>

<?php include("template/footer.php") ?>