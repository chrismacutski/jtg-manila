<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chatter extends Model
{
    protected $table = 'chatters';

    protected $fillable = [
        'nickname',
        'first_name',
        'middle_name',
        'last_name',
        'email_address',
        'phone_number',
        'is_new_chatter'
    ];

    protected $casts = [
        'is_new_chatter' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        self::created(function ($customer) {
            $customer->nickname = $customer->setNickname();
            $customer->save();
        });

        self::updating(function ($customer) {
            $customer->nickname = $customer->setNickname();
        });
    }


    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public static function findByFullName($firstName, $middleName, $lastName)
    {
        $fullName = strtoupper($firstName . ' ' . $middleName . ' ' . $lastName);

        return static::where('nickname', 'LIKE', '%' . $fullName . '%')->first();
    }

    public function setNickname()
    {
        return strtoupper(trim(sprintf('%s %s %s', $this->first_name, $this->middle_name, $this->last_name)));
    }
}
