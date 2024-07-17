<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Zona;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Invitado;


class ZonaController extends Controller
{
    public function getSecciones(Request $request){
        try{
            // $user = Auth::user();
            // if($user->tipo_usuario_id == 1){
                $zonas = Zona::where('status',1)->get();
            // }
            // else{
                // $zonas = Zona::where('status',1)->where('user_id',$user->id)->get();
            // }

            $array_zonas = array();
            $cont = 1;
            foreach($zonas as $zona){
                $objectZona = new \stdClass();
                $objectZona->id = $zona->id;
                $objectZona->numero_registro = $cont;
                $objectZona->nombre = $zona->nombre;
                $objectZona->color = $zona->color;
                // $objectEvento->sede = $evento->sede;
                // $objectEvento->fecha_i = $evento->fecha_inicial;
                // $objectEvento->fecha_f = $evento->fecha_final;
                // $objectEvento->domicilio_sede = $evento->domicilio_sede;
                // $objectEvento->ubicacion = $evento->ubicacion;
                // $objectEvento->horario = $evento->horario;
                array_push($array_zonas, $objectZona);
                $cont++;
            }

            return response()->json([
                "status" => "ok",
                "message" => "Secciones obtenidos con exito",
                "secciones" => $array_zonas
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

    public function guardarSeccion(Request $request){

        $user = Auth::user();
        $exito = false;
        DB::beginTransaction();
        try{

            $zona = new Zona;
            $zona->nombre = $request->nombre;
            $zona->color = $request->color;
            // $zona->sede = $request->sede;
            // $zona->fecha_inicial = $request->fecha_i;
            // $zona->fecha_final = $request->fecha_f;
            // $zona->horario = $request->horario;
            // $zona->domicilio_sede = $request->domicilio;
            // $zona->ubicacion = $request->ubicacion;
            // $zona->user_id = $user->id;
            $zona->save();

            $zonas = Zona::where('status',1)->get();
            $array_zonas = array();
            $cont = 1;
            foreach($zonas as $zona){
                $objectZona = new \stdClass();
                $objectZona->id = $zona->id;
                $objectZona->numero_registro = $cont;
                $objectZona->nombre = $zona->nombre;
                $objectZona->color = $zona->color;
                // $objectEvento->sede = $evento->sede;
                // $objectEvento->fecha_i = $evento->fecha_inicial;
                // $objectEvento->fecha_f = $evento->fecha_final;
                // $objectEvento->domicilio_sede = $evento->domicilio_sede;
                // $objectEvento->ubicacion = $evento->ubicacion;
                // $objectEvento->horario = $evento->horario;
                array_push($array_zonas, $objectZona);
                $cont++;
            }


            DB::commit();
            $exito = true;
        }catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al generar la nueva seccion.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Nueva Secion guardada con exito.",
                "secciones" => $array_zonas
            ], 200);
        }

    }
    public function actualizarSeccion(Request $request){
        
        $exito = false;
        $user = Auth::user();
        DB::beginTransaction();
        try {
            $seccion = Zona::find($request->id);
            $seccion->nombre = $request->nombre;
            $seccion->color = $request->color;
            // $seccion->sede = $request->sede;
            // $seccion->fecha_inicial = $request->fecha_i;
            // $seccion->fecha_final = $request->fecha_f;
            // $seccion->horario = $request->horario;     
            // $seccion->domicilio_sede = $request->domicilio;
            // $seccion->ubicacion = $request->ubicacion;       
            $seccion->save();
            
            $zonas = Zona::where('status',1)->get();
            $array_zonas = array();
            $cont = 1;
            foreach($zonas as $zona){
                $objectZona = new \stdClass();
                $objectZona->id = $zona->id;
                $objectZona->numero_registro = $cont;
                $objectZona->nombre = $zona->nombre;
                $objectZona->color = $zona->color;
                // $objectEvento->sede = $evento->sede;
                // $objectEvento->fecha_i = $evento->fecha_inicial;
                // $objectEvento->fecha_f = $evento->fecha_final;
                // $objectEvento->domicilio_sede = $evento->domicilio_sede;
                // $objectEvento->ubicacion = $evento->ubicacion;
                // $objectEvento->horario = $evento->horario;
                array_push($array_zonas, $objectZona);
                $cont++;
            }
            
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al actualizar los datos de la seccion.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Seccion actualizada con exito.",
                "secciones" => $array_zonas
            ], 200);
        }
    }

    public function eliminarSeccion(Request $request){
        $user = Auth::user();
        $exito = false;
        DB::beginTransaction();
        try {
            $seccion = Zona::find($request->id);
            $seccion->status = false;
            $seccion->save();

            // $invitados= Invitado::where('evento_id',$request->id)->where('status',1)->get();

            // foreach($invitados as $invitado){
            //     $invitado->status = false;
            //     $invitado->save();
            // }


            $zonas = Zona::where('status',1)->get();
            $array_zonas = array();
            $cont = 1;
            foreach($zonas as $zona){
                $objectZona = new \stdClass();
                $objectZona->id = $zona->id;
                $objectZona->numero_registro = $cont;
                $objectZona->nombre = $zona->nombre;
                $objectZona->color = $zona->color;
                // $objectEvento->sede = $evento->sede;
                // $objectEvento->fecha_i = $evento->fecha_inicial;
                // $objectEvento->fecha_f = $evento->fecha_final;
                // $objectEvento->domicilio_sede = $evento->domicilio_sede;
                // $objectEvento->ubicacion = $evento->ubicacion;
                // $objectEvento->horario = $evento->horario;
                array_push($array_zonas, $objectZona);
                $cont++;
            }

            DB::commit();
            $exito = true;
        }catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al eliminar la seccion.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Seccion eliminada con exito.",
                "secciones" => $array_zonas
            ], 200);
        }
    }
    public function SeccionesConteo(Request $request){
        try{

            $zonas = Zona::where('status',1)->get();
            
            $array_zonas = array();
            foreach($zonas as $zona){

                $objectZona = new \stdClass();
                $objectZona->id = $zona->id;
                $objectZona->nombre = $zona->nombre;

                $confirmados = Invitado::where('status',1)->where('zona_id',$zona->id)->where('confirmo',1)->where('evento_id',$request->evento_id)->count();
                $ingresados = Invitado::where('status',1)->where('zona_id',$zona->id)->where('verificado',1)->where('evento_id',$request->evento_id)->count();
                $pendientes = Invitado::where('status',1)->where('zona_id',$zona->id)->where('verificado',0)->where('evento_id',$request->evento_id)->count();
                $total_seccion = Invitado::where('status',1)->where('zona_id',$zona->id)->where('evento_id',$request->evento_id)->count();

                $objectZona->ingresados = $ingresados;
                $objectZona->pendientes = $pendientes;
                $objectZona->confirmados = $confirmados;
                $objectZona->total_seccion = $total_seccion;

                array_push($array_zonas, $objectZona);
            }

            return response()->json([
                "status" => "ok",
                "message" => "Secciones contadas obtenidas con éxito",
                "secciones" => $array_zonas
            ], 200);

        }catch(\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el conteo de las secciones",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }
}
