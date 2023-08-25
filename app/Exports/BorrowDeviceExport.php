<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\BorrowDevice;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\WithTitle;

class BorrowDeviceExport implements FromView
{
    // protected $data;

    // public function __construct(array $data)
    // {
    //     $this->data = $data;
    // }

    public function view(): View
    {
        $changeStatus = [
            1 => 'chưa trả',
            2=> 'Đã trả'
        ];
        $BorrowDevices = BorrowDevice::all();
        return view('exportExcel.BorrowDevice',[

            'BorrowDevices'=> $BorrowDevices,
            'changeStatus' => $changeStatus
        ]); 
    }
    
        
    
}