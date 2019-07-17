<?php

namespace App\Services;

use App\TheModel;

class TheModelHandler
{
    public function store($data)
    {
        return TheModel::create($data);
    }

    public function update($data, $theModel)
    {
        $theModel->update($data);
    }
}
