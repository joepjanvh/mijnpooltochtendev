<div>
    @if($open)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg">
            <h2 class="text-2xl mb-4">Upload bestanden</h2>
            <form wire:submit.prevent="import">
                <div class="mb-4">
                    <label for="formulier" class="block text-sm font-medium text-gray-700">Formulier gegevens</label>
                    <input type="file" wire:model="formulierFile" id="formulier" class="block w-full mt-1">
                    @error('formulierFile') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-4">
                    <label for="subgroepen" class="block text-sm font-medium text-gray-700">Subgroepen</label>
                    <input type="file" wire:model="subgroepenFile" id="subgroepen" class="block w-full mt-1">
                    @error('subgroepenFile') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Importeer</button>
                    <button type="button" wire:click="closeImportModal" class="ml-4 bg-red-600 text-white px-4 py-2 rounded-md">Annuleer</button>
                </div>
            </form>
            <!-- Spinner tijdens het laden -->
            <div wire:loading wire:target="import" class="flex justify-center mt-4">
                <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12"></div>
            </div>
        </div>
    </div>
    @endif

    <!-- Succesmelding na het importeren -->
    @if($successMessage)
        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ $successMessage }}</span>
            <span wire:click="$set('successMessage', null)" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">×</span>
        </div>
    @endif
    <script>
        Livewire.on('importCompleted', () => {
            setTimeout(() => {
                @this.set('successMessage', null);
            }, 3000); // Melding verdwijnt na 3 seconden
        });
    </script>
    <script>
        window.addEventListener('openImportModal', event => {
            @this.set('open', true);
        });
    </script>
</div>
