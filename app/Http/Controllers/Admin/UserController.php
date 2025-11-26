<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Evento;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        return view('admin.users.index', ['users' => $users]);
    }

    public function create()
    {
        $eventos = Evento::orderBy('nome', 'asc')->get();
        return view('admin.users.create', ['eventos' => $eventos]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:administrador,organizador',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Attach eventos if role is organizador and eventos are selected
        if ($request->role === 'organizador' && $request->has('eventos')) {
            $user->eventos()->sync($request->eventos);
        }

        return redirect()->route('admin.users.index')->with('sucesso', 'Usuário criado com sucesso!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $eventos = Evento::orderBy('nome', 'asc')->get();
        return view('admin.users.edit', ['user' => $user, 'eventos' => $eventos]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:administrador,organizador',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Sync eventos if role is organizador
        if ($request->role === 'organizador' && $request->has('eventos')) {
            $user->eventos()->sync($request->eventos);
        } elseif ($request->role === 'organizador') {
            $user->eventos()->sync([]);
        }

        return redirect()->route('admin.users.index')->with('sucesso', 'Usuário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('erro', 'Você não pode excluir seu próprio usuário.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('sucesso', 'Usuário excluído com sucesso!');
    }
}
