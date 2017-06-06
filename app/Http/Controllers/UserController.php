<?php

namespace App\Http\Controllers;

use App\Events\ExecutedAction;
use App\Http\Controllers\Auth\AuthController;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    public function __construct()
    {

        $this->middleware('activation', ['except' => ['index']]);


        $privileges = [
//            'post.read'=>[],  // subscriber
//            'post.create'=>,  // creator
//            'post.edit'=>[''],   //editor
//            'post.delete'=>[], // admin
//            'post.deletePermanent'=>[], // main admin

            'user.read' => ['index'],
            'user.create' => ['create', 'store'],
            'user.deactivate' => ['deactivate'],  //admin
            'user.edit' => ['edit', 'update'],
            'user.activate' => ['activate'],
            'user.fullRead' => ['indexAdmin'],

            'user.enable' => ['enable'], // main admin
            'user.disable' => ['disable'], // main admin
        ];

        foreach ($privileges as $key => $privilege) {
            $this->middleware('privilege:' . $key, ['only' => $privilege]);

        }


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
        //
//        return Redirect::route('user.indexAdmin');


        // kill eager loading (with) and get users depend on relation columns values
        $users = User::with('role')->whereHas('role', function ($query) {
            $query->where('name', '!=', 'mainAdmin')->where('name', '!=', 'admin');
        })->get();


        return view('user.index', compact('users'));
    }

    public function indexAdmin()
    {
        //

        $users = User::with('role')->all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('user.create');

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
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);


        $user = new User();
//        die(var_dump($request->all()) );
        $user->email = $request->email;
        $user->name = $request->name;

        $user->password = bcrypt($request->password);

        $user->save();

        return Redirect::route('user.index');

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
        $user = User::findOrFail($id);
        return view('user.show',compact('user'));

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
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));

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

        $privilegeAccess = Auth::user()->hasAccess('privilege.edit');
        $this->validate($request, [
            'name' => 'required|max:255',
            'password' => 'min:6',
            'role' => $privilegeAccess ? 'required' : null
        ]);

        $user = User::findOrFail($id);
        if ($user->email !== $request->email)
            $this->validate($request, [
                'email' => 'required|email|max:255|unique:users',
            ]);
        $user->email = $request->email;
        $user->name = $request->name;
//        dd($user->password,
//            bcrypt($request->password)
//        );
        if (isset($request->password) && $request->password != '')
            if ($user->password != bcrypt($request->password))
                $user->password = bcrypt($request->password);
        if ($privilegeAccess)
            $user->role()->associate($request->get('role'));
        $user->save();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $user));

        return Redirect::route('user.index');
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

        $user = User::findOrFail($id);
        $user->delete();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $user));
        return Redirect::route('user.index');

    }

    public function deactivate($id)
    {
        //
        $user = User::findOrFail($id);
        $user->activated = false;
        $user->save();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $user));

        return Redirect::route('user.index');

    }

    public function activate($id)
    {
        //
        $user = User::findOrFail($id);
        $user->activated = true;
        $user->save();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $user));

        return Redirect::route('user.index');

    }

    public function disable($id)
    {
        //
        $user = User::findOrFail($id);
        $user->enabled = false;
        $user->save();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $user));

        return Redirect::route('user.index');

    }

    public function enable($id)
    {
        //
        $user = User::findOrFail($id);
        $user->enabled = true;
        $user->save();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $user));

        return Redirect::route('user.index');

    }


}
