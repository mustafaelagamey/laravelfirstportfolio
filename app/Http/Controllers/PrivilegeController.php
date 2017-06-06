<?php

namespace App\Http\Controllers;

use App\Events\ExecutedAction;
use App\Http\Middleware\Privilege as PrivilegeMiddleware;
use App\Role;
use App\Privilege;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PrivilegeController extends Controller
{

    public function __construct()
    {


        $this->middleware('privilege:privilege.edit');

//        $this->middleware('privilege:user.read', ['only' => ['index']]);
//        $this->middleware('privilege:user.create', ['only' => ['create', 'store']]);
//        $this->middleware('privilege:user.deactivate', ['only' => ['deactivate' ]]);
//        $this->middleware('privilege:user.fullRead', ['only' => ['indexAdmin']]);
//        $this->middleware('privilege:user.edit', ['only' => ['edit', 'update']]);
//        $this->middleware('privilege:user.activate', ['only' => [ ]]);
//        $this->middleware('privilege:mainAdmin', ['only' => ['restore' ]]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $privileges = Privilege::with('roles')->paginate(20);


        return view('privilege.index', compact('privileges'));

        //

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

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $privilege = Privilege::findOrFail($id);
        return view('privilege.show', compact('privilege'));

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
        $privilege = Privilege::findOrFail($id);
        $roles = Role::all();
        $selectedRoles = $privilege->roles->all();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $privilege));

        return view('privilege.edit', compact('privilege', 'roles', 'selectedRoles'));
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
        $this->validate($request, ['name' => 'regex:/^[\pL\s\-]+$/u|required|min:5', 'roles' => 'array|required|min:1']);
//        dd($request->get('roles'));
        $privilege = Privilege::findOrFail($id);
        $privilege->roles()->sync($request->get('roles'));
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $privilege));

        return Redirect::route('privilege.index');

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
    }
}
