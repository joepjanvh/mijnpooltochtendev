<?php

namespace App\Http\Controllers;

use App\Models\Post; // Zorg dat je Post model hebt
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Haal alle posts op uit de database
        $posts = Post::with('user')->get(); // Zorg dat 'user' een relatie is in het Post model

        // Stuur de posts naar de view
        return view('welcome', compact('posts'));
    }
}
