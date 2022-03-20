<?php namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\API\ResponseTraint;
use config\Services;
use Firebase\JWT\JWT;

class Auth extends BaseController
{
    use ResponseTraint;

    public function __construct(){
        helper('secure_password');
    }

    public function login()
    {
       try{
           $username = $this->request->getPost('username');
           $password = $this->request->getPost('password');

           $usuarioModel = new UsaurioModel();
           $validateUsuario = $usuarioModel->where('username', $username)->first();

           if($validateUsuario == null)
           return $this->failNotFound('Usuario no encontado');

           if(verifyPassword($password, $validateUsuario["password"])):
            
            //$this->generateJWT($validateUsuario);

            $jwt = $this->generateJWT($validateUsuario);
            return $this->respond(['Token' => $jwt], 201);

           else:
             return $this->failValidationError('Contraseña invalida');

            endif;
       } catch (\Exception $e) {
           return $this->failServerError('Ha ocurrido un error en el servidor');
       }
    }

    protected function generateJWT($Usuario){
       $key = Services::getSecretKey(); 
       $time = time();
       $payload = [
           'auth' => baseurl(),
           'iat' => $time,
           'exp' => $time + 120,
           'data' => [
               'nombre' => $usuario['nombre'],
               'username'=> $usuario['username'],
               'rol'=> $usuario['rol_id']
           ]

       ];

       $jwt = JWT::encode($payload, $key);
       return $jwt;

    }
}
