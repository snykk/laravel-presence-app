<?php

namespace App\Models;

use App\Models\DepartmentTranslation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RichanFongdasen\I18n\Contracts\TranslatableModel;
use RichanFongdasen\I18n\Eloquent\Extensions\Translatable;

class Department extends Model implements TranslatableModel
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
        'code',
        'name',
        'description',
    ];

    /**
     * List all of the translatable attributes.
     *
     * @var string[]
     */
    protected array $translateFields = [
        'name',
        'description',
    ];

    /**
     * The database table which stores all of the translation values.
     *
     * @var string
     */
    protected string $translationTable = 'department_translations';


    /**
     * Get name attribute (accessor).
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return (string) $this->getAttribute('name');
    }

    /**
     * Get description attribute (accessor).
     *
     * @return string
     */
    public function getDescriptionAttribute(): string
    {
        return (string) $this->getAttribute('description');
    }
}
