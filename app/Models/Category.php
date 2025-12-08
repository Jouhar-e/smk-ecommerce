<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Category extends Model
{
    protected $fillable = ['category'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
