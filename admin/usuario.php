<?php include("template/header.php") ?>
    <header>
        <h2 class="subtitle header-elements">Panel Usuarios</h2>

        <div>
            <a class ="header-elements" href="entityRegistration/usuario_registro.php"><button class="btn-black-header header-buttons">Agregar</button></a>
        </div>
    </header>

    <form method="POST" class="form-search">
        <div class ="div-form-inputs">
            <label for="inputId">Id de usuario</label>
            <input class ="text-inputs" type="text" name="txtId" id="inputId">
        </div>

        <div class ="div-form-inputs">
            <label for="inputName">Nombre</label>
            <input class ="text-inputs" type="text" name="txtName" id="inputName">
        </div>

        <div class ="div-form-inputs">
            <label for="txtIdRol">Id rol de usuario</label>
            <input class="text-inputs" type="text" name="txtIdRol" id="txtIdRol">
        </div>

        <div class ="div-form-inputs space-top">
            <input class ="btn-black-header" type="submit" value="Buscar">
        </div>
    </form>

    <section class = "section-table">
        <button class ="btn-black-header table-buttons">Agregar Rol</button>
            
        <label for = "chkTable" class ="btn-black-header table-buttons">Desplegar</label>
        <input type="checkbox" name="chkTable" id="chkTable" class ="chkTable table-buttons">

        <div class ="border-table space-top">
            <table class = "table">
                <thead>
                    <tr>
                        <th>ID rol</th>
                        <th>Tipo rol</th>
                        <th>Modificar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </section>

    <section class = "section-title">
        <h2 class ="subtitle">Datos</h2>
        
        <form method ="post" class ="date-container">
            <article>
                <label class="" for="firstDate">Fecha inicio</label>
                <input type="date" name="firstDate" id="firstDate">
            </article>

            <article>
                <label for="firstDate">Fecha final</label>
                <input type="date" name="firstDate" id="firstDate">
            </article>

            <article class ="table-buttons">
                <input type="submit" value="Buscar" class ="btn-black-header header-buttons">
            </article>
        </form>

    </section>

    <section class ="info-container">
        <article class ="card">
            <p>Id Usuario</p>
            <p>Nombre</p>
            <p>Direccion</p>
            <p>Telefono</p>
            <p>Rol</p>
        </article>
        <article class ="card">
            <p>Id Usuario</p>
            <p>Nombre</p>
            <p>Direccion</p>
            <p>Telefono</p>
            <p>Rol</p>
        </article>
        <article class ="card">
            <p>Id Usuario</p>
            <p>Nombre</p>
            <p>Direccion</p>
            <p>Telefono</p>
            <p>Rol</p>
        </article>
        <article class ="card">
            <p>Id Usuario</p>
            <p>Nombre</p>
            <p>Direccion</p>
            <p>Telefono</p>
            <p>Rol</p>
        </article>
        <article class ="card">
            <p>Id Usuario</p>
            <p>Nombre</p>
            <p>Direccion</p>
            <p>Telefono</p>
            <p>Rol</p>
        </article>
        <article class ="card">
            <p>Id Usuario</p>
            <p>Nombre</p>
            <p>Direccion</p>
            <p>Telefono</p>
            <p>Rol</p>
        </article>
        <article class ="card">
            <p>Id Usuario</p>
            <p>Nombre</p>
            <p>Direccion</p>
            <p>Telefono</p>
            <p>Rol</p>
        </article>
    </section>

<?php include("template/footer.php") ?>
