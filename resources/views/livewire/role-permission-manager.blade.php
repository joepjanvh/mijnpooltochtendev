<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Rollen en Permissies Beheer</h1>

    <!-- Rol Aanmaken -->
    <div class="mb-8">
        <h2 class="text-xl mb-2">Nieuwe Rol Aanmaken</h2>
        <input type="text" wire:model="roleName" placeholder="Rolnaam" class="border rounded p-2">
        <button wire:click="createRole" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">Rol Aanmaken</button>
        @error('roleName') <span class="text-red-600">{{ $message }}</span> @enderror
    </div>

    <!-- Permissie Aanmaken -->
    <div class="mb-8">
        <h2 class="text-xl mb-2">Nieuwe Permissie Aanmaken</h2>
        <input type="text" wire:model="permissionName" placeholder="Permissienaam" class="border rounded p-2">
        <button wire:click="createPermission" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Permissie Aanmaken</button>
        @error('permissionName') <span class="text-red-600">{{ $message }}</span> @enderror
    </div>

    <!-- Rol Permissies Beheren -->
    <div class="mb-8">
        <h2 class="text-xl mb-2">Permissies Toekennen aan Rol</h2>
        <select wire:model="selectedRole" wire:change="selectRole($event.target.value)" class="border rounded p-2">
            <option value="">Selecteer een rol</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>

        @if($selectedRole)
            <h3 class="mt-4">Permissies voor {{ $selectedRole->name }}</h3>
            <div class="grid grid-cols-2 gap-2">
                @foreach($permissions as $permission)
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="selectedPermissions" value="{{ $permission->name }}">
                        <span class="ml-2">{{ $permission->name }}</span>
                    </label>
                @endforeach
            </div>
            <button wire:click="updateRolePermissions" class="mt-4 bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-md">Permissies Bijwerken</button>
        @endif
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif
</div>
