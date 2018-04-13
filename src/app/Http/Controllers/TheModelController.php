<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogEntryRequest;
use App\Services\LogEntryHandler;
use App\LogEntry;
use Illuminate\Http\Request;

class LogEntryController extends Controller
{
    public function __construct(LogEntryHandler $logEntryHandler)
    {
        $this->logEntryHandler = $logEntryHandler;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', LogEntry::class);

        $log_entries = LogEntry::all();

        return view('log-entries.index', compact('log_entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', LogEntry::class);

        return view('log-entries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LogEntryRequest $request)
    {
        $this->authorize('create', LogEntry::class);

        $log_entry = $this->logEntryHandler->store($request);

        return redirect()->route('log-entries.show', $log_entry);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(LogEntry $logEntry)
    {
        $this->authorize('view', $logEntry);

        return view('log-entries.show', compact('logEntry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(LogEntry $logEntry)
    {
        $this->authorize('update', $logEntry);

        return view('log-entries.edit', compact('logEntry'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LogEntryRequest $request, LogEntry $logEntry)
    {
        $this->authorize('update', $logEntry);

        $this->logEntryHandler->update($request, $logEntry);

        return redirect()->back()->with('success', 'Log Entry Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogEntry $logEntry)
    {
        $this->authorize('delete', $logEntry);

        $logEntry->delete();

        return $logEntry;
    }
}
