<?php include("template/header.php") ?>
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
            <label for="inputMunicipio">Municipio</label>
            <input class ="text-inputs" type="text" name="txtMunicipio" id="inputMunicipio">
        </div>

        <div class ="div-form-inputs space-top">
            <input class ="btn-black-header" type="submit" value="Buscar">
        </div>
    </form>

    <section class = "section-table">
        <button class ="btn-black-header table-buttons">Agregar municipio</button>
            
        <label for = "chkTable" class ="btn-black-header table-buttons">Desplegar</label>
        <input type="checkbox" name="chkTable" id="chkTable" class ="chkTable table-buttons">

        <div class ="border-table space-top">
            <table class = "table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Municipio</th>
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
                </tbody>
            </table>
        </div>
    </section>

    <section class = "section-title">
        <h2 class ="subtitle">Datos</h2>
    </section>

    <section class ="info-container">
        <article class ="card">
            <p>Id Cliente</p>
            <p>Nombres</p>
            <p>Apellidos</p>
            <p>Colonia</p>
            <p>Dirección</p>
            <p>Telefono</p>
            <p>Num interior</p>
            <p>Num exterior</p>
            <p>Id Municipio</p>
        </article>
        <article class ="card">
            <p>Id Cliente</p>
            <p>Nombres</p>
            <p>Apellidos</p>
            <p>Colonia</p>
            <p>Dirección</p>
            <p>Telefono</p>
            <p>Num interior</p>
            <p>Num exterior</p>
            <p>Id Municipio</p>
        </article>
        <article class ="card">
            <p>Id Cliente</p>
            <p>Nombres</p>
            <p>Apellidos</p>
            <p>Colonia</p>
            <p>Dirección</p>
            <p>Telefono</p>
            <p>Num interior</p>
            <p>Num exterior</p>
            <p>Id Municipio</p>
        </article>
        <article class ="card">
            <p>Id Cliente</p>
            <p>Nombres</p>
            <p>Apellidos</p>
            <p>Colonia</p>
            <p>Dirección</p>
            <p>Telefono</p>
            <p>Num interior</p>
            <p>Num exterior</p>
            <p>Id Municipio</p>
        </article>
    </section>

<?php include("template/footer.php") ?>
