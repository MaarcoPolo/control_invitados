<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Invitado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    public function getEventos(Request $request){
        try{
            $user = Auth::user();
            // if($user->tipo_usuario_id == 1){
                $eventos = Evento::where('status',1)->get();
            // }
            // else{
            //     $eventos = Evento::where('status',1)->where('user_id',$user->id)->get();
            // }

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
                $objectEvento->domicilio_sede = $evento->domicilio_sede;
                $objectEvento->ubicacion = $evento->ubicacion;
                $objectEvento->horario = $evento->horario;
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

    public function guardarEvento(Request $request){

        $user = Auth::user();
        $exito = false;
        DB::beginTransaction();
        try{

            $evento = new Evento;
            $evento->nombre = $request->nombre;
            $evento->organizador = $request->organizador;
            $evento->sede = $request->sede;
            $evento->fecha_inicial = $request->fecha_i;
            $evento->fecha_final = $request->fecha_f;
            $evento->horario = $request->horario;
            $evento->domicilio_sede = $request->domicilio;
            $evento->ubicacion = $request->ubicacion;
            $evento->user_id = $user->id;
            $evento->save();

            $eventos = Evento::where('status',1)->where('user_id',$user->id)->get();
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
                $objectEvento->domicilio_sede = $evento->domicilio_sede;
                $objectEvento->ubicacion = $evento->ubicacion;
                $objectEvento->horario = $evento->horario;
                array_push($array_eventos, $objectEvento);
                $cont++;
            }


            DB::commit();
            $exito = true;
        }catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al generar el nuevo evento.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Nuevo Evento guardado con exito.",
                "eventos" => $array_eventos
            ], 200);
        }

    }

    public function actualizarEvento(Request $request){
        
        $exito = false;
        $user = Auth::user();
        DB::beginTransaction();
        try {
            $evento = Evento::find($request->id);
            $evento->nombre = $request->nombre;
            $evento->organizador = $request->organizador;
            $evento->sede = $request->sede;
            $evento->fecha_inicial = $request->fecha_i;
            $evento->fecha_final = $request->fecha_f;
            $evento->horario = $request->horario;     
            $evento->domicilio_sede = $request->domicilio;
            $evento->ubicacion = $request->ubicacion;       
            $evento->save();
            
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
                $objectEvento->domicilio_sede = $evento->domicilio_sede;
                $objectEvento->ubicacion = $evento->ubicacion;
                $objectEvento->horario = $evento->horario;
                array_push($array_eventos, $objectEvento);
                $cont++;
            }
            
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al actualizar los datos del evento.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Evento actualizado con exito.",
                "eventos" => $array_eventos
            ], 200);
        }
    }

    public function eliminarEvento(Request $request){
        $user = Auth::user();
        $exito = false;
        DB::beginTransaction();
        try {
            $evento = Evento::find($request->id);
            $evento->status = false;
            $evento->save();

            $invitados= Invitado::where('evento_id',$request->id)->where('status',1)->get();

            foreach($invitados as $invitado){
                $invitado->status = false;
                $invitado->save();
            }


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
                $objectEvento->domicilio_sede = $evento->domicilio_sede;
                $objectEvento->ubicacion = $evento->ubicacion;
                $objectEvento->horario = $evento->horario;
                array_push($array_eventos, $objectEvento);
                $cont++;
            }

            DB::commit();
            $exito = true;
        }catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al eliminar a este evento.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Evento eliminado con exito.",
                "eventos" => $array_eventos
            ], 200);
        }
    }
}
