<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'shared_password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'shared_password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'shared_password' => 'hashed'
    ];

    public function role() {
        $role = '';
        switch ($this->role) {
            case 1:
                $role = 'Pemilik';
                break;

            case 2:
                $role = 'Bagian Gudang';
                break;

            case 2:
                $role = 'Apoteker';
                break;
            
            default:
                $role = null;
                break;
        }
        return $role;
    }
}
