<?php

    namespace Models;
    use Lib\BaseDatos;
    use PDO;
    use PDOException;

    class Pedido{
        private string $id;
        private string $usuario_id;
        private string $provincia;
        private string $localidad;
        private string $direccion;
        private string $coste;
        private string $estado;
        private string $fecha;
        private string $hora;

        private BaseDatos $db;

        public function __construct(string $id, string $usuario_id, string $provincia, string $localidad, string $direccion, string $coste, string $estado, string $fecha, string $hora){
            $this->db = new BaseDatos();
            $this->id = $id;
            $this->usuario_id = $usuario_id;
            $this->provincia = $provincia;
            $this->localidad = $localidad;
            $this->direccion = $direccion;
            $this->coste = $coste;
            $this->estado = $estado;
            $this->fecha = $fecha;
            $this->hora = $hora;
        }

        public function getId(): string{
            return $this->id;
        }

        public function setId(string $id){
            $this->id = $id;
        }

        public function getUsuario_id(): string{
            return $this->usuario_id;
        }

        public function setUsuario_id(string $usuario_id){
            $this->usuario_id = $usuario_id;
        }

        public function getProvincia(): string{
            return $this->provincia;
        }

        public function setProvincia(string $provincia){
            $this->provincia = $provincia;
        }

        public function getLocalidad(): string{
            return $this->localidad;
        }

        public function setLocalidad(string $localidad){
            $this->localidad = $localidad;
        }

        public function getDireccion(): string{
            return $this->direccion;
        }

        public function setDireccion(string $direccion){
            $this->direccion = $direccion;
        }

        public function getCoste(): string{
            return $this->coste;
        }

        public function setCoste(string $coste){
            $this->coste = $coste;
        }

        public function getEstado(): string{
            return $this->estado;
        }

        public function setEstado(string $estado){
            $this->estado = $estado;
        }

        public function getFecha(): string{
            return $this->fecha;
        }

        public function setFecha(string $fecha){
            $this->fecha = $fecha;
        }

        public function getHora(): string{
            return $this->hora;
        }

        public function setHora(string $hora){
            $this->hora = $hora;
        }



        public static function fromArray(array $data): Pedido{
            return new Pedido(
                $data['id'] ?? '',
                $data['usuario_id'] ?? '',
                $data['provincia'] ?? '',
                $data['localidad'] ?? '',
                $data['direccion'] ?? '',
                $data['coste'] ?? '',
                $data['estado'] ?? '',
                $data['fecha'] ?? '',
                $data['hora'] ?? '',
            );
        }

        public function save(): bool{
            $ins = $this->db->prepara("INSERT INTO pedidos (id, usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) VALUES(:id, :usuario_id, :provincia, :localidad, :direccion, :coste, :estado, :fecha, :hora)");

            $ins->bindParam('id', $id);
            $ins->bindParam(':usuario_id', $usuario_id, PDO::PARAM_STR);
            $ins->bindParam(':provincia', $provincia, PDO::PARAM_STR);
            $ins->bindParam(':localidad', $localidad, PDO::PARAM_STR);
            $ins->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            $ins->bindParam(':coste', $coste, PDO::PARAM_STR);
            $ins->bindParam(':estado', $estado, PDO::PARAM_STR);
            $ins->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $ins->bindParam(':hora', $hora, PDO::PARAM_STR);

            $id = NULL;
            $usuario_id=$this->getUsuario_id();
            $provincia=$this->getProvincia();
            $localidad=$this->getLocalidad();
            $direccion=$this->getDireccion();
            $coste=$this->getCoste();
            $estado=$this->getEstado();
            $fecha=$this->getFecha();
            $hora=$this->getHora();

            try{
                $ins->execute();
                $result = true;
            }catch(PDOException $err){
                $result = false;
            }

            return $result;
        }

        public function save_lineas_pedidos($i): bool{
            $ins = $this->db->prepara("INSERT INTO lineas_pedidos (id, pedido_id, producto_id, unidades) VALUES(:id, :pedido_id, :producto_id, :unidades)");

            $ins->bindParam('id', $id);
            $ins->bindParam(':pedido_id', $pedido_id, PDO::PARAM_STR);
            $ins->bindParam(':producto_id', $producto_id, PDO::PARAM_STR);
            $ins->bindParam(':unidades', $unidades, PDO::PARAM_STR);


            $id = NULL;
            $pedido_id = Pedido::get_id_pedido();
            $producto_id = $_SESSION['carrito'][$i]['id_producto'];
            $unidades = $_SESSION['carrito'][$i]['unidades'];


            try{
                $ins->execute();
                $result = true;
            }catch(PDOException $err){
                $result = false;
            }

            return $result;
        }

        // Funcion que nos devolverá el id del pedido para meterlo en lineas pedidos.
        public function get_id_pedido(): string{
            // Comprobar si existe.
            $cons = $this->db->prepara("SELECT id FROM pedidos WHERE usuario_id = :usuario_id AND fecha = :fecha AND hora = :hora ");

            $cons->bindParam(':usuario_id', $usuario_id, PDO::PARAM_STR);
            $cons->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $cons->bindParam(':hora', $hora, PDO::PARAM_STR);

            $usuario_id = $this->getUsuario_id();
            $fecha = $this->getFecha();
            $hora = $this->getHora();

            try{
                $cons->execute();
                if($cons && $cons->rowCount() == 1){ // Si la cantidad de filas devueltas es 1 existe.
                    $result = $cons->fetch(PDO::FETCH_OBJ); // Aqui estará el objeto que ha devuelto la BD.
                }
            } catch(PDOException $err){
                $result = false;
            }

            return $result->id;
        }

    }

?>