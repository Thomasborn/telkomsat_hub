<?php

namespace App\Controllers;

use App\Models\SLA;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class HubController extends BaseController
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
        return view('hub', [
            'items' => $data['items'],
            'avData' => $avData,
            'ttrData' => $ttrData,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
     // Your index method code here
        // This method could load a view, fetch data from a model, etc.
    }

    public function add()
{
    // Assuming SLA is your model for interacting with the database
    $model = new SLA();

    // Retrieve form data
    $data = [
        'platform' => $this->request->getPost('platform'),
        'id' => $this->request->getPost('id'),
        'tanggal_instalasi' => $this->request->getPost('tanggal_instalasi'),
        'hub_status' => $this->request->getPost('hub_status'),
        'ttr' => $this->request->getPost('ttr')
    ];

    // Insert data into database
    $model->insert($data);

    // Redirect to a success page or back to the form with a success message
    return redirect()->to(base_url('hub '))->with('success', 'Data berhasil ditambahkan!');
}


    public function edit($id)
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

        return redirect()->to(base_url('hub '))->with('success', 'Data berhasil diperbarui!');
        // This method could load a form for editing a record, update records, etc.
    }
    
    
    public function export(){
        // Assuming SLA is your model for interacting with the database
        $model = new SLA();
    
        // Retrieve data from database
        $data = $model->findAll();
        
    
        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Set headers
        $sheet->setCellValue('A1', 'Platform');
        $sheet->setCellValue('B1', 'ID');
        $sheet->setCellValue('C1', 'Tanggal Instalasi');
        $sheet->setCellValue('D1', 'Hub Status');
        $sheet->setCellValue('E1', 'TTR');
        //$sheet->setCellValue('F1', 'Availability');
    
        // Populate data
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item['platform']);
            $sheet->setCellValue('B' . $row, $item['id']);
            $sheet->setCellValue('C' . $row, $item['tanggal_instalasi']);
            $sheet->setCellValue('D' . $row, $item['hub_status']);
            $sheet->setCellValue('E' . $row, $item['ttr']);
           // $sheet->setCellValue('F' . $row, $avPercentage);
            $row++;
        }
    
        // Create a writer
        $writer = new Xlsx($spreadsheet);
    
        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="sla_data.xlsx"');
        header('Cache-Control: max-age=0');
    
        // Write file to the browser
        $writer->save('php://output');
    }
    
    public function import()
    {
        // Retrieve uploaded file
        $file = $this->request->getFile('file');
    
        // Load the uploaded file if it exists
        if ($file->isValid() && !$file->hasMoved()) {
            // Move the uploaded file to a writable directory
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);
    
            // Read the uploaded Excel file
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load(WRITEPATH . 'uploads/' . $newName);
    
            // Get the first sheet in the Excel file
            $sheet = $spreadsheet->getActiveSheet();
    
            // Get the highest row number and column letter
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
    
            // Iterate through each row of the sheet
            $model = new SLA();
            for ($row = 2; $row <= $highestRow; $row++) {
                // Retrieve cell values
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE)[0];
    
                // Prepare data for insertion
                $data = [
                    'platform' => $rowData[0],
                    'id' => $rowData[1],
                    'tanggal_instalasi' => $rowData[2],
                    'hub_status' => $rowData[3],
                    'ttr' => $rowData[4]
                ];
    
                // Insert data into database
                $model->insert($data);
            }
    
            // Redirect to a success page or back to the form with a success message
            return redirect()->to(base_url('hub'))->with('success', 'Data berhasil diimpor!');
        }
    
        // Redirect to a failure page or back to the form with an error message
        return redirect()->to(base_url('hub'))->with('error', 'Gagal mengimpor data!');
    }

    public function delete($id)
    {
        $model = new SLA();
        $model->deleteData($id);  
        return redirect()->to(base_url('hub '))->with('success', 'Data berhasil dihapus!');
        // Your delete method code here
        // This method could delete a record from the database
    }

    // Add more methods as needed for your application
}
