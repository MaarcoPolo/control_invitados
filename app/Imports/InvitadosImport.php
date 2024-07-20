<?php

namespace App\Imports;

use App\Models\Invitado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
// use App\Models\Invitado;
// use Maatwebsite\Excel\Concerns\ToModel;

// class InvitadosImport implements ToModel
class InvitadosImport implements ToCollection, WithHeadingRow
{
    public $evento_id;
    public $n_invitados;
    public $zona_id;
    public $cont;
    public $total;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    

    public function __construct($evento_id,$n_invitados,$zona_id)
    {
        $this->evento_id = $evento_id;  
        $this->n_invitados = $n_invitados+1;
        $this->zona_id = $zona_id;

        // return $this->$cont;
    }
    public function collection(collection $rows)
    {
        $array = [];
        $tamaño = count($rows);
        $cont = 1;
        $cont_insert= 0;
        foreach($rows as $row)
        {
            if($row["email"] != ''){
                if($invitado = Invitado::where('nombre',$row["nombre"])
                    ->where('apellido_p',$row["apellido_paterno"])
                    ->where('apellido_m',$row["apellido_materno"])
                    ->where('dependencia',$row["dependencia"])
                    ->where('cargo',$row["cargo"])
                    ->where('area',$row["area"])
                    ->where('telefono',$row["telefono"])
                    ->where('email',$row["email"])
                    ->where('status',1)
                    ->exists()){

                // return response()->json([
                //     "status" => "ok",
                //     "message" => "Registro duplicado.",
                // ], 200); 
                }else{
                    if($cont <= (count($rows)))
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
                    $cont_insert++;
                    }

                }

            }
        }
        $this->cont = $cont_insert;
        $this->total = $tamaño;
        // return $total;
    }

    public function ruler()
    {
        return [
            '1' => Rule::in(['flopez@pjpuebla.gob.mx']),
            // 'nombre' => Rule::notIn(['vacio o null'])
        ];
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
