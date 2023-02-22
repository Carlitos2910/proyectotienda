<?php

    namespace Models;
    use Lib\BaseDatos;
    use PDO;
    use PDOException;

    class Categoria{
        private string $id;
        private string $nombre;

        private BaseDatos $db;
            // Errores.
            // protected static $errores = [];

        public function __construct(){
            $this->db = new BaseDatos();
        }


        public function getId(): string{
            return $this->id;
        }

        public function setId(string $id){
            $this->id = $id;
        }

        public function getNombre(): string{
            return $this->nombre;
        }

        public function setNombre(string $nombre){
            $this->nombre = $nombre;
        }

        public function getAll(){
            $categorias = $this->db->prepara("SELECT * FROM categorias ORDER BY id DESC");
            return $categorias;
        }

        public function getOne(){
            $categoria = $this->db->prepara("SELECT * FROM categorias WHERE id={$this->id}");
            return $categoria->fetch(PDO::FETCH_OBJ);
        }

        public static function obtenerCategorias(){
            $categoria = new Categoria();
            $categorias = $categoria->db->prepara("SELECT * FROM categorias ORDER BY id DESC");
            $categorias->execute();
            return $categorias;
        }

        public function save($name): bool{
            $ins = $this->db->prepara("INSERT INTO categorias (id, nombre) VALUES(:id,:nombre)");

            $ins->bindParam('id', $id);
            $ins->bindParam(':nombre', $name, PDO::PARAM_STR);

            $id = NULL;

            try{
                $ins->execute();
                $result = true;
            }catch(PDOException $err){
                $result = false;
            }

            return $result;
        }

    }

?>