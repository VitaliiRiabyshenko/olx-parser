@extends('layouts.app')

@section('content')
  <section class="py-12">
    <div class="container mx-auto px-4">
      <div class="flex justify-center">
        <div class="max-w-lg w-full">

          <div class="bg-white shadow-md rounded-lg">
            <div class="p-6 border-b border-gray-200">
              <h2 class="text-2xl font-semibold text-center text-gray-800">
                {{ __('Verify Your Email') }}
              </h2>

              <p class="mt-4 text-gray-600">
                {{ __('Before getting started, could you verify your email address by clicking on the link we just emailed to you?') }}
              </p>

              <hr class="my-4">
            </div>

            <div class="p-6">
              <form method="POST" action="{{ route('verify-email-send', ['email' => $user->email]) }}">
                @csrf

                <button 
                  class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:ring focus:ring-blue-300" 
                  type="submit">
                  {{ __('Resend Verification Email') }}
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
