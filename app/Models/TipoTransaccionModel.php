<?php namespace App\Models;

use CodeIgniter\Model;

class TipoTransaccionModel extends Model
{
    protected $table ='tipotransaccion';
    protected $primaryKey = 'id';

    protected $returntype = 'array';
    protected $allwedFields =['nombre', 'apellido', 'telefono', 'correo'];

    protected $useTimestamps = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';

    protected $validationRules = [
        'monto' => 'required|numeric',
        'cuenta_id' => 'required|integer|is_:valid_cuenta',

    ]; 


   protected $skipValidation = false; 
}