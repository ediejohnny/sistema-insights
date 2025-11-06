<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use function Livewire\Volt\{state, rules, layout, title};

state(['name' => '', 'email' => '', 'password' => '', 'password_confirmation' => '']);

rules([
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:users',
    'password' => 'required|string|min:6|confirmed',
]);

layout('components.layouts.app');
title('Registro - Quadro de Insights');

$register = function () {
    $validated = $this->validate();
    
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);
    
    auth()->login($user, true);
    request()->session()->regenerate();
    
    return $this->redirect('/', navigate: true);
};

?>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-trello-blue to-trello-gray">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <div class="flex justify-center mb-4">
                <svg class="w-16 h-16 text-trello-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">
                Quadro de Insights
            </h1>
            <h2 class="text-xl text-center text-gray-600 mb-8">Criar Conta</h2>

            <form wire:submit="register" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Nome
                    </label>
                    <input
                        type="text"
                        id="name"
                        wire:model="name"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-trello-blue focus:border-transparent"
                    />
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        E-mail
                    </label>
                    <input
                        type="email"
                        id="email"
                        wire:model="email"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-trello-blue focus:border-transparent"
                    />
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Senha
                    </label>
                    <input
                        type="password"
                        id="password"
                        wire:model="password"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-trello-blue focus:border-transparent"
                    />
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        Confirmar Senha
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        wire:model="password_confirmation"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-trello-blue focus:border-transparent"
                    />
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full bg-trello-blue text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors"
                >
                    Registrar
                </button>
            </form>

            <p class="text-center mt-6 text-gray-600">
                Já tem uma conta?
                <a href="{{ route('login') }}" class="text-trello-blue hover:underline font-medium">
                    Fazer login
                </a>
            </p>
        </div>
    </div>
</div>
