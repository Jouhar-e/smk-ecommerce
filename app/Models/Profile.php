<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'store_name',
        'tagline',
        'description',
        'logo_path',
        'address',
        'phone',
        'email',
        'instagram',
        'facebook',
        'tiktok',
        'open_hours',
    ];
}
