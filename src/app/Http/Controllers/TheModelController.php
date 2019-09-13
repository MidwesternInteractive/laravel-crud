<?php

namespace App\Http\Controllers;

use App\Http\Requests\TheModelRequest;
use App\Services\TheModelHandler;
use App\TheModel;
use Illuminate\Http\Request;

class TheModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('view', TheModel::class);

        $the_models = TheModelHandler::get($request->input());

        return view('the-models.index', compact('the_models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', TheModel::class);

        return view('the-models.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TheModelRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TheModelRequest $request)
    {
        $this->authorize('create', TheModel::class);

        $the_model = TheModelHandler::store($request->input());

        return redirect()->route('the-models.show', $the_model);
    }

    /**
     * Display the specified resource.
     *
     * @param  TheModel $theModel
     * @return \Illuminate\View\View
     */
    public function show(TheModel $theModel)
    {
        $this->authorize('view', $theModel);

        return view('the-models.show', compact('theModel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  TheModel $theModel
     * @return \Illuminate\View\View
     */
    public function edit(TheModel $theModel)
    {
        $this->authorize('update', $theModel);

        return view('the-models.edit', compact('theModel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TheModelRequest  $request
     * @param  TheModel $theModel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TheModelRequest $request, TheModel $theModel)
    {
        $this->authorize('update', $theModel);

        TheModelHandler::update($request->input(), $theModel);

        return redirect()->back()->with('success', 'Log Entry Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  TheModel $theModel
     * @return TheModel $theModel
     */
    public function destroy(TheModel $theModel)
    {
        $this->authorize('delete', $theModel);

        $theModel->delete();

        return $theModel;
    }
}
