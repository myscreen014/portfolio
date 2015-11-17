<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/* My uses */
use Illuminate\Support\Facades\Mail;

class UserModel extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function sendEmailConfirmation() {
        $urlConfirmation = route('auth.confirmation', array($this->id, $this->key));
        $subject = 'Sujet du mail';
        return Mail::send('_emails.register', array(
            'subject' => $subject,
            'urlConfirmation' => $urlConfirmation

        ), function ($m) use ($subject) {
            $m->from('hello@app.com', 'Your Application');
            $m->to('test@tetst.fr', 'name de test')->subject($subject);
        });
    }
}
