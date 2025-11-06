<div class="relative">
    <!-- Profile Menu Button -->
    <div x-data="{ open: false }" class="relative">
        <button
            @click="open = !open"
            class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition-all duration-200 group">
            <!-- User Avatar -->
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-trello-blue to-blue-600 flex items-center justify-center text-white font-semibold text-sm shadow-md">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            
            <!-- User Name -->
            <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
            
            <!-- Chevron Down Icon -->
            <svg 
                class="w-4 h-4 text-gray-500 transition-transform duration-200"
                :class="{ 'rotate-180': open }"
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @click.away="open = false"
            class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden"
            style="display: none;">
            
            <!-- User Info Header -->
            <div class="px-4 py-3 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-trello-blue to-blue-600 flex items-center justify-center text-white font-bold shadow-md">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Menu Items -->
            <div class="py-2">
                <button
                    @click="open = false; $dispatch('edit-profile')"
                    class="w-full text-left px-4 py-2.5 hover:bg-gray-50 text-gray-700 text-sm flex items-center gap-3 transition-colors group">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                        <svg class="w-4 h-4 text-trello-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span class="font-medium">Editar Perfil</span>
                </button>

                <button
                    @click="open = false; $dispatch('change-password')"
                    class="w-full text-left px-4 py-2.5 hover:bg-gray-50 text-gray-700 text-sm flex items-center gap-3 transition-colors group">
                    <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center group-hover:bg-purple-100 transition-colors">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <span class="font-medium">Mudar Senha</span>
                </button>

                <div class="my-2 border-t border-gray-100"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="w-full text-left px-4 py-2.5 hover:bg-red-50 text-red-600 text-sm flex items-center gap-3 transition-colors group">
                        <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center group-hover:bg-red-100 transition-colors">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </div>
                        <span class="font-medium">Sair</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div
        x-data="{ show: false }"
        x-init="$nextTick(() => $watch('show', val => {
            if (val) document.body.style.overflow = 'hidden';
            else document.body.style.overflow = 'auto';
        }))"
        @edit-profile.window="show = true"
        @profile-updated.window="setTimeout(() => show = false, 1500)"
        @keydown.escape.window="show = false"
        x-show="show"
        class="fixed inset-0 bg-black/20 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        
        <div class="bg-white rounded-lg shadow-2xl max-w-md w-full" @click.stop>
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Editar Perfil</h2>
                <button
                    @click="show = false"
                    @mousedown.stop
                    @mouseup.stop
                    class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="p-6">
                <form wire:submit="updateName" class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nome</label>
                        <input
                            type="text"
                            id="name"
                            wire:model="name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-trello-blue focus:border-transparent outline-none transition-all"
                            placeholder="Seu nome" />
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Toast Message -->
                    @if ($toast && $toastType === 'success')
                        <div class="p-3 rounded-lg bg-green-50 text-green-700 text-sm">
                            {{ $toast }}
                        </div>
                    @endif

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-gray-200">
                        <button
                            type="button"
                            @click="show = false"
                            @mousedown.stop
                            @mouseup.stop
                            class="flex-1 px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors">
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            @mousedown.stop
                            @mouseup.stop
                            class="flex-1 px-4 py-2 bg-trello-blue hover:bg-blue-600 text-white rounded-lg font-medium transition-colors">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div
        x-data="{ show: false }"
        x-init="$nextTick(() => $watch('show', val => {
            if (val) document.body.style.overflow = 'hidden';
            else document.body.style.overflow = 'auto';
        }))"
        @change-password.window="show = true"
        @password-updated.window="setTimeout(() => show = false, 1500)"
        @keydown.escape.window="show = false"
        x-show="show"
        class="fixed inset-0 bg-black/20 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        
        <div class="bg-white rounded-lg shadow-2xl max-w-md w-full" @click.stop>
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Mudar Senha</h2>
                <button
                    @click="show = false"
                    @mousedown.stop
                    @mouseup.stop
                    class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="p-6">
                <form wire:submit="updatePassword" class="space-y-4">
                    <div>
                        <label for="currentPassword" class="block text-sm font-medium text-gray-700 mb-2">Senha Atual</label>
                        <input
                            type="password"
                            id="currentPassword"
                            wire:model="currentPassword"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-trello-blue focus:border-transparent outline-none transition-all"
                            placeholder="Sua senha atual" />
                        @error('currentPassword')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-2">Nova Senha</label>
                        <input
                            type="password"
                            id="newPassword"
                            wire:model="newPassword"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-trello-blue focus:border-transparent outline-none transition-all"
                            placeholder="Nova senha (mínimo 8 caracteres)" />
                        @error('newPassword')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="newPassword_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Senha</label>
                        <input
                            type="password"
                            id="newPassword_confirmation"
                            wire:model="newPassword_confirmation"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-trello-blue focus:border-transparent outline-none transition-all"
                            placeholder="Confirme a nova senha" />
                        @error('newPassword_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Toast Message -->
                    @if ($toast)
                        <div class="p-3 rounded-lg {{ $toastType === 'success' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }} text-sm">
                            {{ $toast }}
                        </div>
                    @endif

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-gray-200">
                        <button
                            type="button"
                            @click="show = false"
                            @mousedown.stop
                            @mouseup.stop
                            class="flex-1 px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors">
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            @mousedown.stop
                            @mouseup.stop
                            class="flex-1 px-4 py-2 bg-trello-blue hover:bg-blue-600 text-white rounded-lg font-medium transition-colors">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
