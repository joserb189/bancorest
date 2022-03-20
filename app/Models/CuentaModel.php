<?php namespace App\Models;

use CodeIgniter\Model;

class CuentaModel extends Model
{
    protected $table ='cuenta';
    protected $primaryKey = 'id';

    protected $returntype = 'array';
    protected $allwedFields =['moneda', 'fondo', 'cliente_id'];

    protected $useTimestamps = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';

    protected $validationRules = [
        'moneda' => 'required|alpha_space|min_lenght[3]|max_length[3]',
        'fondo' => 'required|numeric',
        'cliente_id' => 'required|integer|is_valid_cliente|is_allow_cliente',
       
    ];     

    protected $validationMassages =
[

    'cliente_id' =>    [
    'is_valid_cliente' => 'Estimado usuario, debe ingresar un cliente valido',
    'is_allow_cliente' => 'Estimado usuario, debe ingresar un cliente de la lista permitida'
     ]
   ];  

   protected $skipValidation = false; 
}