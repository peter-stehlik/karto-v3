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
        'id',
        'person_id',
        'user_id',
        'sum',
        'bank_account_id',
        'number',
        'package_number',
        'invoice',
        'accounting_date',
        'confirmed',
        'note',
        'income_date',
        'created_at',
        'deleted_at',
    ];

    /**
     * Get the bank account that belongs to the income.
     */
    public function bank_account()
    {
        return $this->belongsTo(BankAccount::class);
    }

    /**
     * Get the person details income is for.
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Get all transfers
     */
    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }
}
