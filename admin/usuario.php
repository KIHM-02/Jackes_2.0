<?php include("template/header.php") ?>
    <header>
        <h2 class="subtitle header-elements">Panel Usuarios</h2>
        <a class ="header-elements" href="#"><button class="btn-black-header">Agregar</button></a>
        <a class ="header-elements" href="#"><button class="btn-black-header">Modificar</button></a>
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
            <input class ="btn-black-header" type="submit" value="Buscar">
        </div>
    </form>

    <section class = "section-table">
        <div>
            <button class = "btn-black-header">
                <label for = "chkTable">Desplegar</label>
                <input type="checkbox" name="chkTable" id="chkTable">
            </button>

            <button class ="btn-black-header">Agregar Rol</button>
        </div>
        
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
            </tbody>
        </table>
    </section>

    <section>
        <article>
            <p>Id Usuario</p>
            <p>Nombre</p>
            <p>Direccion</p>
            <p>Telefono</p>
            <p>Rol</p>
        </article>
    </section>

<?php include("template/footer.php") ?>
