<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Moment;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Edition;
use livewire\Attributes\On;

class MomentFeed extends Component
{
    use WithPagination;

    public $moments = [];
    public $page = 1;
    public $hasMorePages = true;
    public $newMomentIds = [];
    public $lastFeedCheck;  // Tijdstip van laatste feed check
    protected $paginationTheme = 'tailwind';
    public $newComment = ''; // Zorg ervoor dat deze variabele aanwezig is
    public $showComments = [];
    public $activeComment = []; // Dynamische variabele voor comment per post
    public $showMenu = []; // Voeg deze regel toe
    public $activeEdition;
    public $isOpen = false;
public $moment;


//protected $listeners = ['loadMore', 'momentUpdated' => 'refreshMoments', 'refreshMoment', 'closeSubMenu'];
protected $listeners = ['updateMoment', 'loadMore', 'toggleVisibility', 'deleteMoment', 'momentUpdated' => 'refreshMoments', 'refreshMomentList' => '$refresh', 'closeSubMenu'];

public $showFullCaption = [];
    public function mount()
{
    $this->showFullCaption = [];

    // Haal de actieve editie op en sla deze op in de component
    $this->activeEdition = Edition::where('active', true)->first();

    // Check of er een actieve editie is
    if ($this->activeEdition) {
        if (Auth::check()) {
            $this->lastFeedCheck = Auth::user()->last_feed_check;

            // Laad de eerste set momenten van de actieve editie en markeer nieuwe momenten voor ingelogde gebruikers
            $this->moments = Moment::with('user')
                ->where('visible', true) // Alleen zichtbare momenten
                ->where('edition_id', $this->activeEdition->id) // Filter op de huidige actieve editie
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get()
                ->map(function ($moment) {
                    $moment->is_new = $this->lastFeedCheck ? $moment->id > $this->lastFeedCheck : true;
                    return $moment;
                });

            $this->updateLastFeedCheck();
        } else {
            // Laad de eerste set momenten voor niet-ingelogde gebruikers
            $this->moments = Moment::with('user')
                ->where('visible', true) // Alleen zichtbare momenten
                ->where('edition_id', $this->activeEdition->id) // Filter op de huidige actieve editie
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        }
    }
}


public function closeSubMenu($payload)
{
    $momentId = $payload['momentId'];
    unset($this->showMenu[$momentId]); // Sluit het submenu voor het betreffende moment
}
public function removeMoment($momentId)
{
    dd("clicked remove");
    $moment = Moment::findOrFail($momentId);

    if (Auth::id() === $moment->user_id) {
        // Verwijder het moment uit de database (soft delete)
        $moment->delete();
        dd("delete");
        // Verwijder het moment uit de Livewire-collectie
        $this->moments = $this->moments->filter(function($moment) use ($momentId) {
            return $moment->id !== $momentId;
        });

         // Voeg dd() hier toe om te controleren wat er gebeurt na het filteren
         dd($this->moments);

        // Forceer een update van de component
        $this->dispatch('refreshMomentList');  // Verzenden van een refresh event naar de Livewire component

        // Stuur een flash-bericht naar de gebruiker
        session()->flash('message', 'Het moment is succesvol verwijderd.');

        // Sluit het submenu na verwijderen
        $this->dispatch('closeSubMenu', ['momentId' => $momentId]);
    }
}

public function deleteMoment($momentId)
{
    $moment = Moment::find($momentId);

    if ($moment && Auth::id() === $moment->user_id) {
        $moment->delete();  // Verwijder het bericht (soft delete)

        // Verwijder het moment uit de Livewire-collectie
        $this->moments = $this->moments->filter(function($m) use ($momentId) {
            return $m->id !== $momentId;
        });

        session()->flash('message', 'Het bericht is succesvol verwijderd.');
        // Sluit het submenu na verwijderen
        $this->dispatch('closeSubMenu', ['momentId' => $momentId]);
    }
}



    public function refreshMoment($momentId)
    {
        // Zoek het moment op dat is bijgewerkt
        $updatedMoment = Moment::with('user')
            ->find($momentId);
    
        // Werk het moment bij in de collectie
        $this->moments = $this->moments->map(function ($moment) use ($updatedMoment) {
            return $moment->id == $updatedMoment->id ? $updatedMoment : $moment;
        });
        $this->mount();  // Herlaadt de momenten
    }

    // Werk last_feed_check bij naar de huidige tijd
    public function updateLastFeedCheck()
    {
        // Het nieuwste moment is de eerste in de collectie
        $lastLoadedMoment = $this->moments->first();

        if ($lastLoadedMoment) {
            // Werk de last_feed_check bij met het ID van het nieuwste moment
            Auth::user()->update([
                'last_feed_check' => $lastLoadedMoment->id,
            ]);

            // Update de lokale state met het nieuwste moment-ID
            $this->lastFeedCheck = $lastLoadedMoment->id;
        }
    }

    // Laad oudere momenten voor infinite scroll

    public function loadMore()
{
    if (!$this->activeEdition) {
        return; // Stop de methode als er geen actieve editie is
    }

    if ($this->hasMorePages) {
        $this->page++;

        // Laad de volgende pagina met momenten
        $moments = Moment::with('user')
            ->where('visible', true) // Alleen zichtbare momenten
            ->where('edition_id', $this->activeEdition->id) // Filter op de huidige actieve editie
            ->orderBy('created_at', 'desc')
            ->simplePaginate(10, ['*'], 'page', $this->page);

        // Voeg de nieuwe momenten toe aan de bestaande collectie
        if (Auth::check()) {
            $this->moments = $this->moments->concat(
                $moments->map(function ($moment) {
                    $moment->is_new = $this->lastFeedCheck ? $moment->id > $this->lastFeedCheck : false;
                    return $moment;
                })
            );
        } else {
            $this->moments = $this->moments->concat($moments);
        }

        $this->hasMorePages = $moments->hasMorePages();
    }
}

public function toggleLike($momentId)
{
    $moment = Moment::find($momentId);

    if (!$moment) {
        return;
    }

    $user = Auth::user();

    if ($moment->isLikedBy($user)) {
        $moment->likes()->detach($user->id); // Unlike
    } else {
        $moment->likes()->attach($user->id); // Like
    }

    // Ververs het moment om de like status te updaten
    $this->moments = collect($this->moments)->map(function ($m) use ($moment) {
        return $m->id == $moment->id ? $moment->fresh() : $m;
    });
}
public function toggleMenu($momentId)
{
    if (isset($this->showMenu[$momentId])) {
        unset($this->showMenu[$momentId]);
    } else {
        $this->showMenu = []; // Reset alle andere menu's
        $this->showMenu[$momentId] = true; // Toon alleen het menu voor de huidige post
    }
}
public function setActiveComment($momentId)
{
    // Zet alleen het invoerveld van de geselecteerde post actief
    $this->activeComment[$momentId] = '';
}

// Add comments
public function addComment($momentId)
{
    // Valideer het actieve commentaar veld voor de specifieke post
    $this->validate([
        'activeComment.' . $momentId => 'required|string|max:500',
    ]);

    if (Auth::user()->can('post comments')) {
        // Maak een nieuwe comment aan voor het moment
        Comment::create([
            'body' => $this->activeComment[$momentId],
            'user_id' => Auth::id(),
            'moment_id' => $momentId,
        ]);

        // Reset het commentaarveld voor de specifieke post
        $this->activeComment[$momentId] = '';
        
        // Optioneel: Refresh de comments voor het moment
        $this->moments = $this->moments->map(function ($moment) use ($momentId) {
            if ($moment->id == $momentId) {
                $moment->load('comments');
            }
            return $moment;
        });
    }
}




public function addEmoji($emoji)
{
    $this->newComment .= $emoji;
}

public function toggleComments($momentId)
{
    if (isset($this->showComments[$momentId])) {
        unset($this->showComments[$momentId]);
    } else {
        $this->showComments[$momentId] = true;
    }
}

//#[On('toggleVisibility.{momentId}')] 
public function toggleVisibility($momentId)
{
    //dd("start toggle");
    $moment = Moment::find($momentId);

    // Controleer of de gebruiker de eigenaar is
    if ($moment && Auth::id() === $moment->user_id) {
        // Zichtbaarheid toggelen
        $moment->visible = !$moment->visible;
        $moment->save();
        
        
        // Als de post onzichtbaar wordt, verwijder deze uit de Livewire-collectie
        if (!$moment->visible) {
            $this->moments = $this->moments->filter(function($m) use ($momentId) {
                return $m->id !== $momentId;
            });
        }

        // Sluit het submenu na het aanpassen van de zichtbaarheid
        //$this->dispatch('closeSubMenu', ['momentId' => $momentId]);
        // Eventueel een bevestigingsmelding
        
       //session()->flash('messagex', 'De post is ' . ($moment->visible ? 'zichtbaar' : 'verborgen') . ' gemaakt.');
        //$this->dispatch('show-popup'); 
    }
}

#[On('updateMoment')]
public function updateMoment($id, $caption, $location)
{
    // Checkpoint om te zien of de functie wordt aangeroepen
    //dd('Function reached');

    $moment = Moment::findOrFail($id);

    // Controleer of de gebruiker de eigenaar is van het moment
    if (Auth::id() !== $moment->user_id) {
        abort(403, 'Unauthorized action.');
    }

    // Update het moment
    $moment->caption = $caption;
    $moment->location = $location;
    $moment->save();

     // Stuur een event om het moment te verversen in de UI
     $this->dispatch('refreshMoment', $moment->id);

     // Sluit het submenu na de update
     //$this->dispatch('closeMenu', ['momentId' => $id]);
 
     // Flash message
     session()->flash('message', 'Moment succesvol bijgewerkt!');
       // Sluit het submenu na verwijderen
       $this->dispatch('closeSubMenu', ['momentId' => $id]);

}





public function triggerFlashMessage()
{
    // Zet een flash message in de sessie
    session()->flash('messagex', 'Dit is een test flash message!');

    // Optioneel: als je de pagina direct wilt verversen
    $this->dispatch('flashMessageTriggered');
}

    public function render()
    {
        return view('livewire.moment-feed', [
            'moments' => $this->moments,
            
        ]);
    }
}
