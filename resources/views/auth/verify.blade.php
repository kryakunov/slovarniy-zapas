@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-center">
            <div class="w-full max-w-md">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-700 text-center">{{ __('Verify Your Email Address') }}</h2>

                    <div class="mt-4">
                        @if (session('resent'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">{{ __('Success!') }}</strong>
                                <span class="block sm:inline">{{ __('A fresh verification link has been sent to your email address.') }}</span>
                            </div>
                        @endif

                        <p class="mt-2 text-gray-600">
                            {{ __('Before proceeding, please check your email for a verification link.') }}
                        </p>
                        <p class="mt-2 text-gray-600">
                            {{ __('If you did not receive the email') }},
                        <form class="inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="text-blue-500 hover:text-blue-700 underline">{{ __('click here to request another') }}</button>.
                        </form>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
