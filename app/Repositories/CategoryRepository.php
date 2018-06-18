<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 17.06.18
 * Time: 12:55
 */

namespace App\Repositories;


use App\Category;

class CategoryRepository extends  Repository
{
   public function __construct(Category $category)
   {
       $this->model=$category;
   }
}