<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\TaskStatus;

class Task extends Model
{
    use HasFactory;

    protected $table = 'task';

    protected $fillable = ['title', 'description', 'status'];

    protected $casts = [
        'status' => TaskStatus::class,
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
