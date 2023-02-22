<?php

    namespace Controllers;
    use Models\Categoria;
    use Models\Producto;
    use Lib\Pages;
    use Utils\Utils;


    class CategoriaController{
        private Pages $pages;


        public function __construct(){
            $this->pages = new Pages();
        }

        public function index(){
            Utils::isAdmin();
            $categoria = new Categoria();
            $categorias = $categoria->getAll();

            $this->pages->render('Categoria/index', ['categorias' => $categorias]);

        }

        public function save(){
            Utils::isAdmin();
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $name = $_POST['nombre'];

                $categoria = new Categoria();

                $categoria->save($name);

            }

            $this->pages->render('Categoria/crear');
        }

        public function ver($id){

                // Cojemos La Categoría.
                $categoria = new Categoria();
                $categoria->setId($id);
                $categoria = $categoria->getOne();

                // Conseguimos Los Productos de esa Categoria.
                $producto = new Producto();
                $producto->setCategoria_Id($id);
                $productos = $producto->getAllCategory();


            $this->pages->render('Categoria/ver', ['categoria' => $categoria, 'productos' => $productos]);
        }

    }

?>