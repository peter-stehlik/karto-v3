<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NonperiodicalPublication extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'abbreviation',
        'created_at',
    ];

    /**
     * Get all transfers
     */
    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }
}
