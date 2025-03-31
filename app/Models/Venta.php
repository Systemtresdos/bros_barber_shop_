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
    /**
 * Obtener el usuario/cliente asociado a la venta.
 */
}