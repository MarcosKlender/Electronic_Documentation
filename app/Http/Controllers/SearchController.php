<?php

namespace WebServiceApp\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use WebServiceApp\Models\Emproservis;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    // Esta búsqueda de documentos es exclusiva del súperusuario.

    public function ruc()
    {
        $w = Input::get('w');
        if($w != '')
        {
            $busqueda_ruc = Emproservis::where([
                ['ruc_cliente_proveedor', $w],
                ['estado', 'AUTORIZADO']
            ])->whereNotNull('xml_documento')->whereNotNull('reporte_pdf')
            ->orderBy('fecha_emision_documento', 'desc')->paginate(10);
            
            if(count($busqueda_ruc) > 0)
            {
                return view('search.ruc')->withDetails($busqueda_ruc)->withQuery($w);
            }
            elseif(count($busqueda_ruc) === 0)
            {
                return view('search.ruc')->withMessage('No se ha encontrado ningún documento.');
            }
        }
        return view('search.ruc');
    }

    // Las siguientes funciones se encargan de la búsqueda de documentos del usuario.

    public function numero()
    {
        $q = Input::get('q');
        if($q != '')
        {
            $ruc_usuario = Auth::user()->ruc_o_ci;

            $busqueda_numero = Emproservis::where([
                ['numero_documento', $q],
                ['ruc_cliente_proveedor', $ruc_usuario],
                ['estado', 'AUTORIZADO']
            ])->whereNotNull('xml_documento')->whereNotNull('reporte_pdf')
            ->orderBy('fecha_emision_documento', 'desc')->get();
            
            if(count($busqueda_numero) > 0)
            {
                return view('search.numero')->withDetails($busqueda_numero)->withQuery($q);
            }
            elseif(count($busqueda_numero) === 0)
            {
                return view('search.numero')->withMessage('No se ha encontrado ningún documento.');
            }
        }
        return view('search.numero');
    }

    public function valor()
    {
        $x = Input::get('x');
        if($x != '')
        {
            $ruc_usuario = Auth::user()->ruc_o_ci;

            $busqueda_valor = Emproservis::where([
                ['valor_total', $x],
                ['ruc_cliente_proveedor', $ruc_usuario],
                ['estado', 'AUTORIZADO']
            ])->whereNotNull('xml_documento')->whereNotNull('reporte_pdf')
            ->orderBy('valor_total', 'desc')->get();
            
            if(count($busqueda_valor) > 0)
            {
                return view('search.valor')->withDetails($busqueda_valor)->withQuery($x);
            }
            elseif(count($busqueda_valor) === 0)
            {
                return view('search.valor')->withMessage('No se ha encontrado ningún documento.');
            }
        }
        return view('search.valor');
    }

    public function fecha()
    {
        $e1 = Input::get('e1');
        $e2 = Input::get('e2');
        $ruc_usuario = Auth::user()->ruc_o_ci;
 

        if($e1 != '' and $e2 != '')
        {
            if($e1 > $e2)
            {
                return view('search.fecha')->withMessage('La fecha ingresada es inválida.');
            }

            $busqueda_fecha = Emproservis::whereBetween('fecha_emision_documento', [$e1, $e2])
            ->where([ ['ruc_cliente_proveedor', $ruc_usuario], ['estado', 'AUTORIZADO'] ])
            ->whereNotNull('xml_documento')->whereNotNull('reporte_pdf')
            ->orderBy('fecha_emision_documento', 'desc')->paginate(10);

            if(count($busqueda_fecha) > 0)
            {
                $fechas = ['desde' => $e1, 'hasta' => $e2];
                return view('search.fecha')->withDetails($busqueda_fecha)->with($fechas);
            }
            elseif(count($busqueda_fecha) === 0)
            {
                return view('search.fecha')->withMessage('No se ha encontrado ningún documento.');
            }
        }
        return view('search.fecha');
    }
}
