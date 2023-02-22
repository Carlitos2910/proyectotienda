<?php

    namespace Models;
    use Lib\BaseDatos;
    use PDO;
    use PDOException;

    class Producto{
        private string $id;
        private string $categoria_id;
        private string $nombre;
        private string $descripcion;
        private string $precio;
        private string $stock;
        private string $oferta;
        private string $fecha;
        private string $imagen;

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

        public function getCategoria_id(): string{
            return $this->categoria_id;
        }

        public function setCategoria_id(string $categoria_id){
            $this->categoria_id = $categoria_id;
        }

        public function getNombre(): string{
            return $this->nombre;
        }

        public function setNombre(string $nombre){
            $this->nombre = $nombre;
        }

        public function getDescripcion(): string{
            return $this->descripcion;
        }

        public function setDescripcion(string $descripcion){
            $this->descripcion = $descripcion;
        }

        public function getPrecio(): string{
            return $this->precio;
        }

        public function setPrecio(string $precio){
            $this->precio = $precio;
        }

        public function getStock(): string{
            return $this->stock;
        }

        public function setStock(string $stock){
            $this->stock = $stock;
        }

        public function getOferta(): string{
            return $this->oferta;
        }

        public function setOferta(string $oferta){
            $this->oferta = $oferta;
        }

        public function getFecha(): string{
            return $this->fecha;
        }

        public function setFecha(string $fecha){
            $this->fecha = $fecha;
        }

        public function getImagen(): string{
            return $this->imagen;
        }

        public function setImagen(string $imagen){
            $this->imagen = $imagen;
        }


        public function getAll(){
            $productos = $this->db->prepara("SELECT * FROM productos ORDER BY id ASC");
            $productos->execute();
            return $productos;
        }

        public function getAllCategory(){
            $sql = "SELECT p.*, c.nombre AS 'catnombre' FROM productos p
            INNER JOIN categorias c ON c.id = p.categoria_id
            WHERE p.categoria_id = {$this->getCategoria_Id()}
            ORDER BY id DESC";

            $productos = $this->db->prepara($sql);
            $productos->execute();

            return $productos;
        }

        public static function obtenerProductos(){
            $producto = new Producto();
            $productos = $producto->db->prepara("SELECT * FROM productos ORDER BY id DESC");
            $productos->execute();
            return $productos;
        }

        public static function obtenerProductosNombre(){
            $producto = new Producto();
            $productos = $producto->db->prepara("SELECT nombre FROM productos ORDER BY id DESC");
            $productos->execute();
            return $productos;
        }

        public function getOne(){
            $producto = $this->db->prepara("SELECT * FROM productos WHERE id={$this->id}");
            $producto->execute();
            return $producto->fetch(PDO::FETCH_OBJ);
        }

        public function save($data): bool{
            $ins = $this->db->prepara("INSERT INTO productos (id, categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen)
            VALUES(:id, :categoria_id, :nombre, :descripcion, :precio, :stock, :oferta, :fecha, :imagen)");

            $ins->bindParam('id', $id);
            $ins->bindParam(':categoria_id',$data['categoria'], PDO::PARAM_STR);
            $ins->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
            $ins->bindParam(':descripcion',$data['descripcion'], PDO::PARAM_STR);
            $ins->bindParam(':precio',$data['precio'], PDO::PARAM_STR);
            // $ins->bindParam(':stock',$data['stock'], PDO::PARAM_STR);
            $ins->bindParam(':stock',$data['stock']);
            $ins->bindParam(':oferta',$oferta, PDO::PARAM_STR);
            $ins->bindParam(':fecha',$fecha, PDO::PARAM_STR);
            $ins->bindParam(':imagen',$data['imagen']);

            $id = NULL;
            $oferta = NULL;
            $fecha = date('Y-m-d');

            try{
                $ins->execute();
                $result = true;
            }catch(PDOException $err){
                $result = false;
            }

            return $result;
        }

        public function editar_stock($id, $cantidad_comprada){
            $cantidad_stock = $this->cantidad_id($id)->stock;

            try{
                $this->db->prepara("UPDATE productos SET stock = $cantidad_stock - $cantidad_comprada WHERE id = $id")->execute();
            }catch(PDOException){
                echo "Error";
            }

        }

        public function cantidad_id($id){
            $cantidad = $this->db->prepara("SELECT stock FROM productos WHERE id=$id");
            $cantidad->execute();
            return $cantidad->fetch(PDO::FETCH_OBJ);
        }



        public function borrar($id){
            $producto = $this->db->prepara("UPDATE productos SET stock = 0 WHERE id = $id");

            try{
                $producto->execute();
            }catch(PDOException){
                echo "Error al eliminar producto.";
            }
        }



        public function editar($data): bool{
            $ins = $this->db->prepara("UPDATE productos SET categoria_id=:categoria_id, nombre=:nombre, descripcion=:descripcion, precio=:precio, stock=:stock, oferta=:oferta, fecha=:fecha, imagen=:imagen WHERE nombre = :nombre");

            $ins->bindParam(':categoria_id',$data['categoria'], PDO::PARAM_STR);
            $ins->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
            $ins->bindParam(':descripcion',$data['descripcion'], PDO::PARAM_STR);
            $ins->bindParam(':precio',$data['precio'], PDO::PARAM_STR);
            $ins->bindParam(':stock',$data['stock']);
            $ins->bindParam(':oferta',$oferta, PDO::PARAM_STR);
            $ins->bindParam(':fecha',$fecha, PDO::PARAM_STR);
            $ins->bindParam(':imagen',$data['imagen']);

            $id = NULL;
            $oferta = NULL;
            $fecha = date('Y-m-d');

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