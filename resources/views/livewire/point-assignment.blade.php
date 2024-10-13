<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Punten toekennen voor Post {{ $post_id }}</h1>

    <!-- Succesboodschap -->
    @if($successMessage)
        <div id="successMessage" class="text-green-600 mb-4">
            ✔ {{ $successMessage }}
        </div>
    @endif

    <!-- Groepenlijst -->
    <ul class="space-y-4">
        @foreach($groups as $group)
            <li class="p-4 bg-white rounded-lg shadow">
                <div class="flex justify-between items-center">
                    <!-- Groepsinformatie -->
                    <div>
                        <h3 class="text-lg font-semibold">
                            Koppel: {{ $group->group_number }} - {{ $group->group_name }}
                        </h3>

                        <!-- Punten toekenningsformulier -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-2">
                            <!-- Aan-/afmelden punten -->
                            <div>
                                <label for="checkInPoints-{{ $group->id }}" class="block text-sm font-medium text-gray-700">Aan-/afmelden (Max 2)</label>
                                <input type="number" id="checkInPoints-{{ $group->id }}" wire:model.lazy="checkInPoints.{{ $group->id }}" max="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $checkInPoints[$group->id] ?? 0 }}">
                            </div>

                            <!-- Houding punten -->
                            <div>
                                <label for="attitudePoints-{{ $group->id }}" class="block text-sm font-medium text-gray-700">Houding (Max 2)</label>
                                <input type="number" id="attitudePoints-{{ $group->id }}" wire:model.lazy="attitudePoints.{{ $group->id }}" max="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $attitudePoints[$group->id] ?? 0 }}">
                            </div>

                            <!-- Uitvoering punten -->
                            <div>
                                <label for="performancePoints-{{ $group->id }}" class="block text-sm font-medium text-gray-700">Uitvoering (Max 6)</label>
                                <input type="number" id="performancePoints-{{ $group->id }}" wire:model.lazy="performancePoints.{{ $group->id }}" max="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $performancePoints[$group->id] ?? 0 }}">
                            </div>
                        </div>
                    </div>

                    <!-- Punten toekennen knop -->
                    <div class="mt-4 sm:mt-0">
                        <button wire:click="assignPoints({{ $group->id }})" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-white text-base font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Punten toekennen
                        </button>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    <!-- Script om succesboodschap te verbergen -->
    <script>
        document.addEventListener('livewire:update', function () {
            // Controleer of de succesboodschap aanwezig is
            if (document.getElementById('successMessage')) {
                // Verberg de succesboodschap na 3 seconden
                setTimeout(function() {
                    document.getElementById('successMessage').style.display = 'none';
                }, 3000);
            }
        });
    </script>
</div>
