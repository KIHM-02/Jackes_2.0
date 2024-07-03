<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>

    <link rel="stylesheet" href="../css/color.css">
    <link rel="stylesheet" href="../css/init-border.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <section class ="main">
        <div class="warning-box">
            <p>El ID de usuario o la contraseña son incorrectas. Vuelva a intentarlo</p>
        </div>

        <header>
            <h1>Bienvenido Adminitrador!</h1>
        </header>
        
        <form method ="POST">
            <div>
                <label class = "labels" for="txtID">Ingrese su ID de usuario:</label>
                <input class = "inputs" type="text" id ="txtID" name ="txtID" placeholder = "ID">
            </div>

            <div>
                <label class = "labels" for="txtPwd">Ingrese su contraseña:</label>
                <input class = "inputs" type="password" name="txtPwd" id="txtPwd" placeholder = "Contraseña">
            </div>
        </form>
    </section>

</body>
</html>