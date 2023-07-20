<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property Carbon $created_at
 *
 * @property Contact[]|Collection $contacts
 */
class Company extends Model
{
    protected $fillable = [
        'name'
    ];

    const UPDATED_AT = null;

    // Relations
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
