<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     * 
     * @var string
     */
    protected $primaryKey = 'venta_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cliente_id',
        'fecha_venta',
        'total',
        'tipo_pago',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'fecha_venta' => 'datetime',
        'total' => 'decimal:2',
        'status' => 'integer'
    ];

    /**
     * The default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'tipo_pago' => 'efectivo',
        'status' => 1
    ];
    
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id', 'usuario_id');
    }
    //============================================================================
        public static function get_labels(){
            return [
                'data' => [
                    [
                        'display-name' => 'ID',
                        'name' => 'venta_id',
                        'type' => 'auto',
                    ],
                    [
                        'display-name' => 'Fecha',
                        'name' => 'fecha_venta',
                        'type' => 'date',
                    ],
                    [
                        'display-name' => 'Total',
                        'name' => 'total',
                        'type' => 'decimal',
                    ],
                    [
                        'display-name' => 'Tipo de pago',
                        'name' => 'tipo_pago',
                        'type' => 'text',
                    ],
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
    /**
 * Obtener el usuario/cliente asociado a la venta.
 */
}