<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SLA;
use CodeIgniter\HTTP\ResponseInterface;
class DataSLAController extends BaseController
{
    public function index()
    {
        $model = new SLA();
        $data['items'] = $model->getAllData();
        $bulan = date('m');
        $tahun = date('Y');
    
        if ($this->request->getPost('bulan')) {
            $bulan = $this->request->getPost('bulan');
        }
    
        if ($this->request->getPost('tahun')) {
            $tahun = $this->request->getPost('tahun');
        }
    
        // Instantiate DataSlaModel
        $dataSlaModel = new SLA();
    
        // Get data for AV
        $avData = $dataSlaModel->getAvData($bulan, $tahun);
    
        // Get data for TTR
        $ttrData = $dataSlaModel->getTtrData($bulan, $tahun);
    
        // Calculate percentage and add to data array
        foreach ($data['items'] as &$row) {
            $ttr = $row['ttr'];
            $create_at = $row['create_at'];
    
            $bulan = date('n', strtotime($create_at));
            $tahundata = date('y', strtotime($create_at));
    
            if (in_array($bulan, [1, 3, 5, 7, 8, 10, 12])) {
                $persentase = (44640 - $ttr) / 44640;
            } elseif (in_array($bulan, [4, 6, 9, 11])) {
                $persentase = (43200 - $ttr) / 43200;
            } else {
                if (($tahundata % 4 == 0 && $tahundata % 100 != 0) || $tahundata % 400 == 0) {
                    $persentase = (41760 - $ttr) / 41760; //29 days
                } else {
                    $persentase = (40320 - $ttr) / 40320; //28 days
                }
            }
    
            $persentasepersen = $persentase * 100;
            $row['av_percentage'] = floor($persentasepersen * 100) / 100;
        }
    
        // Pass all necessary data to the view
        return view('index', [
            'items' => $data['items'],
            'avData' => $avData,
            'ttrData' => $ttrData,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
    
        }
    
        public function update($id)
        {
            $model = new SLA();
            $data = [
                'platform' => $this->request->getPost('platform'),
                'id' => $this->request->getPost('id'),
                'tanggal_instalasi' => $this->request->getPost('tanggal_instalasi'),
                'hub_status' => $this->request->getPost('hub_status'),
                'ttr' => $this->request->getPost('ttr')
            ];
    
            $model->updateDataSla($data, $id);
    
            return redirect()->to('/data-sla');
        }
    
        public function delete($id)
        {
            $model = new SLA();
            $model->deleteDataSla($id);
    
            return redirect()->to('/data-sla');
    }
}
