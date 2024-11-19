<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    /**
     * fillable
     * 
     * @var array
     */
    protected $fillable = [
        'thumbnail',
        'title',
        'description',
        'type',
        'link',
        'author',
    ];

    /**
     * thumbnail
     * 
     * @return Attribute
     */
    protected function thumbnail(): Attribute
    {
        return Attribute::make(
            get: fn ($thumbnail) => url('/storage/projects/'. $thumbnail),
        );
    }
}
