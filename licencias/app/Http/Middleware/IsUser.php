<?php
/**
 * Created by PhpStorm.
 * User: taxque
 * Date: 25/09/16
 * Time: 02:03 AM
 */
namespace CityBoard\Http\Middleware;
class IsUser extends IsType{
    public function getType()
    {
        return 2;
    }
}