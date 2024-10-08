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
use Carbon\Carbon;
use App\Models\Evento;
use App\Imports\InvitadosImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exports\InvitadosExport;
use Illuminate\Support\Facades\Storage;

class InvitadoController extends Controller{

    public function getInvitados(Request $request){
        try {
            
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
                $objectInvitado->apellido_p = $invitado->apellido_p;
                $objectInvitado->apellido_m = $invitado->apellido_m;
                $objectInvitado->nombreC = $invitado->nombre.' '.$invitado->apellido_p.' '.$invitado->apellido_m;
                $objectInvitado->dependencia = $invitado->dependencia;
                $objectInvitado->area = $invitado->area;
                $objectInvitado->telefono = $invitado->telefono;
                $objectInvitado->email = $invitado->email;
                $objectInvitado->evento_id = $invitado->evento_id;
                $objectInvitado->nombre_evento = $invitado->evento->nombre;
                $objectInvitado->zona = $invitado->zona->nombre;
                $objectInvitado->cargo = $invitado->cargo;
                $objectInvitado->parking = $invitado->con_parking;
                $objectInvitado->confirmo = $invitado->confirmo == 1 ? "SI" : "NO";
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
                $n_invitado = Invitado::where('evento_id', $request->evento_id)->where('status',1)->count();

            
                $invitado = new Invitado;
                $invitado->n_invitado = $n_invitado+1;
                $invitado->nombre = $request->nombre;
                $invitado->apellido_p = $request->apellido_p;
                $invitado->apellido_m = $request->apellido_m;
                $invitado->dependencia = $request->dependencia;
                $invitado->area = $request->area;
                $invitado->telefono = $request->telefono;
                $invitado->email = $request->email;
                $invitado->estado = $request->estado;
                $invitado->municipio = $request->municipio;
                $invitado->folio = $request->evento_id.'-'.Str::random(10);
                $invitado->evento_id = $request->evento_id;
                $invitado->zona_id = $request->seccion;
                $invitado->cargo = $request->cargo;
                $invitado->con_parking = $request->estacionamiento;
                $invitado->confirmo = $request->confirmo == 'SI' ? 1 : 0;
                $invitado->save();

                $invitados = Invitado::where('evento_id', $request->evento_id)->where('status',1)->get();

                $array_invitados = array();
                $cont = 1;
    
                foreach ($invitados as $invitado) {
                    $objectInvitado = new \stdClass();
                    $objectInvitado->id = $invitado->id;
                    $objectInvitado->numero_registro = $cont;
                    $objectInvitado->nombre = $invitado->nombre;
                    $objectInvitado->apellido_p = $invitado->apellido_p;
                    $objectInvitado->apellido_m = $invitado->apellido_m;
                    $objectInvitado->nombreC = $invitado->nombre.' '.$invitado->apellido_p.' '.$invitado->apellido_m;
                    $objectInvitado->dependencia = $invitado->dependencia;
                    $objectInvitado->area = $invitado->area;
                    $objectInvitado->telefono = $invitado->telefono;
                    $objectInvitado->email = $invitado->email;
                    $objectInvitado->evento_id = $invitado->evento_id;
                    $objectInvitado->nombre_evento = $invitado->evento->nombre;
                    $objectInvitado->zona = $invitado->zona->nombre;
                    $objectInvitado->cargo = $invitado->cargo;
                    $objectInvitado->parking = $invitado->con_parking;
                    $objectInvitado->confirmo = $invitado->confirmo == 1 ? "SI" : "NO";
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
            $invitado->apellido_p = $request->apellido_p;
            $invitado->apellido_m = $request->apellido_m;
            $invitado->dependencia = $request->dependencia;
            $invitado->cargo = $request->cargo;
            $invitado->area = $request->area;
            $invitado->telefono = $request->telefono;
            $invitado->email = $request->email;
            $invitado->estado = $request->estado;
            $invitado->municipio = $request->municipio;
            $invitado->zona_id = $request->seccion;
            $invitado->con_parking = $request->estacionamiento;
            $invitado->confirmo = $request->confirmo == 'SI' ? 1 : 0;
            $invitado->save();
            
            $invitados = Invitado::where('evento_id', $request->evento_id)->where('status',1)->get();

            $array_invitados = array();
            $cont = 1;

            foreach ($invitados as $invitado) {
                $objectInvitado = new \stdClass();
                $objectInvitado->id = $invitado->id;
                $objectInvitado->numero_registro = $cont;
                $objectInvitado->nombre = $invitado->nombre;
                $objectInvitado->apellido_p = $invitado->apellido_p;
                $objectInvitado->apellido_m = $invitado->apellido_m;
                $objectInvitado->nombreC = $invitado->nombre.' '.$invitado->apellido_p.' '.$invitado->apellido_m;
                $objectInvitado->dependencia = $invitado->dependencia;
                $objectInvitado->area = $invitado->area;
                $objectInvitado->telefono = $invitado->telefono;
                $objectInvitado->email = $invitado->email;
                $objectInvitado->evento_id = $invitado->evento_id;
                $objectInvitado->nombre_evento = $invitado->evento->nombre;
                $objectInvitado->zona = $invitado->zona->nombre;
                $objectInvitado->cargo = $invitado->cargo;
                $objectInvitado->parking = $invitado->con_parking;
                $objectInvitado->confirmo = $invitado->confirmo == 1 ? "SI" : "NO";
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
                $objectInvitado->apellido_p = $invitado->apellido_p;
                $objectInvitado->apellido_m = $invitado->apellido_m;
                $objectInvitado->nombreC = $invitado->nombre.' '.$invitado->apellido_p.' '.$invitado->apellido_m;
                $objectInvitado->dependencia = $invitado->dependencia;
                $objectInvitado->area = $invitado->area;
                $objectInvitado->telefono = $invitado->telefono;
                $objectInvitado->email = $invitado->email;
                $objectInvitado->evento_id = $invitado->evento_id;
                $objectInvitado->nombre_evento = $invitado->evento->nombre;
                $objectInvitado->zona = $invitado->zona->nombre;
                $objectInvitado->cargo = $invitado->cargo;
                $objectInvitado->parking = $invitado->con_parking;
                $objectInvitado->confirmo = $invitado->confirmo == 1 ? "SI" : "NO";
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
        $evento = Evento::find($request->evento_id);

        $date = new Carbon($evento->fecha_inicial);
        $f = $this->formatearFecha($date->dayOfWeek, $date->day, $date->month, $date->year);

        $h = Carbon::createFromFormat('H:i:s',$evento->horario)->format('H:i');

        if($h >= '13:00'){
            $w = 'PM';
        }else{
            $w = 'AM';
        }
        $hora = $h.' '.$w;

            $style = array(
                'border' => 0,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0,0,0),
                'bgcolor' => false, //array(255,255,255)
                'module_width' => 1, // width of a single module in points
                'module_height' => 1 // height of a single module in points
            );

            $view = View::make('pdf.invitacion', compact('invitado','evento','f','hora'));
            $html_content = $view->render();

            $PDF_MARGIN_LEFT = 15;
            $PDF_MARGIN_TOP = 30;
            $PDF_MARGIN_RIGHT = 15;
            $PDF_MARGIN_BOTTOM = 05;

            PDF::SetMargins($PDF_MARGIN_LEFT, $PDF_MARGIN_TOP, $PDF_MARGIN_RIGHT,$PDF_MARGIN_BOTTOM);
            PDF::SetAutoPageBreak(true, $PDF_MARGIN_BOTTOM);
            
            PDF::AddPage('P', 'A4');

            $bMargin = PDF::getBreakMargin();
            // get current auto-page-break mode
            $auto_page_break = PDF::getAutoPageBreak();
            // disable auto-page-break
            PDF::SetAutoPageBreak(false, 0);
            // set bacground image
            // $img_file = Storage::url($evento->fondo); 
            $img_file = public_path() . '/storage/'.$evento->fondo;
            // dd($img_file);
            PDF::Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
            // restore auto-page-break status
            PDF::SetAutoPageBreak($auto_page_break, $bMargin);
            // set the starting point for the page content
            PDF::setPageMark();

            PDF::writeHTML($html_content, true, false, true, false, '');
            PDF::write2DBarcode('https://eventos.pjpuebla.gob.mx/validar-invitado?folio='.$invitado->folio, 'QRCODE,M', 70, 198, 70, 70, $style, 'N');

            PDF::Text(65, 275, 'CÓDIGO DE VESTIMENTA: FORMAL');

            ob_end_clean();

            PDF::Output();
        

    }
    public function buscarFolio(Request $request) {
        $current_day = Carbon::now();
        try {
            $user = Auth::user();
            if($user->tipo_usuario_id == 3){
                $invitado = Invitado::where('folio',$request->folio)->where('status',1)->first();
                if($invitado){
                    $hora = $current_day->toTimeString();
                    if($invitado->verificado == 0){
                        DB::beginTransaction();
                        $invitado->hora_ingreso = $hora;
                        $invitado->verificado = 1;
                        $invitado->save();
    
                        DB::commit();
                        return response()->json([
                            "status" => "ok",
                            "message" => "Folio encontrada con éxito",
                            "nombre" => $invitado->nombre.' '.$invitado->apellido_p.' '.$invitado->apellido_m,
                            "cargo" => $invitado->cargo,
                            "zona" => $invitado->zona->nombre,
                            "color" => $invitado->zona->color,
                        ], 200);
                    }
                    if($invitado->verificado == 1){
    
                        return response()->json([
                            "status" => "usado",
                            "message" => "Folio ya usado",
                            "nombre" => $invitado->nombre.' '.$invitado->apellido_p.' '.$invitado->apellido_m,
                            "hora" => $invitado->hora_ingreso
                        ], 200);
                    }
                }
                else{
                    return response()->json([
                        "status" => "no_existe_e",
                        "message" => "Folio no existe",
                    ], 200);
                } 

            }else{
                $invitado = Invitado::where('folio',$request->folio)->where('status',1)->first();
                if($invitado){
                    if($invitado->con_parking == 1){
                        if($invitado->parking == 1){
                            return response()->json([
                                "status" => "entro_antes",
                                "message" => "Accedio con anterioridad",
                                "nombre" => $invitado->nombre.' '.$invitado->apellido_p.' '.$invitado->apellido_m,
                                "cargo" => $invitado->cargo,
                                "zona" => $invitado->zona->nombre,
                            ], 200);

                        }else if($invitado->parking == 0){
                            DB::beginTransaction();
                            $invitado->parking = 1;
                            $invitado->save();
        
                            DB::commit();
                            return response()->json([
                                "status" => "entro",
                                "message" => "Llego al estacionamiento",
                                "nombre" => $invitado->nombre.' '.$invitado->apellido_p.' '.$invitado->apellido_m,
                                "cargo" => $invitado->cargo,
                                "zona" => $invitado->zona->nombre,
                            ], 200);

                        }
                        
                    }
                    if($invitado->con_parking == 0){
    
                        // $nombre =$invitado->nombre;
                        return response()->json([
                            "status" => "sin_estacionamiento",
                            "message" => "No tiene Aceso al estacionamiento",
                        ], 200);
                    }
                }
                else{
                    return response()->json([
                        "status" => "no_existe",
                        "message" => "Folio no existe",
                    ], 200);
                } 

            }
                    

        
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
                    $objectInvitado->apellido_p = $invitado->apellido_p;
                    $objectInvitado->apellido_m = $invitado->apellido_m;
                    $objectInvitado->nombreC = $invitado->nombre.' '.$invitado->apellido_p.' '.$invitado->apellido_m;
                    $objectInvitado->dependencia = $invitado->dependencia;
                    $objectInvitado->area = $invitado->area;
                    $objectInvitado->telefono = $invitado->telefono;
                    $objectInvitado->email = $invitado->email;
                    $objectInvitado->evento_id = $invitado->evento_id;
                    $objectInvitado->nombre_evento = $invitado->evento->nombre;
                    $objectInvitado->zona = $invitado->zona->nombre;
                    $objectInvitado->cargo = $invitado->cargo;
                    $objectInvitado->estado = $invitado->estado;
                    $objectInvitado->municipio = $invitado->municipio;
                    $objectInvitado->seccion = $invitado->zona_id;
                    $objectInvitado->parking = $invitado->con_parking;
                    $objectInvitado->confirmo = $invitado->confirmo == 1 ? "SI" : "NO";
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
        
        try{
        $invitado = Invitado::find($request->id);
        $evento = Evento::find($request->evento_id);

        $date = new Carbon($evento->fecha_inicial);
        $f = $this->formatearFecha($date->dayOfWeek, $date->day, $date->month, $date->year);

        $h = Carbon::createFromFormat('H:i:s',$evento->horario)->format('H:i');

        if($h >= '13:00'){
            $w = 'PM';
        }else{
            $w = 'AM';
        }
        $hora = $h.' '.$w;

         //header
        // PDF::setHeaderCallBack(function($pdf){
        //     $logo = public_path() . '/img/logo_poder_j.png';
        //     $pdf->Image($logo,26,0,160,45);
        // });

        $style = array(
            'border' => 0,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );



        $view = View::make('pdf.invitacion', compact('invitado','evento','f','hora'));
        $html_content = $view->render();

        $PDF_MARGIN_LEFT = 15;
        $PDF_MARGIN_TOP = 30;
        $PDF_MARGIN_RIGHT = 15;
        $PDF_MARGIN_BOTTOM = 05;

        PDF::SetMargins($PDF_MARGIN_LEFT, $PDF_MARGIN_TOP, $PDF_MARGIN_RIGHT,$PDF_MARGIN_BOTTOM);
        PDF::SetAutoPageBreak(true, $PDF_MARGIN_BOTTOM);
        
        PDF::AddPage('P', 'A4');

        $bMargin = PDF::getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = PDF::getAutoPageBreak();
        // disable auto-page-break
        PDF::SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = public_path() . '/storage/'.$evento->fondo;
        PDF::Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        PDF::SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        PDF::setPageMark();

        PDF::writeHTML($html_content, true, false, true, false, '');
        PDF::write2DBarcode('https://eventos.pjpuebla.gob.mx/validar-invitado?folio='.$invitado->folio, 'QRCODE,M', 70, 198, 70, 70, $style, 'N');

        PDF::Text(65, 275, 'CÓDIGO DE VESTIMENTA: FORMAL');

        ob_end_clean();

        $pdf = PDF::Output('Código.pdf','S');


        Mail::to($invitado->email)->send(new EnviarCorreo($invitado,$evento,$pdf,$hora,$f));


        $invitados = Invitado::where('evento_id', $request->evento_id)->where('status',1)->get();

        $array_invitados = array();
        $cont = 1;

        foreach ($invitados as $invitado) {
            $objectInvitado = new \stdClass();
            $objectInvitado->id = $invitado->id;
            $objectInvitado->numero_registro = $cont;
            $objectInvitado->nombre = $invitado->nombre;
            $objectInvitado->apellido_p = $invitado->apellido_p;
            $objectInvitado->apellido_m = $invitado->apellido_m;
            $objectInvitado->nombreC = $invitado->nombre.' '.$invitado->apellido_p.' '.$invitado->apellido_m;
            $objectInvitado->dependencia = $invitado->dependencia;
            $objectInvitado->area = $invitado->area;
            $objectInvitado->telefono = $invitado->telefono;
            $objectInvitado->email = $invitado->email;
            $objectInvitado->evento_id = $invitado->evento_id;
            $objectInvitado->nombre_evento = $invitado->evento->nombre;
            $objectInvitado->zona = $invitado->zona->nombre;
            $objectInvitado->cargo = $invitado->cargo;
            $objectInvitado->parking = $invitado->con_parking;
            array_push($array_invitados, $objectInvitado);
            $cont++;
        }
        return response()->json([
            "status" => "ok",
            "message" => "Correo enviado con éxito.",
            "invitados" => $array_invitados
        ], 200);

    }catch (\Throwable $th) {
    
        return response()->json([
            "status" => "error",
            "message" => "Ocurrió un error al enviar el correo.",
            "error" => $th->getMessage(),
            "location" => $th->getFile(),
            "line" => $th->getLine(),
        ], 200);
    }

    }
    public function formatearFecha($week_day, $day, $month, $year)
    {
        $nombre_dia = '';
        switch ($week_day) {
            case 0:
                $nombre_dia = 'Domingo';
                break;
            case 1:
                $nombre_dia = 'Lunes';
                break;
            case 2:
                $nombre_dia = 'Martes';
                break;
            case 3:
                $nombre_dia = 'Miércoles';
                break;
            case 4:
                $nombre_dia = 'Jueves';
                break;
            case 5:
                $nombre_dia = 'Viernes';
                break;
            case 6:
                $nombre_dia = 'Sábado';
                break;
        }

        $nombre_mes = '';
        switch ($month) {
            case 1:
                $nombre_mes = 'Enero';
                break;
            case 2:
                $nombre_mes = 'Febrero';
                break;
            case 3:
                $nombre_mes = 'Marzo';
                break;
            case 4:
                $nombre_mes = 'Abril';
                break;
            case 5:
                $nombre_mes = 'Mayo';
                break;
            case 6:
                $nombre_mes = 'Junio';
                break;
            case 7:
                $nombre_mes = 'Julio';
                break;
            case 8:
                $nombre_mes = 'Agosto';
                break;
            case 9:
                $nombre_mes = 'Septiembre';
                break;
            case 10:
                $nombre_mes = 'Octubre';
                break;
            case 11:
                $nombre_mes = 'Noviembre';
                break;
            case 12:
                $nombre_mes = 'Diciembre';
                break;
        }

        $fecha_formateada = $nombre_dia . '         ' . $day . '          ' . $nombre_mes;
        return $fecha_formateada;
    }

    public function importInvitados(Request $request)
    {
        try {
            $total_invitados = Invitado::where('evento_id',$request->evento_id)->count();

            $ex = new InvitadosImport($request->evento_id,$total_invitados,$request->zona_id);
            Excel::import($ex,$request->file('file')); 
        
            return response()->json([
                "status" => "ok",
                "message" => "Importados ".$ex->cont. " de ".$ex->total,
                "invitados" => $ex->cont,
                "total" => $ex->total,
            ], 200);       
        } catch (\Throwable $th) {
        
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al agregar los invitados.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function confirmarAsistencia(Request $request) {
        try {
            $invitado = Invitado::where('folio',$request->folio)->where('status',1)->first();
            if($invitado){
                if($invitado->confirmo == 0){
                    DB::beginTransaction();
                    $invitado->confirmo = 1;
                    $invitado->save();

                    DB::commit();
                    return response()->json([
                        "status" => "ok",
                        "message" => "Folio confirmado con éxito",
                        "nombre" => $invitado->nombre.' '.$invitado->apellido_p.' '.$invitado->apellido_m,
                        "cargo" => $invitado->cargo,
                        "zona" => $invitado->zona->nombre,
                    ], 200);
                }
                if($invitado->confirmo == 1){

                    return response()->json([
                        "status" => "usado",
                        "message" => "Folio ya está confirmado",
                        "nombre" => $invitado->nombre.' '.$invitado->apellido_p.' '.$invitado->apellido_m,
                        "hora" => $invitado->hora_ingreso
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

    public function enviarCorreosMasivo(Request $request)
    {
        DB::beginTransaction();
        try{
            $evento = Evento::find($request->evento_id);
            $invitados = Invitado::where('evento_id',$evento->id)->where('status',1)->where('correo_enviado',0)->get();
            $cont_correos = 0;
            foreach($invitados as $invitado)
            {
    
                $invitado->correo_enviado = 1;
                $invitado->save();

                $date = new Carbon($evento->fecha_inicial);
                $f = $this->formatearFecha($date->dayOfWeek, $date->day, $date->month, $date->year);
        
                $h = Carbon::createFromFormat('H:i:s',$evento->horario)->format('H:i');
        
                if($h >= '13:00'){
                    $w = 'PM';
                }else{
                    $w = 'AM';
                }
                $hora = $h.' '.$w;
        
                // //header
                // PDF::setHeaderCallBack(function($pdf){
                //     $logo = public_path() . '/img/logo_poder_j.png';
                //     $pdf->Image($logo,26,0,160,45);
                // });
        
                $style = array(
                    'border' => 0,
                    'vpadding' => 'auto',
                    'hpadding' => 'auto',
                    'fgcolor' => array(0,0,0),
                    'bgcolor' => false, //array(255,255,255)
                    'module_width' => 1, // width of a single module in points
                    'module_height' => 1 // height of a single module in points
                );

                $view = View::make('pdf.invitacion', compact('invitado','evento','f','hora'));                
                $html_content = $view->render();

                PDF::reset();
                
                $PDF_MARGIN_LEFT = 15;
                $PDF_MARGIN_TOP = 30;
                $PDF_MARGIN_RIGHT = 15;
                $PDF_MARGIN_BOTTOM = 05;
        
                PDF::SetMargins($PDF_MARGIN_LEFT, $PDF_MARGIN_TOP, $PDF_MARGIN_RIGHT,$PDF_MARGIN_BOTTOM);
                PDF::SetAutoPageBreak(true, $PDF_MARGIN_BOTTOM);
                
                PDF::AddPage('P', 'A4');

                $bMargin = PDF::getBreakMargin();
                // get current auto-page-break mode
                $auto_page_break = PDF::getAutoPageBreak();
                // disable auto-page-break
                PDF::SetAutoPageBreak(false, 0);
                // set bacground image
                $img_file = public_path() . '/storage/'.$evento->fondo;
                PDF::Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
                // restore auto-page-break status
                PDF::SetAutoPageBreak($auto_page_break, $bMargin);
                // set the starting point for the page content
                PDF::setPageMark();
        
                PDF::writeHTML($html_content, true, false, true, false, '');
                PDF::write2DBarcode('https://eventos.pjpuebla.gob.mx/validar-invitado?folio='.$invitado->folio, 'QRCODE,M', 70, 198, 70, 70, $style, 'N');
        
                PDF::Text(65, 275, 'CÓDIGO DE VESTIMENTA: FORMAL');
                
                $pdf = PDF::Output('Código.pdf','S');
            
                if (filter_var($invitado->email, FILTER_VALIDATE_EMAIL)) {
                    Mail::to($invitado->email)->send(new EnviarCorreo($invitado,$evento,$pdf,$hora,$f));
                }
                DB::commit();
                $cont_correos++;
            }

            return response()->json([
                "status" => "ok",
                "message" => "Correos enviados con éxito.",
                "total" => $cont_correos
            ], 200); 

        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al enviar los correos.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }

    public function ExportarExcel(Request $request)
    {
        $invitados = Invitado::where('evento_id',$request->evento_id)->get();
        
        $array_invitados = [];
        foreach($invitados as $invitado)
        {
            $objectInvitado = new \stdClass();
            $objectInvitado->id = $invitado->id;
            $objectInvitado->nombreC = $invitado->nombre.' '.$invitado->apellido_p.' '.$invitado->apellido_m;
            $objectInvitado->dependencia = $invitado->dependencia;
            $objectInvitado->cargo = $invitado->cargo;
            $objectInvitado->area = $invitado->area;
            $objectInvitado->telefono = $invitado->telefono;
            $objectInvitado->email = $invitado->email;
            $objectInvitado->estado = $invitado->estado;
            $objectInvitado->municipio = $invitado->municipio;
            $objectInvitado->evento = $invitado->evento->nombre;
            $objectInvitado->zona = $invitado->zona->nombre;
            $objectInvitado->confirmo = $invitado->confirmo == 1 ? "SI" : "NO";
            $objectInvitado->ingreso = $invitado->verificado == 1 ? "SI" : "NO"; 
            $objectInvitado->hora_ingreso = $invitado->hora_ingreso;
            
            array_push($array_invitados, $objectInvitado);
        }
        return (new InvitadosExport($array_invitados))->download('Invitados.xlsx');
    }

}
