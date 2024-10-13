<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use App\Models\Moment;
use App\Models\Hike;
use App\Models\Edition;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;

class MomentUpload extends Component
{
    use WithFileUploads;

    public $file;
    public $caption;
    public $convertedFilePath;

    public $location;
    public $exif_coordinates;
    public $hike_id;
    public $photo_taken_at;
    public $manualDateTime;
    public $showModal = false;
    public $coordinates_source;

    protected $rules = [
        'file' => 'required|mimes:jpeg,png,jpg,mp4,mov|max:81920', // 80MB max
        'caption' => 'nullable|string|max:255',
        'location' => 'nullable|string',
        'hike_id' => 'nullable|exists:hikes,id',
    ];

    public function mount()
    {
        $this->exif_coordinates = null;
        $this->photo_taken_at = null;
        $this->latitude = null;
        $this->longitude = null;
        $this->convertedFilePath = null;
    }

    public function updatedFile()
    {
        $extension = strtolower($this->file->getClientOriginalExtension());

        // EXIF-verwerking voor afbeeldingen
        if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
            $exif_data = @exif_read_data($this->file->getRealPath());

            if ($exif_data) {
                if (isset($exif_data['DateTimeOriginal'])) {
                    $this->photo_taken_at = date('Y-m-d H:i:s', strtotime($exif_data['DateTimeOriginal']));
                }
                if (isset($exif_data['GPSLatitude'], $exif_data['GPSLongitude'])) {
                    $lat = $this->getGps($exif_data['GPSLatitude'], $exif_data['GPSLatitudeRef']);
                    $lon = $this->getGps($exif_data['GPSLongitude'], $exif_data['GPSLongitudeRef']);
                    $this->exif_coordinates = "$lat, $lon";
                    $this->coordinates_source = 'EXIF';
                }
            }
        }

        // Converteer video's (MOV naar MP4)
        if (in_array($extension, ['mov'])) {
            $tmpPath = $this->file->store('tmp', 'public');
            $fullTmpPath = storage_path('app/public/' . $tmpPath);
            $convertedFilePath = str_replace('.mov', '.mp4', $tmpPath);

            // Gebruik FFmpeg voor de conversie
            $ffmpeg = FFMpeg::create();
            $video = $ffmpeg->open($fullTmpPath);
            $video->save(new X264(), storage_path('app/public/' . $convertedFilePath));

            // Verwijder het originele MOV-bestand
            Storage::disk('public')->delete($tmpPath);

            // Zet het geconverteerde bestandspad voor voorvertoning
            $this->convertedFilePath = $convertedFilePath;
        }

        // Als de EXIF-coördinaten ontbreken, vraag om locatie
        if (!$this->exif_coordinates) {
            $this->dispatch('requestUserLocation');
        }

        // Toon modaal voor datum/tijd als geen EXIF-datum beschikbaar is
        if (!$this->photo_taken_at && in_array($extension, ['jpg', 'jpeg', 'png'])) {
            $this->dispatch('showAlert', 'Geen EXIF-informatie gevonden, stel een datum/tijd in.');
            $this->showModal = true;
        }
    }

    #[On('setUserLocation')]
    public function setUserLocation($latitude, $longitude)
    {
        if ($latitude && $longitude) {
            $this->exif_coordinates = "$latitude, $longitude";
            $this->coordinates_source = 'user'; // Zet de bron op user
        } else {
            \Log::info('User location could not be determined.');
        }
    }

    public function saveManualDateTime()
    {
        $this->photo_taken_at = $this->manualDateTime;
        $this->dispatch('closeDateTimePicker'); // Sluit de modaal
    }

    public function savePhotoTime()
    {
        $this->photo_taken_at = date('Y-m-d H:i:s', strtotime($this->photo_taken_at));
        $this->showModal = false;
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

                $activeEdition = Edition::where('active', true)->first();
                $year = $activeEdition ? $activeEdition->year : date('Y');
                $hike = Hike::find($this->hike_id);
                $hikeName = $hike ? $hike->hike_letter : 'NoCategory';
                $editionPath = "moments/{$year}/{$hikeName}";
                $thumbnailsPath = "{$editionPath}/thumbs";

                Storage::disk('public')->makeDirectory($editionPath);
                Storage::disk('public')->makeDirectory($thumbnailsPath);

                $filePath = $this->convertedFilePath ?? $this->file->store($editionPath, 'public');
                $thumbnailPath = $thumbnailsPath . '/' . basename($filePath);
                $thumbnailPathForDB = $thumbnailsPath;

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

                $this->reset(['file', 'caption', 'hike_id', 'location', 'convertedFilePath']);
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
        $hikes = Hike::whereHas('edition', function ($query) {
            $query->where('active', true);
        })->get();

        return view('livewire.moment-upload', [
            'hikes' => $hikes,
        ])->layout('layouts.app');
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
}
