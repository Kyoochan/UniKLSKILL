@extends('layoutStyle.styling')

@section('content')
    <div class="flex justify-center mt-10 mb-10">
        <div class="flex rounded-xl overflow-hidden w-full max-w-4xl shadow-lg">

            <div class="bg-white w-1/2 p-8 text-center text-black">
                <h2 class="text-3xl font-extrabold mb-6">LOGIN</h2>

                @if (session('success'))
                    <p class="text-green-500 mb-4">{{ session('success') }}</p>
                @endif
                @if ($errors->any())
                    <div class="text-red-500 mt-4 text-left">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.perform') }}" method="POST" id="loginForm" class="space-y-4">
                    @csrf

                    <input type="text" name="login" placeholder="Email or Student ID" value="{{ old('login') }}"
                        required
                        class="border p-3 rounded w-full bg-white text-black placeholder-gray-400 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-400">

                    <input type="password" id="password" name="password" placeholder="Password" required
                        class="border p-3 rounded w-full bg-white text-black placeholder-gray-400 focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-400">

                    <button type="submit"
                        class="mt-5 bg-orange-400 text-white  px-6 py-3 rounded w-full hover:bg-orange-600 transition duration-300">
                        Login
                    </button>
                </form>
                <p class="mt-4 text-black">
                    Don't have an account?
                    <a href="{{ route('register.show') }}"
                        class="text-orange-400 hover:text-orange-500 font-semibold underline">
                        Register now
                    </a>
                </p>
            </div>
            {{-- Left Blue Box --}}
            <div class="bg-blue-600 w-1/2 p-8 text-white flex flex-col justify-center items-center">
                <h2 class="text-4xl font-extrabold mb-4">Welcome Back!</h2>
                <div class="flex-shrink-0">
                    <img src="{{ asset('images/homepage_sec2img2.png') }}" alt="Sample Image"
                        class="rounded-lg w-100 h-100 object-cover ">
                </div>
                <p class="text-lg text-center">Login to access your UniKLSKILL account and manage your activities.</p>
            </div>
        </div>
    </div>
@endsection
