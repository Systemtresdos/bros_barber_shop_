<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

    protected $primaryKey = 'producto_id';
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'fecha_actualizacion',
    ];
    //============================================================================
        public static function get_labels(){
            return [
                'data' => [
                    [
                        'display-name' => 'ID',
                        'name' => 'producto_id',
                        'type' => 'auto',
                    ],
                    [
                        'display-name' => 'Nombre',
                        'name' => 'nombre',
                        'type' => 'text',
                    ],
                    [
                        'display-name' => 'Descripcion',
                        'name' => 'descripcion',
                        'type' => 'textarea',
                    ],
                    [
                        'display-name' => 'Precio',
                        'name' => 'precio',
                        'type' => 'decimal',
                    ],
                    [
                        'display-name' => 'Stock',
                        'name' => 'stock',
                        'type' => 'number',
                    ],
                    [
                        'display-name' => 'Fecha de actualizacion',
                        'name' => 'fecha_actualizacion',
                        'type' => 'date',
                    ],
                ],
            ];
        }
        public static function get_validate(){
            return [
                'nombre' => ['required', 'string', 'max:64'],
                'descripcion' => ['required', 'string', 'max:255'],
                'precio' => ['required', 'numeric','min:0','max:999999'],
                'stock' => ['required', 'integer','min:0','max:999999'],
                'fecha_actualizacion' => ['required', 'string', 'max:10'],
            ];
        }
        public static function get_fkLabels(){
            return [
            ];
        }
        public function get_fk()
        {
            return [
            ];
        }
        //============================================================================
}
