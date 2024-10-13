
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-semibold mb-4">Puntenoverzicht voor {{ $hike->hike_letter }} Hike - {{ $edition->year }}</h1>
    <!-- Sorteren op Koppelnummer of Puntentotaal -->
    <div class="flex justify-between mb-4">
        <div>
            <label for="search" class="mr-2">Search:</label>
            <input type="text" id="search" placeholder="Search koppels..." class="border px-4 py-2 rounded-md">
        </div>
        <!-- Export knop -->
    <div class="mb-4">
        <button wire:click="exportPointsOverview" class="bg-blue-600 text-white px-4 py-2 rounded-md">
            Exporteer naar Excel
        </button>
    </div>
        <div>
            <label for="sortBy" class="mr-2">Sorteren :</label>
            <select wire:model.change="sortBy" class="border px-4 py-2 rounded-md">
                <option value="group_number">Koppel</option>
                <option value="total_points">Totaal</option>
            </select>
        </div>
    </div>

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Koppel
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Totaal
                </th>
                @foreach($posts as $post)
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Post {{ $post->id }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($pointsOverview as $overview)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $overview['group']->group_number }} - {{ $overview['group']->group_name }}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $overview['total_points'] }}
                        </span>
                    </td>
                    @foreach($posts as $post)
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900">{{ $overview['points_per_post'][$post->id] }}</span>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
