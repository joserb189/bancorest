<?php namespace App\Controllers\API;
use App\Models\TipoTransaccionModel;
use CodeIgniter\RESTful\ResourceController;

class TipoTransacciones extends ResourceController
{

    public function __construct(){
        $this->model = $this->setModel(new TipoTransaccionesModel());

    }
    public function index()
    {
        $tipoTransacciones = $this->model->findAll();
       return $this->respond($clientes);
    
    }

    public function create()
    {
        try {

            $tipoTransaccion = $this->request->getJSON();
            if($this->model->insert($tipotransaccion)):
                $tipoTransaccion->id = $this->model->insert($tipoTransaccion);
                return $this->respondCreated($tipoTransaccion);
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
            
                $tipoTransaccion = $this->model->find($id);

            if($tipoTransaccion ==null)
            return $this->failNotFound('No se ha encontrado un cliente con el id:'.$id);

            return $this->respond($tipoTransaccion);


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