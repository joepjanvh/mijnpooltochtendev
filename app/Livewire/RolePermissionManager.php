<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionManager extends Component
{
    public $roles;
    public $permissions;
    public $roleName;
    public $permissionName;
    public $selectedRole;
    public $selectedPermissions = [];

    public function mount()
    {
        $this->roles = Role::all();
        $this->permissions = Permission::all();
    }

    
    // Maak een nieuwe rol aan
    public function createRole()
    {
        $this->validate([
            'roleName' => 'required|string|max:255',
        ]);

        Role::create(['name' => $this->roleName]);
        $this->roleName = ''; // Clear het invoerveld
        $this->roles = Role::all(); // Herlaad de rollenlijst
    }

    // Maak een nieuwe permissie aan
    public function createPermission()
    {
        $this->validate([
            'permissionName' => 'required|string|max:255',
        ]);

        Permission::create(['name' => $this->permissionName]);
        $this->permissionName = ''; // Clear het invoerveld
        $this->permissions = Permission::all(); // Herlaad de permissieslijst
    }

    // Selecteer een rol om permissies toe te wijzen
    public function selectRole($roleId)
    {
        $this->selectedRole = Role::findById($roleId);
        $this->selectedPermissions = $this->selectedRole->permissions->pluck('name')->toArray();
    }

    // Wijzig de permissies van de geselecteerde rol
    public function updateRolePermissions()
    {
        $this->selectedRole->syncPermissions($this->selectedPermissions);
        session()->flash('message', 'Permissies bijgewerkt!');
    }
    public function savePermissions()
{
    $role = Role::findByName($this->selectedRole);
    
    // Stel permissies in voor de geselecteerde rol
    foreach ($this->selectedPermissions as $permissionName => $actions) {
        if ($actions['view']) {
            $role->givePermissionTo($permissionName . '-view');
        }
        if ($actions['create']) {
            $role->givePermissionTo($permissionName . '-create');
        }
        // Voeg de rest van de acties toe...
    }

    session()->flash('message', 'Permissies succesvol opgeslagen.');
}
    public function render()
    {
        return view('livewire.role-permission-manager', [
            'roles' => $this->roles,
            'permissions' => $this->permissions,
        ])->layout('layouts.app');
    }
}


