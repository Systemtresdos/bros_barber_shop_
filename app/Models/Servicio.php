<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $primaryKey = 'servicio_id';
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'duracion',
    ];
    //============================================================================
        public static function get_labels(){
            return [
                'data' => [
                    [
                        'display-name' => 'ID',
                        'name' => 'servicio_id',
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
                        'display-name' => 'Duracion',
                        'name' => 'duracion',
                        'type' => 'text',
                    ],
                ],
            ];
        }
        public static function get_validate(){
            return [
                'nombre' => ['required', 'string', 'max:64'],
                'descripcion' => ['required', 'string', 'max:255'],
                'precio' => ['required', 'numeric','min:0','max:999999'],
                'duracion' => ['required', 'string', 'max:64'],
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
