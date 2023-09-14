<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class ExportUserHistoryBook extends Controller
{
    public function export_history_book($id)
    {
        // dd(123);
        $user = User::findOrFail($id);
        $borrows = Borrow::where('user_id', $id)->get();

        // Đường dẫn đến mẫu Excel đã có sẵn
        $templatePath = public_path('uploads/so-muon-v2.xlsx');


         // Tạo một Spreadsheet từ mẫu
        $reader = IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load($templatePath);


        // Lấy sheet hiện tại
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('D2', $user->name);
        $sheet->setCellValue('H2', '');
        $sheet->setCellValue('K2', $user->nest->name);
        $sheet->getStyle('K2')->getFont()->setSize(14);

        // dd($borrows);
        $index = 6;
        foreach ($borrows as $key => $borrow) {
            // dd($borrow->the_devices);
            foreach ($borrow->the_devices as $device) {
                //cột ngày mượn
                $sheet->setCellValue('A' . $index, $borrow->borrow_date);
                $sheet->setCellValue('B' . $index, $device->return_date);
                $sheet->setCellValue('C' . $index, '');
                $sheet->setCellValue('D' . $index, '');
                $sheet->setCellValue('E' . $index, $device->device->name);
                $sheet->setCellValue('F' . $index, $device->quantity);
                $sheet->setCellValue('G' . $index, $device->lecture_name);
                $sheet->setCellValue('H' . $index, $device->lesson_name);
                $sheet->setCellValue('I' . $index, $device->room->name);
                $sheet->setCellValue('J' . $index, '');
                $sheet->setCellValue('K' . $index, '');
                $index++;
            }
        }

        $spreadsheet->setActiveSheetIndex(0);
        $newFilePath = public_path('storage/uploads/so-muon-'.time().'.xlsx');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newFilePath);


        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
        $writer->save($newFilePath);
        return response()->download($newFilePath)->deleteFileAfterSend(true);

    }
}
