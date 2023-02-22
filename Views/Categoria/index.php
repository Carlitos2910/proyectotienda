<?php
    use Models\Categoria;

    $categorias = Categoria::obtenerCategorias();
?>

<h1> Gestionar categorias</h1>

<a href="categoria_save" class="button button-small">
    Crear Categoría
</a>

<table>
    <tr>
        <th>ID</th>
        <th>NOMBRE</th>
    </tr>
    <?php while ($cat = $categorias->fetch(PDO::FETCH_OBJ)): ?>
        <tr>
            <td><?=$cat->id;?></td>
            <td><?=$cat->nombre;?></td>
        </tr>
    <?php endwhile; ?>
</table>