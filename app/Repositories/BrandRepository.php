<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 17.06.18
 * Time: 13:12
 */

namespace App\Repositories;


use App\Brand;

class BrandRepository extends Repository
{
    public function __construct(Brand $brand)
    {
        $this->model=$brand;
    }
}