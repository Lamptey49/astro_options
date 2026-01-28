@extends('admin.layout')

@section('content')
<h1 class="text-3xl font-bold mb-6">User Management</h1>

<table class="w-full bg-white/5 rounded-xl overflow-hidden">
    <thead class="bg-white/10 text-left">
        <tr>
            <th class="p-4">Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Role</th>
            <th class="text-right p-4">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr class="border-t border-white/10">
            <td class="p-4">{{ $user->name }}</td>
            <td>{{ $user->email }}</td>

            <td>
                <span class="{{ $user->is_active ? 'text-green-400' : 'text-red-400' }}">
                    {{ $user->is_active ? 'Active' : 'Suspended' }}
                </span>
            </td>

            <td>
                {{ $user->is_admin ? 'Admin' : 'User' }}
            </td>

            <td class="p-4 text-right flex gap-2 justify-end">

                <!-- Toggle Status -->
                <form method="POST" action="/admin/users/{{ $user->id }}/toggle">
                    @csrf @method('PATCH')
                    <button class="px-3 py-1 rounded bg-yellow-600">
                        {{ $user->is_active ? 'Suspend' : 'Activate' }}
                    </button>
                </form>

                <!-- Toggle Admin -->
                 @if(auth()->user()->role === 'superadmin')
                <form method="POST" action="/admin/users/{{ $user->id }}/toggle-admin">
                    @csrf @method('PATCH')
                    <button class="px-3 py-1 rounded bg-indigo-600 disabled:opacity-50">
                        {{ $user->is_admin ? 'Demote' : 'Promote' }}
                    </button>
                </form>
                @endif

                <!-- Delete -->
                <form method="POST" action="/admin/users/{{ $user->id }}">
                    @csrf @method('DELETE')
                    <button class="px-3 py-1 rounded bg-red-600">
                        Delete
                    </button>
                </form>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-6">
    {{ $users->links() }}
</div>
@endsection
