<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;


class ShowPost extends Component
{
    public $post;
    

    public function mount($postId)
    {
        $this->post = Post::find($postId);
    }

    public function openPost($postId)
    {
        
        // Vind de post
        $post = Post::find($postId);

        if ($post && !$post->time_open) {
            // Post openen
            $post->update(['time_open' => now()]);

            // Refresh de post
            $this->post = $post;
        }
    }

    public function closePost($postId)
    {
        // Vind de post
        $post = Post::find($postId);

        if ($post && !$post->time_close) {
            // Post sluiten
            $post->update(['time_close' => now()]);

            // Refresh de post
            $this->post = $post;
        }
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
        return view('livewire.show-post', ['post' => $this->post])
            ->layout('layouts.app');
    }
}
