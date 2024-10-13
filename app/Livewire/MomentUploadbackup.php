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
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use FFMpeg\Coordinate\TimeCode;



class MomentUpload extends Component
{
    use WithFileUploads; // Voeg WithEvents trait toe

    public $file;
    public $caption;
    public $convertedFilePath;
    public $location;
    public $exif_coordinates;
    public $hike_id; // Hike ID
    public $photo_taken_at; // Voeg deze variabele toe om de EXIF-datum op te slaan
    public $manualDateTime; // Variable for manual date and time
    public $showModal = false;
    public $coordinates_source; // Bron van de locatie (EXIF of user)
    protected $rules = [
        'file' => 'required|mimes:jpeg,png,jpg,mp4,mov|max:81920', // 80MB max 
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
            if (!$this->file->isValid()) {
                $this->dispatch('showAlert', 'Het geüploade bestand is ongeldig.');
                return;
            }

            // Haal de actieve editie op
            $activeEdition = Edition::where('active', true)->first();
            $year = $activeEdition ? $activeEdition->year : date('Y');
            $hike = Hike::find($this->hike_id);
            $hikeName = $hike ? $hike->hike_letter : 'NoCategory';
            $editionPath = "moments/{$year}/{$hikeName}";
            $thumbnailsPath = "{$editionPath}/thumbs";

            Storage::disk('public')->makeDirectory($editionPath);
            Storage::disk('public')->makeDirectory($thumbnailsPath);

            $extension = strtolower($this->file->getClientOriginalExtension());

            if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                // Verwerking voor afbeeldingen
                $filePath = $this->file->store($editionPath, 'public');
                $fullFilePath = storage_path('app/public/' . $filePath);

                // Maak de thumbnail aan
                $manager = ImageManager::gd();
                $image = $manager->read($fullFilePath);
                $size = $image->size();
                $thumbnailPath = $thumbnailsPath . '/' . basename($filePath);

                if ($size->isPortrait()) {
                    $image->cover(1080, 1350);
                } else {
                    $image->cover(1080, 608);
                }

                $image->save(storage_path('app/public/' . $thumbnailPath));

                $thumbnailPathForDB = $thumbnailPath;

            } elseif (in_array($extension, ['mov', 'avi', 'mkv', 'mp4'])) {
                // Verwerking voor video's
                $filePath = $this->file->store($editionPath, 'public');
                $fullFilePath = storage_path('app/public/' . $filePath);

                // Controleer of het bestand moet worden geconverteerd naar MP4
                if ($extension !== 'mp4') {
                    $ffmpeg = FFMpeg::create([
                        'ffmpeg.binaries'  => 'C:/path/to/ffmpeg.exe',
                        'ffprobe.binaries' => 'C:/path/to/ffprobe.exe',
                    ]);

                    $video = $ffmpeg->open($fullFilePath);
                    $convertedFilePath = str_replace('.' . $extension, '.mp4', $filePath);

                    // Converteer naar MP4
                    $video->save(new X264(), storage_path('app/public/' . $convertedFilePath));

                    // Verwijder het originele bestand als je wilt
                    Storage::disk('public')->delete($filePath);

                    // Update het bestandspad naar het geconverteerde bestand
                    $filePath = $convertedFilePath;
                }

                $thumbnailPathForDB = null; // Geen thumbnail voor video's (optioneel: voeg hier videothumbnail-logica toe)
            } else {
                $this->dispatch('showAlert', 'Ongeldig bestandstype.');
                return;
            }

            // Sla het moment op in de database
            Moment::create([
                'user_id' => Auth::id(),
                'file_path' => $filePath,
                'thumbnail_path' => $thumbnailPathForDB,
                'caption' => $this->caption,
                'hike_id' => $this->hike_id ?? null,
                'edition_id' => $activeEdition ? $activeEdition->id : null,
                'location' => $this->location ?? null,
                'coordinates' => $this->exif_coordinates ?? null,
                'coordinates_source' => $this->coordinates_source ?? null,
                'photo_taken_at' => $this->photo_taken_at,
            ]);

            $this->reset(['file', 'caption', 'hike_id', 'location']);
            session()->flash('message', 'Moment succesvol geüpload en geconverteerd!');
        } catch (\Exception $e) {
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