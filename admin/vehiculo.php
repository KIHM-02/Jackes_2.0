<?php include("template/header.php") ?>
    <header>
        <h2 class="subtitle header-elements">Panel Vehiculos</h2>

        <div>
            <a class ="header-elements" href="entityRegistration/vehiculo_registro.php"><button class="btn-black-header header-buttons">Agregar</button></a>
        </div>
    </header>

    <form method="POST" class="form-search">
        <div class ="div-form-inputs">
            <label for="inputWorkerId">Id de trabajador</label>
            <input class ="text-inputs" type="text" name="txtWorkerId" id="inputWorkerId">
        </div>

        <div class ="div-form-inputs">
            <label for="inputCarId">Id del vehiculo</label>
            <input class ="text-inputs" type="text" name="txtCarId" id="inputCarId">
        </div>

        <div class ="div-form-inputs space-top">
            <input class ="btn-black-header" type="submit" value="Buscar">
        </div>
    </form>

    <section class = "section-table">
        <button class ="btn-black-header table-buttons">Agregar vehiculo</button>
            
        <label for = "chkTable" class ="btn-black-header table-buttons">Desplegar</label>
        <input type="checkbox" name="chkTable" id="chkTable" class ="chkTable table-buttons">

        <div class ="border-table space-top">
            <table class = "table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Modelo</th>
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
            <p>Id Conduccion</p>
            <label for="txtDateView">Fecha</label>
            <input type="date" name="txtDateView" id="txtDateView">
            <p>Distancia</p>
            <p>Id usuario</p>
            <p>Id vehiculo</p>
        </article>
        <article class ="card">
            <p>Id Conduccion</p>
            <label for="txtDateView">Fecha</label>
            <input type="date" name="txtDateView" id="txtDateView">
            <p>Distancia</p>
            <p>Id usuario</p>
            <p>Id vehiculo</p>
        </article>
        <article class ="card">
            <p>Id Conduccion</p>
            <label for="txtDateView">Fecha</label>
            <input type="date" name="txtDateView" id="txtDateView">
            <p>Distancia</p>
            <p>Id usuario</p>
            <p>Id vehiculo</p>
        </article>
        <article class ="card">
            <p>Id Conduccion</p>
            <label for="txtDateView">Fecha</label>
            <input type="date" name="txtDateView" id="txtDateView">
            <p>Distancia</p>
            <p>Id usuario</p>
            <p>Id vehiculo</p>
        </article>
    </section>

<?php include("template/footer.php") ?>
