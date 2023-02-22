<?php

    namespace Controllers;
    use Models\Pedido;
    use Models\Producto;
    use Models\Carrito;
    use Lib\Pages;
    use Utils\Utils;


    class PedidoController{
        private Pages $pages;


        public function __construct(){
            $this->pages = new Pages();
        }

        public function index(){
            $this->pages->render('Pedido/index');
        }

        public function comprar(){
            // Se crea un pedido y se guarda en la base de datos en la tabla pedidos.
            $pedido = [
                "usuario_id" => $_SESSION['identity']->id,
                "provincia" => "Granada",
                "localidad" => "Granada",
                "direccion" => "Avd Francisco Ayala",
                "coste" => Utils::totalprice(),
                "estado" => "En proceso",
                "fecha" => date('Y-m-d'),
                "hora" => date('h:i:s A'),
            ];

            if(Utils::totalprice() > 0){
                $pedido = Pedido::fromArray($pedido);

                // Comentado para que no se guarden todo el rato en las pruebas.
                $save = $pedido->save();

                // Con la sesión carrito añadimos a la tabla linea_pedidos los productos que hemos pedido con sus unidades.
                for($i=0; $i<count($_SESSION['carrito']); $i++){
                    $save = $pedido->save_lineas_pedidos($i);
                }

                // Le quitamos el la cantidad comprada del stock de la tienda.
                $producto = new Producto();
                for ($i = 0; $i <= count($_SESSION['carrito'])-1 ; $i++) {
                    $producto->editar_stock($_SESSION['carrito'][$i]['id_producto'], $_SESSION['carrito'][$i]['unidades']);
                }

                // Vaciamos el carrito después de hacer la compra.
                foreach($_SESSION['carrito'] as $cada_pedido){
                    $pedido = get_object_vars($cada_pedido['producto']);
                    $pedido['unidades'] = $cada_pedido['unidades'];
                    $_SESSION['pedido'][] = $pedido;
                }

                $this->pages->render('Pedido/sendEmail');
                Utils::deleteSession('carrito');
                header("Location:".$_ENV['BASE_URL']."pedido_index");

            }else{
                header("Location:".$_ENV['BASE_URL']."carrito_index");
            }

        }

        public function eliminar_pedidos(){
            Utils::deleteSession('pedido');
            // Header
            header("Location:".$_ENV['BASE_URL']."producto_index");
        }

    }

?>