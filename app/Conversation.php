<?php

namespace App;

use App\Conversation\Message;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    const STATUS_OPEN = 'open';
    const STATUS_CLOSING = 'closing';
    const STATUS_CLOSED = 'closed';

    protected $table = 'conversations';

    protected $fillable = [
        'link',
        'session_id',
        'user_id',
        'chatter_id',
        'status',
        'received_at',
        'was_queued',
        'queued_at',
        'queued_time',
        'assigned_at',
        'assigned_time',
        'was_sent_queueing_message',
        'was_sent_auto_reply',
        'queue_position',
        'actual_handling_time',
        'agent_handling_time'
    ];

    protected $casts = [
        'was_queued' => 'boolean',
        'was_sent_queueing_message' => 'boolean',
        'was_sent_auto_reply' => 'boolean'
    ];

    protected $dates = [
        'received_at',
        'closed_at',
        'assigned_at',
        'queued_at'
    ];

    protected static function boot()
    {
        parent::boot();

        self::created(function ($conversation) {
            $conversation->link = route('conversations.show', [$conversation->id, $conversation->session_id]);
            $conversation->save();
        });
    }

    public function admin()
    {
        return $this->belongsTo(User::class);
    }

    public function chatter()
    {
        return $this->belongsTo(Chatter::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function scopeNew($query)
    {
        $query->whereNull('user_id');
    }

    public function scopeWithSessionId($query, $sessionId)
    {
        $query->where('session_id', $sessionId);
    }

    public function scopeOfUser($query, User $user)
    {
        $query->where('user_id', $user->id);
    }

    public function scopeWithStatus($query, $status)
    {
        $query->where('status', $status);
    }

    public function scopeWasQueued($query)
    {
        $query->where('was_queued', true);
    }

    public function getMessageCountAttribute()
    {
        return $this->messages()->count();
    }

    public static function findBySessionId($sessionId)
    {
        return static::where('session_id', $sessionId)->first();
    }

    public function getRouteKey()
    {
        return $this->sessionId();
    }

    public function sessionId()
    {
        return $this->session_id;
    }

    public function getRouteKeyName()
    {
        return 'sessionId';
    }

    public function hasAssignedAdmin()
    {
        return is_null($this->user_id) ? false : true;
    }

    public function assignTo(User $user)
    {
        $this->assigned_at = now();
        $this->assignment_time = $this->assigned_at->diffInSeconds($this->received_at);


        if ($this->was_queued === true) {
            $this->queued_time = $this->queued_at->diffInSeconds($this->assigned_at);
        }

        $this->user_id = $user->id;
        $this->queue_position = 0;
        $this->save();

        event(new ConversationAssigned($this));

        return $this;
    }

    public function unassign()
    {
        if ($this->was_queued != true) {
            $this->queued_at = now();
        }

        $this->was_queued = true;
        $this->assigned_at = NULL;
        $this->assignment_time = NULL;

        $this->user_id = NULL;
        $this->save();

        return $this;
    }

    public function close(Carbon $closedAt)
    {
        $has_agent_reply = $this->messages()->where('from_agent', true)
            ->where('is_system_message', false)
            ->first();

        if (!$has_agent_reply) {
            throw new \Exception("Conversation cannot be closed, awaiting reply from the agent");
        }

        $this->status = Conversation::STATUS_CLOSED;
        $this->closed_at = $closedAt;

        $this->save();

        if ($this->agent) {
            if ($this->agent->current_conversation_count > 0) {
                $this->agent->current_conversation_count--;
                $this->agent->save();
            }
        }

        logger("Conversation Closed Event Dispatched");
        event(new ConversationClosed($this));

        return $this;
    }

    public function addMessage($params)
    {
        $content = $params['content'];

        if (is_null($content)) {
            return;
        }

        if ($content == '') {
            return;
        }

        $fingerprint = Message::setMessageFingerprint($this, $params['fingerprint']);

        $message = $this->messages()->firstOrCreate([
            'fingerprint' => $fingerprint,
        ], [
            'type'  => $params['type'],
            'content'  => $content,
            'sent_at' => $params['sent_at'],
            'from_admin' => $params['from_admin'],
            'is_system_message' => $params['is_system_message'],
            'idx' => $params['idx']
        ]);

        return $message;
    }

    public function setInitialPayload()
    {
        $data = $this->toArray();

        $data['messages'] = $this->messages ? $this->messages->toArray() : null;
        $data['chatter'] = $this->chatter ? $this->chatter->toArray() : null;
        $data['admin'] = $this->user ? $this->user->toArray() : null;

        return $data;
    }

    public function setPayload(Message $message)
    {
        $data = $this->toArray();

        $data['messages'] = $message->toArray();
        $data['chatter'] = $this->chatter->toArray();
        $data['admin'] = $this->user ? $this->user->toArray() : null;

        return $data;
    }
}
