<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    protected $table = 'password_reset_tokens';

    protected $fillable = ['email', 'token', 'code'];

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
