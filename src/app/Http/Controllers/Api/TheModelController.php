<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TheModelRequest;
use App\Services\TheModelHandler;
use App\TheModel;
use Illuminate\Http\Request;

class TheModelController extends ApiController
{
    public function __construct(TheModelHandler $theModelHandler)
    {
        $this->the_model_handler = $theModelHandler;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->safeCall(function() {
            $this->authorize('view', TheModel::class);

            $the_models = TheModel::all();

            return view('the-models.index', compact('the_models'));
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TheModelRequest $request)
    {
        $this->safeCall(function() use ($request) {
            $this->authorize('create', TheModel::class);

            $the_model = $this->the_model_handler->store($request->input());

            return redirect()->route('the-models.show', $the_model);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TheModel $theModel)
    {
        $this->safeCall(function() use ($theModel) {
            $this->authorize('view', $theModel);

            return view('the-models.show', compact('theModel'));
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TheModelRequest $request, TheModel $theModel)
    {
        $this->safeCall(function() use ($request, $theModel) {
            $this->authorize('update', $theModel);

            $this->the_model_handler->update($request->input(), $theModel);

            return redirect()->back()->with('success', 'Log Entry Updated Successfully!');
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TheModel $theModel)
    {
        $this->safeCall(function() use ($theModel) {
            $this->authorize('delete', $theModel);

            $theModel->delete();

            return $theModel;
        });
    }
}
