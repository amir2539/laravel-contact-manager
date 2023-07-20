<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $note
 * @property int $contact_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Contact $contact
 */
class ContactNote extends Model
{
    protected $fillable = [
        'note'
    ];

    // Relations
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
