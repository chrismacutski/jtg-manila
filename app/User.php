<?php

namespace App;

use App\User\EmailAddress;
use App\User\PhoneNumber;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'password',
        'phone_number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'name'
    ];

    public function phone_numbers()
    {
        return $this->hasMany(PhoneNumber::class);
    }

    public function email_addresses()
    {
        return $this->hasMany(EmailAddress::class);
    }

    public function getNameAttribute()
    {
        return sprintf('%s %s', $this->first_name, $this->last_name);
    }

    public function attachPhoneNumber($phone_number)
    {
        if ($phone_number != '') {
            $this->phone_numbers()->firstOrCreate(['phone_number' => $phone_number]);
        }
    }

    public function updatePhoneNumber($params)
    {
        $this->phone_numbers()->where('id', $params['id'])->update(['phone_number' => $params['phone_number']]);
    }

    public function detachPhoneNumber($params)
    {
        $this->phone_numbers()->where('id', $params['id'])->where('phone_number', $params['phone_number'])->delete();
    }

    public function attachEmailAddress($email_address)
    {
        if ($email_address != '') {
            $this->email_addresses()->firstOrCreate(['email_address' => $email_address]);
        }
    }

    public function updateEmailAddress($params)
    {
        $this->email_addresses()->where('id', $params['id'])->update(['email_address' => $params['email_address']]);
    }

    public function detachEmailAddress($params)
    {
        $this->email_addresses()->where('id', $params['id'])->where('email_address', $params['email_address'])->delete();
    }
}
