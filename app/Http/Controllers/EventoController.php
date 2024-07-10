<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Evento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    public function getEventos(Request $request){
        try{
            $user = Auth::user();
            if($user->tipo_usuario_id == 1){
                $eventos = Evento::where('status',1)->get();
            }
            else{
                $eventos = Evento::where('status',1)->where('user_id',$user->id)->get();
            }

            $array_eventos = array();
            $cont = 1;
            foreach($eventos as $evento){
                $objectEvento = new \stdClass();
                $objectEvento->id = $evento->id;
                $objectEvento->numero_registro = $cont;
                $objectEvento->nombre = $evento->nombre;
                $objectEvento->organizador = $evento->organizador;
                $objectEvento->sede = $evento->sede;
                $objectEvento->fecha_i = $evento->fecha_inicial;
                $objectEvento->fecha_f = $evento->fecha_final;
                array_push($array_eventos, $objectEvento);
                $cont++;
            }

            return response()->json([
                "status" => "ok",
                "message" => "Eventos obtenidos con exito",
                "eventos" => $array_eventos
            ], 200);

        }catch(\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener los eventos",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }
}
