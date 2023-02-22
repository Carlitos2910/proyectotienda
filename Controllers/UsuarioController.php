<?php

    namespace Controllers;
    use Models\Usuario;
    use Lib\Pages;


    class UsuarioController{
        private Pages $pages;


        public function __construct(){
            $this->pages = new Pages();
        }


        public function registro(){

            if($_SERVER['REQUEST_METHOD'] === 'POST'){

                if($_POST['data']){
                    $registrado = $_POST['data'];

                    $registrado['password'] = password_hash($registrado['password'], PASSWORD_BCRYPT, ['cost'=>4]);

                    $usuario = Usuario::fromArray($registrado);

                    $save = $usuario->save();
                    if($save){
                        $_SESSION['register'] = "complete";
                    }else{
                        $_SESSION['register'] = "failed";
                    }
                }else{
                    $_SESSION['register'] = "failed";
                }
            }

            $this->pages->render('Usuario/registro');
        }



        public function identifica(){
            // Identificar al usuariow
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                if($_POST['data']){
                    $auth = $_POST['data'];
                    
                    // Consulta a la base de datos.
                    $usuario = Usuario::fromArray($auth);
                    
                    $identity = $usuario->login();
                    
                    // Crear sesión para el usuario.
                    if($identity && is_object($identity)){
                        $_SESSION['identity'] = $identity;

                        if($identity->rol == 'admin'){
                            $_SESSION['admin'] = true;
                        }

                    }else{
                        $_SESSION['error_login'] = 'Identificación fallida';
                    }

                }
                header("Location:" . $_ENV['BASE_URL']);
            }
            $this->pages->render('Usuario/login');
        }


        public function logout(){
            if(isset($_SESSION['identity'])){
                unset($_SESSION['identity']);
            }

            if(isset($_SESSION['admin'])){
                unset($_SESSION['admin']);
            }

            header("Location:".$_ENV['BASE_URL']);
        }
    }

?>