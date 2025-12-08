<?php
namespace App\Models;

use App\Models\Order;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
        'status',
        'alamat',
        'telp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function confirmedPayments()
    {
        return $this->hasMany(Order::class, 'payment_confirmed_by');
    }

    public function isAdmin(): bool
    {
        return $this->level === 'admin';
    }

    public function isSeller(): bool
    {
        return $this->level === 'seller';
    }

    public function isCustomer(): bool
    {
        return $this->level === 'customer';
    }
}
