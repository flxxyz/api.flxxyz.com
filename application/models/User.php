<?php
namespace App\models;
use RealRap\Model\Model as Model;

class User extends Model
{
    protected $table = 'user';

    protected $primaryKey = 'id';

    protected $cast = [
        'id' => 'integer',
    ];

    protected $hidden = [
        'password',
        'email',
        'online',
        'created_at',
        'updated_at',
    ];
}