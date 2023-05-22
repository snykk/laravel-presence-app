<?php

namespace App\Models;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Classroom extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 'active';

    const STATUS_UNDER_MAINTENANCE = 'under maintenance';
    /**
     * The attributes that should be mutated to dates.
     *
     * @var string[]
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'building_id',
        'room_number',
        'capacity',
        'floor',
        'status',
    ];
// Model accessors declaration

    /**
     * Model relationship definition.
     * Classroom belongs to Building
     *
     * @return BelongsTo
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }
}
