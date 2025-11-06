<?php

namespace App\Livewire;

use App\Models\Insight;
use Livewire\Component;
use Livewire\Attributes\Validate;

class InsightManager extends Component
{
    public $insights = [];
    public $showModal = false;
    public $showConfirmDelete = false;
    public $editingId = null;
    public $deleteId = null;
    
    #[Validate('required|string|max:255')]
    public $title = '';
    
    #[Validate('required|string|max:5000')]
    public $content = '';
    
    public $toast = ['show' => false, 'message' => '', 'type' => 'success'];

    public function mount()
    {
        \Carbon\Carbon::setLocale('pt_BR');
        $this->loadInsights();
    }

    public function loadInsights()
    {
        $this->insights = Insight::where('user_id', auth()->id())
            ->latest()
            ->get()
            ->toArray();
    }

    public function openModal($id = null)
    {
        $this->resetValidation();
        
        if ($id) {
            $insight = Insight::findOrFail($id);
            
            if ($insight->user_id !== auth()->id()) {
                abort(403);
            }
            
            $this->editingId = $id;
            $this->title = $insight->title;
            $this->content = $insight->content;
        } else {
            $this->editingId = null;
            $this->title = '';
            $this->content = '';
        }
        
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->editingId = null;
        $this->title = '';
        $this->content = '';
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();
        
        if ($this->editingId) {
            $insight = Insight::findOrFail($this->editingId);
            
            if ($insight->user_id !== auth()->id()) {
                abort(403);
            }
            
            $insight->update([
                'title' => $this->title,
                'content' => $this->content,
            ]);
            
            $this->showToast('Insight atualizado com sucesso!');
        } else {
            Insight::create([
                'user_id' => auth()->id(),
                'title' => $this->title,
                'content' => $this->content,
            ]);
            
            $this->showToast('Insight criado com sucesso!');
        }
        
        $this->loadInsights();
        
        // Dispatch evento para fechar modal com animação
        $this->dispatch('close-modal');
        
        // Aguarda um pouco antes de resetar o estado
        usleep(200000); // 200ms
        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showConfirmDelete = true;
    }

    public function delete()
    {
        $insight = Insight::findOrFail($this->deleteId);
        
        if ($insight->user_id !== auth()->id()) {
            abort(403);
        }
        
        $insight->delete();
        
        $this->loadInsights();
        $this->showConfirmDelete = false;
        $this->deleteId = null;
        
        $this->showToast('Insight excluído com sucesso!');
    }

    public function showToast($message, $type = 'success')
    {
        $this->toast = ['show' => true, 'message' => $message, 'type' => $type];
        
        $this->dispatch('toast-shown');
    }

    public function render()
    {
        return view('livewire.insight-manager');
    }
}
