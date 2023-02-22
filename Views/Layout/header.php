<?php

    use Models\Categoria;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zapatos</title>
    <link rel="stylesheet" href="../../styles/style.css">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <header>
        <a href="/proyectotienda/public/">
            <img src="" alt="">
            <h1>TIENDA DE ZAPATOS</h1>
        </a>
        <b>Login: admin@admin.es  --> admin123 </b>
        <p>
            <?php
                if (isset($_SESSION['identity'])){
                    echo $_SESSION['identity']->nombre. " ". $_SESSION['identity']->apellidos;
                }
            ?>
        </p>

        <nav class="navbar">
            <ul class="opciones-sesion">
                <?php if(!isset($_SESSION['identity'])):?>
                    <li>
                        <a href="/proyectotienda/public/usuario_identifica">Iniciar Sesión</a>
                    </li>
                    <li>
                        <a href="/proyectotienda/public/usuario_registro">Registrarse</a>
                    </li>
                <?php endif; ?>
                <?php if(isset($_SESSION['admin'])):?>
                    <li>
                        <a href="/proyectotienda/public/producto_index">Gestionar Productos | </a>
                    </li>
                    <li>
                        <a href="/proyectotienda/public/categoria_index">Gestionar Categorías |</a>
                    </li>
                <?php endif; ?>

                <?php if(isset($_SESSION['identity']) || isset($_SESSION['admin'])):?>
                    <li>
                        <?php if(isset($_SESSION['carrito'])):?>
                            <a href="/proyectotienda/public/carrito_index">Carrito(<?=count($_SESSION['carrito'])?>) | </a>
                        <?php else: ?>
                            <a href="/proyectotienda/public/carrito_index">Carrito (0) | </a>
                        <?php endif;?>
                    </li>
                    <li>
                        <a href="/proyectotienda/public/pedido_index">Mis pedidos | </a>
                    </li>
                    <li>
                        <a href="/proyectotienda/public/usuario_logout">Cerrar sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>


        
    </header>