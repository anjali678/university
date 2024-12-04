<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStates\HasStates;
use App\States\CourseStatus\CourseStatus;

class Course extends Model
{
    use HasStates, SoftDeletes;

    protected $fillable = ['faculty_id', 'name', 'seo_url', 'credit', 'state', 'published_at'];

    protected $casts = [
        'state' => CourseStatus::class,
    ];

    /**
     * @return BelongsTo
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * @return HasMany
     */
    public function syllabuses(): HasMany
    {
        return $this->hasMany(Syllabus::class);
    }

    /**
     * @return HasMany
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }
}

