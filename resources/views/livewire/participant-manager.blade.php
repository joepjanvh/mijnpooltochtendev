<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Deelnemersbeheer voor Groep {{ $group->group_number }} - {{ $group->group_name }}</h1>
    <div id="participant-form-section"></div> <!-- Dit is de scroll anchor -->
    <!-- Knoppenrij voor Annuleren en Voeg deelnemer toe -->
    <div class="flex justify-between items-center mb-4">
        <!-- Annuleren knop -->
        <button wire:click="{{ $showForm ? 'hideForm' : 'showCreateForm' }}" 
                class="{{ $showForm ? 'bg-red-500 hover:bg-red-600' : 'bg-blue-500 hover:bg-blue-600' }} text-white px-4 py-2 rounded-md">
            {{ $showForm ? 'Annuleren' : 'Nieuwe deelnemer Aanmaken' }}
        </button>

        <!-- Voeg deelnemer toe knop, alleen zichtbaar als het formulier getoond wordt -->
        @if ($showForm)
            <button type="submit" wire:click.prevent="{{ $editMode ? 'updateParticipant' : 'addParticipant' }}" 
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">
                {{ $editMode ? 'Update Deelnemer' : 'Voeg Deelnemer Toe' }}
            </button>
        @endif
    </div>
    @if ($showForm)
        <!-- Formulier om een nieuwe deelnemer toe te voegen of te bewerken -->
        <form wire:submit.prevent="{{ $editMode ? 'updateParticipant' : 'addParticipant' }}" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            
            <!-- Alle velden van het formulier -->
        <!-- Voornaam -->
        <div class="col-span-1">
            <label for="first_name" class="block text-sm font-medium text-gray-700">Voornaam</label>
            <input type="text" wire:model="first_name" id="first_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Voer voornaam in">
            @error('first_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Tussenvoegsel -->
        <div class="col-span-1">
            <label for="middle_name" class="block text-sm font-medium text-gray-700">Tussenvoegsel</label>
            <input type="text" wire:model="middle_name" id="middle_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <!-- Achternaam -->
        <div class="col-span-1">
            <label for="last_name" class="block text-sm font-medium text-gray-700">Achternaam</label>
            <input type="text" wire:model="last_name" id="last_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Voer achternaam in">
            @error('last_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Adresvelden: Straat, Huisnummer, Postcode, Plaats -->
        <div class="col-span-1">
            <label for="street" class="block text-sm font-medium text-gray-700">Straat</label>
            <input type="text" wire:model="street" id="street" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <div class="col-span-1">
            <label for="house_number" class="block text-sm font-medium text-gray-700">Huisnummer</label>
            <input type="text" wire:model="house_number" id="house_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <div class="col-span-1">
            <label for="postal_code" class="block text-sm font-medium text-gray-700">Postcode</label>
            <input type="text" wire:model="postal_code" id="postal_code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <div class="col-span-1">
            <label for="city" class="block text-sm font-medium text-gray-700">Plaats</label>
            <input type="text" wire:model="city" id="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <!-- Lidnummer scouting Nederland (optioneel) -->
        <div class="col-span-1">
            <label for="membership_number" class="block text-sm font-medium text-gray-700">Lidnummer Scouting Nederland (optioneel)</label>
            <input type="text" wire:model="membership_number" id="membership_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <!-- Email -->
        <div class="col-span-1">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" wire:model="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <!-- Scoutinggroep -->
        <div class="col-span-1">
            <label for="scouting_group" class="block text-sm font-medium text-gray-700">Scoutinggroep</label>
            <input type="text" wire:model="scouting_group" id="scouting_group" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
  <!-- Vorige hike -->
  <div class="col-span-1">
    <label for="previous_hike" class="block text-sm font-medium text-gray-700">Welke hike heb je eerder gelopen?</label>
    <select wire:model="previous_hike" id="previous_hike" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        <option value="Geen">Geen</option>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
        <option value="E">E</option>
        <option value="F">F</option>
    </select>
</div>
 <!-- Naam en telefoon ouders -->
 <div class="col-span-1">
    <label for="parent_name" class="block text-sm font-medium text-gray-700">Naam ouder(s)</label>
    <input type="text" wire:model="parent_name" id="parent_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    @error('parent_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
</div>
<div class="col-span-1">
    <label for="parent_phone" class="block text-sm font-medium text-gray-700">Telefoonnummer ouder(s)</label>
    <input type="text" wire:model="parent_phone" id="parent_phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    @error('parent_phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
</div>
        <!-- Dieetwensen -->
        <div class="col-span-1">
            <label for="dietary_preferences" class="block text-sm font-medium text-gray-700">Dieetwensen</label>
            <input type="text" wire:model="dietary_preferences" id="dietary_preferences" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <!-- Privacy instellingen -->
        <div class="col-span-2">
            <label for="privacy_setting" class="block text-sm font-medium text-gray-700">Mogen andere deelnemers je gegevens inzien?</label>
            <select wire:model="privacy_setting" id="privacy_setting" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="A">Andere deelnemers mogen mijn NAW-Gegevens zien</option>
                <option value="B">Andere deelnemers mogen uitsluitend mijn naam en land zien</option>
                <option value="C">Andere deelnemers mogen geen persoonlijke gegevens van mij zien</option>
            </select>
        </div>

        <!-- Ouder-toestemming -->
        <div class="col-span-1">
            <label for="parental_consent" class="block text-sm font-medium text-gray-700">Heb je toestemming van je ouders om mee te doen aan de pooltochten?</label>
            <select wire:model="parental_consent" id="parental_consent" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="1">Ja</option>
                <option value="0">Nee</option>
            </select>
            @if($parental_consent === '0')
                <span class="text-red-600 text-sm">Toestemming van ouders is verplicht voor deelname.</span>
            @endif
        </div>

        <!-- Deelnemersvoorwaarden -->
        <div class="col-span-1">
            <label for="agreement_terms" class="block text-sm font-medium text-gray-700">Ga je akkoord met de deelnemersvoorwaarden?</label>
            <select wire:model="agreement_terms" id="agreement_terms" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="1">Ja</option>
                <option value="0">Nee</option>
            </select>
            @if($agreement_terms === '0')
                <span class="text-red-600 text-sm">Akkoord gaan met de deelnemersvoorwaarden is verplicht voor deelname.</span>
            @endif
        </div>

        <!-- Medicijngebruik -->
        <div class="col-span-1">
            <label for="medicine_use" class="block text-sm font-medium text-gray-700">Gebruik je medicijnen?</label>
            <select wire:model.change="medicine_use" id="medicine_use" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="1">Ja</option>
                <option value="0">Nee</option>
            </select>
        </div>
        
        @if($medicine_use == 1)
        <!-- Medicijndetails -->
        <div class="col-span-2">
            <label for="medicine_details" class="block text-sm font-medium text-gray-700">Details medicijngebruik</label>
            <textarea wire:model="medicine_details" id="medicine_details" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
        </div>
    @endif
   <!-- <button wire:click="testFunction">Test</button>-->

        <!-- Toevoegen/Bewerken knop -->
        <div class="col-span-1 sm:col-span-2">
            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                {{ $editMode ? 'Update Deelnemer' : 'Voeg Deelnemer Toe' }}
            </button>
        </div>
    </form>
@endif
    <!-- Bestaande Deelnemers -->
    <h2 class="text-xl font-semibold mb-4">Bestaande Deelnemers</h2>
    <ul class="space-y-4">
        @foreach($participants as $participant)
            <li class="p-4 bg-white rounded-lg shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold">@can('deelnemers naam bekijken'){{ $participant->first_name }}@endcan @can('deelnemers uitgebreid bekijken'){{ $participant->middle_name ?? '' }} {{ $participant->last_name }}@endcan</h3>
                    </div>
                    @can('deelnemers aanpassen')<div>
                        <button wire:click="showEditForm({{ $participant->id }})" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-white text-base font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 edit-post-btn">
                            Bewerken
                        </button>
                        
                    </div>
                    @endcan
                </div>
            </li>
        @endforeach
    </ul>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Livewire.on('scrollToForm', () => {
                const formSection = document.getElementById('participant-form-section');
                if (formSection) {
                    formSection.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        let lastScrollPosition = 0;

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.edit-post-btn').forEach(button => {
                button.addEventListener('click', function () {
                    lastScrollPosition = window.pageYOffset;
                });
            });

            Livewire.on('scrollBackToPosition', () => {
                window.scrollTo({ top: lastScrollPosition, behavior: 'smooth' });
            });
        });
    </script>
    
</div>
