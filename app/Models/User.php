<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $primaryKey = 'usuario_id';


    protected $fillable = [
        'name',
        'email',
        'password',
        'telefono',
        'direccion',
        'foto_perfil',
        'rol'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'integer',
        ];
    }

    protected $attributes = [
        'rol' => 'cliente',
        'status' => 1
    ];

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'cliente_id', 'usuario_id');
    }

    //============================================================================
    public static function get_labels(){
        return [
            'data' => [
                [
                    'display-name' => 'ID',
                    'name' => 'usuario_id',
                    'type' => 'auto',
                ],
                [
                    'display-name' => 'Nombre',
                    'name' => 'name',
                    'type' => 'text',
                ],
                [
                    'display-name' => 'Email',
                    'name' => 'email',
                    'type' => 'email',
                ],
                [
                    'display-name' => 'Telefono',
                    'name' => 'telefono',
                    'type' => 'text',
                ],
                [
                    'display-name' => 'Direccion',
                    'name' => 'direccion',
                    'type' => 'textarea',
                ],
                [
                    'display-name' => 'Url perfil',
                    'name' => 'foto_perfil',
                    'type' => 'text',
                ],
                [
                    'display-name' => 'Rol',
                    'name' => 'rol',
                    'type' => 'enum',
                    'enum' => [
                        ['display-name' => 'Administrador', 'name' => 'administrador'],
                        ['display-name' => 'Barbero', 'name' => 'barbero'],
                        ['display-name' => 'Cliente', 'name' => 'cliente'],
                    ]
                ],
            ],
        ];
    }
    public static function get_fkLabels(){
        return [];
    }
    public function get_fk()
    {
        return [];
    }
    public static function get_validate(){
        return [
            'name' => ['required', 'string', 'max:16'],
            'email' => ['required', 'email'],
            'telefono' => ['nullable', 'string', 'max:16'],
            'direccion' => ['nullable','string', 'max:255'],
            'foto_perfil' => ['nullable', 'string', 'max:255'],
            'rol' => ['required', 'string', 'max:16'],
        ];
    }
    //============================================================================
}
