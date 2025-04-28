@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-center">
            <div class="w-full max-w-md">
                <div class="bg-gray-200 shadow-md  mt-20 rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-700 text-center">{{ __('Регистрация') }}</h2>

                    <div class="mt-4">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Имя') }}</label>
                                <input id="name" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Email') }}</label>
                                <input id="email" type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Пароль') }}</label>
                                <input id="password" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password-confirm" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Повторите пароль') }}</label>
                                <input id="password-confirm" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="flex items-center justify-between">
                                <button type="submit" class="cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    {{ __('Зарегистрироваться') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
