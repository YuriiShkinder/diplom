<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 17.06.18
 * Time: 13:08
 */

namespace App\Repositories;


use App\Order;

class OrderRepository extends Repository
{
    public function __construct(Order $order)
    {
        $this->model=$order;
    }
}