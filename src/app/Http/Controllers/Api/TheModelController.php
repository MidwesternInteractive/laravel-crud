<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TheModelRequest;
use App\Services\TheModelHandler;
use App\TheModel;
use Illuminate\Http\Request;

class TheModelController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->safeCall(function() use ($request) {
            $this->authorize('view', TheModel::class);

            $the_models = TheModelHandler::get($request->input());

            return fractal($the_models, new TheModelTransformer)->respond();
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(TheModelRequest $request)
    {
        return $this->safeCall(function() use ($request) {
            $this->authorize('create', TheModel::class);

            $the_model = TheModelHandler::store($request->input());

            return fractal($the_model, new TheModelTransformer)->respond();
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TheModel  $theModel
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show(TheModel $theModel)
    {
        return $this->safeCall(function() use ($theModel) {
            $this->authorize('view', $theModel);

            return fractal($the_model, new TheModelTransformer)->respond();
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TheModel  $theModel
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(TheModelRequest $request, TheModel $theModel)
    {
        return $this->safeCall(function() use ($request, $theModel) {
            $this->authorize('update', $theModel);

            TheModelHandler::update($request->input(), $theModel);

            return fractal($the_model, new TheModelTransformer)->respond();
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TheModel  $theModel
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy(TheModel $theModel)
    {
        return $this->safeCall(function() use ($theModel) {
            $this->authorize('delete', $theModel);

            $theModel->delete();

            return fractal($the_model, new TheModelTransformer)->respond();
        });
    }
}
