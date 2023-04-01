<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        $users = User::query()
                    ->when($request->input('search'), function (Builder $query, $q) {
                        $query->where('name', 'like', '%' . $q . '%')
                            ->orWhere('email', 'like', '%' . $q . '%')
                            ->orWhere('role', 'like', '%' . $q . '%');
                    })->paginate(10)
                    ->withQueryString();

        return Inertia::render('Users/UserList', [
            'users' => $users,
            'filters' => $request->only(['search'])
        ]);
    }

    /**
     * Handle an incoming user add request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class)],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return Redirect::route('users.create');
    }

    /**
     * Remove the specific user.
     *
     * @param User $user
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return Redirect::route('users')->with('success', 'User successfully deleted.');
    }

    /**
     * Edit the specific user.
     *
     * @param User $user
     */
    public function edit(User $user): Response
    {
        return Inertia::render('Users/UserEdit', [
            'user' => $user,
        ]);
    }

    /**
     * Edit the specific user.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user->fill($request->only(['name', 'email']));
        $user->password = Hash::make($request->password);
        $user->save();

        return Redirect::route('users.edit', [$user]);
    }
}
