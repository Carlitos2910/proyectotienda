<h1> Productos Por Categoria</h1>

<?php
    use Models\Categoria;

    $categorias = Categoria::obtenerCategorias();
?>
<nav id="menucat">
    <ul class="opciones-categorias">
        <?php while($cat = $categorias->fetch(PDO::FETCH_OBJ)): ?>
            <li>
                <a href="<?=$_ENV['BASE_URL']?>categoria_ver/<?=$cat->id?>"><?=$cat->nombre?></a>
            </li>
        <?php endwhile; ?>
    </ul>
</nav>



<?php if(isset($_SESSION['admin'])):?>
    <a href="<?=$_ENV['BASE_URL']?>producto_save" class="button button-small">
        Crear Producto
    </a>
<?php endif; ?>


<table style="width: 60%; margin:auto; text-align:center;">
    <tr>
        <th style="border: 1px solid;">NOMBRE</th>
        <th style="border: 1px solid;">STOCK</th>
        <th style="border: 1px solid;">PRECIO</th>
        <th style="border: 1px solid;">IMAGEN</th>
        <th style="border: 1px solid;">COMPRAR</th>
    </tr>


    <?php while ($prod = $productos->fetch(PDO::FETCH_OBJ)): ?>
        <tr>
            <td style="border: 1px solid;"><?=$prod->nombre;?></td>
            <td style="border: 1px solid;"><?=$prod->stock;?></td>
            <td style="border: 1px solid;"><?=$prod->precio;?>€</td>
            <td style="border: 1px solid;">
                <img src="<?=$_ENV['BASE_URL_IMG']?><?=$prod->imagen;?>" width="120px" alt="<?=$prod->imagen;?>">
            </td>
            <td style="border: 1px solid;">
                <?php if($prod->stock > 0):?>
                    <a href="<?=$_ENV['BASE_URL']?>carrito_add/<?=$prod->id;?>" class="button"> Comprar </a> |

                    <?php if(isset($_SESSION['admin'])):?>
                        <a href="<?=$_ENV['BASE_URL']?>producto_borrar/<?=$prod->id;?>" class="button button-small"> Borrar </a> |
                        <a href="<?=$_ENV['BASE_URL']?>producto_editar" class="button button-small"> Editar </a>
                    <?php endif; ?>

                <?php else: ?>
                    <p>Sin Stock</p>
                <?php endif;?>
            </td>
        </tr>
    <?php endwhile; ?>
</table>