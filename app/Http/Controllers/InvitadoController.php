<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Invitado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDF;



class InvitadoController extends Controller{
    public function getInvitados(Request $request){
        try {
            $invitados = Invitado::all();

            $array_invitados = array();
            $cont = 1;

            foreach ($invitados as $invitado) {
                $objectInvitado = new \stdClass();
                $objectInvitado->id = $invitado->id;
                $objectInvitado->numero_registro = $cont;
                $objectInvitado->nombre = $invitado->nombre;
                $objectInvitado->dependencia = $invitado->dependencia;
                $objectInvitado->area = $invitado->area;
                $objectInvitado->telefono = $invitado->telefono;
                $objectInvitado->email = $invitado->email;
                $objectInvitado->evento_id = $invitado->evento_id;
                
                array_push($array_invitados, $objectInvitado);
                $cont++;
            }

            return response()->json([
                "status" => "ok",
                "message" => "Invitados obtenidos con exito",
                "invitados" => $array_invitados
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el catalogo de invitados",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }
    public function guardarInvitado(Request $request){
        $exito = false;

        DB::beginTransaction();
        try {
            
                $invitado = new Invitado;
                $invitado->nombre = $request->nombre;
                $invitado->dependencia = $request->dependencia;
                $invitado->area = $request->area;
                $invitado->telefono = $request->telefono;
                $invitado->email = $request->email;
                $invitado->folio = Str::random(10);
                $invitado->evento_id = 1;
                $invitado->save();

                $invitados = Invitado::where('evento_id', $request->evento_id)->get();

                $array_invitados = array();
                $cont = 1;

                foreach ($invitados as $invitado) {
                    $objectInvitado = new \stdClass();
                    $objectInvitado->id = $invitado->id;
                    $objectInvitado->numero_registro = $cont;
                    $objectInvitado->nombre = $invitado->nombre;
                    $objectInvitado->dependencia = $invitado->dependencia;
                    $objectInvitado->area = $invitado->area;
                    $objectInvitado->telefono = $invitado->telefono;
                    $objectInvitado->email = $invitado->email;
                    $objectInvitado->evento_id = $invitado->evento_id;
                    
                    array_push($array_invitados, $objectInvitado);
                    $cont++;
                }

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al generar al nuevo invitado.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Nuevo invitado guardado con exito.",
                "invitados" => $array_invitados
            ], 200);
        }
    }
    public function actualizarInvitado(Request $request){
        
        $exito = false;

        DB::beginTransaction();
        try {
            $invitado = Invitado::find($request->id);
            $invitado->nombre = $request->nombre;
            $invitado->dependencia = $request->dependencia;
            $invitado->area = $request->area;
            $invitado->telefono = $request->telefono;
            $invitado->email = $request->email;
            $invitado->evento_id = $request->evento_id;            
            $invitado->save();
            
            $invitados = Invitado::where('evento_id', $request->evento_id)->get();

                $array_invitados = array();
                $cont = 1;

                foreach ($invitados as $invitado) {
                    $objectInvitado = new \stdClass();
                    $objectInvitado->id = $invitado->id;
                    $objectInvitado->numero_registro = $cont;
                    $objectInvitado->nombre = $invitado->nombre;
                    $objectInvitado->dependencia = $invitado->dependencia;
                    $objectInvitado->area = $invitado->area;
                    $objectInvitado->telefono = $invitado->telefono;
                    $objectInvitado->email = $invitado->email;
                    $objectInvitado->evento_id = $invitado->evento_id;
                    
                    array_push($array_invitados, $objectInvitado);
                    $cont++;
                }
            
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al actualizar los datos del invitado.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Invitado actualizado con exito.",
                "invitados" => $array_invitados
            ], 200);
        }
    }
    
    public function eliminarInvitado(Request $request){
        
        $exito = false;

        DB::beginTransaction();
        try {

            $invitado = Invitado::find($request->id);
            $invitado->status = false;
            $invitado->save();

            $invitados = Invitado::where('evento_id', $request->evento_id)->get();

            $array_invitados = array();
            $cont = 1;

            foreach ($invitados as $invitado) {
                $objectInvitado = new \stdClass();
                $objectInvitado->id = $invitado->id;
                $objectInvitado->numero_registro = $cont;
                $objectInvitado->nombre = $invitado->nombre;
                $objectInvitado->dependencia = $invitado->dependencia;
                $objectInvitado->area = $invitado->area;
                $objectInvitado->telefono = $invitado->telefono;
                $objectInvitado->email = $invitado->email;
                $objectInvitado->evento_id = $invitado->evento_id;
                
                array_push($array_invitados, $objectInvitado);
                $cont++;
            }

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al eliminar a este invitado.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Invitado eliminado con exito.",
                "invitados" => $array_invitados
            ], 200);
        }
    }
    public function generarCodigoQR(Request $request){

        $invitado = Invitado::find($request->id);
        PDF::reset();

        $PDF_MARGIN_LEFT = 5;
        $PDF_MARGIN_TOP = 30;
        $PDF_MARGIN_RIGHT = 5;
        $PDF_MARGIN_BOTTOM = 20;

        PDF::SetMargins($PDF_MARGIN_LEFT, $PDF_MARGIN_TOP, $PDF_MARGIN_RIGHT,$PDF_MARGIN_BOTTOM);
        PDF::SetAutoPageBreak(true, $PDF_MARGIN_BOTTOM);

        PDF::AddPage();

        PDF::Ln(10);
    
        $style = array(
            'border' => false,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );

        PDF::Image('../public/img/letras_poder_judicial.png', 172, 238 , 20, 5, '', '', '', false, 200, '', false, false, 0);
        // PDF::write2DBarcode('http://validaciondocumentos.pjpuebla.gob.mx/validar-oficio?codigo='.$oficio->codigo, 'QRCODE,M', 172, 218, 20, 20, $style, 'N');
       PDF::write2DBarcode('http://control_invitados.test/validar-invitado?folio='.$invitado->folio, 'QRCODE,M', 91, 205, 30, 30, $style, 'N');
       // PDF::SetFont('','B',9);
       // PDF::Text(85, 200, 'OFICIO NÚMERO : '.$oficio->num_oficio);
       // PDF::SetFont('','',9);
       // PDF::Text(169, 236, 'pjpuebla.gob.mx');
       // PDF::Text(74, 209, 'DE ESTE OFICIO ESCANEA EL QR');

        PDF::Output('Código.pdf');
    }
    public function buscarFolio(Request $request) {

        try {
            $invitado = Invitado::where('folio',$request->folio)->first();
            // dd($request->folio);
            if($invitado){
                if($invitado->verificado == 0){
                    return response()->json([
                        "status" => "ok",
                        "message" => "Folio encontrada con éxito",
                        // "cita" => $request->folio
                    ], 200);
                }
                if($invitado->verificado == 1){
                    return response()->json([
                        "status" => "usado",
                        "message" => "Folio ya usado",
                        // "cita" => $request->folio
                    ], 200);
                }
            }
           else{
                return response()->json([
                    "status" => "no_existe",
                    "message" => "Folio no existe",
                    // "cita" => $request->folio
                ], 200);
            }
            // $objectInvitado = new \stdClass();
            // $objectInvitado->id = $invitado->id;
            // $objectInvitado->nombre = $invitado->nombre;
            // $objectInvitado->dependencia = $invitado->dependencia;
            // $objectInvitado->area = $invitado->area;
            // $objectInvitado->telefono = $invitado->telefono;
            // $objectInvitado->email = $invitado->email;
            // $objectInvitado->folio = $invitado->folio;
            // $objectInvitado->verificado = $invitado->verificado;
            // $objectInvitado->evento_id = $invitado->evento_id;

            // return response()->json([
            //     "status" => "ok",
            //     "message" => "Invitado encontrado.",
            //     "folio" => $objectInvitado
            // ], 200);
            

           
        }catch (\Throwable $th) {
           
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al encontrar al invitado.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
       
    }
}
