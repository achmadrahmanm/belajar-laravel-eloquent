<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\IsActiveScope;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'description',
        'is_active',
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    protected static function booted()
    {
        parent::booted();

        // Apply the IsActiveScope globally
        self::addGlobalScope(new IsActiveScope());
    }
}
