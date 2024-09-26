<?php

namespace LaravelCompany\Mail\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageFailure extends BaseModel
{
    protected $table = 'message_failures';

    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }
}
