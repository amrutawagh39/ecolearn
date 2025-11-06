<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_url',
        'criteria_type',
        'criteria_value'
    ];

    protected $casts = [
        'criteria_value' => 'integer'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_badges')
                    ->withTimestamps();
    }
}
