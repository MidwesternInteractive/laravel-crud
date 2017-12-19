<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModelRequest;
use App\Services\ModelCrud;
use App\Model;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Html\Builder;

class ModelsController extends Controller
{
    // We'll house our model crud service here
    private $modelCrud;

    public function __construct(ModelCrud $modelCrud)
    {
        $this->modelCrud = $modelCrud;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Model::class);

        $models = Model::all();

        return view('models.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Model::class);

        return view('models.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModelRequest $request)
    {
        $this->authorize('create', Model::class);

        $model = $this->modelCrud->create($request);

        return redirect()->route('models.show', $model);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Model $model)
    {
        $this->authorize('view', $model);

        return view('models.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Model $model)
    {
        $this->authorize('update', $model);

        return view('models.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModelRequest $request, Model $model)
    {
        $this->authorize('update', $model);

        $model = $this->modelCrud->update($request, $model);

        return redirect()->back()->with('success', 'Model Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $model)
    {
        $this->authorize('delete', $model);

        $model->delete();

        return $model;
    }
}
