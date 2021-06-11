<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'person_id',
        'user_id',
        'sum',
        'bank_account_id',
        'number',
        'package_number',
        'invoice',
        'accounting_date',
        'posted',
        'note',
        'income_date',
    ];
}
