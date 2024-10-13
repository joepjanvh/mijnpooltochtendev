<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Hike;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use App\Models\Edition;  // Zorg ervoor dat dit model is geïmporteerd
use App\Models\Service; // Zorg ervoor dat het model voor diensten bestaat

class PostManager extends Component
{
    public $hike_id;
    public $post_number;
    public $date;
    public $location;
    public $instructions;
    public $required_workforce;
    public $posts;
    public $hike;
    public $edition;
    public $planned_start_time;
    public $planned_duration;
    public $supply_post;
    public $supply_adas_hoeve;
    public $materials = [];
    public $new_material;
    public $services; // Voor het laden van de diensten
    //coordinaten
    public $latitude;
public $longitude;
public $selected_day;
public $totalDelay;
public $post_id; // Om te bepalen of we aan het bewerken zijn
public $showForm = false;


public function mount($hikeId)
{
    // Stel de hike en edition in
    $this->hike_id = $hikeId;
    $this->hike = Hike::find($hikeId);
    $this->edition = Edition::find($this->hike->edition_id);

    // Haal de bestaande posten op
    $this->posts = Post::where('hike_id', $hikeId)->get();
    $this->services = Service::all(); // Haal alle services op
}

//show or hide form
public function showCreateForm()
{
    $this->resetForm();
    $this->showForm = true;  // Toon het formulier
    $this->dispatch('initMap');
    $this->dispatch('scrollToForm'); // Voeg dit toe
}

public function showEditForm($postId)
{
    $this->editPost($postId);
    $this->showForm = true;  // Toon het formulier met de ingevulde gegevens
    $this->dispatch('initMap');
    $this->dispatch('scrollToForm'); // Voeg dit toe
    
}

public function hideForm()
{
    $this->showForm = false;  // Verberg het formulier
     // Voeg dit toe om terug te scrollen
     $this->dispatch('scrollBackToPosition'); // Scroll terug naar de opgeslagen positie
    
}

public function resetForm()
{
    // Reset alle formuliervelden
    $this->post_id = null;
    $this->post_number = null;
    $this->selected_day = null;
    $this->location = null;
    $this->instructions = null;
    $this->required_workforce = null;
    $this->planned_start_time = null;
    $this->planned_duration = null;
    $this->supply_post = null;
    $this->supply_adas_hoeve = null;
    $this->materials = [];
    $this->latitude = null;
    $this->longitude = null;
}



// Laad post voor bewerken
public function editPost($postId)
{   
    //kijken of formulier verschijnt bij klikken op knop
    //$this->editPost($postId);



    $post = Post::find($postId);
    $this->post_id = $post->id; // Set het post_id om bij te houden dat we aan het bewerken zijn
    $this->post_number = $post->post_number;
    $this->location = $post->location;
    $this->instructions = $post->instructions;
    $this->required_workforce = $post->required_workforce;
    $this->planned_start_time = $post->planned_start_time;
    $this->planned_duration = $post->planned_duration;
    $this->supply_post = $post->supply_post;
    $this->supply_adas_hoeve = $post->supply_adas_hoeve;
    $this->materials = json_decode($post->materials, true);
    $this->latitude = $post->latitude;
    $this->longitude = $post->longitude;
    $this->selected_day = $this->calculateSelectedDay($post->date);
    //update kaart
    //dd($this->dispatch('updateMarker', lat: $this->latitude, lng: $this->longitude));
    // Dispatch het event om de kaart te updaten met de huidige coördinaten
    // Log the lat and lng to ensure they are being set correctly
        // Zorg ervoor dat het formulier zichtbaar is
        //$this->showForm = true;
    
        // Update de kaart met de huidige coördinaten
        //$this->dispatch('initMap');
    //dd($this->latitude);
    // Dispatch het event naar de frontend om de marker te updaten
    $this->dispatch('updateMarker', lat: $this->latitude, lng: $this->longitude); 
    
    
}
 // Update post na bewerking
 public function updatePost()
 {
     $this->dispatch('initMap');
     $this->validate([
         'post_number' => 'required',
         'selected_day' => 'required',
         'location' => 'required',
         'instructions' => 'required',
         'required_workforce' => 'required|integer',
         'planned_start_time' => 'required',
         'planned_duration' => 'required|integer',
         'supply_post' => 'required',
         'supply_adas_hoeve' => 'required',
         'materials' => 'array',
         'latitude' => 'required|numeric',
         'longitude' => 'required|numeric'
     ]);

     $date = $this->calculateDate($this->selected_day);

     $post = Post::find($this->post_id);
     $post->update([
         'post_number' => $this->post_number,
         'date' => $date,
         'location' => $this->location,
         'instructions' => $this->instructions,
         'required_workforce' => $this->required_workforce,
         'planned_start_time' => $this->planned_start_time,
         'planned_duration' => $this->planned_duration,
         'supply_post' => $this->supply_post,
         'supply_adas_hoeve' => $this->supply_adas_hoeve,
         'materials' => json_encode($this->materials),
         'latitude' => $this->latitude,
         'longitude' => $this->longitude
     ]);

     $this->resetInput();
     $this->posts = Post::where('hike_id', $this->hike_id)->get();
     $this->showForm = false;  // Verberg het formulier
 }
  public function calculateSelectedDay($date)
    {
        $startDate = $this->edition->start_date;
        $days = [
            'woensdag' => 0,
            'donderdag' => 1,
            'vrijdag' => 2,
            'zaterdag' => 3
        ];

        foreach ($days as $day => $offset) {
            if (date('Y-m-d', strtotime($startDate . " +$offset days")) == $date) {
                return $day;
            }
        }

        return 'woensdag'; // Default naar woensdag
    }

    public function resetInput()
    {
        $this->post_id = null;
        $this->post_number = null;
        $this->date = null;
        $this->location = null;
        $this->instructions = null;
        $this->required_workforce = null;
        $this->planned_start_time = null;
        $this->planned_duration = null;
        $this->supply_post = null;
        $this->supply_adas_hoeve = null;
        $this->materials = [];
        $this->latitude = null;
        $this->longitude = null;
        $this->selected_day = null;
    }

     // Methode om materiaal toe te voegen
     public function addMaterial()
     {
         if ($this->new_material) {
             $this->materials[] = $this->new_material;
             $this->new_material = ''; // Reset het inputveld
         }
     }
 
     // Methode om materiaal te verwijderen
     public function removeMaterial($index)
     {
         unset($this->materials[$index]);
         $this->materials = array_values($this->materials); // Reset de array keys
     }
 

     public function createPost()
    {       
            $this->validate([
                'post_number' => 'required',
                'selected_day' => 'required', // Valideer de geselecteerde dag
                //'date' => 'required|date',
                'location' => 'required',
                'instructions' => 'required',
                'required_workforce' => 'required|integer',
                'planned_start_time' => 'required',
                'planned_duration' => 'required|integer',
                'supply_post' => 'required',
                'supply_adas_hoeve' => 'required',
                'materials' => 'array',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric'
            ]);
        
    
        // Als validatie slaagt, dump and die
        //dd("passed validation");
        //selecteer juiste datum voor geselecteerde dag
        $date = $this->calculateDate($this->selected_day);
        // Maak de nieuwe post aan
        Post::create([
            'hike_id' => $this->hike_id,
            'post_number' => $this->post_number,
            'date' => $date,
            'location' => $this->location,
            'instructions' => $this->instructions,
            'required_workforce' => $this->required_workforce,
            'planned_start_time' => $this->planned_start_time,
            'planned_duration' => $this->planned_duration,
            'supply_post' => $this->supply_post,
            'supply_adas_hoeve' => $this->supply_adas_hoeve,
            'materials' => json_encode($this->materials),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude // Sla materialen op als JSON
        ]);

        // Reset de invoer velden
        $this->resetInput();
        // Vernieuw de lijst met posten
        $this->posts = Post::where('hike_id', $this->hike_id)->get();
    }
    public function calculateDate($day)
    { 
        // Stel de startdatum van de editie vast (woensdag)
        $startDate = $this->edition->start_date;
        //dd($day);
        switch ($day) {
           
            case 'woensdag':
                return $startDate;
            case 'donderdag':
                return date('Y-m-d', strtotime($startDate . ' +1 day'));
            case 'vrijdag':
                return date('Y-m-d', strtotime($startDate . ' +2 days'));
            case 'zaterdag':
                return date('Y-m-d', strtotime($startDate . ' +3 days'));
            default:
                return $startDate; // Default naar woensdag als fallback
        }
    }
   // Reset de invoervelden
   

    
    public function openPost($postId)
{

    // Vind de post eerst
    $post = Post::find($postId);

    // Test of de knop werkt en we de juiste post hebben
    //dd('knop werkt', $postId, $post);

    // Update de tijd wanneer de post is geopend
    $post->update(['time_open' => now()]);
    //dd($post);
    // Vernieuw de lijst met posten
    $this->posts = Post::where('hike_id', $this->hike_id)->get();
}
public function testClick()
{
    dd('Knop werkt!');
}
//public function closePost($postId)
//{
//    $post = Post::find($postId);
//    $post->update(['time_close' => now()]);

    // Vernieuw de lijst met posten na het sluiten
//    $this->posts = Post::where('hike_id', $this->hike_id)->get();
//}
public function closePost($postId)
    {
        // Zoek de post op
        $post = Post::find($postId);

        // Controleer of de post gevonden is
        if ($post) {
            // Update de tijd wanneer de post is gesloten
            $post->update(['time_close' => now()]);

            // Vernieuw de lijst met posten
            $this->posts = Post::where('hike_id', $this->hike_id)->get();
        }
    }
    //delaytracker
    public function checkPostDelays()
    {
        $delaySummary = 0;  // Holds the total accumulated delay in minutes
        foreach ($this->posts as $post) {
            // Check if the post has not been opened and the planned start time has passed
            if (is_null($post->time_open) && now()->greaterThan($post->planned_start_time)) {
                // Calculate the delay in minutes
                $delayInMinutes = now()->diffInMinutes($post->planned_start_time);
                $post->delay = $delayInMinutes;  // Store the delay for visual indication
    
                // Accumulate total delay
                $delaySummary += $delayInMinutes;
            } else {
                $post->delay = 0;  // Reset delay if post is opened on time
            }
        }
    
        return $delaySummary;
    }

    public function generateQrCode($postId)
{
    $post = Post::find($postId);
    $url = route('post.show', ['postId' => $postId]);

    // Maak de QR-code
    $qrCode = QrCode::create($url);
    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // Retourneer de QR-code als base64-afbeelding om direct in HTML te gebruiken
    return $result->getDataUri();
}

public function render()
{
    return view('livewire.post-manager', [
        'hike' => $this->hike,
        'edition' => $this->edition,
        'services' => $this->services,
        //'totalDelay' => $totalDelay  // Pass the total delay to Blade
    ])->layout('layouts.app');
}
}