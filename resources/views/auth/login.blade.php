@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-center">
            <div class="w-full max-w-md ">
                <div class="bg-gray-200 mt-20 shadow-md rounded-lg p-6 ">
                    <h2 class="text-lg font-semibold text-gray-700 text-center">Войти</h2>

                    <div class="mt-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Email') }}</label>
                                <input id="email" type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Пароль') }}</label>
                                <input id="password" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4 flex items-center">
                                <input class="mr-2 leading-tight" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="text-sm" for="remember">Запомнить меня</label>
                            </div>

                            <div class="flex items-center justify-between">
                                <button type="submit" class="cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Войти
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('password.request') }}">
                                        Забыли пароль?
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
