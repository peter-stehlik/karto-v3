<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Correction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from_person_id',
        'for_person_id',
        'sum',
        'from_periodical_id',
        'from_nonperiodical_id',
        'for_periodical_id',
        'for_nonperiodical_id',
        'user_id',
        'confirmed',
        'note',
        'correction_date',
    ];
}
