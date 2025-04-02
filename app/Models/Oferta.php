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
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id', 'usuario_id');
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
            'fecha_venta' => ['required', 'string', 'max:10'],
            'total' => ['required', 'numeric','min:0','max:999999'],
            'tipo_pago' => ['required','string', 'max:255'],
            'cliente_id' => ['required', 'exists:users,usuario_id'],
        ];
    }
    public static function get_fkLabels(){
        return [
            [
                'name' => 'Usuario',
                'attr' => 'cliente_id',
                'fk_name' => 'email',
                'fk_id' => 'usuario_id',
                'data' => User::select('usuario_id', 'email')->get(),
            ],
        ];
    }
    public function get_fk()
    {
        return [
            'cliente_id' => $this->cliente->email,
        ];
    }
    //============================================================================
}