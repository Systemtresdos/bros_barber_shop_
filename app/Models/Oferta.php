<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{

    protected $primaryKey = 'oferta_id';
    protected $fillable = [
        'nombre',
        'descripcion',
        'descuento',
        'fecha_inicio',
        'fecha_fin',
        'tipo',
        'item_id',
    ];
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'item_id', 'producto_id');
    }
//============================================================================
    public static function get_labels(){
        return [
            'data' => [
                [   'display-name' => 'ID',
                    'name' => 'oferta_id',
                    'type' => 'auto',],
                [   'display-name' => 'Nombre',
                    'name' => 'nombre',
                    'type' => 'text',],
                [   'display-name' => 'Descripcion',
                    'name' => 'descripcion',
                    'type' => 'textarea',],
                [   'display-name' => 'Descuento',
                    'name' => 'descuento',
                    'type' => 'decimal',],
                [   'display-name' => 'Fecha inicio',
                    'name' => 'fecha_inicio',
                    'type' => 'date',],
                [   'display-name' => 'Fecha fin',
                    'name' => 'fecha_fin',
                    'type' => 'date',],
                [   'display-name' => 'Tipo',
                    'name' => 'tipo',
                    'type' => 'enum',
                    'enum' => [
                        ['display-name' => 'Servicio', 'name' => 'servicio'],
                        ['display-name' => 'Producto', 'name' => 'producto'],
                    ],],
            ],
        ];
    }
    public static function get_validate(){
        return [
            'nombre' => ['required','string', 'max:64'],
            'descuento' => ['required', 'numeric','min:0','max:999999'],
            'fecha_inicio' => ['required', 'string', 'max:10'],
            'fecha_fin' => ['required', 'string', 'max:10'],
            'tipo' => ['required','string', 'max:255'],
            'item_id' => ['required', 'exists:productos,producto_id'],
        ];
    }
    public static function get_fkLabels(){
        return [
            [
                'name' => 'Producto',
                'attr' => 'item_id',
                'fk_name' => 'nombre',
                'fk_id' => 'producto_id',
                'data' => Producto::select('producto_id', 'nombre')->get(),
            ],
        ];
    }
    public function get_fk()
    {
        return [
            'item_id' => $this->producto->nombre,
        ];
    }
    //============================================================================
}