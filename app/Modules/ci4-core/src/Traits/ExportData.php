<?php 

namespace Adnduweb\Ci4Core\Traits;

// Import Excel Package
use \SplTempFileObject;
use \SplFileObject;
use League\Csv\Reader;
use League\Csv\CharsetConverter;
use League\Csv\Writer;
use League\Csv\Statement;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/*** CLASS ***/
trait ExportData
{
    /**  @var string  */
    public $supported = ['csv', 'pdf', 'xls'];

    /**  @var string  */
    public $setTitle;

    /**  @var string  */
    public $filename;

    /**  @var object  */
    public $spreadsheet;


    public function exportXls(string $setTitle, string $filename, bool $ajax){

        $this->spreadsheet = new Spreadsheet();

        $sheet = $this->spreadsheet->getActiveSheet();
        $sheet->setTitle($this->className);
        $sheet->fromArray($this->headerExport, null, 'A1');
        //$sheet->setCellValue('A1', 'Hello World !');
        $sheet->fromArray($this->dataExport, null, 'A2', true);
        
        
        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename .'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($this->spreadsheet);

        if($ajax == true){

            ob_start();
            $writer->save('php://output');
            $xlsData = ob_get_contents();
            ob_end_clean();

            return $xlsData;

        }else{
            ob_end_clean();
            $writer->save('php://output');
        }

    }

    public function exportCsv(string $filename, bool $ajax){

        if($ajax == true){

            ob_start();
            $csv = Writer::createFromPath('php://temp', 'r+');
            //we insert the CSV header
            //print_r($this->headerExport);exit;
            $csv->insertOne($this->headerExport);
            $csv->insertAll($this->dataExport);
            $csv->setDelimiter(';');
            $csv->setOutputBOM(Reader::BOM_UTF8);
            $csv->output($filename);

            $csvData = ob_get_contents();
            ob_end_clean();

            return $csvData;

        }else{
            //$csv = Writer::createFromFileObject(new SplFileObject('php://output', 'w'));
            $csv = Writer::createFromPath('php://temp', 'r+');
            //we insert the CSV header
            $csv->insertOne($this->headerExport);
            $csv->insertAll($this->dataExport);
            $csv->setDelimiter(';');
            //we insert
            $csv->setOutputBOM(Reader::BOM_UTF8);
            $csv->output('export_' . strtolower($this->className) . '_' . date('dmyHis') . '.csv');

        }

    }

    public function exportPdf(string $filename, $setPaper, $orientation, bool $ajax){

        if($ajax == true){

            $dompdf = new \Dompdf\Dompdf(); 
            //$customPaper = array(0,0,567.00,283.80);
            $dompdf->loadHtml(view('Themes\backend\metronic\layout\partials\extras\_pdf_view_export_datatable', $this->viewData));
            // $dompdf->setPaper('A4', 'landscape');
            $dompdf->setPaper($setPaper, $orientation);
            $dompdf->render();

                                // redirect output to client browser
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');

            return $dompdf;

        }else{

            $dompdf = new \Dompdf\Dompdf(); 
            $dompdf->loadHtml(view('Themes\backend\metronic\layout\partials\extras\_pdf_view_export_datatable', $this->viewData));
            $dompdf->setPaper($setPaper, $orientation);
            $dompdf->render();
            $dompdf->stream($filename, [ "Attachment" => true ]);
            return $dompdf;

        }

    }

    

        /**
     * Export the item (soft).
     *
     * @param string $itemId
     *
     * @return RedirectResponse
     */
    public function export($format = null)
    {
    
          //https://onlinewebtutorblog.com/export-data-into-excel-report-in-codeigniter-4-tutorial/

          $format = !is_null($format) ? $format : $this->request->getPost('format');

          if(!$format){
              $response = ['code' => 200, 'message' => lang('Core.not_choice'), 'success' => true, csrf_token() => csrf_hash()];
              return $this->respond($response, 200);
              exit;
          }

          switch ($format) {
              case 'excel':
                  if ($this->request->isAJAX()) {
                      $header = array_merge(model(PermissionModel::class)::$orderable, ['created_at']);
                      $permissionsData = model(PermissionModel::class)->asArray()->select(implode(',', $header))->findAll();

                      $spreadsheet = new Spreadsheet();
                      
                      $sheet = $spreadsheet->getActiveSheet();
                      $sheet->setTitle($this->className);
                      $sheet->fromArray($header, null, 'A1');
                      //$sheet->setCellValue('A1', 'Hello World !');
                      $sheet->fromArray($permissionsData, null, 'A2', true);
                      
                      $fileName = strtolower($this->className).'-'.time().'.xlsx';
                      

                      // redirect output to client browser
                      header('Content-Type: application/vnd.ms-excel');
                      header('Content-Disposition: attachment;filename="'.$fileName .'"');
                      header('Cache-Control: max-age=0');

                      $writer = new Xlsx($spreadsheet);

                      ob_start();
                      $writer->save('php://output');

                      $xlsData = ob_get_contents();
                      ob_end_clean();

                      $response = ['code' => 200, 'message' => lang('Core.download_file'),  'op' => 'ok', 'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData), 'success' => true, csrf_token() => csrf_hash()];
                      return $this->respond($response, 200);

                  }else{
                      $header = array_merge(model(PermissionModel::class)::$orderable, ['created_at']);
                      $permissionsData = model(PermissionModel::class)->asArray()->select(implode(',', $header))->findAll();
  
                      $spreadsheet = new Spreadsheet();
                      
                      $sheet = $spreadsheet->getActiveSheet();
                      $sheet->setTitle($this->className);
                      $sheet->fromArray($header, null, 'A1');
                      //$sheet->setCellValue('A1', 'Hello World !');
                      $sheet->fromArray($permissionsData, null, 'A2', true);
                      
                      $fileName = strtolower($this->className).'-'.time().'.xlsx';
                      
                      // redirect output to client browser
                      header('Content-Type: application/vnd.ms-excel');
                      header('Content-Disposition: attachment;filename="'.$fileName .'"');
                      header('Cache-Control: max-age=0');
  
                      $writer = new Xlsx($spreadsheet);
  
                      ob_end_clean();
                      $writer->save('php://output');
  
                      exit;
                     } 
                  
                  break;
              case 'csv':
                  if ($this->request->isAJAX()) {

                      $header = array_merge(model(PermissionModel::class)::$orderable, ['created_at']);
                      $permissionsData = model(PermissionModel::class)->asArray()->select(implode(',', $header))->findAll();

                      ob_start();
                      $csv = Writer::createFromPath('php://temp', 'r+');
                      //we insert the CSV header
                      $csv->insertOne($header);
                      $csv->insertAll($permissionsData);
                      $csv->setDelimiter(';');
                      $csv->setOutputBOM(Reader::BOM_UTF8);
                      $csv->output('export_' . strtolower($this->className) . '_' . date('dmyHis') . '.csv');

                      $xlsData = ob_get_contents();
                      ob_end_clean();


                      $response = ['code' => 200, 'message' => lang('Core.download_file'),  'op' => 'ok', 'file' => "data:application/csv;base64,".base64_encode($xlsData), 'success' => true, csrf_token() => csrf_hash()];
                      return $this->respond($response, 200);


                      exit;


                  }else{
                  
                      $header = array_merge(model(PermissionModel::class)::$orderable, ['created_at']);
                      $permissionsData = model(PermissionModel::class)->asArray()->select(implode(',', $header))->findAll();

                      //$csv = Writer::createFromFileObject(new SplFileObject('php://output', 'w'));
                      $csv = Writer::createFromPath('php://temp', 'r+');
                      //we insert the CSV header
                      $csv->insertOne($header);
                      $csv->insertAll($permissionsData);
                      $csv->setDelimiter(';');
                      //we insert
                      $csv->setOutputBOM(Reader::BOM_UTF8);
                      $csv->output('export_' . strtolower($this->className) . '_' . date('dmyHis') . '.csv');
                      exit;
                  }
                  break;
              case 'pdf':
                  if ($this->request->isAJAX()) {
                      $this->viewData['header'] = array_merge(model(PermissionModel::class)::$orderable, ['created_at']);
                      $this->viewData['data'] = model(PermissionModel::class)->asArray()->select(implode(',', $this->viewData['header']))->findAll();
                      $dompdf = new \Dompdf\Dompdf(); 
                      //$customPaper = array(0,0,567.00,283.80);
                      $dompdf->loadHtml(view('Themes\backend\metronic\layout\partials\extras\_pdf_view_export_datatable', $this->viewData));
                      // $dompdf->setPaper('A4', 'landscape');
                      $dompdf->setPaper('A4', 'portrait');
                      $dompdf->render();
   
                                          // redirect output to client browser
                      header('Content-Type: application/vnd.ms-excel');
                      header('Content-Disposition: attachment;filename="export_' . strtolower($this->className) . '_' . date('dmyHis') . '.pdf"');
                      header('Cache-Control: max-age=0');


                      $response = ['code' => 200, 'message' => lang('Core.download_file'),  'op' => 'ok', 'file' => "data:application/pdf;base64,".base64_encode($dompdf->output()), 'success' => true, csrf_token() => csrf_hash()];
                      return $this->respond($response, 200);

                      exit;


                  }else{
                      $this->viewData['header'] = array_merge(model(PermissionModel::class)::$orderable, ['created_at']);
                      $this->viewData['data'] = model(PermissionModel::class)->asArray()->select(implode(',', $this->viewData['header']))->findAll();
                      $dompdf = new \Dompdf\Dompdf(); 
                      $dompdf->loadHtml(view('Themes\backend\metronic\layout\partials\extras\_pdf_view_export_datatable', $this->viewData));
                      $dompdf->setPaper('A4', 'landscape');
                      $dompdf->render();
                      $dompdf->stream();
                      exit;
                  }
      
                  break;
              default:
                  $response = ['code' => 200, 'message' => lang('Core.not_choice'), 'success' => true, csrf_token() => csrf_hash()];
                  return $this->respond($response, 200);
          }
      
      // }
      // return $this->respondNoContent();
        }
}