<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'team_id',
    ];

    /**
     * Get all of the posts for the user.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
