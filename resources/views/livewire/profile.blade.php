@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <x-navbar />

    <section class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session()->has('error'))
                <div x-data="{ show: true }" x-show="show" x-transition x-on:click="show = !show"
                    class="p-4 sm:p-8 bg-red-200 dark:bg-gray-800 shadow sm:rounded-lg cursor-pointer">
                    <div class="max-w-xl">
                        <p class="text-white font-medium">{{ session()->get('error') }}</p>
                    </div>
                </div>
            @endif

            @if (session()->has('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-on:click="show = !show"
                    class="p-4 sm:p-8 bg-green-200 dark:bg-gray-800 shadow sm:rounded-lg cursor-pointer">
                    <div class="max-w-xl">
                        <p class="text-white font-medium">{{ session()->get('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section id="profile-update-info">
                        <x-profile-header>
                            <x-slot name="title">
                                Profile Information
                            </x-slot>
                            <x-slot name="text">
                                Update your account's profile information and email address.
                            </x-slot>
                        </x-profile-header>

                        <form action="{{ route('profile.update') }}" method="post" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                    :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                    :value="old('email', $user->email)" required autocomplete="email" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>Save</x-primary-button>

                                @if (session('status') === 'profile-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400">Saved</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section id="profile-update-password">
                        <x-profile-header>
                            <x-slot name="title">
                                Update Password
                            </x-slot>
                            <x-slot name="text">
                                Ensure your account is using a long, random password to stay secure.
                            </x-slot>
                        </x-profile-header>
                        <form method="post" action="{{ route('profile.update_password') . '#profile-update-password' }}"
                            class="mt-6 space-y-6">
                            @csrf
                            @method('put')
                            <div>
                                <x-input-label for="current_password" :value="__('Current Password')" />
                                <x-text-input id="current_password" name="current_password" type="password"
                                    class="mt-1 block w-full" autocomplete="current-password" />
                                <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password" :value="__('New Password')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                                    autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                    class="mt-1 block w-full" autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>Save</x-primary-button>

                                @if (session('status') === 'password-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                        class="text-sm text-gray-600 dark:text-gray-400">Saved</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section id="profile-delete-account" class="space-y-6">
                        <x-profile-header>
                            <x-slot name="title">
                                Delete Account
                            </x-slot>
                            <x-slot name="text">
                                Once your account is deleted, all of its resources and data will be permanently deleted.
                                Before deleting your account, please download any data or information that you wish to
                                retain.
                            </x-slot>
                        </x-profile-header>

                        <x-danger-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
                            Delete Account
                        </x-danger-button>

                        <x-modal name="confirm-user-deletion" :show="session()->has('deleting_account')" focusable>
                            <form method="post" action="{{ route('profile.delete') }}" class="p-6">
                                @csrf
                                @method('delete')

                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Are you sure your want to
                                    delete your account?</h2>

                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    Once your account is deleted, all of its resources and data will be permanently deleted.
                                    Please enter your password to confirm you would like to permanently delete your account.
                                </p>

                                <div class="mt-6">
                                    <x-input-label for="delete_password" value="Password" class="sr-only" />

                                    <x-text-input id="delete_password" name="delete_password" type="password"
                                        class="mt-1 block w-3/4" placeholder="Password" required />

                                    <x-input-error :messages="session()->get('delete_password')" class="mt-2" />
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        Cancel
                                    </x-secondary-button>

                                    <x-danger-button class="ml-3">
                                        Delete Account
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection
