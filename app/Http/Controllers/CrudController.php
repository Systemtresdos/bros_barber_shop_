<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CrudController extends Controller
{
    public static function get_tablas(){
        return [
            'User', 'Venta', 'Servicio',
            'Producto', 'Oferta', 'Cita',
            'Detalle_venta', 'Inventario_movimiento'
        ];
    }
    public static function index($request)
    {
        $nombre = CrudController::get_index_from_query($request);
        $modelo = 'App\\Models\\'.$nombre;
        if (!Auth::user()) {
            return redirect('/');
        }
        $crud = new $modelo();
        $arregloDatos = $modelo::get_labels();
        $fk = $modelo::get_fkLabels();
        $datos = $modelo::all();
        return view('crud', compact('datos','arregloDatos','nombre','fk'));
    }

    public static function create(Request $request)
    {
        if(Auth::user()->rol=="cliente"){
            return redirect()->back()->with('error', 'No tienes los permisos requeridos para crear datos.');
        }
        $nombre = CrudController::get_index_from_query($request);
        $modelo = 'App\\Models\\'.$nombre;
        $validateData = $modelo::get_validate();
        //return response()->json($request);
        $request->validate($validateData);
    
        $datos = [];
        //Datos normales
        $arregloRequest = $request->toArray();
        $arregloDatos = $modelo::get_labels();
        foreach ($arregloDatos['data'] as $index){
            if($index['type']!='auto'){
                //Arreglar el problema de switch mediante un checkbox ("on"=true,null=false)
                switch($index['type']){
                    case 'switch':
                        $arregloRequest[$index['name']] = array_key_exists($index['name'],$arregloRequest)?true:false;
                }
                $datos[$index['name']] = $arregloRequest[$index['name']];
            }
        }

        //Datos con fk
        $arregloDatos = $modelo::get_fkLabels();
        
        foreach ($arregloDatos as $index){
            $datos[$index['attr']] = $arregloRequest[$index['attr']];
        }
        // Guardar en la base de datos
        $modelo::create($datos);

        return redirect()->back()->with('success', $nombre.' creado exitosamente.')
        ;
    }

    public static function edit(Request $request)
    {   
        if(Auth::user()->rol=="cliente"){
            return redirect()->back()->with('error', 'No tienes los permisos requeridos para modificar datos.');
        }
        $nombre = CrudController::get_index_from_query($request);
        $modelo = 'App\\Models\\'.$nombre;
        $validateData = $modelo::get_validate();
        $request->validate($validateData);

        $dato = $modelo::find($request->id);
        if (!$dato) {
            return redirect()->back()->with('error', $nombre.' no encontrado.');
        }
        // Convertir todo en arreglo
        $arregloRequest = $request->toArray();
        $arregloDato = $dato->toArray();
        // Actualizar datos
        $arregloLabels = $modelo::get_labels();
        $datos = [];
        foreach ($arregloLabels['data'] as $index){
            if ($index['type'] != 'auto'){
                switch($index['type']){
                    case 'switch':
                        $arregloRequest[$index['name']] = array_key_exists($index['name'],$arregloRequest)?true:false;
                }
                $datos[$index['name']] = $arregloRequest[$index['name']];
            }
        }
        //Datos con fk
        $arregloLabels = $modelo::get_fkLabels();
        foreach ($arregloLabels as $index){
            $datos[$index['attr']] = $arregloRequest[$index['attr']];
        }
        $dato->update($datos);
        return redirect()->back()->with('success', $nombre.' modificado exitosamente.');
    }

    public static function delete(Request $request)
    {   
        if(Auth::user()->rol=="cliente"){
            return redirect()->back()->with('error', 'No tienes los permisos requeridos para borrar datos.');
        }
        $nombre = CrudController::get_index_from_query($request);
        $modelo = 'App\\Models\\'.$nombre;
        $dato = $modelo::find($request->id);
        if (!$dato) {
            return redirect()->back()->with('error', $nombre.' no encontrado.');
        }
        $dato->delete();
        return redirect()->back()->with('success', $nombre.' eliminado exitosamente.');
    }

    public static function get_index_from_query(Request $request){
        $tablas = CrudController::get_tablas();
        $query = ucfirst($request->query('tabla'));
        $indice = $tablas[0];
        foreach ($tablas as $tabla){
            if($tabla==$query){
                $indice=$query;
                break;
            }
        }
        return $indice;
    }
}
