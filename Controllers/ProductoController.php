<?php

    namespace Controllers;
    use Models\Categoria;
    use Models\Producto;
    use Lib\Pages;
    use Utils\Utils;


    class ProductoController{
        private Pages $pages;


        public function __construct(){
            $this->pages = new Pages();
        }

        public function index(){

            // Utils::isAdmin();

            $producto = new Producto();
            $productos = $producto->getAll();

            $this->pages->render('Producto/index', ['productos' => $productos]);

        }


        public function save(){
            Utils::isAdmin();
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $data = $_POST['data'];

                $producto = new Producto();

                $producto->save($data);

            }

            $categoria = new Categoria();
            $categorias = $categoria->getAll();
            $this->pages->render('Producto/crear', ['categorias' => $categorias]);

        }


        public function borrar($id){
            Utils::isAdmin();

            $producto = new Producto();

            $producto->borrar($id);

            header('Location:'. $_ENV['BASE_URL']);

        }

        public function editar($id){
            Utils::isAdmin();

            $producto = new Producto();

            $producto->editar($id);

            header('Location:'. $_ENV['BASE_URL']);

        }


    }

?>