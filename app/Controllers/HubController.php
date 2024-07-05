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

        // Get data for AV
        $avData = $model->getAvData($bulan, $tahun);

        // Get data for TTR
        $ttrData = $model->getTtrData($bulan, $tahun);

        // Calculate percentage and add to data array
        foreach ($data['items'] as &$row) {
            $row['av_percentage'] = $model->calculateAvPercentage($row['ttr'], $row['create_at']);
        }

        // Pass all necessary data to the view
        return view('hub', [
            'items' => $data['items'],
            'avData' => $avData,
            'ttrData' => $ttrData,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);
    }

    public function add()
    {
        $model = new SLA();
        $data = [
            'platform' => $this->request->getPost('platform'),
            'id' => $this->request->getPost('id'),
            'tanggal_instalasi' => $this->request->getPost('tanggal_instalasi'),
            'hub_status' => $this->request->getPost('hub_status'),
            'ttr' => $this->request->getPost('ttr')
        ];

        // Insert data into database
        $model->insertDataSla($data);

        // Redirect to a success page or back to the form with a success message
        return redirect()->to(base_url('hub'))->with('success', 'Data berhasil ditambahkan!');
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

        // Update data in database
        $model->updateDataSla($data, $id);

        return redirect()->to(base_url('hub'))->with('success', 'Data berhasil diperbarui!');
    }
    public function exportcsv()
    {
        // Assuming SLA is your model for interacting with the database
        $model = new SLA();
    
        // Retrieve data from database
        $data = $model->findAll();
    
        // Set headers for CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="sla_data.csv"');
        header('Cache-Control: max-age=0');
    
        // Open a file pointer to php://output for writing
        $output = fopen('php://output', 'w');
    
        // Write headers to the CSV file
        fputcsv($output, ['Platform', 'ID', 'Tanggal Instalasi', 'Hub Status', 'TTR', 'Availability']);
    
        // Write data rows to the CSV file
        foreach ($data as $item) {
            // Adjust 'tanggal_instalasi' and 'av_percentage' as needed based on their format
            $rowData = [
                $item['platform'],
                $item['id'],
                $item['tanggal_instalasi'],
                $item['hub_status'],
                $item['ttr'],
                $item['av_percentage'] / 100 // Assuming 'av_percentage' is stored as a percentage
            ];
    
            fputcsv($output, $rowData);
        }
    
        // Close the file pointer
        fclose($output);
    
        // Terminate script to prevent any additional output
        exit();
    }
    
    public function export()
    {
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
        $sheet->setCellValue('F1', 'Availability');

        // Populate data
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item['platform']);
            $sheet->setCellValue('B' . $row, $item['id']);
            $sheet->setCellValue('C' . $row, $item['tanggal_instalasi']);
            $sheet->setCellValue('D' . $row, $item['hub_status']);
            $sheet->setCellValue('E' . $row, $item['ttr']);
            $sheet->setCellValue('F' . $row, $item['av_percentage'] / 100);
            $row++;
        }
        $sheet->getStyle('F2:F' . ($row - 1))->getNumberFormat()->setFormatCode('0.00%');
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
        // Load session library if not autoloaded
        $session = \Config\Services::session();
    
        // Check if the request is a POST request
        if ($this->request->getMethod() === 'post') {
            // Retrieve uploaded file
            $file = $this->request->getFile('file');
    
            // Check if file is valid and not moved
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
    
                // Initialize success flag
                $success = true;
    
                // Initialize message
                $message = 'Data berhasil diimpor!';
    
                // Iterate through each row of the sheet
                $model = new SLA();
                for ($row = 2; $row <= $highestRow; $row++) {
                    // Retrieve cell values
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE)[0];
    
                    // Check if the first column is empty to stop importing
                    if (empty($rowData[0])) {
                        break; // Stop importing if the first column is empty
                    }
    
                    // Prepare data for insertion
                    $data = [
                        'platform' => $rowData[0],
                        'id' => $rowData[1],
                        'tanggal_instalasi' => $rowData[2],
                        'hub_status' => $rowData[3],
                        'ttr' => $rowData[4]
                    ];
    
                    // Insert data into database
                    $success = $model->insertDataSla($data);
    
                    // Check if insertion failed
                    if (!$success) {
                        $message = 'Gagal mengimpor data!';
                        break; // Stop importing on failure
                    }
                }
    
                // Check if import was successful
                if ($success) {
                    // Set session flashdata for success message (optional)
                    $session->setFlashdata('success', 'Data berhasil diimpor!');
                    // Return JSON response
                    return $this->response->setJSON(['success' => true, 'message' => $message]);
                } else {
                    // Return JSON response
                    return $this->response->setJSON(['success' => false, 'message' => $message]);
                }
            }
        }
    
        // Return JSON response for invalid file or other errors
        return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengimpor data!']);
    }
    


    public function delete($id)
    {
        $model = new SLA();
        $model->deleteData($id);
        return redirect()->to(base_url('hub'))->with('success', 'Data berhasil dihapus!');
    }
}
