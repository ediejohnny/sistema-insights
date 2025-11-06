<div x-data="{ loaded: true }">
    <!-- Loading Skeleton -->
    <div 
        wire:loading 
        wire:target="save,delete"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 transition-opacity duration-300"
    >
        <!--[if BLOCK]><![endif]--><?php for($i = 0; $i < 3; $i++): ?>
            <div class="bg-white bg-opacity-50 rounded-lg shadow-md p-5 animate-pulse">
                <div class="h-6 bg-gray-200 rounded mb-3"></div>
                <div class="h-20 bg-gray-200 rounded mb-4"></div>
                <div class="h-4 bg-gray-200 rounded w-1/2"></div>
            </div>
        <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <!-- Empty State -->
    <!--[if BLOCK]><![endif]--><?php if(count($insights) === 0): ?>
        <div 
            wire:loading.remove 
            wire:target="save,delete"
            class="text-center py-20 transition-opacity duration-300"
        >
            <svg class="w-24 h-24 mx-auto mb-4 text-white text-opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h2 class="text-2xl font-bold text-white mb-2">Nenhum insight ainda</h2>
            <p class="text-white text-opacity-80 mb-6">Clique no botão "+" para criar seu primeiro insight!</p>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Insights Grid -->
    <?php if(count($insights) > 0): ?>
        <div 
            wire:loading.remove 
            wire:target="save,delete"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 transition-opacity duration-300"
        >
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $insights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $insight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div 
                    wire:key="insight-<?php echo e($insight['id']); ?>"
                    wire:click="openModal(<?php echo e($insight['id']); ?>)"
                    class="bg-white rounded-lg shadow-md p-5 hover:shadow-xl hover:-translate-y-1 transition-all duration-200 relative group animate-fadeIn cursor-pointer flex flex-col"
                    style="max-height: 400px;"
                >
                    <div class="flex justify-between items-start mb-3 flex-shrink-0">
                        <h3 class="text-lg font-semibold text-gray-800 flex-1 pr-2 break-words">
                            <?php echo e($insight['title']); ?>

                        </h3>
                        <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity flex-shrink-0">
                            <button
                                wire:click.stop="openModal(<?php echo e($insight['id']); ?>)"
                                class="text-blue-600 hover:text-blue-800 hover:scale-110 transition-transform"
                                title="Editar"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button
                                wire:click.stop="confirmDelete(<?php echo e($insight['id']); ?>)"
                                class="text-red-600 hover:text-red-800 hover:scale-110 transition-transform"
                                title="Excluir"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex-1 overflow-hidden mb-4">
                        <p class="text-gray-600 text-left break-words line-clamp-6">
                            <?php echo e($insight['content']); ?>

                        </p>
                    </div>
                    
                    <div class="text-sm text-gray-400 flex items-center flex-shrink-0">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <?php echo e(\Carbon\Carbon::parse($insight['created_at'])->diffForHumans()); ?>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Floating Add Button -->
    <button
        wire:click="openModal"
        class="fixed bottom-8 right-8 bg-trello-blue text-white w-16 h-16 rounded-full shadow-lg hover:bg-blue-700 hover:shadow-xl transition-all flex items-center justify-center z-40"
        title="Adicionar novo insight"
    >
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
    </button>

    <!-- Toast Notification -->
    <!--[if BLOCK]><![endif]--><?php if($toast['show']): ?>
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition
            class="fixed top-20 right-4 bg-white rounded-lg shadow-lg p-4 z-50 <?php echo e($toast['type'] === 'success' ? 'border-l-4 border-green-500' : 'border-l-4 border-red-500'); ?>"
        >
            <p class="font-medium <?php echo e($toast['type'] === 'success' ? 'text-green-800' : 'text-red-800'); ?>">
                <?php echo e($toast['message']); ?>

            </p>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Insight Form Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showModal): ?>
        <div
            x-data="{ show: false }"
            x-init="
                $nextTick(() => show = true);
                $wire.on('close-modal', () => {
                    show = false;
                });
            "
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50 p-4"
        >
            <div
                x-show="show"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white rounded-lg shadow-2xl p-6 w-full max-w-2xl" 
                @click.stop>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">
                        <?php echo e($editingId ? 'Editar Insight' : 'Novo Insight'); ?>

                    </h2>
                    <button
                        @click="show = false; setTimeout(() => $wire.closeModal(), 200)"
                        class="text-gray-500 hover:text-gray-700 transition-colors"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                            Título
                        </label>
                        <input
                            type="text"
                            id="title"
                            wire:model="title"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-trello-blue focus:border-transparent"
                        />
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">
                            Conteúdo
                        </label>
                        <textarea
                            id="content"
                            wire:model="content"
                            rows="6"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-trello-blue focus:border-transparent resize-none"
                        ></textarea>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button
                            type="button"
                            @click="show = false; setTimeout(() => $wire.closeModal(), 200)"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors"
                        >
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="save"
                            class="px-4 py-2 bg-trello-blue text-white rounded-md hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span wire:loading.remove wire:target="save"><?php echo e($editingId ? 'Salvar' : 'Criar'); ?></span>
                            <span wire:loading wire:target="save">
                                <svg class="animate-spin h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Salvando...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Confirm Delete Dialog -->
    <!--[if BLOCK]><![endif]--><?php if($showConfirmDelete): ?>
        <div
            x-data="{ show: false }"
            x-init="$nextTick(() => show = true)"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50 p-4"
        >
            <div
                x-show="show"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white rounded-lg shadow-2xl p-6 w-full max-w-md" 
                @click.stop>
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    Confirmar Exclusão
                </h2>
                
                <p class="text-gray-600 mb-6">
                    Tem certeza que deseja excluir este insight? Esta ação não pode ser desfeita.
                </p>
                
                <div class="flex justify-end space-x-3">
                    <button
                        type="button"
                        @click="show = false; setTimeout(() => $wire.$set('showConfirmDelete', false), 200)"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors"
                    >
                        Cancelar
                    </button>
                    <button
                        type="button"
                        wire:click="delete"
                        wire:loading.attr="disabled"
                        wire:target="delete"
                        class="px-4 py-2 bg-trello-red text-white rounded-md hover:bg-red-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span wire:loading.remove wire:target="delete">Excluir</span>
                        <span wire:loading wire:target="delete">
                            <svg class="animate-spin h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Excluindo...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div><?php /**PATH /var/www/html/resources/views/livewire/insight-manager.blade.php ENDPATH**/ ?>