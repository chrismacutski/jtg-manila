<?php

namespace App\Conversation;

use App\Conversation;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

class Message extends Model
{
    const SENDER_CHATTER = 'chatter';
    const SENDER_ADMIN = 'admin';

    const TYPE_TEXT = 'text';

    protected $table = 'conversation_messages';

    protected $fillable = [
        'type',
        'content',
        'conversation_id',
        'sent_at',
        'read_at',
        'from_admin',
        'fingerprint',
        'is_system_message',
        'idx'
    ];

    protected $casts = [
        'from_admin' => 'boolean',
        'is_system_message' => 'boolean'
    ];

    protected $dates = [
        'sent_at',
        'read_at'
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public static function setMessageFingerprint(Conversation $conversation, $fingerprint)
    {
        if (!$fingerprint) {
            return $conversation->id . time() . rand(10 * 45, 100 * 98);
        }

        return $fingerprint;
    }

    public static function findByFingerprint($fingerprint)
    {
        $id = Hashids::decode($fingerprint);

        if (!$id) {
            $message = static::where('fingerprint', $fingerprint)->first();
            if (!$message) {
                return null;
            }

            return $message;
        }

        return static::find($id[0]);
    }
}
