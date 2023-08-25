<?php
namespace App\Http\Controllers;

use App\Models\BorrowDevice;
use App\Models\User;
use Illuminate\Http\Request;
use Redirect;
use PDF;

class PDFController extends Controller
{
    public function exportPDF($id)
{
    $user = User::find($id);
    $imagePath = public_path('images/your_image.jpg');

    $pdf = PDF::loadView('users.pdf', compact('user', 'imagePath'))->setPaper('a4', 'landscape');
    return $pdf->download('phieumuon.pdf');
}

}
