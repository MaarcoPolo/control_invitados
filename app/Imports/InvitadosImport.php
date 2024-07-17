<?php

namespace App\Imports;

use App\Models\Invitado;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
// use Maatwebsite\Excel\Concerns\ToModel;

// class InvitadosImport implements ToModel
class InvitadosImport implements ToCollection, WithHeadingRow
{
    public $evento_id;
    public $n_invitados;
    public $zona_id;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function __construct($evento_id,$n_invitados)
    {
        $this->evento_id = $evento_id;  
        $this->n_invitados = $n_invitados+1;
        $this->zona_id = $zona_id;
    }
    public function collection(collection $rows)
    {
        $array = [];
        $tamaño = count($rows);
        $cont = 1;
        foreach($rows as $row)
        {
            if($cont <= (count($rows)-1))
            {
                Invitado::create([
                    'n_invitado' => $this->n_invitados,
                    'nombre' => $row["nombre"], 
                    'apellido_p' => $row["apellido_paterno"],
                    'apellido_m' => $row["apellido_materno"],
                    'dependencia' => $row["dependencia"],
                    'cargo' => $row["cargo"],
                    'area' => $row["area"],
                    'telefono' => $row["telefono"],
                    'email' => $row['email'],
                    'folio' => $this->evento_id.'-'.Str::random(10),          
                    // 'hora_ingreso' => $row["hora_ingreso"],
                    'estado' => $row["estado"],
                    'municipio' => $row["municipio"],
                    'zona_id' => $this->zona_id,
                    'evento_id' => $this->evento_id,

                    //n_invitado = cont obtener numero de invitados
                    //folio evento_id + - + rand(10)
                ]);
                $this->n_invitados++;
                // Invitado::create([
                //     'n_invitado' => $row[0],
                //     'nombre' => $row[1], 
                //     'apellido_p' => $row[2],
                //     'apellido_m' => $row[3],
                //     'dependencia' => $row[4],
                //     'cargo' => $row[5],
                //     'area' => $row[6],
                //     'telefono' => $row[7],
                //     'email' => $row[8],
                //     'folio' => $row[9],            
                //     'hora_ingreso' => $row[10],
                //     'estado' => $row[11],
                //     'municipio' => $row[12],
                //     'evento_id' => $this->evento_id,
                // ]);
                $cont++;
            }
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
