<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalle_venta extends Model
{
    protected $primaryKey = 'detalle_id';
    protected $fillable = [
        'producto_id',
        'tipo_movimiento',
        'cantidad',
        'fecha_movimiento',
        'descripcion',
    ];
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'producto_id');
    }
//============================================================================
    public static function get_labels(){
        return [
            'data' => [
                [   'display-name' => 'ID',
                    'name' => 'movimiento_id',
                    'type' => 'auto',],
                [   'display-name' => 'Tipo',
                    'name' => 'tipo_movimiento',
                    'type' => 'enum',
                    'enum' => [
                        ['display-name' => 'Entrada', 'name' => 'entrada'],
                        ['display-name' => 'Salida', 'name' => 'salida'],
                ],],
                [   'display-name' => 'Cantidad',
                    'name' => 'cantidad',
                    'type' => 'number',],
                [   'display-name' => 'Fecha',
                    'name' => 'fecha_movimiento',
                    'type' => 'date',],
                [   'display-name' => 'Descripcion',
                    'name' => 'descripcion',
                    'type' => 'textarea',],
            ],
        ];
    }
    public static function get_validate(){
        return [
            'tipo_movimiento' => ['required','string', 'max:64'],
            'cantidad' => ['required', 'integer','min:0','max:999999'],
            'fecha_movimiento' => ['required', 'string', 'max:10'],
            'descripcion' => ['required','string', 'max:255'],
            'producto_id' => ['required', 'exists:productos,producto_id'],
        ];
    }
    public static function get_fkLabels(){
        return [
            [
                'name' => 'Producto',
                'attr' => 'producto_id',
                'fk_name' => 'nombre',
                'fk_id' => 'producto_id',
                'data' => Producto::select('producto_id', 'nombre')->get(),
            ],
        ];
    }
    public function get_fk()
    {
        return [
            'producto_id' => $this->producto->nombre,
        ];
    }
    //============================================================================
}
