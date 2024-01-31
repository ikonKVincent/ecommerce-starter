<?php

namespace App\Livewire\Admin\Administrators\Form;

use App\Models\Admins\Admin;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mary\Traits\Toast;

class AccountForm extends Component
{
    use Toast;

    public ?Admin $admin;
    public ?String $firstname = null;
    public ?String $lastname = null;
    public ?String $password = null;
    public ?String $email = null;

    /**
     * Mount the component
     * @return void
     */
    public function mount(): void
    {
        $this->admin = Auth::guard('admin')->user();
        $this->firstname = $this->admin->firstname;
        $this->lastname = $this->admin->lastname;
        $this->email = $this->admin->email;
    }

    /**
     * Render the component
     * @return View
     */
    public function render(): View
    {
        return view('livewire.admin.admins.account-form');
    }

    /**
     * Update admin account
     * @return mixed
     */
    public function updateAccount(): void
    {
        // Validate
        $rules = $this->rules();
        $this->validate($rules);

        // Update
        $update = [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
        ];
        if ($this->password) {
            $update['password'] = bcrypt(trim($this->password));
        }
        $this->admin->update($update);
        // Toast
        session()->flash('mary.toast.title', "Compte modifié");
        session()->flash('mary.toast.description', __('admin.admins.users.update_success'));
        $this->dispatch('close-drawer');
    }

    /**
     * Define the validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        $rules = [
            'firstname' => 'string|max:255',
            'lastname' => 'string|max:255',
            'email' => 'required|email|unique:' . config('akawam.database.table_prefix') . 'admins,email,' . $this->admin->id,
            'password' => ['nullable', 'min:8', 'max:255', 'confirmed', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[!"#$%&()*+,-.:;<=>?@[\]\\\\^_`{|}~]/'],
        ];

        if ($this->password) {
            $rules['password'][] = 'required';
        }

        return $rules;
    }
}
