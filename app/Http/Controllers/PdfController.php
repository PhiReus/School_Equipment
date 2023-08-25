<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\BorrowDevice;
use App\Models\User;
use PDF;

class PDFController extends Controller
{
    public function exportPDF($id)
    {
        $item = BorrowDevice::with('borrow', 'user', 'room', 'device')->orderBy('id', 'DESC')->findOrFail($id);
        $changeStatus = [
            0 => 'Chưa trả',
            1 => 'Đã trả',
        ];
        $pdf = PDF::loadView('borrows.pdf', compact('item', 'changeStatus'))->setPaper('a4', 'landscape');
        return $pdf->download('phieumuon.pdf');
    }
}
