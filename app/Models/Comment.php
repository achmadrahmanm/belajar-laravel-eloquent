<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    // Default values for attributes
    protected $attributes = [
        'title' => 'Sample Title',
        'comment' => 'Sample Comment',
    ];

    // Fillable attributes for mass assignment
    protected $fillable = [
        'email',
        'title',
        'comment',
    ];
}
