<?php namespace App\Controllers\API;
use App\Models\ClienteModel;
use App\Models\CuentaModel;
use CodeIgniter\RESTful\ResourceController;

class Clientes extends ResourceController
{

    public function __construct(){
        $this->model = $this->setModel(new ClienteModel());
        helper('access_rol');

    }
    public function index()
    {
       
        try {
            if(!validateAccess(array('admin'), $this->request->getServer('HTTP_AUTHORIZATION')));
            return $this->failServerError('El rol no tiene acceso a este recurso');

            $clientes = $this->model->findAll();
            return $this->respond($clientes);

        }catch (\Exception $e){
            return $this->faiServerError('ha ocurrido un error en el servidor');
        }

    
    }

    public function create()
    {
        try {

            $cliente = $this->request->getJSON();
            if($this->model->insert($cliente)):
                $cliente->id = $this->model->insert($cliente);
                return $this->respondCreated($cliente);
                else:
                    return $this->faiValidationError($this->model->validation->listErrors());
            endif;

        }catch (\Exception $e){
            return $this->faiServerError('ha ocurrido un error en el servidor');
        }

    }

    public function edit($id = null)
    {
        try {

            if($id == null)
                return $this->failValidationError('No se ha pasado un Id valido');
            
                $cliente = $this->model->find($id);

            if($cliente ==null)
            return $this->failNotFound('No se ha encontrado un cliente con el id:'.$id);

            return $this->respond($cliente);


        }catch (\Exception $e){
            return $this->faiServerError('ha ocurrido un error en el servidor');
        }
    }

    public function update($id = null)
    {
        try {

            if($id == null)
                return $this->failValidationError('No se ha pasado un Id valido');
            
                $clienteVerificado = $this->model->find($id);

            if($clienteVerificado == null)
            return $this->failNotFound('No se ha encontrado un cliente con el id:'.$id);

            $cliente = $this->request->getJSON();

            if($this->model->update($id, $cliente)):
                $cliente->id = $id;
                return $this->respondUpdate($cliente);
                else:
                    return $this->failValidationError($this->model->validation->listErrors());
            endif;


        }catch (\Exception $e){
            return $this->faiServerError('ha ocurrido un error en el servidor');
        }
    } 

    public function delete($id = null)
    {
        try {

            if($id == null)
                return $this->failValidationError('No se ha pasado un Id valido');
            
                $clienteVerificado = $this->model->find($id);

            if($clienteVerificado == null)
            return $this->failNotFound('No se ha encontrado un cliente con el id:'.$id);


            if($this->model->delete($id)):
                return $this->respondDelated($clienteVerificado);
                else:
                    return $this->failServerError('No se ha podido eliminar el registro');
            endif;


        }catch (\Exception $e){
            return $this->faiServerError('Ha ocurrido un error en el servidor');
        }
    }
}
