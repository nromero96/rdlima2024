<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'knowledge_area',
        'category',
        'author_coauthors',
        'institution',
        'user_id',
        'title',
        'description',
        'file_1',
        'file_2',
        'file_3',
        'file_4',
        'file_5',
        'file_6',
        'status',
    ];
}
