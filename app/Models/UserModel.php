<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'email',
        'name',
        'profile_picture',
        'password_hash', // Add 'profile_picture' if not already present
    ];
}
