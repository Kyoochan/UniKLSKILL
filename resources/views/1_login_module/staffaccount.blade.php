@extends('layoutStyle.styling')

{{-- Admin create account for staff --}}
@section('content')

    <div x-data="{ tab: 'Create' }" class=" p-6 rounded-lg shadow">
        <div class="flex justify-center mt-10">

            <div class="w-8/12 bg-white p-6 rounded-lg shadow-md">
                <!-- Tabs -->
                <div class="flex border-b mb-4">
                    <button @click="tab = 'Create'"
                        :class="tab === 'Create' ?
                            'bg-orange-600 text-white shadow-md' :
                            'text-gray-600 hover:bg-orange-100'"
                        class="px-5 py-2 rounded-t-lg border-b-2 border-transparent font-semibold transition duration-200">
                        Create staff account
                    </button>

                    <button @click="tab = 'Manage'"
                        :class="tab === 'Manage'
                            ?
                            'bg-blue-600 text-white shadow-md' :
                            'text-gray-600 hover:bg-blue-100'"
                        class="px-5 py-2 rounded-t-lg border-b-2 border-transparent font-semibold transition duration-200">
                        Manage Staff Account
                    </button>



                </div>

                <!-- Content Container -->
                <div class="bg-white rounded-lg ">

                    <!-- TAB 1 -->
                    <div x-show="tab === 'Create'" x-transition>

                        <div class="flex justify-center ">

                            <div class="w-8/12 bg-white p-6 rounded-lg border-1">
                                <h2 class="text-2xl font-bold mb-4 text-center">Staff Account Management</h2>

                                {{-- Create Staff Account Form --}}
                                <form action="{{ route('staffaccount.store') }}" method="POST" class="space-y-4">
                                    @csrf

                                    @if ($errors->any())
                                        <div class="mt-4 text-red-600">
                                            <ul class="list-disc pl-5">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div>
                                        <label class="block font-medium">Staff ID</label>
                                        <input type="text" name="staff_id" value="{{ old('staff_id') }}"
                                            placeholder="Insert staff ID"
                                            class="border px-3 py-2 mb-2 mt-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                            required>
                                    </div>

                                    <div>
                                        <label class="block font-medium">Full Name</label>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            placeholder="Insert staff's name"
                                            class="border px-3 py-2 mb-2 mt-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                            required>
                                    </div>

                                    <div>
                                        <label class="block font-medium">Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            placeholder="Insert staff email"
                                            class="border px-3 py-2 mb-2 mt-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                            required>
                                    </div>

                                    <div>
                                        <label class="block font-medium">Password</label>
                                        <input type="password" name="password"
                                            placeholder="Insert password for staff account"
                                            class="border px-3 py-2 mb-2 mt-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                            required>
                                    </div>

                                    <div>
                                        <label class="block font-medium">Confirm Password</label>
                                        <input type="password" name="password_confirmation"
                                            placeholder="Reconfirm password for staff account"
                                            class="border px-3 py-2 mb-2 mt-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                            required>
                                    </div>

                                    <div>
                                        <label class="block font-medium">Assign Role</label>
                                        <select name="userRole"
                                            class="border px-3 py-2 mb-2 mt-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                            required>
                                            <option value="">Select Account Role</option>
                                            <option value="admin">Admin</option>
                                            <option value="advisor">Advisor</option>
                                            <option value="secretary">Secretary</option>
                                        </select>
                                    </div>

                                    <div class="flex justify-end mt-4">
                                        <button type="submit"
                                            class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
                                            Create Account
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 2 -->
                    <div x-show="tab === 'Manage'" x-cloak x-transition>

                        {{-- Staff List Table --}}
                        <div class="flex justify-center ">
                            <div class="w-full bg-white p-6 rounded-lg shadow-md">
                                <h2 class="text-xl font-bold mb-4 text-center border-b">Existing Staff Accounts</h2>

                                <table class=" w-full border-collapse border border-gray-300">
                                    <thead class="bg-blue-800 text-white">
                                        <tr>
                                            <th class="border border-gray-300 px-4 py-2 text-center">Staff ID</th>
                                            <th class="border border-gray-300 px-4 py-2 text-center">Name</th>
                                            <th class="border border-gray-300 px-4 py-2 text-center">Email</th>
                                            <th class="border border-gray-300 px-4 py-2 text-center">Role</th>
                                            <th class="border border-gray-300 px-4 py-2 text-center">Assigned Club</th>
                                            <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($staff as $user)
                                            <tr class="hover:bg-gray-50">
                                                <td class="border border-gray-300 px-4 py-2">{{ $user->student_id ?? '-' }}
                                                </td>
                                                <td class="border border-gray-300 px-4 py-2">{{ $user->name }}</td>
                                                <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                                                <td class="border border-gray-300 px-4 py-2 capitalize">
                                                    {{ $user->userRole }}</td>
                                                <td class="border border-gray-300 px-4 py-2">
                                                    @if ($user->userRole === 'advisor' && $user->club)
                                                        {{ $user->club->clubname }}
                                                    @elseif ($user->userRole === 'advisor')
                                                        <form action="{{ route('advisor.assign', $user->id) }}"
                                                            method="POST" class="flex items-center space-x-2">
                                                            @csrf
                                                            @method('PUT')
                                                            <select name="club_id" class="border rounded p-1" required>
                                                                <option value="">Select Club to Assign</option>
                                                                @foreach ($availableClubs as $club)
                                                                    <option value="{{ $club->id }}">
                                                                        {{ $club->clubname }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <button type="submit"
                                                                class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                                                Assign
                                                            </button>
                                                        </form>
                                                    @else
                                                        —
                                                    @endif
                                                </td>
                                                <td class="border border-gray-300 px-4 py-2 text-center">
                                                    @if ($user->userRole === 'advisor' && $user->club)
                                                        <form action="{{ route('advisor.unassign', $user->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Unassign this advisor from their club?');">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                                                Unassign
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-gray-400">N/A</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-gray-500">No staff accounts
                                                    found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
