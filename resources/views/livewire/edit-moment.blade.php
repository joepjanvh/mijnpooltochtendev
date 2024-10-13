<div x-data="{ open: @entangle('isOpen') }" x-show="open" class="fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-lg">
            <div class="px-4 py-5 sm:p-6">
                <!-- Modal Header -->
                <div class="flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Moment bewerken
                    </h3>
                    <button @click="open = false" wire:click="closeModal" class="text-gray-500 text-2xl font-bold">
                        &times;
                    </button>
                </div>

                <!-- Form fields for editing the moment -->
                <form wire:submit.prevent="updateMoment">
                    <div class="mt-4">
                        <label for="caption" class="block text-sm font-medium text-gray-700">Caption</label>
                        <input type="text" id="caption" wire:model.defer="caption" class="mt-1 block w-full">
                        @error('caption') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-4">
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" id="location" wire:model.defer="location" class="mt-1 block w-full">
                        @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button type="button" @click="open = false" wire:click="closeModal" class="mr-2 bg-gray-500 text-white font-bold py-2 px-4 rounded">
                            Annuleren
                        </button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Opslaan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
