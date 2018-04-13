<?php

namespace App\Http\Controllers;

use App\Http\Requests\TheModelRequest;
use App\Services\TheModelHandler;
use App\TheModel;
use Illuminate\Http\Request;

class TheModelController extends Controller
{
    public function __construct(TheModelHandler $theModelHandler)
    {
        $this->theModelHandler = $theModelHandler;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', TheModel::class);

        $the_models = TheModel::all();

        return view('the-models.index', compact('the_models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', TheModel::class);

        return view('the-models.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TheModelRequest $request)
    {
        $this->authorize('create', TheModel::class);

        $the_model = $this->theModelHandler->create($request);

        return redirect()->route('the-models.show', $the_model);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TheModel $theModel)
    {
        $this->authorize('view', $theModel);

        return view('the-models.show', compact('theModel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TheModel $theModel)
    {
        $this->authorize('update', $theModel);

        return view('the-models.edit', compact('theModel'));
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
        $this->authorize('update', $theModel);

        $this->theModelHandler->update($request, $theModel);

        return redirect()->back()->with('success', 'The Model Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TheModel $theModel)
    {
        $this->authorize('delete', $theModel);

        $theModel->delete();

        return $theModel;
    }
}
