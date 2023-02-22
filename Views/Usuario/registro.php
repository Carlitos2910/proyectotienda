<h1>Crear una Cuenta</h1>



<?php use Utils\Utils;?>

    <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'complete'): ?>
        <b class="alert_green"> Registro Completado Correctamente</b>
    <?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'failed'):?>
        <b class="alert_red"> Registro Fallido, introduce bien los datos</b>
    <?php endif; ?>

<?php Utils::deleteSession('register'); ?>


<form action="usuario_registro" method="POST">
    <label for="nombre">Nombre</label>
    <input type="text" name="data[nombre]" required pattern="^[a-zA-Z]*\d{0,4}$" title="El nombre de usuario debe tener solo letras, números."/>
<br>
    <label for="apellidos">Apellidos</label>
    <input type="text" name="data[apellidos]" required pattern="^[a-zA-Z]$" title="El apellido solo puede contener letras."/>
<br>
    <label for="email">Email</label>
    <input type="email" name="data[email]" required title="El email debe seguir su patron ejemplo@ejemplo"/>
<br>
    <label for="password">Contraseña</label>
    <input type="password" name="data[password]" required/>
<br>
    <input type="submit" value="Registrarse">

</form>