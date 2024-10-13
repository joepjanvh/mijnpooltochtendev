<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Google\Cloud\Storage\StorageClient;
class GoogleCloudUploader extends Component
{
    use WithFileUploads;

    public $file;

    public function uploadFile()
    {
        $this->validate([
            'file' => 'required|file|max:10240', // maximaal 10MB
        ]);

        // Maak een nieuwe Google Cloud Storage client aan
        $storage = new StorageClient([
            'keyFilePath' => env('GOOGLE_CLOUD_KEY_FILE'),
        ]);

        // Selecteer de bucket
        $bucket = $storage->bucket(env('GOOGLE_CLOUD_STORAGE_BUCKET'));

        // Upload het bestand
        $filePath = $this->file->getRealPath();
        $fileName = $this->file->getClientOriginalName();

        $bucket->upload(fopen($filePath, 'r'), [
            'name' => $fileName,
        ]);

        // Feedback geven
        session()->flash('message', 'Bestand geüpload naar Google Cloud Storage');
    }
    public function render()
    {
        return view('livewire.google-cloud-uploader'
        )->layout('layouts.app');
    }
}
