<?php

    use Utils\Utils;

?>

<h1> Carrito de la compra </h1>

<table style="width:80%; margin:auto; text-align:center;">

    <?php if(isset($_SESSION['carrito']) && count($_SESSION['carrito']) != 0):?>

        <?php for($i=0; $i<count($_SESSION['carrito']); $i++): ?>
            <tr>
                <th style="border: 1px solid;">Imagen</th>
                <th style="border: 1px solid;">Nombre</th>
                <th style="border: 1px solid;">Precio</th>
                <th style="border: 1px solid;">Unidades</th>
                <th style="border: 1px solid;">ELIMINAR</th>
            </tr>

            <tr>
                <td style="border: 1px solid;">
                    <img src="../images/<?=$_SESSION['carrito'][$i]['producto']->imagen;?>" width="120px">
                </td>
                <td style="border: 1px solid;"><?=$_SESSION['carrito'][$i]['producto']->nombre;?></td>
                <td style="border: 1px solid;"><?=$_SESSION['carrito'][$i]['precio'];?></td>
                <td style="border: 1px solid;"><?=$_SESSION['carrito'][$i]['unidades'];?>
                    <h3>
                        <a href="<?=$_ENV['BASE_URL']?>carrito_sumar/<?=$_SESSION['carrito'][$i]['id_producto'];?>">+</a>
                        <a href="<?=$_ENV['BASE_URL']?>carrito_restar/<?=$_SESSION['carrito'][$i]['id_producto'];?>">-</a>
                    </h3>
                </td>
                <td style="border: 1px solid;">
                    <h3><a href="<?=$_ENV['BASE_URL']?>carrito_quitar/<?=$i;?>">Eliminar Producto</a></h3>
                </td>
            </tr>
        <?php endfor;?>

    <?php else: ?>

        <b>El carrito está vacío, añade algún producto.</b>

    <?php endif; ?>

</table>

</br>
<ul class="opciones-cesta">
    <li>
        <h2><a href="carrito_vaciar">Vaciar Cesta</a></h2>
    </li>
    <li>
        <h4>PRECIO TOTAL: <?=Utils::totalprice();?>€</h4>
    </li>
    <?php if(isset($_SESSION['identity']) || isset($_SESSION['admin'])):?>
        <li>
            <h2><a href="<?=$_ENV['BASE_URL']?>pedido_comprar">Comprar</a></h2>
        </li>
    <?php else:?>
        <li>
            <h2><a href="<?=$_ENV['BASE_URL']?>usuario_identifica">Iniciar Sesión Para Comprar</a></h2>
        </li>
    <?php endif;?>
</ul>
