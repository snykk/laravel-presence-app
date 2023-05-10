<?php

namespace App\Models;

use App\Models\Department;
use App\Models\Schedule;
use App\Models\SubjectSchedule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RichanFongdasen\I18n\Contracts\TranslatableModel;
use RichanFongdasen\I18n\Eloquent\Extensions\Translatable;

class Subject extends Model implements TranslatableModel
{
    use HasFactory;
    use Translatable;
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
        'department_id',
        'code',
        'score_credit',
        'title',
    ];

    /**
     * List all of the translatable attributes.
     *
     * @var string[]
     */
    protected array $translateFields = [
        'title',
    ];

    /**
     * The database table which stores all of the translation values.
     *
     * @var string
     */
    protected string $translationTable = 'subject_translations';

    /**
     * Get title attribute (accessor).
     *
     * @return string
     */
    public function getTItleAttribute(): string
    {
        return (string) $this->getAttribute('title');
    }

    /**
     * Model relationship definition.
     * Subject belongs to Department
     *
     * @return BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Model relationship definition.
     * Subject belongs to many Schedules
     *
     * @return BelongsToMany
     */
    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(Schedule::class, 'subject_schedule');
    }

    /**
     * Model relationship definition.
     * Subject has many SubjectSchedules
     *
     * @return HasMany
     */
    public function subjectSchedules(): HasMany
    {
        return $this->hasMany(SubjectSchedule::class, 'subject_id');
    }
}
