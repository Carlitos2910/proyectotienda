<?php

    use Models\Categoria;
    $categorias = Categoria::obtenerCategorias();

?>

<h1>Crear Nuevo Producto</h1>

<form action="producto_save" method="POST">
    <label for="nombre">Nombre</label>
    <input type="text" name="data[nombre]" required pattern="^[a-zA-Z]+$"/>
    <label for="descripcion">Descripcion</label>
    <textarea name="data[descripcion]" rows="1" cols="20" required></textarea>
    <label for="precio">Precio</label>
    <input type="text" name="data[precio]" required pattern="^\d+(\.\d+)?$"/>
    <label for="stock">Stock</label>
    <input type="number" min="1" name="data[stock]" required/>
    <label for="categoria">Categoria</label>
    <select name="data[categoria]" id="categoria">
        <?php while ($cat = $categorias->fetch(PDO::FETCH_OBJ)): ?>
            <option value="<?=$cat->id;?>"><?=$cat->nombre;?></option>
        <?php endwhile; ?>
    </select>
    <label for="imagen">Imagen</label>
    <input type="file" name="data[imagen]" required>
    <input type="submit" value="Guardar">
</form>