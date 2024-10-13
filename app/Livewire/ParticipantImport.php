<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Participant;
use App\Models\Group;
use SimpleXMLElement;

class ParticipantImport extends Component
{
    use WithFileUploads;

    public $formulierFile;
    public $subgroepenFile;
    public $open = false;
    public $hike_id;
    public $isLoading = false;
    public $successMessage = null;

    public function mount($hikeId)
    {
        $this->hike_id = $hikeId;
    }

    //#[On('openImportModal')]
    public function open()
    {
        $this->open = true;
    }

    public function closeImportModal()
    {
        $this->open = false;
    }

    public function import()
    {
        $this->isLoading = true;

        $this->validate([
            'formulierFile' => 'required|file|mimes:xml',
            'subgroepenFile' => 'required|file|mimes:xml',
        ]);
    
        // Parse Formulier XML file
        $formulierXML = simplexml_load_file($this->formulierFile->getRealPath());
    
        // Stap 1: Headers extraheren uit de eerste rij
        $headers = [];
        $headerRow = $formulierXML->Worksheet->Table->Row[0]; // Eerste rij bevat de headers
    
        $columnIndex = 0; // Start een kolomindex teller
    
        foreach ($headerRow->Cell as $cell) {
            if (isset($cell->Data)) {
                $headerText = (string) $cell->Data;
                $headers[$headerText] = $columnIndex;
            }
            $columnIndex++;
        }
    
        // Stap 2: Verwerk de rijen vanaf de tweede rij (index 1)
        $rowIndex = 0;
        foreach ($formulierXML->Worksheet->Table->Row as $row) {
            if ($rowIndex == 0) {
                $rowIndex++;
                continue;
            }
    
            $rowIndex++;
    
            // Haal de waarden op met behulp van de helper-functie
            $lidnummer = $this->getCellValue($row, $headers, 'Lidnummer');
            $firstName = $this->getCellValue($row, $headers, 'Lid voornaam');
            $middleName = $this->getCellValue($row, $headers, 'Lid tussenvoegsel');
            $lastName = $this->getCellValue($row, $headers, 'Lid achternaam');
            $street = $this->getCellValue($row, $headers, 'Lid straat');
            $houseNumber = $this->getCellValue($row, $headers, 'Lid huisnummer');
            $postcode = $this->getCellValue($row, $headers, 'Lid postcode');
            $city = $this->getCellValue($row, $headers, 'Lid plaats');
            $scoutgroup = $this->getCellValue($row, $headers, 'Organisatie');
            $email = $this->getCellValue($row, $headers, 'Wat is het mailadres wat je regelmatig raadpleegt?');
            $parentData = $this->getCellValue($row, $headers, 'Geef naam en telefoonnummer op van je ouders/verzorgers tijdens de Pooltochten?');
            $previousHike = $this->translateHike($this->getCellValue($row, $headers, 'Heb je eerder een hike bij de Pooltochten gelopen?'));
            $dietaryPreferences = $this->getCellValue($row, $headers, 'Heb je dieetwensen?');
            $privacySettings = $this->translatePrivacySettings($this->getCellValue($row, $headers, 'Mogen andere deelnemers je gegevens inzien?'));
            $parentalConsent = $this->translateParentalConcent($this->getCellValue($row, $headers, 'Heb je toestemming van je ouders om mee te doen aan de Pooltochten?'));
            $agreementTerms = $this->translateAgreementTerms($this->getCellValue($row, $headers, 'Ga je akkoord met de deelnemersvoorwaarden?'));
            $medicineUse = $this->translateMedicineUse($this->getCellValue($row, $headers, 'Ik gebruik medicijnen'));
    
            list($parentName, $parentPhone) = $this->processParentData($parentData);
    
            // Zoek de participant op basis van het lidnummer
            $participant = Participant::where('membership_number', $lidnummer)->first();
    
            if ($participant) {
                // Bestaande participant bijwerken
                $participant->update([
                    'first_name' => $firstName,
                    'middle_name' => $middleName,
                    'last_name' => $lastName,
                    'street' => $street,
                    'house_number' => $houseNumber,
                    'postal_code' => $postcode,
                    'city' => $city,
                    'scouting_group' => $scoutgroup,
                    'email' => $email,
                    'parent_name' => $parentName,
                    'parent_phone' => $parentPhone,
                    'previous_hike' => $previousHike,
                    'dietary_preferences' => $dietaryPreferences,
                    'privacy_setting' => $privacySettings,
                    'parental_consent' => $parentalConsent,
                    'agreement_terms' => $agreementTerms,
                    'medicine_use' => $medicineUse,
                ]);
            } else {
                // Nieuwe participant aanmaken
                $participant = Participant::create([
                    'membership_number' => $lidnummer,
                    'first_name' => $firstName,
                    'middle_name' => $middleName,
                    'last_name' => $lastName,
                    'street' => $street,
                    'house_number' => $houseNumber,
                    'postal_code' => $postcode,
                    'city' => $city,
                    'scouting_group' => $scoutgroup,
                    'email' => $email,
                    'parent_name' => $parentName,
                    'parent_phone' => $parentPhone,
                    'previous_hike' => $previousHike,
                    'dietary_preferences' => $dietaryPreferences,
                    'privacy_setting' => $privacySettings,
                    'parental_consent' => $parentalConsent,
                    'agreement_terms' => $agreementTerms,
                    'medicine_use' => $medicineUse,
                ]);
            }
        }
    
        // Parse Subgroepen XML file om groups toe te voegen en relaties bij te werken
        $this->importSubgroepen();
    
        // Sluit de modal en reset de loading state
        $this->dispatch('importCompleted');
        $this->isLoading = false;
        $this->successMessage = 'Importeren geslaagd!';
        $this->closeImportModal();
    }

    private function importSubgroepen()
    {
        $subgroepenXML = simplexml_load_file($this->subgroepenFile->getRealPath());

    // Sla de eerste rij (headers) over
    $skipFirstRow = true;

    foreach ($subgroepenXML->Worksheet->Table->Row as $row) {
        if ($skipFirstRow) {
            $skipFirstRow = false;
            continue;
        }

        $lidnummer = (string) $row->Cell[1]->Data;
        $subgroepnaam = (string) $row->Cell[34]->Data;

        // Zoek de participant op basis van het lidnummer
        $participant = Participant::where('membership_number', $lidnummer)->first();

        if ($participant) {
            // Zoek of maak een nieuwe groep aan
            $group = Group::firstOrCreate(
                ['group_name' => $subgroepnaam, 'hike_id' => $this->hike_id],
                ['group_number' => $this->getGroupNumber($this->hike_id)]
            );

            // Update de group_id van de participant
            $participant->group_id = $group->id;
            $participant->save();
        }
    }
    }

    private function getCellValue($row, $headers, $fieldName)
    {
        // Controleer of de header bestaat in de array
        if (isset($headers[$fieldName])) {
            $columnIndex = $headers[$fieldName];  // Haal de kolomindex op voor de gegeven header
    
            // Controleer of de kolomindex bestaat in de huidige rij
            if (isset($row->Cell[$columnIndex])) {
                $cell = $row->Cell[$columnIndex]; // Haal de specifieke cel op
    
                // Controleer of er Data aanwezig is in de cel en geef deze terug
                if (isset($cell->Data)) {
                    return (string) $cell->Data;
                }
            }
        }
    
        return null;  // Geef null terug als de header of data niet beschikbaar is
    }

    private function processParentData($parentData)
    {
        if (preg_match('/(\+?\d{1,3}[-.\s]?\d{2,4}[-.\s]?\d{2,4}[-.\s]?\d{2,4})/', $parentData, $matches)) {
            $parentPhone = $matches[0];
            $parentName = trim(str_replace($parentPhone, '', $parentData));

            if (empty($parentName)) {
                $parentName = 'Onbekend';
            }
        } else {
            $parentPhone = $parentData;
            $parentName = 'Onbekend';
        }

        return [$parentName, $parentPhone];
    }

    private function translateHike($previousHike)
    {
        switch ($previousHike) {
            case "Nee":
                return "Geen";
            case "Ja, de A-hike":
                return "A";
            case "Ja, de B-hike":
                return "B";
            case "Ja, de C-hike":
                return "C";
            case "Ja, de D-hike":
                return "D";
            case "Ja, de E-hike":
                return "E";
            case "Ja, de F-hike":
                return "F";
            default:
                return "Geen";
        }
    }

    private function translatePrivacySettings($privacySetting)
    {
        switch ($privacySetting) {
            case "Andere deelnemers mogen mijn NAW-gegevens zien":
                return "A";
            case "Andere deelnemers mogen uitsluitend mijn naam en land zien":
                return "B";
            case "Andere deelnemers mogen geen persoonlijke gegevens van mij zien":
                return "C";
            default:
                return "A";
        }
    }
    private function translateParentalConcent($parentalConsent)
    {
        switch ($parentalConsent) {
            case "Ja":
                return "1";
            case "Nee":
                return "0";
            default:
                return "1";
        }
    }

    private function translateAgreementTerms($agreementTerms)
    {
        switch ($agreementTerms) {
            case "Ja":
                return "1";
            case "Nee":
                return "0";
            default:
                return "1";
        }
    }
    private function translateMedicineUse($medicineUse)
    {
        switch ($medicineUse) {
            case "Ja":
                return "1";
            case "Nee":
                return "0";
            default:
                return "1";
        }
    }

    private function getGroupNumber($hikeId)
    {
        $highestGroupNumber = Group::where('hike_id', $hikeId)->max('group_number');
        return $highestGroupNumber ? $highestGroupNumber + 1 : 1;
    }

    public function render()
    {
        return view('livewire.participant-import');
    }
}
