<?php
namespace App\Models;

use App\Enums\ModuleTypeEnum;
use App\States\ModuleStatus\ModuleStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStates\HasStates;

class Module extends Model
{
    use HasStates, SoftDeletes;

    protected $fillable = ['course_id', 'code', 'name', 'description', 'credit', 'type', 'state', 'published_at'];

    protected $casts = [
        'type' => ModuleTypeEnum::class,
        'state' => ModuleStatus::class,
    ];

    /**
     * @return BelongsToMany
     */
    public function semesters(): BelongsToMany
    {
        return $this->belongsToMany(Semester::class, 'semester_modules');
    }

    /**
     * @return HasMany
     */
    public function moduleTeachers(): HasMany
    {
        return $this->hasMany(ModuleTeacher::class);
    }

    /**
     * @return BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}



