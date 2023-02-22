<h1>Mis Pedidos</h1>
<a href="eliminar_pedidos">Eliminar Pedido</a>


<?php if(isset($_SESSION['pedido'])):?>
    <?php foreach($_SESSION['pedido'] as $pedido): ?>

        <div class="order-item">
            <div class="order-item-header">
                <h2>En Proceso</h2>
                <h4>Pedido efectuado el: <?=$pedido['fecha']?></h4>
            </div>
            <div class="order-item-content">
                <img src="../images/<?=$pedido['imagen']?>" width="150px" height="200px" alt="">
                <div class="order-item-info">
                    <h3><?=$pedido['nombre']?></h3>
                    <br/>
                    <p><?=$pedido['descripcion']?></p>
                    <p>Unidades: <?=$pedido['unidades']?></p>
                    <p>Precio unidad: <?=$pedido['precio']?>€</p>
                    <h4>Total: <?=$pedido['precio']*$pedido['unidades']?>€</h4>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
<?php else: ?>
    <h2 style="text-align: center;"> Todavía no tienes ningún pedido.</h2>
<?php endif; ?>
