<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'income_id',
        'sum',
        'periodical_publication_id',
        'nonperiodical_publication_id',
        'note',
        'transfer_date',
    ];

    /**
     * Get the income ID.
     */
    public function income()
    {
        return $this->belongsTo(Income::class);
    }

    /**
     * Get the periodical ID.
     */
    public function periodical()
    {
        return $this->belongsTo(PeriodicalPublication::class);
    }

    /**
     * Get the nonperiodical ID.
     */
    public function nonperiodical()
    {
        return $this->belongsTo(NonperiodicalPublication::class);
    }
}
