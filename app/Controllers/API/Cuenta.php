<?php namespace App\Controllers\API;

use App\Models\CuentaModel;
use CodeIgniter\RESTful\ResourceController;

class cuentas extends ResourceController
{

    public function __construct(){
        $this->model = $this->setModel(new CuentaModel());

    }
    public function index()
    {
        $cuentas = $this->model->findAll();
       return $this->respond($cuentas);
    
    }

    public function create()
    {
        try {

            $cuenta = $this->request->getJSON();
           /* $clienteModel = new ClieneModel();
            $cliente = $clienteModel->find($cuenta->cliente_id);
            */
            if($this->model->insert($cuenta)):
                $cuenta->id = $this->model->insertID();
                return $this->respondCreated($cueta);
                else:
                    return $this->failValidationError($this->model->validation->listErrors());
            endif;

        }catch (\Exception $e){
            return $this->failServerError('Ha ocurrido un error en el servidor');
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
            return $this->failServerError('ha ocurrido un error en el servidor');
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
