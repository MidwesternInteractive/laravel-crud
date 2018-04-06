<?php

namespace App\Services;

class TheModelHandler
{
    public function store($request)
    {
        return TheModel::create($request->input());
    }

    public function update($request, $theModel)
    {
        $theModel->update($request->input());
    }
}
