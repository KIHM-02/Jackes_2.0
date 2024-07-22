<?php 
    session_start(); 
    
    if(isset($_SESSION['idUser']))
    {
        header("Location:index.php");
    }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/color.css">
    <link rel="stylesheet" href="../css/init-border.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/main.css">

    <title>Adminitrador</title>
</head>
<body>
    <nav class ="nav-bar">
        <ul class ="ul-left">
            <button class ="list-elements btn-black"><a href="#">Agregar Corte</a></button>
            <li class ="list-elements"><a href="config/close_session.php">Salir</a></li>
        </ul>

        <ul class ="ul-right">
            <li class ="list-elements"><a href="corte.php">Cortes</a></li>
            <li class ="list-elements"><a href="usuario.php">Usuarios</a></li>
            <li class ="list-elements"><a href="#">Vehiculos</a></li>
            <li class ="list-elements"><a href="#">Maquinas</a></li>
            <li class ="list-elements"><a href="#">Clientes</a></li>
        </ul>
    </nav>

    <main>