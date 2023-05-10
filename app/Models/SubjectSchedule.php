<?php

namespace App\Models;

use App\Models\Schedule;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubjectSchedule extends Model
{
    use HasFactory;
// Used traits declaration
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
        'subject_id',
        'schedule_id',
    ];
// Model accessors declaration

    /**
     * Model relationship definition.
     * SubjectSchedule belongs to Schedule
     *
     * @return BelongsTo
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Model relationship definition.
     * SubjectSchedule belongs to Subject
     *
     * @return BelongsTo
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
