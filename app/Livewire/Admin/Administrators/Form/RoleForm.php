<?php

namespace App\Livewire\Admin\Administrators\Form;

use App\Models\Admins\AdminRole;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Locked;
use Livewire\Component;

class RoleForm extends Component
{
    use AuthorizesRequests;

    public ?string $role_name = null;

    #[Locked]
    public string $route;

    /**
     * Create an admin role
     */
    public function createRole(): mixed
    {
        // Validate
        $rules = $this->rules();
        $this->validate($rules);

        // Create
        AdminRole::create([
            'name' => $this->role_name,
        ]);
        session()->flash('success', __('admin.admins.roles.create_success'));

        return $this->redirect($this->route);
    }

    /**
     * Render the component
     * @return View
     */
    public function render(): View
    {
        return view('livewire.admin.admins.form.role-form');
    }

    /**
     * Define the validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'role_name' => 'required|max:255|unique:' . config('akawam.database.table_prefix') . 'admin_roles,name',
        ];
    }
}
