<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
         public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

       public function update(Request $request, $id)
    {
    $data = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'role' => 'required|in:admin,colaborador',
        'password' => 'nullable|min:6', // 👈 nova validação
    ]);

    $user = User::findOrFail($id);

    // Atualiza dados básicos
    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->role = $data['role'];

    // Só altera senha se preencher
    if (!empty($request->password)) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }


    public function destroy($id)
    {
    User::findOrFail($id)->delete();
    return redirect()->route('users.index')->with('success', 'Usuário removido com sucesso!');
    }

    // Exibir listagem
    public function index()
    {
        $users = User::orderBy('id', 'asc')->get();
        return view('users.index', compact('users'));
    }

    // Exibir formulário de criação
    public function create()
    {
        return view('users.create');
    }

    // Salvar novo usuário
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email',
            'role'  => 'required|in:admin,colaborador',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso!');
    }
}
