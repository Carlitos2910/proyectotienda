<?php

    namespace Models;
    use Lib\BaseDatos;
    use PDO;
    use PDOException;

    class Usuario{
        private string $id;
        private string $nombre;
        private string $apellidos;
        private string $email;
        private string $password;
        private string $rol;

        private BaseDatos $db;
        // Errores.
        // protected static $errores = [];

        public function __construct(string $id, string $nombre, string $apellidos, string $email, string $password, string $rol){
            $this->db = new BaseDatos();
            $this->id = $id;
            $this->nombre = $nombre;
            $this->apellidos = $apellidos;
            $this->email = $email;
            $this->password = $password;
            $this->rol = $rol;
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

        public function getApellidos(): string{
            return $this->apellidos;
        }

        public function setApellidos(string $apellidos){
            $this->apellidos = $apellidos;
        }

        public function getEmail(): string{
            return $this->email;
        }

        public function setEmail(string $email){
            $this->email = $email;
        }

        public function getPassword(): string{
            return $this->password;
        }

        public function setPassword(string $password){
            $this->password = $password;
        }

        public function getRol(): string{
            return $this->rol;
        }

        public function setRol(string $rol){
            $this->rol = $rol;
        }

        // public function validar(){
            // -----------------
            // -----------------
        // }

        // public function sanitizar(){
        //     ------------------
        //     ------------------
        // }



        public static function fromArray(array $data): Usuario{
            return new Usuario(
                $data['id'] ?? '',
                $data['nombre'] ?? '',
                $data['apellidos'] ?? '',
                $data['email'] ?? '',
                $data['password'] ?? '',
                $data['rol'] ?? '',
            );
        }

        public function save(): bool{
            $ins = $this->db->prepara("INSERT INTO usuarios (id, nombre, apellidos, email, password, rol) VALUES(:id,:nombre,:apellidos,:email,:password,:rol)");

            $ins->bindParam('id', $id);
            $ins->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $ins->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
            $ins->bindParam(':email', $email, PDO::PARAM_STR);
            $ins->bindParam(':password', $password, PDO::PARAM_STR);
            $ins->bindParam(':rol', $rol, PDO::PARAM_STR);

            $id = NULL;
            $nombre=$this->getNombre();
            $apellidos=$this->getApellidos();
            $email=$this->getEmail();
            $password=$this->getPassword();
            $rol='user';

            try{
                $ins->execute();
                $result = true;
            }catch(PDOException $err){
                $result = false;
            }

            return $result;
        }



        public function buscaMail($email):bool|object{
            $result = false;
            // Comprobar si existe.
            $cons = $this->db->prepara("SELECT * FROM usuarios WHERE email = :email");
            $cons->bindParam(':email', $email, PDO::PARAM_STR);

            try{
                $cons->execute();
                if($cons && $cons->rowCount() == 1){ // Si la cantidad de filas devueltas es 1 existe.
                    $result = $cons->fetch(PDO::FETCH_OBJ); // Aqui estará el objeto que ha devuelto la BD.
                }
            } catch(PDOException $err){
                $result = false;
            }

            return $result;
        }



        public function login(): bool|object{

            $result = false;
            $email = $this->email;
            $password = $this->password;

            // Comprobar si existe el email.
            $usuario = $this->buscaMail($email);

            if ($usuario !== false){

                // Verificar Password.
                $verify = password_verify($password, $usuario->password);

                if($verify){
                    $result = $usuario;
                }
            }

            return $result;

        }


    }

?>