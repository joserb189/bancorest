<?php namespace App\Controllers\API;

use App\Models\CuentaModel;
use CodeIgniter\RESTful\ResourceController;

class cuentas extends ResourceController
{

    public function __construct(){
        $this->model = $this->setModel(new TransaccionModel());

    }
    public function index()
    {
        $transacciones = $this->model->findAll();
       return $this->respond($transacciones);
    
    }

    public function create()
    {
        try {

            $transaccion = $this->request->getJSON();
           /* $clienteModel = new ClieneModel();
            $cliente = $clienteModel->find($cuenta->cliente_id);
            */
            if($this->model->insert($transaccion)):
                $transaccion->id = $this->model->insertID();
                $transaccion->resultado = $this->actualizarFondoCuenta($transaccion->tipo_transaccion_id, $transaccion);
                return $this->respondCreated($transaccion);
                else:
                    return $this->failValidationError($this->model->validation->listErrors());
            endif;

        }catch (\Exception $e){
            return $this->faiServerError('Ha ocurrido un error en el servidor');
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
/*
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
    */
    public function getTrasaccionesByCliente($id = null) 
    {
        try {
            $modelCliente = new ClienteModel();

            if($id == null)
                return $this->failValidationError('No se ha pasado un Id valido');
            
               
            $cliente = $modelCliente->find(id);
            if($cliente == null)
            return $this->failNotFound('No se ha encontrado un cliente con el id:'.$id);

            $transacciones = $this->model->TrasaccionesPorCliente($id);

            return $this->respond($transacciones);


        }catch (\Exception $e){
            return $this->failServerError('ha ocurrido un error en el servidor');
        }

    }

    private function actualizarFondoCuenta($tipoTransacionId, $monto, $cuentaId)
    {
        $modelCuenta = new CuentaModel();
        $cuenta = $modelCuenta->find($cuentaId);

        switch ($tipoTransacionId){
            case 1:
                $cuenta["fondo"] += $monto;
                break;

                case 2:
                    $cuenta["fondo"] -= $monto;
                    break;
        }

        if($modelCuenta->update($cuentaId, $cuenta)) :
            return array('TransaccionExistosa' => true, 'NuevoFondo' => $cuenta["fondo"]);
        else:
            return array('TransaccionExistosa' => false, 'Nuevofondo' => $cuenta["fondo"]);
            endif;
    }
}