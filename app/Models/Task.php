<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'column_id', 'order', 'fixed', 'content',
    ];

    /**
     * Get all of the posts for the user.
     */
    public function column()
    {
        return $this->belongsTo(Column::class);
    }
}
