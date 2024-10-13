<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On; 
//use Livewire\WithEvents; // Voeg deze regel toe
use App\Models\Moment;
use App\Models\Hike;
use App\Models\Edition;
use Illuminate\Support\Facades\Auth;

use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // Gebruik 'Imagick\Driver' als je Imagick gebruikt
use Illuminate\Support\Facades\Storage;

class MomentUpload extends Component
{
    use WithFileUploads; // Voeg WithEvents trait toe

    public $file;
    public $caption;

    public $location;
    public $exif_coordinates;
    public $hike_id; // Hike ID
    public $photo_taken_at; // Voeg deze variabele toe om de EXIF-datum op te slaan
    public $manualDateTime; // Variable for manual date and time
    public $showModal = false;
    public $coordinates_source; // Bron van de locatie (EXIF of user)
    protected $rules = [
        'file' => 'required|mimes:jpeg,png,jpg,mp4|max:20480', // 20MB max
        'caption' => 'nullable|string|max:255',

        'location' => 'nullable|string',
        'hike_id' => 'nullable|exists:hikes,id', // Validatie voor optionele hike_id
    ];

    public function mount()
    {
        $this->exif_coordinates = null;
        $this->photo_taken_at = null; // Stel de standaardwaarde in op null
        $this->latitude = null;
        $this->longitude = null;
    }
   

    public function updatedFile()
{
    $extension = strtolower($this->file->getClientOriginalExtension());

    // Controleer op EXIF-ondersteunde bestandstypes (bijv. jpg, jpeg)
    if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
        $exif_data = @exif_read_data($this->file->getRealPath());

        if ($exif_data) {
            if (isset($exif_data['DateTimeOriginal'])) {
                $this->photo_taken_at = date('Y-m-d H:i:s', strtotime($exif_data['DateTimeOriginal']));
            } else {
                \Log::info('DateTimeOriginal not found in EXIF data.');
            }

            if (isset($exif_data['GPSLatitude'], $exif_data['GPSLongitude'])) {
                $lat = $this->getGps($exif_data['GPSLatitude'], $exif_data['GPSLatitudeRef']);
                $lon = $this->getGps($exif_data['GPSLongitude'], $exif_data['GPSLongitudeRef']);
                $this->exif_coordinates = "$lat, $lon";
                $this->coordinates_source = 'EXIF'; // Zet de bron op EXIF
            }
        } else {
            \Log::info('EXIF data could not be read.');
        }
    }

    // Als er geen EXIF-GPS-informatie beschikbaar is, vraag dan de huidige locatie van de gebruiker op
    if (!$this->exif_coordinates) {
        $this->dispatch('requestUserLocation'); // Vraag de gebruiker om toestemming voor locatie
    }

    // Als er geen EXIF-datum beschikbaar is, toon de modaal met de date picker
    if (!$this->photo_taken_at) {
        $this->photo_taken_at = date('Y-m-d\TH:i'); // Standaard ISO 8601-formaat voor datetime-local
        $this->dispatch('showAlert', 'Geen EXIF-informatie gevonden, stel een datum/tijd in.');
        $this->showModal = true; // Toon de modal
    }
}

#[On('setUserLocation')]
public function setUserLocation($latitude, $longitude)
{
    if ($latitude && $longitude) {
        $this->exif_coordinates = "$latitude, $longitude";
        $this->coordinates_source = 'user'; // Zet de bron op user
        //dd($this->exif_coordinates);
    } else {
        \Log::info('User location could not be determined.');
    }
}
public function saveManualDateTime()
{
    // Gebruik de handmatig ingevoerde datum/tijd
    $this->photo_taken_at = $this->manualDateTime;
    $this->dispatch('closeDateTimePicker'); // Sluit de modaal
}
public function savePhotoTime()
{
     // Formatteer de datum naar 'Y-m-d H:i:s'
     $this->photo_taken_at = date('Y-m-d H:i:s', strtotime($this->photo_taken_at));
    $this->showModal = false;
    
    // Extra logica voor opslaan van tijd
}

    private function getGps($exifCoord, $hemi)
    {
        $degrees = count($exifCoord) > 0 ? $this->convertToDecimal($exifCoord[0]) : 0;
        $minutes = count($exifCoord) > 1 ? $this->convertToDecimal($exifCoord[1]) : 0;
        $seconds = count($exifCoord) > 2 ? $this->convertToDecimal($exifCoord[2]) : 0;

        $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

        return $flip * ($degrees + ($minutes / 60) + ($seconds / 3600));
    }

    private function convertToDecimal($part)
    {
        $parts = explode('/', $part);

        if (count($parts) <= 0) {
            return 0;
        }

        if (count($parts) == 1) {
            return $parts[0];
        }

        return floatval($parts[0]) / floatval($parts[1]);
    }
    
  
    

    public function uploadMoment()
    {
        if (!Auth::check()) {
            $this->dispatch('showAlert', 'Je moet ingelogd zijn om een moment te uploaden.');
            return;
        }
    
        if ($this->file) {
            try {

                
                // Debugging: Controleer of het bestand correct is
                if (!$this->file->isValid()) {
                    $this->dispatch('showAlert', 'Het geüploade bestand is ongeldig.');
                    return;
                }

                // Haal de actieve editie op
            $activeEdition = Edition::where('active', true)->first();
            
            $year = $activeEdition ? $activeEdition->year : date('Y'); // Gebruik het jaar van de actieve editie, of anders het huidige jaar
            
            // Haal de geselecteerde hike op
            $hike = Hike::find($this->hike_id);
            
            $hikeName = $hike ? $hike->hike_letter : 'NoCategory'; // Gebruik de naam van de hike of 'NoCategory' als er geen hike is geselecteerd
            
    
                // Stel de paden in
            $editionPath = "moments/{$year}/{$hikeName}";
            $thumbnailsPath = "{$editionPath}/thumbs";
            //dd($thumbnailsPath);
                // Ensure the directories exist
                Storage::disk('public')->makeDirectory($editionPath);
                Storage::disk('public')->makeDirectory($thumbnailsPath);
    
                // Upload the original file
                $filePath = $this->file->store($editionPath, 'public');
               
                // Debugging: Controleer het volledige pad naar de opgeslagen afbeelding
                $fullFilePath = storage_path('app/public/' . $filePath);
                //dd($fullFilePath);
                if (!file_exists($fullFilePath)) {
                    $this->dispatch('showAlert', 'Het bestand kon niet worden gevonden op: ' . $fullFilePath);
                    return;
                }
               
               // dump(vars: $ImageManager::gd());
                //dd("nu stop ik");
                // Create an instance of ImageManager
                $manager = ImageManager::gd();
                
                
                // Read the image
                $image = $manager->read($fullFilePath);
                //dd($image);
                
                // Get the image size and check if it's portrait or landscape
                $size = $image->size();
                $thumbnailPath = $thumbnailsPath . '/' . basename($filePath);
    
                if ($size->isPortrait()) {
                    // Portrait: Apply 1080x1350 crop
                    $image->cover(1080, 1350);
                } else {
                    // Landscape: Scale to width 1080, then pad to 1080x1350
                    $image->cover(width: 1080, height:608);
                   // $image->resizeCanvas(1080, 608, '000000', 'center');
                }
    
                // Save the resized thumbnail
                $image->save(storage_path('app/public/' . $thumbnailPath));
    
                // Save the moment information in the database
                Moment::create([
                    'user_id' => Auth::id(),
                    'file_path' => $filePath,
                    'thumbnail_path' => $thumbnailPath,
                    'caption' => $this->caption,
                    'hike_id' => $this->hike_id ?? null,
                    'edition_id' => $activeEdition ? $activeEdition->id : null, // Actieve editie ID opslaan
                    'location' => $this->location ?? null,
                    'coordinates' => $this->exif_coordinates ?? null,
                    'coordinates_source' => $this->coordinates_source ?? null, // Sla de bron van de coördinaten op
                    'photo_taken_at' => $this->photo_taken_at,
                ]);
    
                // Reset the input fields
                $this->reset(['file', 'caption', 'hike_id', 'location']);
    
                // Send a confirmation message to the user
                session()->flash('message', 'Moment succesvol geüpload!');
            } catch (\Intervention\Image\Exceptions\DecoderException $e) {
                // Handle decoding errors
                $this->dispatch('showAlert', 'Afbeelding kon niet verwerkt worden. Fout: ' . $e->getMessage());
            } catch (\Exception $e) {
                // Catch any other exceptions
                $this->dispatch('showAlert', 'Er trad een onverwachte fout op: ' . $e->getMessage());
            }
        } else {
            $this->dispatch('showAlert', 'Er is geen bestand geüpload.');
        }
    }
    

    
    


      public function render()
    {
        $hikes = Hike::whereHas('edition', function($query) {
            $query->where('active', true);
        })->get();

        return view('livewire.moment-upload', [
            'hikes' => $hikes,
           
        ])->layout('layouts.app');
    }
}