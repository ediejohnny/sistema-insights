<?php

use function Livewire\Volt\{state, layout, title};

layout('components.layouts.app');
title('Dashboard - Quadro de Insights');

?>

<div class="min-h-screen bg-gradient-to-br from-trello-blue to-trello-gray">
        <!-- Header -->
        <header class="bg-white shadow-md sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <svg class="w-8 h-8 text-trello-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <h1 class="text-2xl font-bold text-trello-blue">
                        Quadro de Insights
                    </h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <livewire:user-profile />
                </div>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 py-8">
            <livewire:insight-manager />
        </main>
    </div>
</div>
