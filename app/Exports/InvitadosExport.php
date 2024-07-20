<?php

namespace App\Exports;

use App\Models\Invitados;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Excel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

// class InvitadosExport implements FromCollection,WithEvents,ShouldAutoSize
class InvitadosExport implements FromView, WithEvents,ShouldAutoSize
{
    use Exportable;
    use RegistersEventListeners;

    public $invitados;
    /**
    * @return \Illuminate\Support\Collection
    */

    function __construct($invitados)
    {
        $this->invitados = $invitados;
    }

    public function view() : view
    {
        return view('exports.invitados_export', [
            'invitados' => $this->invitados,
        ]);
    }

    public static function afterSheet(afterSheet $event)
    {
        $num_rows = 0;
        
        $title_font_style = [
            'font' => [
                'name' => 'Arial',
                'bold' => true,
            ]
        ];

        $heads_font_style = [
            'font' => [
                'name' => 'Arial',
                'bold' => true,
            ],
        ];
        
        $active_sheet = $event->sheet->getDelegate();
        $active_sheet->getStyle('A1:W1')->applyFromArray($heads_font_style);
    }
}
