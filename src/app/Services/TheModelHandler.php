<?php

namespace App\Services;

use App\TheModel;

class TheModelHandler
{
    public static function get($data)
    {
        return TheModel::all();
    }

    public static function store($data)
    {
        return TheModel::create($data);
    }

    public static function update($data, $theModel)
    {
        return $theModel->update($data);
    }
}
