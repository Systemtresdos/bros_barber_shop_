<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $primaryKey = 'cita_id';
    protected $fillable = [
        'cliente_id',
        'barbero_id',
        'servicio_id',
        'fecha_hora',
        'estado',
    ];
    public function cliente()
    {return $this->belongsTo(User::class, 'cliente_id', 'usuario_id');}
    public function empleado()
    {return $this->belongsTo(User::class, 'barbero_id', 'usuario_id');}
    public function servicio()
    {return $this->belongsTo(Servicio::class, 'servicio_id', 'servicio_id');}
//============================================================================
    public static function get_labels(){
        return [
            'data' => [
                [   'display-name' => 'ID',
                    'name' => 'cita_id',
                    'type' => 'auto',],
                [   'display-name' => 'Fecha',
                    'name' => 'fecha_hora',
                    'type' => 'date',],
                [   'display-name' => 'Estado',
                    'name' => 'estado',
                    'type' => 'enum',
                    'enum' => [
                        ['display-name' => 'Pendiente', 'name' => 'pendiente'],
                        ['display-name' => 'Confirmada', 'name' => 'confirmada'],
                        ['display-name' => 'Cancelada', 'name' => 'cancelada'],
                        ['display-name' => 'Completada', 'name' => 'completada'],
                    ],
                ],
            ],
        ];
    }
    public static function get_validate(){
        return [
            'fecha_hora' => ['required','string', 'max:64'],
            'estado' => ['required','string', 'max:64'],
            'cliente_id' => ['required', 'exists:users,usuario_id'],
            'barbero_id' => ['required', 'exists:users,usuario_id'],
            'servicio_id' => ['required', 'exists:servicios,servicio_id'],
        ];
    }
    public static function get_fkLabels(){
        return [
            [
                'name' => 'Cliente',
                'attr' => 'cliente_id',
                'fk_name' => 'email',
                'fk_id' => 'usuario_id',
                'data' => User::select('usuario_id', 'email')->get(),
            ],
            [
                'name' => 'Barbero',
                'attr' => 'barbero_id',
                'fk_name' => 'email',
                'fk_id' => 'usuario_id',
                'data' => User::select('usuario_id', 'email')->get(),
            ],
            [
                'name' => 'Sevicio',
                'attr' => 'servicio_id',
                'fk_name' => 'nombre',
                'fk_id' => 'servicio_id',
                'data' => Servicio::select('servicio_id', 'nombre')->get(),
            ],
        ];
    }
    public function get_fk()
    {
        return [
            'cliente_id' => $this->cliente->email,
            'barbero_id' => $this->empleado->email,
            'servicio_id' => $this->servicio->nombre,
        ];
    }
    //============================================================================
}

