<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'bank_name',
        'abbreviation',
        'number',
        'created_at',
        'deleted_at',
    ];

    /**
     * Get the incomes
     */
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
}
