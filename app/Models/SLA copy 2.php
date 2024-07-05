<?php
namespace App\Models;

use CodeIgniter\Model;

class SLA extends Model
{
    protected $table = 'data_sla';
    protected $primaryKey = 'hub_id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['platform' ,
    'id' ,
    'tanggal_instalasi',
    'hub_status',
    'ttr',
    'av_percentage'];
    // Method to get all data
    public function getAllData()
    {
        return $this->findAll();
    }

    // Method to get AV data
    public function getAvData($bulan, $tahun)
    {
        // Your code to fetch AV data
    }

    // Method to get TTR data
    public function getTtrData($bulan, $tahun)
    {
        // Your code to fetch TTR data
    }

    // Method to calculate AV percentage
    public function calculateAvPercentage($ttr, $create_at)
    {
        $bulan = date('n', strtotime($create_at));
        $tahundata = date('Y', strtotime($create_at)); // Menggunakan format tahun 4 digit

        if (in_array($bulan, [1, 3, 5, 7, 8, 10, 12])) {
            $persentase = (44640 - $ttr) / 44640;
        } elseif (in_array($bulan, [4, 6, 9, 11])) {
            $persentase = (43200 - $ttr) / 43200;
        } else {
            if (($tahundata % 4 == 0 && $tahundata % 100 != 0) || $tahundata % 400 == 0) {
                $persentase = (41760 - $ttr) / 41760; // 29 days
            } else {
                $persentase = (40320 - $ttr) / 40320; // 28 days
            }
        }

        $persentasepersen = $persentase * 100;
        return floor($persentasepersen * 100) / 100;
    }

    // Override insert method to calculate AV percentage
    public function insertDataSla($data)
    {
        $data['av_percentage'] = $this->calculateAvPercentage($data['ttr'], $data['tanggal_instalasi']);
        return $this->insert($data);
    }

    // Override update method to calculate AV percentage
    public function updateDataSla($data, $id)
    {
        $data['av_percentage'] = $this->calculateAvPercentage($data['ttr'], $data['tanggal_instalasi']);
        return $this->update($id, $data);
    }

    // Method to delete data SLA
    public function deleteDataSla($id)
    {
        return $this->delete($id);
    }
}
