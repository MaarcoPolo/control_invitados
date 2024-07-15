<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Invitado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDF;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCorreo;





class InvitadoController extends Controller{

    public function getInvitados(Request $request){
        try {
            // $invitados = Invitado::all();
            if($request->evento_id){
                $invitados = Invitado::where('evento_id', $request->evento_id)->where('status',1)->get();
            }else{
                $invitados = Invitado::all();
            }


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
                $invitado->evento_id = $request->evento_id;
                $invitado->save();

                $invitados = Invitado::where('evento_id', $request->evento_id)->where('status',1)->get();

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
            
            $invitados = Invitado::where('evento_id', $request->evento_id)->where('status',1)->get();

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

            $invitados = Invitado::where('evento_id', $request->evento_id)->where('status',1)->get();

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

            //header
            PDF::setHeaderCallBack(function($pdf){
                $logo = public_path() . '/img/logo_poder_j.png';
                $pdf->Image($logo,26,0,160,45);
            });

            $style = array(
                'border' => 2,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0,0,0),
                'bgcolor' => false, //array(255,255,255)
                'module_width' => 1, // width of a single module in points
                'module_height' => 1 // height of a single module in points
            );



            $view = View::make('pdf.invitacion', compact('invitado'));
            $html_content = $view->render();

            $PDF_MARGIN_LEFT = 15;
            $PDF_MARGIN_TOP = 30;
            $PDF_MARGIN_RIGHT = 15;
            $PDF_MARGIN_BOTTOM = 05;

            PDF::SetMargins($PDF_MARGIN_LEFT, $PDF_MARGIN_TOP, $PDF_MARGIN_RIGHT,$PDF_MARGIN_BOTTOM);
            PDF::SetAutoPageBreak(true, $PDF_MARGIN_BOTTOM);
            
            PDF::AddPage('P', 'A4');

            PDF::writeHTML($html_content, true, false, true, false, '');
            PDF::write2DBarcode('http://control_invitados.test/validar-invitado?folio='.$invitado->folio, 'QRCODE,M', 85, 210, 50, 50, $style, 'N');

            PDF::Text(65, 265, 'ESPERANDO CONTAR SON SU PRESENCIA');
            PDF::Text(10, 280, 'FIRMA');
            PDF::Text(180, 280, 'FIRMA2');


            ob_end_clean();

            PDF::Output('Código.pdf');


        // PDF::reset();

        

    
       

        // PDF::Image('../public/img/letras_poder_judicial.png', 95, 150 , 30, 15, '', '', '', false, 200, '', false, false, 0);
        // PDF::SetFont('','B',9);
        // PDF::Text(85, 160, $invitado->evento->nombre);
        // PDF::Text(85, 170, $invitado->nombre);
        // PDF::Text(85, 180, $invitado->dependencia);
        // PDF::Text(85, 190, $invitado->area);
        // PDF::write2DBarcode('http://validaciondocumentos.pjpuebla.gob.mx/validar-oficio?codigo='.$oficio->codigo, 'QRCODE,M', 172, 218, 20, 20, $style, 'N');
       // PDF::SetFont('','B',9);
        

    }
    public function buscarFolio(Request $request) {

        try {
            $invitado = Invitado::where('folio',$request->folio)->first();
            // dd($request->folio);
            if($invitado){

                if($invitado->verificado == 0){
                    DB::beginTransaction();

                    $invitado->verificado = 1;
                    $invitado->save();

                    DB::commit();
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
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al encontrar al invitado.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }
    public function buscarInvitado(Request $request) {

        try {
            $invitados = Invitado::where('evento_id', $request->evento_id)->where('status',1)->get();

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
                "message" => "Invitados encontrados.",
                "invitados" => $array_invitados
            ], 200);
    
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
    public function enviarCorreo(Request $request) {

        $invitado = Invitado::find($request->id);


        Mail::to($invitado->email)->send(new EnviarCorreo($invitado, $pdf));

    }

}
