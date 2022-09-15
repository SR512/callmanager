<?php

namespace App\Exports;

use App\Models\SmsLogs;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SmsLogExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths,WithEvents
{
    public $params;

    /**
     * SmsLogExport constructor.
     */
    public function __construct($params)
    {
        $this->params = $params;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return SmsLogs::when(!empty($this->params['query_str']), function ($query) {
            $query->whereHas('users', function ($query) {
                $query->where('name', 'LIKE', '%' . $this->params['query_str'] . "%");
            });
        })->when(!empty($this->params['status']), function ($query) {
            $query->where('is_send', $this->params['status']);
        })->when(auth()->user()->getRole() ==  config('constants.USER'),function ($query){
            $query->where('user_id',auth()->id());
        })->get()->map(function (SmsLogs $smsLogs) {
            return [
                'Date' => $smsLogs->date_formatted,
                'User' => $smsLogs->users->name,
                'Device' => !empty($smsLogs->devices)?$smsLogs->devices->device_code:'',
                'Message' => $smsLogs->message,
                'Error' => $smsLogs->error,
                'Status' => $smsLogs->is_send == 'Y' ?'Sent':'Fail',
            ];
        });
    }

    public function headings(): array
    {
        return ["Date", "User", "Device", 'Message', 'Error', 'Status'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 20,
            'D' => 50,
            'E' => 50,
            'F' => 20,
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A:F'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal('left');
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setVertical('top');
            }
        ];
    }
}
