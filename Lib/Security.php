<?php

    namespace Lib;
    use Dotenv\Dotenv;
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    use PDOException;
    use Models\Usuario;

    class Security {

        final public static function clavesecreta(){
            $dotenv = Dotenv::createImmutable(dirname(__DIR__.'/'));
            $dotenv->load();
            return $_ENV['SECRET_KEY'];
        }

        // Encriptar la contraseña.
        final public static function encriptaPassw(string $passw): string{
            $passw = password_hash($passw, PASSWORD_DEFAULT);
            return $passw;
        }

        // verificar pass
        final public static function validaPassw(string $passw, string $passwhash): bool{
            if(password_verify($passw, $passwhash)){
                return true;
            }
            else{
                echo "Contraseña Incorrecta";
                // error_log('Contraseña incorrecta');
                return false;
            }
        }


        // Crear token
        final public static function crearToken(string $key, string $data) {

            $time = strtotime("now");
            $token = array(
                "iat"=>$time, // Tiempo en el que creamos el Token.
                "exp"=>$time + 3600,  // Tiempo de expiracion del Token.
                "data"=>$data
                );
            
            // return JWT::encode($token, $key, 'HS256');
            return $token;
        }

        // Comprueba que el token es válido y no ha expirado, para poder ejecutar ciertas funciones con permisos.
        final public static function getToken(){
            $headers = apache_request_headers(); // Recoger las cabeceras en el servidor Apache
            if(!isset($headers['Authorization'])){  // Comprobamos que existe la cabecera authorization
                return $response['message'] = json_decode(ResponseHttp::StatusMessage(403, 'Acceso denegado'));
            }
            try{
                $authorizationArr = explode(' ', $headers['Authorization']);
                $token = $authorizationArr[1];


                $usuario = new Usuario();
                $expiracion = $usuario->tokenExp($token);

                if ($expiracion >= strtotime("now")){
                    $decodeToken = JWT::decode($token, new Key(Security::clavesecreta(), 'HS256'));
                    return $decodeToken;
                }else{
                    return $response['message'] = json_encode(ResponseHttp::statusMessage(401, 'Token expirado'));
                }

            }catch (PDOException $exception){
                return $response['message'] = json_encode(ResponseHttp::statusMessage(401, 'Token invalido'));
            }
        }


        // Valida el Token de la cabecera o el usuario
        final public static function validateToken():bool{
            $info = self::getToken();
            $info2 = self::getUser();

            if(isset($info -> data)){
                return true;
            }
            else if (gettype($info2) == "boolean"){
                if($info2 == 1){
                    return true;
                }else{
                    return false;
                }
            }
            else{
                return false;
            }
        }

        // Comprueba que el usuario recibido por cabecera, está confirmado para poder ejecutar ciertas funciones con permisos.
        final public static function getUser(){
            $headers = apache_request_headers();
            if(!isset($headers['Usuario'])){
                return $response['message'] = json_decode(ResponseHttp::StatusMessage(403, 'Acceso denegado'));
            }
            try{
                $usuarioArr = explode(' ', $headers['Usuario']);
                $user = $usuarioArr[1];
                
                $usuario = new Usuario();
                $confirmado = $usuario->comprobarConfirmado($user);

                if($confirmado == 1) {
                    return true;
                }else{
                    return false;
                }

            }catch (PDOException $exception){
                return $response['message'] = json_encode(ResponseHttp::statusMessage(401, 'Usuario no Confirmado o Token inválido'));
            }

        }
        

    }

?>