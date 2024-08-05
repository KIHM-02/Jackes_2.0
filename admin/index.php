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

    <?php
        session_start();

        $userFound = true;

        if($_POST)
        {
            require_once("config/conexion.php");
            
            try
            {
                $idUser = $_POST['txtID'];
                $pwdUser = $_POST['txtPwd'];

                $conection = new Conexion();            
                $userFound = $conection->verifyUserExistence($idUser, $pwdUser);
            }
            catch(Exception $er)
            {
                echo $er->getMessage();
            }
        }
    ?>

    <section class ="main">

        <?php if(!$userFound){ ?>
            <div class="warning-box">
                <p>El ID de usuario o la contraseña son incorrectas. Vuelva a intentarlo</p>
            </div>
        <?php } ?>

        
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
            <div>
                <button class ="inputs btn" type="submit">Iniciar sesión</button>
            </div>
        </form>
    </section>

</body>
</html>