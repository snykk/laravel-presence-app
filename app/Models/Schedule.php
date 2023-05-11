<?php

namespace App\Models;

use App\Models\Subject;
use App\Models\SubjectSchedule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;
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
        'seq',
        'start_time',
        'end_time',
    ];
// Model accessors declaration

    /**
     * Model relationship definition.
     * Schedule has many SubjectSchedules
     *
     * @return HasMany
     */
    public function subjectSchedules(): HasMany
    {
        return $this->hasMany(SubjectSchedule::class, 'schedule_id');
    }

    /**
     * Model relationship definition.
     * Schedule belongs to many Subjects
     *
     * @return BelongsToMany
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'subject_schedule');
    }
}
