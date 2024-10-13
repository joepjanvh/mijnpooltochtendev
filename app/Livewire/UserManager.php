<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserManager extends Component
{
    public $users;
    public $roles;
    public $permissions;
    public $selectedUser;
    public $userRoles = [];
    public $userPermissions = [];
    public $search = '';


    public function mount()
    {
        // Laad alle gebruikers, rollen en permissies bij het initialiseren
        $this->users = User::all();
        $this->roles = Role::all();
        $this->permissions = Permission::all();
        $this->searchUsers(); // Laad gebruikers bij het initialiseren
    }
    public function selectUser(User $user)
    {
        $this->selectedUser = $user;
        // Laad de rollen en permissies van de geselecteerde gebruiker
        $this->userRoles = $user->roles->pluck('name')->toArray();
        $this->userPermissions = $user->permissions->pluck('name')->toArray();
    }

    public function loadUsers()
    {
        // Zoek gebruikers op naam of e-mail, en pas de zoekterm toe
        $this->users = User::where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%')
                            ->get();
    }
    public function updatedSearch()
    {
        //$this->loadUsers();
        $this->searchUsers();
    }
    public function updateRolesAndPermissions()
    {
        // Zorg ervoor dat de gebruiker bestaat
        if ($this->selectedUser) {
            $this->selectedUser->syncRoles($this->userRoles);
            $this->selectedUser->syncPermissions($this->userPermissions);

            session()->flash('success', 'Rollen en permissies bijgewerkt.');
        }
    }
    public function searchUsers()
    {
        $searchTerms = collect(explode(' ', $this->search)) // Split de zoekterm op spaties
                        ->filter(); // Verwijder lege termen

        // Haal alle gebruikers op en filter ze op basis van de zoektermen
        $this->users = User::query()
            ->where(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where(function ($q) use ($term) {
                        $q->where('name', 'LIKE', '%' . $term . '%')
                          ->orWhere('email', 'LIKE', '%' . $term . '%');
                    });
                }
            })
            ->get();
    }
    public function addUser()
    {
        // Voeg functionaliteit toe om een nieuwe gebruiker aan te maken
    }
    public function render()
    {
        return view('livewire.user-manager', [
            'users' => $this->users,
            'roles' => $this->roles,
            'permissions' => $this->permissions,
            'selectedUser' => $this->selectedUser,
            'userRoles' => $this->userRoles,
            'userPermissions' => $this->userPermissions,
       // ])->layout('layouts.app');
        ])->layout('layouts.app');
    }
    



}
