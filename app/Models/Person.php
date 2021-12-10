<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'category_id',
        'title',
        'name1',
        'name2',
        'address1',
        'address2',
        'organization',
        'zip_code',
        'city',
        'state',
        'email',
        'note',
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
