<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_date',
        'total',
        'pay',
        'change',
        'status',
        'payment_status',
        'payment_method',
        'payment_proof_path',
        'payment_confirmed_at',
        'payment_confirmed_by',
        'customer_name',
        'customer_address',
        'customer_phone',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'payment_confirmed_at' => 'datetime',
        'total' => 'decimal:2',
        'pay' => 'decimal:2',
        'change' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function confirmer()
    {
        return $this->belongsTo(User::class, 'payment_confirmed_by');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
