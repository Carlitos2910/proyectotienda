

<h1>Crear Nueva Categoria</h1>

<form action="categoria_save" method="POST">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" required pattern="[a-zA-Z]" title="Solo se pueden introducir letras en el campo Categor&iacute;a."/>

    <input type="submit" value="Guardar">
</form>