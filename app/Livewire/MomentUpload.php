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
    }

    public function updatedFile()
    {
        $extension = strtolower($this->file->getClientOriginalExtension());

        // Verwerking van EXIF-gegevens voor afbeeldingen
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

        // Vraag de gebruikerslocatie op als er geen EXIF-coördinaten zijn
        if (!$this->exif_coordinates) {
            $this->dispatch('requestUserLocation');
        }

        // Toon de datum/tijd modaal als er geen EXIF-datum is
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
            $this->coordinates_source = 'user';
        } else {
            \Log::info('User location could not be determined.');
        }
    }

    public function saveManualDateTime()
    {
        $this->photo_taken_at = $this->manualDateTime;
        $this->dispatch('closeDateTimePicker');
    }

    public function savePhotoTime()
    {
        $this->photo_taken_at = date('Y-m-d H:i:s', strtotime($this->photo_taken_at));
        $this->showModal = false;
    }

    private function getGps($exifCoord, $hemi)
    {
        $degrees = $this->convertToDecimal($exifCoord[0] ?? 0);
        $minutes = $this->convertToDecimal($exifCoord[1] ?? 0);
        $seconds = $this->convertToDecimal($exifCoord[2] ?? 0);

        $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

        return $flip * ($degrees + ($minutes / 60) + ($seconds / 3600));
    }

    private function convertToDecimal($part)
    {
        $parts = explode('/', $part);

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
                Storage::disk('public')->makeDirectory($editionPath);

                $extension = strtolower($this->file->getClientOriginalExtension());
                $filePath = $this->file->store($editionPath, 'public');

                if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                    // Afbeeldingsverwerking
                    $fullFilePath = storage_path('app/public/' . $filePath);
                    $manager = ImageManager::gd();
                    $image = $manager->read($fullFilePath);
                    $size = $image->size();
                    $thumbnailPath = "{$editionPath}/thumbs/" . basename($filePath);

                   // $image->cover(1080, 1350);
                   if ($size->isPortrait()) {
                    $image->cover(1080, 1350);
                } else {
                    $image->cover(1080, 608);
                }
                   
                    $image->save(storage_path('app/public/' . $thumbnailPath));

                } elseif (in_array($extension, ['mov'])) {
                    // Videoverwerking en conversie naar MP4
                    $fullFilePath = storage_path('app/public/' . $filePath);
                    $ffmpeg = FFMpeg::create();
                    $video = $ffmpeg->open($fullFilePath);
                    $convertedFilePath = str_replace('.mov', '.mp4', $filePath);

                    $video->save(new X264(), storage_path('app/public/' . $convertedFilePath));

                    // Verwijder het originele .mov-bestand
                    Storage::disk('public')->delete($filePath);

                    $filePath = $convertedFilePath; // Update het pad naar de geconverteerde MP4

                }

                Moment::create([
                    'user_id' => Auth::id(),
                    'file_path' => $filePath,
                    'thumbnail_path' => in_array($extension, ['jpg', 'jpeg', 'png']) ? $thumbnailPath : null,
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
