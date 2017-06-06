<?php

namespace App\Http\Controllers;

use App\Events\Event;
use App\Events\ExecutedAction;
use App\Log;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Validator;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($logable = null)
    {
        //
        $withTrashed = Auth::user()->hasAccess(['log.deletePermanent', 'log.restore']);

        if (!is_null($logable)) {
            if ($withTrashed)
                $logs = Log::where('logable_type', 'App\\' . ucfirst(strtolower($logable)))->with('user', 'logable')->withTrashed()->orderBy('id', 'desc')->paginate(200);
            else
                $logs = Log::where('logable_type', 'App\\' . ucfirst(strtolower($logable)))->with('user', 'logable')->orderBy('id', 'desc')->paginate(20);
//
        } else {
            $logs = Log::with('user', 'logable')->orderBy('id', 'desc')->paginate(20);
            if ($withTrashed)
                $logs = Log::with('user', 'logable')->withTrashed()->orderBy('id', 'desc')->paginate(200);
        }
        return view('log.index', compact('logs', compact('withTrashed')));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public static function storeEvent(Event $event)
    {
        //

        $log = new Log();
        $log->user()->associate($event->user);
        $log->name = $event->action;
        $event->affectedElement->logs()->save($log);

//        $log->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $destroyedLog = Log::findOrFail($id);
        $destroyedLog->delete();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $destroyedLog));

        return Redirect::route('log.index');
    }

    public function permanentDelete($id)
    {

        //
        $deletedLog = Log::withTrashed()->findOrFail($id);
        $deletedLog->forceDelete();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $deletedLog));

        return Redirect::route('log.index');

    }

    public function restore($id)
    {

        //
        $restoredLog = Log::withTrashed()->findOrFail($id);
        $restoredLog->restore();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $restoredLog));

        return Redirect::route('log.index');

    }
}
