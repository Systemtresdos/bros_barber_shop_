<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalle_venta extends Model
{
    protected $primaryKey = 'detalle_id';
    protected $fillable = [
        'venta_id',
        'tipo_item',
        'item_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
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
                    'name' => 'detalle_id',
                    'type' => 'auto',],
                [   'display-name' => 'Tipo',
                    'name' => 'tipo_item',
                    'type' => 'enum',
                    'enum' => [
                        ['display-name' => 'Servicio', 'name' => 'servicio'],
                        ['display-name' => 'Producto', 'name' => 'producto'],
                ],],
                [   'display-name' => 'Cantidad',
                    'name' => 'cantidad',
                    'type' => 'number',],
                [   'display-name' => 'Precio unitario',
                    'name' => 'precio_unitario',
                    'type' => 'decimal',],
                [   'display-name' => 'Sub total',
                    'name' => 'subtotal',
                    'type' => 'decimal',],
            ],
        ];
    }
    public static function get_validate(){
        return [
            'tipo_item' => ['required','string', 'max:64'],
            'cantidad' => ['required', 'integer','min:0','max:999999'],
            'precio_unitario' => ['required', 'numeric','min:0','max:999999'],
            'subtotal' => ['required', 'numeric','min:0','max:999999'],
            'item_id' => ['required', 'exists:productos,producto_id'],
            'venta_id' => ['required', 'exists:ventas,venta_id'],
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
            [
                'name' => 'Venta',
                'attr' => 'venta_id',
                'fk_name' => 'venta_id',
                'fk_id' => 'venta_id',
                'data' => Venta::select('venta_id')->get(),
            ],
        ];
    }
    public function get_fk()
    {
        return [
            'item_id' => $this->producto->nombre,
            'venta_id' => $this->venta_id,
        ];
    }
    //============================================================================
}
