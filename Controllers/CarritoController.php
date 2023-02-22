<?php

    namespace Controllers;
    use Models\Categoria;
    use Models\Producto;
    use Models\Carrito;
    use Lib\Pages;
    use Utils\Utils;


    class CarritoController{
        private Pages $pages;


        public function __construct(){
            $this->pages = new Pages();
        }

        public function index(){
            $this->pages->render('Carrito/index');
        }


        public function vaciarcesta(){
            Utils::deleteSession('carrito');
            
            // header
            header('Location: /proyectotienda/public/carrito_index');
        }


        public function sumar($id){
            // Comprobamos si existe la sesión.
            if(isset($_SESSION['carrito'])){
                // Sumamos uno al contador de unidades.
                $contador = 0;
                foreach($_SESSION['carrito'] as $indice => $elemento){
                    if($elemento['id_producto'] == $id){
                        $total_stock = $_SESSION['carrito'][$indice]['producto']->stock;
                        if($_SESSION['carrito'][$indice]['unidades'] >= $total_stock){
                            // Tienes la cantidad máxima del stock del producto.
                        }else{
                            $_SESSION['carrito'][$indice]['unidades']++;
                            $contador++;
                        }
                    }
                }
            }

            // Header
            header('Location: /proyectotienda/public/carrito_index');

        }

        public function restar($id){
            // Comprobamos si existe la sesión.
            if(isset($_SESSION['carrito'])){
                // Restamos uno al contador de unidades.
                $contador = 0;
                foreach($_SESSION['carrito'] as $indice => $elemento){
                    if($elemento['id_producto'] == $id){

                        // Comprobamos si hay 0 productos para eliminarlos de la sesión.
                        if($_SESSION['carrito'][$indice]['unidades'] == 1){

                            // Eliminamos el producto de la sesión actual.
                            unset($_SESSION['carrito'][$indice]);
                            sort($_SESSION['carrito']);

                            header('Location: carrito_index');
                        }else{
                            $_SESSION['carrito'][$indice]['unidades']--;
                            $contador++;
                        }
                    }
                }
            }

            // Header
            header('Location: /proyectotienda/public/carrito_index');

        }


        public function quitar($id){
            if(isset($id)){
                unset($_SESSION['carrito'][$id]);
                sort($_SESSION['carrito']);
            }
            // Header
            header('Location: /proyectotienda/public/');
        }


        public function add($id){

            // Si recibimos el id lo guardamos en la variable sino volvemos a la página inicial.
            if($id){
                $producto_id = $id;
            }else{
                
                header('Location:'.$_ENV['BASE_URL']);
            }

            // Se existe la sesión carrito con nuestro producto le sumamos unidades al producto.
            // if(isset($_SESSION['carrito'])){
            //     $contador = 0;
            //     foreach($_SESSION['carrito'] as $indice => $elemento){
            //         if($elemento['id_producto'] == $producto_id){
            //             $_SESSION['carrito'][$indice]['unidades']++;
            //             $contador++;
            //         }
            //     }
            // }

            // Se existe la sesión carrito con nuestro producto le sumamos unidades al producto.
            if(isset($_SESSION['carrito'])){
                $contador = 0;
                foreach($_SESSION['carrito'] as $indice => $elemento){
                    if($elemento['id_producto'] == $producto_id){
                        $total_stock = $_SESSION['carrito'][$indice]['producto']->stock;
                        if($_SESSION['carrito'][$indice]['unidades'] >= $total_stock){
                            $contador = $total_stock;
                        }else{
                            $_SESSION['carrito'][$indice]['unidades']++;
                            $contador++;
                        }
                    }
                }
            }


            // Si no existe el contador creamos un objeto producto con el id que recibimos por URL, y creamos le sesión de ese producto.
            if(!isset($contador) || $contador == 0){

                // Cojemos el producto.
                $producto = new Producto();
                $producto->setId($producto_id);
                $producto = $producto->getOne();

                // Añadimos al carrito.
                if(is_object($producto)){
                    $_SESSION['carrito'][] = array(
                        "id_producto" => $producto->id,
                        "precio" => $producto->precio,
                        "unidades" => 1,
                        "producto" => $producto
                    );
                }
            }

            // Header
            header('Location: /proyectotienda/public/carrito_index');

        }
    }

?>