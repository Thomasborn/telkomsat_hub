<?php

namespace App\Models;

use CodeIgniter\Model;

class SLA extends Model
{
    protected $table            = 'data_sla';
    protected $primaryKey       = 'hub_id';
    protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    // protected $protectFields    = true;
    protected $allowedFields    = ['platform' ,
    'id' ,
    'tanggal_instalasi',
    'hub_status',
    'ttr' ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;
    public function getAllData()
    {
        return $this->findAll();
    }

    public function getDataById($id)
    {
        return $this->find($id);
    }

    public function updateData($id, $data)
    {
        return $this->update($id, $data);
    }
    public function updateDataSla($data, $id)
    {
        $this->update($id, $data);
    }
    public function deleteData($id)
    {
        return $this->delete($id);
    }public function getAvData($bulan, $tahun)
    {
        // Fetch AV data based on month and year
        // Assuming 'create_at' is the column storing the creation date in your 'data_sla' table
    
        $query = $this->db->query("
            SELECT id, ttr, create_at
            FROM data_sla
            WHERE MONTH(create_at) = $bulan
            AND YEAR(create_at) = $tahun
        ");
    
        $avData = [
            'labels' => [],
            'persentaseData' => []
        ];
    
        foreach ($query->getResult() as $row) {
            // Compute AV percentage based on your logic
            $persentase = $this->calculateAvailability($bulan, $tahun, $row->ttr, $row->create_at);
    
            $avData['labels'][] = $row->id;
            $avData['persentaseData'][] = $persentase;
        }
    
        return $avData;
    }
    
    public function getTtrData($bulan, $tahun)
    {
        // Fetch TTR data based on month and year
    
        $query = $this->db->query("
            SELECT id, ttr
            FROM data_sla
            WHERE MONTH(create_at) = $bulan
            AND YEAR(create_at) = $tahun
        ");
    
        $ttrData = [
            'labels' => [],
            'ttrData' => []
        ];
    
        foreach ($query->getResult() as $row) {
            $ttrData['labels'][] = $row->id;
            $ttrData['ttrData'][] = $row->ttr;
        }
    
        return $ttrData;
    }
    
    
    // Helper function to calculate availability percentage
    private function calculateAvailability($bulan, $tahun, $ttr, $create_at)
    {
        // Your availability calculation logic here
        // Example logic:
    
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $totalMinutes = $daysInMonth * 24 * 60; // Total minutes in the month
        $availability = (1 - ($ttr / $totalMinutes)) * 100; // Calculate availability percentage
    
        return round($availability, 2); // Round to 2 decimal places
    }
    
    // Callbacks
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];
}
