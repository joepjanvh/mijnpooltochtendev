document.addEventListener('DOMContentLoaded', function () {
    // Ophalen van het laatst weergegeven moment ID uit Local Storage
    let lastViewedMomentId = localStorage.getItem('lastViewedMomentId') || null;
    console.log('Last viewed moment ID:', lastViewedMomentId);

    // Controleer periodiek op nieuwe momenten
    setInterval(() => {
        Livewire.dispatch('checkForNewMoments');
    }, 6000); // Controleer elke 6 seconden op nieuwe momenten

    // Luister naar het 'new-moments-available' event
    Livewire.on('new-moments-available', () => {
        let popup = document.getElementById('newmomentspopup');
        if (popup) {
            popup.style.display = 'flex';
            popup.classList.remove('hidden');
        }
    });

    // Sluit de popup bij klikken op het kruisje
    document.getElementById('closepopup').addEventListener('click', function (event) {
        event.stopPropagation();
        hidePopup();
    });

    // Laad nieuwe momenten wanneer de popup wordt aangeklikt
    document.getElementById('newmomentspopup').addEventListener('click', function () {
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });
        hidePopup();
        Livewire.dispatch('loadNewMoments');
    });

    function hidePopup() {
        let popup = document.getElementById('newmomentspopup');
        if (popup) {
            popup.style.display = 'none';
            popup.classList.add('hidden');
        }
    }

    // Markeer nieuwe momenten en sla het laatste moment ID op
    Livewire.on('markPostInStorage', (data) => {
        console.log('Livewire event triggered - Moment ID:', data.momentId); // Controleer of het wordt getriggerd
        localStorage.setItem('lastViewedMomentId', data.momentId); // Sla het ID op in Local Storage
    });

    // Markeer nieuwe momenten op basis van Local Storage
let moments = document.querySelectorAll('.moment-item');
moments.forEach(function (moment) {
    let momentId = moment.getAttribute('data-moment-id');
    //console.log('Moment ID:', momentId);
    // Controleer of het moment-ID groter is dan het laatst bekeken moment-ID
    if (lastViewedMomentId && momentId > lastViewedMomentId) {
        moment.classList.add('new-moment'); // Voeg de markering toe
       // console.log('New moment marked:', momentId);
    }
});
});
