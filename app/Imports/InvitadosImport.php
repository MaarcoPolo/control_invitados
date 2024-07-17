<?php

namespace App\Imports;

use App\Models\Invitado;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
// use Maatwebsite\Excel\Concerns\ToModel;

// class InvitadosImport implements ToModel
class InvitadosImport implements ToCollection
{
    private $evento_id = null;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function __construct($evento_id)
    {
        $this->evento_id = $evento_id;
        
    }
    public function collection(collection $rows)
    {
        foreach($rows as $row)
        {
            $inv = new \stdClass();
            $inv->ninvitado = $row[0];

            // dd($inv);
            Invitado::create([
                'n_invitado' => $inv->ninvitado,
                'nombre' => $row[1], 
                'apellido_p' => $row[2],
                'apellido_m' => $row[3],
                'dependencia' => $row[4],
                'cargo' => $row[5],
                'area' => $row[6],
                'telefono' => $row[7],
                'email' => $row[8],
                'folio' => $row[9],            
                'hora_ingreso' => $row[10],
                'estado' => $row[11],
                'municipio' => $row[12],
                'evento_id' => $this->evento_id
                // 'evento_id' => 3
            ]);
        }
    }
    // public function model(array $row)
    // {
    //     return new Invitado([
    //         'n_invitado' => $row[0],
    //         'nombre' => $row[1], 
    //         'apellido_p' => $row[2],
    //         'apellido_m' => $row[3],
    //         'dependencia' => $row[4],
    //         'cargo' => $row[5],
    //         'area' => $row[6],
    //         'telefono' => $row[7],
    //         'email' => $row[8],
    //         'folio' => $row[9],            
    //         'hora_ingreso' => $row[10],
    //         'estado' => $row[11],
    //         'municipio' => $row[12],
    //         'evento_id' => 3
    //     ]);
    // }
}
