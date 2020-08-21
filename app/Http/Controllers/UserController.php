<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserPasswordRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('users.index', ['users' => $model->paginate(15)]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request, User $model)
    {
        $model->create(
            $request->merge([
                'password'  => Hash::make($request->get('password'))
            ])->all()
        );

        return redirect()->route('user.index')->withStatus(__('usuario creado correctamente.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit($id, User $model)
    {
        $user = $model->where('id', $id)->first();
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $id)
    {   
        $user = User::find($id);
        $user->update($request->all());
        return redirect()->route('user.index')->withStatus(__('Usuario actualizado.'));
    }

    public function password(UserPasswordRequest $request, $id)
    {
        $user = User::find($id);
        $user->update(['password' => Hash::make($request->get('password'))]);
        return back()->withPasswordStatus(__('Contraseña actualizada.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::destroy($id);

        return redirect()->route('user.index')->withStatus(__('Usuario eliminado exitosamente.'));
    }
}
