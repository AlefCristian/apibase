<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    public const TABLE        =  'clients';
    public const ID           = 'clientId';
    public const NAME         = 'clientName';
    public const EMAIL        = 'clientEmail';
    public const PHONENUMBER  = 'clientPhoneNumber';
    public const CPF          = 'clientCpf';

    protected $table            = self::TABLE;
    protected $primaryKey       = self::ID;
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $protectFields = true;
    protected $allowedFields = [
        self::NAME,
        self::EMAIL,
        self::PHONENUMBER,
        self::CPF
    ];

        /**
     * 🔥 AQUI FICA O CAST
     */
    protected array $casts = [
        self::ID => 'integer',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        self::NAME        => 'required|min_length[3]',
        self::EMAIL       => 'required|valid_email',
        self::PHONENUMBER => 'required|min_length[10]',
        self::CPF         => 'required|min_length[11]',
    ];
}
