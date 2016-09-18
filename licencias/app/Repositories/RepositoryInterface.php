<?php
/**
 * Created by PhpStorm.
 * User: miguel
 * Date: 21/01/16
 * Time: 13:39
 */

namespace CityBoard\Repositories;

use Illuminate\Http\Request;

interface RepositoryInterface
{
    public function all();

    public function paginate($number);

    public function findOrFailById($id);

    public function create(Request $request);

    public function update(Request $request, $id);
}