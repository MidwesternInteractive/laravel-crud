<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TheModelRequest;
use App\Services\TheModelHandler;
use App\TheModel;
use Illuminate\Http\Request;

class TheModelController extends ApiController
{
    protected $the_model_handler;

    public function __construct(TheModelHandler $theModelHandler)
    {
        $this->the_model_handler = $theModelHandler;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->safeCall(function() {
            $this->authorize('view', TheModel::class);

            $the_models = TheModel::all();

            return $the_models;
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\TheModel
     */
    public function store(TheModelRequest $request)
    {
        return $this->safeCall(function() use ($request) {
            $this->authorize('create', TheModel::class);

            $the_model = $this->the_model_handler->store($request->input());

            return $theModel;
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TheModel  $theModel
     * @return \App\TheModel
     */
    public function show(TheModel $theModel)
    {
        return $this->safeCall(function() use ($theModel) {
            $this->authorize('view', $theModel);

            return $theModel;
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TheModel  $theModel
     * @return \App\TheModel
     */
    public function update(TheModelRequest $request, TheModel $theModel)
    {
        return $this->safeCall(function() use ($request, $theModel) {
            $this->authorize('update', $theModel);

            $this->the_model_handler->update($request->input(), $theModel);

            return $theModel;
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TheModel  $theModel
     * @return \App\TheModel
     */
    public function destroy(TheModel $theModel)
    {
        return $this->safeCall(function() use ($theModel) {
            $this->authorize('delete', $theModel);

            $theModel->delete();

            return $theModel;
        });
    }
}
