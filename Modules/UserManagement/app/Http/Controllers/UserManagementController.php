<?php

namespace Modules\UserManagement\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\UserManagement\Http\Requests\UserManagementRequest;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('usermanagement::index', compact('users'));
    }

    public function store(UserManagementRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);
        $data['role'] = UserRole::from($data['role']);

        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(UserManagementRequest $request, User $user)
    {
        $data = $request->validated();

        // Admin tidak boleh menurunkan role akunnya sendiri.
        if (
            auth()->id() === $user->id &&
            $data['role'] !== 'admin'
        ) {
            return back()
                ->withErrors(['role' => 'Anda tidak boleh mengubah role akun sendiri.'])
                ->withInput();
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['role'] = UserRole::from($data['role']);

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Admin tidak boleh menghapus akun sendiri.
        if (auth()->id() === $user->id) {
            return back()->withErrors([
                'user' => 'Anda tidak boleh menghapus akun sendiri.'
            ]);
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
