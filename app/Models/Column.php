<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'board_id', 'order',
    ];

    /**
     * Get all of the posts for the user.
     */
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Get all of the posts for the user.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
