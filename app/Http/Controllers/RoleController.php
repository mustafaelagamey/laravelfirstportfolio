<?php

namespace App\Http\Controllers;

use App\Events\ExecutedAction;
use App\Privilege;
use App\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{


    public function __construct()
    {
        $this->middleware('privilege:privilege.edit');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roles = Role::with('privileges')->orderBy('id','desc')->paginate(20);
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $privileges = Privilege::all();
        return view('role.create', compact('privileges'));
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
        $this->validate($request, ['name' => 'regex:/^[\pL\s\-]+$/u|required|min:5', 'privileges' => 'array|required|min:1']);
        $role = new Role();
        $role->name = $request->name;
        $privileges = Privilege::findOrFail($request->get('privileges'))->all();
        $role->save();
        $role->privileges()->saveMany($privileges);

        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $role));

        return Redirect::route('role.index');
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
        $role = Role::findOrFail($id);
        return view('role.show', compact('role'));
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
        $role = Role::findOrFail($id);
        $privileges = Privilege::all();
        $selectedPrivileges = $role->privileges->all();
        return view('role.edit', compact('role', 'privileges', 'selectedPrivileges'));
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
        $this->validate($request, ['name' => 'regex:/^[\pL\s\-]+$/u|required|min:5', 'privileges' => 'array|required|min:1']);
        $role = Role::findOrFail($id);
        $role->name = $request->get('name');
        $role->save();
        $role->privileges()->sync($request->get('privileges'));
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $role));

        return Redirect::route('role.index');

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
