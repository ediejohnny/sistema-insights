<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserProfile extends Component
{
    public $name = '';
    public $currentPassword = '';
    public $newPassword = '';
    public $newPassword_confirmation = '';
    public $toast = '';
    public $toastType = 'success';

    public function mount()
    {
        $this->name = Auth::user()->name;
    }

    public function updateName()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nome é obrigatório',
            'name.max' => 'Nome não pode ter mais de 255 caracteres',
        ]);

        $user = Auth::user();
        $user->name = $this->name;
        $user->save();

        $this->showToast('Perfil atualizado com sucesso!', 'success');
        $this->dispatch('profile-updated');
    }

    public function updatePassword()
    {
        $this->validate([
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string|min:8',
            'newPassword_confirmation' => 'required|same:newPassword',
        ], [
            'currentPassword.required' => 'Senha atual é obrigatória',
            'newPassword.required' => 'Nova senha é obrigatória',
            'newPassword.min' => 'Nova senha deve ter no mínimo 8 caracteres',
            'newPassword_confirmation.required' => 'Confirme a nova senha',
            'newPassword_confirmation.same' => 'As senhas não conferem',
        ]);

        $user = Auth::user();
        
        if (!Hash::check($this->currentPassword, $user->password)) {
            $this->addError('currentPassword', 'Senha atual incorreta');
            return;
        }

        $user->password = Hash::make($this->newPassword);
        $user->save();

        $this->resetPasswordFields();
        $this->showToast('Senha atualizada com sucesso!', 'success');
        $this->dispatch('password-updated');
    }

    private function resetPasswordFields()
    {
        $this->currentPassword = '';
        $this->newPassword = '';
        $this->newPassword_confirmation = '';
    }

    private function showToast($message, $type)
    {
        $this->toastType = $type;
        $this->toast = $message;
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
