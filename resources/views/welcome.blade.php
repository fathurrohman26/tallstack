@extends('layouts.app')

@php($title = Auth::user() !== null ? 'Home' : 'Welcome')

@section('title', $title)

@section('content')
    <x-navbar />

    @auth
        <form method="post" action="{{ route('verification.resend') }}" id="send-verification">
            @csrf
        </form>
    @endauth

    <section class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session()->has('status') && session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-on:click="show = !show"
                    class="p-4 sm:p-8 bg-blue-200 dark:bg-gray-800 shadow sm:rounded-lg cursor-pointer">
                    <div class="">
                        <p class="text-white font-medium">
                            An email from the system containing a link to activate your new account email has been sent, if
                            you don't receive it use the link below to resend the activation email.
                        </p>
                    </div>
                </div>
            @endif

            @auth
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <p class="font-medium">
                        Welcome back <span class="font-extralight italic">{{ Auth::user()->name }}</span>
                    </p>

                    @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !Auth::user()->hasVerifiedEmail())
                        <div class="mt-8">
                            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                Your email address is unverified.

                                <button form="send-verification"
                                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none">
                                    Click here to re-send the verification email.
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                    A new verification link has been sent to your email address.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            @else
                <div class="mt-16">
                    <ul class="md:grid md:grid-cols-2 gap-8 md:gap-10">
                        <li>
                            <div class="flex bg-white shadow-sm rounded-xl p-5">
                                <div class="flex-shrink-0">
                                    <div
                                        class="flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-br from-teal-400 to-sky-500 text-white">
                                        <img src="https://cdn.devdojo.com/images/august2022/tailwind-icon.png"
                                            alt="Tailwind Icon" class="h-6 w-auto">
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h5 class="text-lg leading-6 font-medium text-gray-900"><a href="https://tailwindcss.com/"
                                            target="_blank" class="hover:underline hover:text-sky-400">Tailwind CSS</a></h5>
                                    <p class="mt-2 text-base leading-6 text-gray-700">
                                        With Tailwind's utility classes, you're writing custom CSS without the CSS. Build your
                                        own customized designs with the ease of Bootstrap and the flexibility of handwritten
                                        CSS.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="mt-10 md:mt-0">
                            <div class="flex bg-white shadow-sm rounded-xl p-5">
                                <div class="flex-shrink-0">
                                    <div
                                        class="flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-br from-teal-400 to-sky-500 text-white">
                                        <img src="https://cdn.devdojo.com/images/august2022/alpine-icon.png" alt="Alpine Icon"
                                            class="h-5 w-auto">
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h5 class="text-lg leading-6 font-medium text-gray-900"><a href="https://alpinejs.dev/"
                                            target="_blank" class="hover:underline hover:text-sky-400">Alpine.js</a></h5>
                                    <p class="mt-2 text-base leading-6 text-gray-700">
                                        Alpine.js is a tiny, declarative JavaScript framework that allows you to create simple
                                        interactive components on the page. Perfectly paired with Livewire, and by the same
                                        creator.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="mt-10 md:mt-0">
                            <div class="flex bg-white shadow-sm rounded-xl p-5">
                                <div class="flex-shrink-0">
                                    <div
                                        class="flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-br from-teal-400 to-sky-500 text-white">
                                        <img src="https://cdn.devdojo.com/images/august2022/laravel-icon.png" alt="Laravel Icon"
                                            class="h-9 ml-1 mt-0.5 w-auto">
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h5 class="text-lg leading-6 font-medium text-gray-900"><a href="https://laravel.com/"
                                            target="_blank" class="hover:underline hover:text-sky-400">Laravel</a></h5>
                                    <p class="mt-2 text-base leading-6 text-gray-700">
                                        Robust, mature, powerful, and flexible, with an incredible community, Laravel is one of
                                        the leading full-stack web frameworks.
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="mt-10 md:mt-0">
                            <div class="flex bg-white shadow-sm rounded-xl p-5">
                                <div class="flex-shrink-0">
                                    <div
                                        class="flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-br from-teal-400 to-sky-500 text-white">
                                        <img src="https://cdn.devdojo.com/images/august2022/livewire-icon.png"
                                            alt="Livewire Icon" class="h-8 w-auto">
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h5 class="text-lg leading-6 font-medium text-gray-900"><a
                                            href="https://laravel-livewire.com/" target="_blank"
                                            class="hover:underline hover:text-sky-400">Livewire</a></h5>
                                    <p class="mt-2 text-base leading-6 text-gray-700">
                                        Laravel view components, delivered seamlessly to your users via JavaScript that <em>you
                                            don't have to write</em>.
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            @endauth
        </div>
    </section>
@endsection
