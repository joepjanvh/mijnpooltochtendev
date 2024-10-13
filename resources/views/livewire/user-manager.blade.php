<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Gebruikersbeheer</h1>

    <!-- Acties voor Gebruikers -->
    <div class="flex justify-between mb-4">
        <button wire:click="addUser" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">
            + Voeg Gebruiker Toe
        </button>

        <div class="flex">
            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md mr-2">
                Acties
            </button>

            <input type="text" placeholder="Zoek..." class="px-4 py-2 border rounded-md" wire:model.live.debounce.250ms="search">
        </div>
    </div>

    <!-- Gebruikerstabel -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">Actief</th>
                    <th class="px-4 py-2 border">Naam</th>
                    <th class="px-4 py-2 border">Gebruikersnaam</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Rollen</th>
                    <th class="px-4 py-2 border">Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="px-4 py-2 border text-center">
                            <input type="checkbox" {{ $user->active ? 'checked' : '' }} disabled>
                        </td>
                        <td class="px-4 py-2 border">{{ $user->name }}</td>
                        <td class="px-4 py-2 border">{{ $user->username }}</td>
                        <td class="px-4 py-2 border">{{ $user->email }}</td>
                        <td class="px-4 py-2 border">
                            @foreach($user->roles as $role)
                                <span class="text-sm bg-blue-100 text-blue-500 px-2 py-1 rounded">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td class="px-4 py-2 border">
                            <button wire:click="selectUser({{ $user->id }})" class="text-blue-500">Bewerk</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Rollen en Permissies Sectie voor geselecteerde gebruiker -->
    @if ($selectedUser)
        <div class="mt-8">
            <h2 class="text-xl font-semibold">Rollen & Permissies voor {{ $selectedUser->name }}</h2>

            <div class="grid grid-cols-2 gap-4">
                <!-- Rollen -->
                <div>
                    <h3 class="text-lg font-semibold">Rollen</h3>
                    @foreach($roles as $role)
                        <label class="block mb-2">
                            <input type="checkbox" wire:model="userRoles" value="{{ $role->name }}">
                            {{ $role->name }}
                        </label>
                    @endforeach
                </div>

                <!-- Permissies -->
                <div>
                    <h3 class="text-lg font-semibold">Permissies</h3>
                    @foreach($permissions as $permission)
                        <label class="block mb-2">
                            <input type="checkbox" wire:model="userPermissions" value="{{ $permission->name }}">
                            {{ $permission->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <button wire:click="updateRolesAndPermissions"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md mt-4">
                Rollen en Permissies Opslaan
            </button>

            @if (session()->has('success'))
                <div class="text-green-600 mt-2">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    @endif
</div>
