<?php
namespace App\Models;

use App\States\SyllabusStatus\SyllabusStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\ModelStates\HasStates;

class Syllabus extends Model
{
    use HasStates;
    protected $table = 'syllabuses';

    protected $fillable = ['course_id', 'year', 'state', 'published_at'];

    protected $casts = [
        'state' => SyllabusStatus::class,
    ];

    /**
     * @return BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * @return HasMany
     */
    public function semesters(): HasMany
    {
        return $this->hasMany(Semester::class);
    }
}

