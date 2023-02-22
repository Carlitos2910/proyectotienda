<?php
    session_start();
    require_once ('../Views/Layout/header.php');

    require_once __DIR__.'/../vendor/autoload.php';

    use Controllers\CarritoController;
    use Controllers\CategoriaController;
    use Controllers\PedidoController;
    use Controllers\ProductoController;
    use Controllers\UsuarioController;

    use Models\Categoria;
    use Models\Carrito;
    use Models\Producto;
    use Models\Pedido;
    use Models\Usuario;
    
    use Lib\Router;
    use Utils\Utils;


    use Dotenv\Dotenv;

    // Añadir Dotenv.
    $dotenv = Dotenv::createImmutable(__DIR__); // Para acceder al contenido del archivo .env
    $dotenv->safeLoad(); // Si no existe nos marca error.



    // Ruta confirmación de la cuenta
    // Router::add('GET', 'confirmarCuenta/:id', function(string $token){
    //     (new ApiusuarioController())->confirmacion($token);
    // });


    Router::add('GET', '/', function(){
        require '../Views/Producto/index.php';
    });


    // REGISTRO DE USUARIOS
    Router::add('GET', 'usuario_registro', function(){
        require '../Views/Usuario/registro.php';
    });
    Router::add('POST', 'usuario_registro', function(){
        (new UsuarioController())->registro();
    });


    // LOGIN DE USUARIOS
    Router::add('GET', 'usuario_identifica', function(){
        require '../Views/Usuario/login.php';
    });
    Router::add('POST', 'usuario_identifica', function(){
        (new UsuarioController())->identifica();
    });


    // LOGOUT DE USUARIOS.
    Router::add('GET', 'usuario_logout', function(){
        (new UsuarioController())->logout();
    });


    // Páginas Iniciales de cada Vista.
    Router::add('GET', 'producto_index', function(){
        require '../Views/Producto/index.php';
    });
    Router::add('GET', 'categoria_index', function(){
        require '../Views/Categoria/index.php';
    });
    Router::add('GET', 'carrito_index', function(){
        require '../Views/Carrito/index.php';
    });
    Router::add('GET', 'pedido_index', function(){
        require '../Views/Pedido/index.php';
    });




    Router::add('GET', 'producto_save', function(){
        require '../Views/Producto/crear.php';
    });
    Router::add('POST', 'producto_save', function(){
        (new ProductoController())->save();
    });
    Router::add('GET', 'producto_borrar/:id', function(string $id){
        (new ProductoController())->borrar($id);
    });
    Router::add('GET', 'producto_editar', function(){
        require '../Views/Producto/editar.php';
    });
    Router::add('POST', 'producto_editar', function(){
        (new ProductoController())->editar();
    });



    Router::add('GET', 'categoria_save', function(){
        require '../Views/Categoria/crear.php';
    });
    Router::add('POST', 'categoria_save', function(){
        (new CategoriaController())->save();
    });
    Router::add('GET', 'categoria_ver/:id', function(int $id){
        (new CategoriaController())->ver($id);
    });



    Router::add('GET', 'carrito_sumar/:id', function(string $id){
        (new CarritoController())->sumar($id);
    });
    Router::add('GET', 'carrito_restar/:id', function(string $id){
        (new CarritoController())->restar($id);
    });
    Router::add('GET', 'carrito_quitar/:id', function(string $id){
        (new CarritoController())->quitar($id);
    });

    Router::add('GET', 'carrito_add/:id', function(string $id){
        (new CarritoController())->add($id);
    });
    Router::add('GET', 'carrito_vaciar', function(){
        (new CarritoController())->vaciarcesta();
    });



    Router::add('GET', 'eliminar_pedidos', function(){
        (new PedidoController())->eliminar_pedidos();
    });
    Router::add('GET', 'pedido_comprar', function(){
        (new PedidoController())->comprar();
    });







    Router::dispatch();


    // http_response_code(404);
    // $array = [
    //     "status"=> 404,
    //     "mensaje"=>"Pagina no encontrada"
    // ];

    // echo json_encode($array);

    // echo ResponseHttp::getStatusMessage(404);


    // $ponente = new Ponente();
    // $array_ponentes = $ponente->getAll();
    // echo json_encode($array_ponentes);



    require_once ('../Views/Layout/footer.php');
?>