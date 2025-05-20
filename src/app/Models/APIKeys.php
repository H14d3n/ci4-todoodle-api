<?php

namespace App\Models;

use CodeIgniter\Model;

class APIKeys extends Model
{
    protected $table            = 'api_keys';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['api_key', 'is_active', 'user_id', 'comments'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'api_key'     => 'required|alpha_numeric|min_length[30]',
        'is_active'   => 'permit_empty|numeric',
        'user_id'     => 'permit_empty|numeric',
        'comments'    => 'permit_empty|alpha_numeric_punct'
    ];
    
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];



    /**
     * Check if API Key is valid
     *
     * @param string $api_key
     * @return mixed
     */
    public function check($api_key) {

        if (!empty($api_key)) {

            // Get API Key
            $api_key = $this->where('api_key', $api_key)
                        ->where('is_active', 1)
                        ->first();

            if (!empty($api_key) && is_array($api_key)) {
                return $api_key;
            }
        }

        return FALSE;
    }
    
}