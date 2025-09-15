<?php

namespace Frota\Models;

use CodeIgniter\Model;

class FrotaModel extends Model {
    protected $table = 'frota';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'nome_motorista',
        'local_destino'
        'horario_saida',
        'km_saida',
        'horario_retorno',
        'km_retorno'
    ];
}