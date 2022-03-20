<?php namespace App\Filters;

use App\Models\RolModel;
use CodeIgniter\Filters\FiltersInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {

        try {
            $key = Services::getSecretkey();
            $authHeader = $request->getServer('HTTP_AUTHORIZATION');

            if($authHeader == null)
              return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'No se ha enviado el JWT requerido');

              $arr = explode(' ', $authHeader);
              $jwt = $arr[1];
  
              $jwt = JWT::decode($jwt, $key, ['HS256']);

              $rolModel = new RolModel();
              $rol = $rolModel->find($jwt->data->rol);

              if($rol == null)
              return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'El rol del JWT es invalido');
              
              return true;
  
            } catch (ExpiredException $ee) {
                return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED, 'Su toquen JWT ha expirado');
        }catch (Exception $e) {
            return Services::response()->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Ocurrio un error en el servidor al el token');

        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}