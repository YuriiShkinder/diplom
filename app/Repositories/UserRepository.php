<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 17.06.18
 * Time: 13:11
 */

namespace App\Repositories;


use App\User;

class UserRepository extends Repository
{
    public function __construct(User $users)
    {
        $this->model=$users;
    }
}