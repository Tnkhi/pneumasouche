<?php

namespace App\Services;

use App\Models\Pneu;
use App\Models\Vehicule;
use App\Models\Alerte;
use App\Services\AlerteIntelligenteService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DistanceUsureService
{
    protected $alerteService;

    public function __construct(AlerteIntelligenteService $alerteService)
    {
        $this->alerteService = $alerteService;
    }

    /**
     * Calculer la distance entre deux points géographiques
     */
    public function calculerDistance(string $origine, string $destination): float
    {
        try {
            // Essayer d'abord avec Google Maps API
            $coordsOrigine = $this->obtenirCoordonneesGPS($origine);
            $coordsDestination = $this->obtenirCoordonneesGPS($destination);

            if ($coordsOrigine && $coordsDestination) {
                // Calculer la distance en utilisant la formule de Haversine
                $distance = $this->calculerDistanceHaversine(
                    $coordsOrigine['lat'], $coordsOrigine['lng'],
                    $coordsDestination['lat'], $coordsDestination['lng']
                );

                Log::info('Distance calculée via Google Maps', [
                    'origine' => $origine,
                    'destination' => $destination,
                    'distance_km' => $distance
                ]);

                return $distance;
            }

            // Fallback : utiliser les coordonnées prédéfinies
            $coordsOrigine = $this->obtenirCoordonneesPredefinies($origine);
            $coordsDestination = $this->obtenirCoordonneesPredefinies($destination);

            if ($coordsOrigine && $coordsDestination) {
                $distance = $this->calculerDistanceHaversine(
                    $coordsOrigine['lat'], $coordsOrigine['lng'],
                    $coordsDestination['lat'], $coordsDestination['lng']
                );

                Log::info('Distance calculée via coordonnées prédéfinies', [
                    'origine' => $origine,
                    'destination' => $destination,
                    'distance_km' => $distance
                ]);

                return $distance;
            }

            Log::warning('Impossible de calculer la distance', [
                'origine' => $origine,
                'destination' => $destination
            ]);

            return 0;

        } catch (\Exception $e) {
            Log::error('Erreur calcul distance', [
                'origine' => $origine,
                'destination' => $destination,
                'error' => $e->getMessage()
            ]);
            return 0;
        }
    }

    /**
     * Obtenir les coordonnées GPS d'un lieu via Google Maps Geocoding API
     */
    private function obtenirCoordonneesGPS(string $adresse): ?array
    {
        try {
            $apiKey = config('services.google_maps.api_key');
            
            if (!$apiKey) {
                Log::warning('Clé API Google Maps non configurée');
                return null;
            }

            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $adresse,
                'key' => $apiKey
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['results'][0]['geometry']['location'])) {
                    $location = $data['results'][0]['geometry']['location'];
                    return [
                        'lat' => $location['lat'],
                        'lng' => $location['lng']
                    ];
                }
            }

            Log::warning('Impossible d\'obtenir les coordonnées', [
                'adresse' => $adresse,
                'response' => $response->body()
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('Erreur géocodage', [
                'adresse' => $adresse,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Obtenir les coordonnées GPS prédéfinies pour les villes du Cameroun
     */
    private function obtenirCoordonneesPredefinies(string $adresse): ?array
    {
        $coordonnees = [
            // Villes principales du Cameroun
            'douala' => ['lat' => 4.0483, 'lng' => 9.7043],
            'yaoundé' => ['lat' => 3.8480, 'lng' => 11.5021],
            'yaounde' => ['lat' => 3.8480, 'lng' => 11.5021],
            'garoua' => ['lat' => 9.3000, 'lng' => 13.4000],
            'bafoussam' => ['lat' => 5.4737, 'lng' => 10.4171],
            'bamenda' => ['lat' => 5.9597, 'lng' => 10.1519],
            'maroua' => ['lat' => 10.5956, 'lng' => 14.3247],
            'ngaoundéré' => ['lat' => 7.3167, 'lng' => 13.5833],
            'ngaoundere' => ['lat' => 7.3167, 'lng' => 13.5833],
            'bertoua' => ['lat' => 4.5833, 'lng' => 14.0833],
            'ebolowa' => ['lat' => 2.9333, 'lng' => 11.1500],
            'kumba' => ['lat' => 4.6333, 'lng' => 9.4333],
            'limbe' => ['lat' => 4.0167, 'lng' => 9.2000],
            'dschang' => ['lat' => 5.4500, 'lng' => 10.0500],
            'foumban' => ['lat' => 5.7167, 'lng' => 10.9000],
            'edéa' => ['lat' => 3.8000, 'lng' => 10.1333],
            'edea' => ['lat' => 3.8000, 'lng' => 10.1333],
            'kribi' => ['lat' => 2.9500, 'lng' => 9.9167],
            'mbalmayo' => ['lat' => 3.5167, 'lng' => 11.5000],
            'sangmélima' => ['lat' => 2.9333, 'lng' => 11.9833],
            'sangmelima' => ['lat' => 2.9333, 'lng' => 11.9833],
            
            // Avec "Cameroun" dans le nom
            'douala, cameroun' => ['lat' => 4.0483, 'lng' => 9.7043],
            'yaoundé, cameroun' => ['lat' => 3.8480, 'lng' => 11.5021],
            'yaounde, cameroun' => ['lat' => 3.8480, 'lng' => 11.5021],
            'garoua, cameroun' => ['lat' => 9.3000, 'lng' => 13.4000],
            'bafoussam, cameroun' => ['lat' => 5.4737, 'lng' => 10.4171],
            'bamenda, cameroun' => ['lat' => 5.9597, 'lng' => 10.1519],
            'maroua, cameroun' => ['lat' => 10.5956, 'lng' => 14.3247],
            'ngaoundéré, cameroun' => ['lat' => 7.3167, 'lng' => 13.5833],
            'ngaoundere, cameroun' => ['lat' => 7.3167, 'lng' => 13.5833],
            'bertoua, cameroun' => ['lat' => 4.5833, 'lng' => 14.0833],
            'ebolowa, cameroun' => ['lat' => 2.9333, 'lng' => 11.1500],
            'kumba, cameroun' => ['lat' => 4.6333, 'lng' => 9.4333],
            'limbe, cameroun' => ['lat' => 4.0167, 'lng' => 9.2000],
            'dschang, cameroun' => ['lat' => 5.4500, 'lng' => 10.0500],
            'foumban, cameroun' => ['lat' => 5.7167, 'lng' => 10.9000],
            'edéa, cameroun' => ['lat' => 3.8000, 'lng' => 10.1333],
            'edea, cameroun' => ['lat' => 3.8000, 'lng' => 10.1333],
            'kribi, cameroun' => ['lat' => 2.9500, 'lng' => 9.9167],
            'mbalmayo, cameroun' => ['lat' => 3.5167, 'lng' => 11.5000],
            'sangmélima, cameroun' => ['lat' => 2.9333, 'lng' => 11.9833],
            'sangmelima, cameroun' => ['lat' => 2.9333, 'lng' => 11.9833],
        ];

        // Normaliser l'adresse (minuscules, sans accents)
        $adresseNormalisee = strtolower($adresse);
        $adresseNormalisee = str_replace(['é', 'è', 'ê', 'ë'], 'e', $adresseNormalisee);
        $adresseNormalisee = str_replace(['à', 'â', 'ä'], 'a', $adresseNormalisee);
        $adresseNormalisee = str_replace(['ù', 'û', 'ü'], 'u', $adresseNormalisee);
        $adresseNormalisee = str_replace(['ô', 'ö'], 'o', $adresseNormalisee);
        $adresseNormalisee = str_replace(['î', 'ï'], 'i', $adresseNormalisee);
        $adresseNormalisee = str_replace(['ç'], 'c', $adresseNormalisee);

        // Chercher une correspondance exacte
        if (isset($coordonnees[$adresseNormalisee])) {
            return $coordonnees[$adresseNormalisee];
        }

        // Chercher une correspondance partielle
        foreach ($coordonnees as $ville => $coords) {
            if (strpos($adresseNormalisee, $ville) !== false) {
                return $coords;
            }
        }

        return null;
    }

    /**
     * Calculer la distance entre deux points GPS (formule de Haversine)
     */
    public function calculerDistanceHaversine(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371; // Rayon de la Terre en kilomètres

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Mettre à jour l'usure des pneus d'un véhicule après un mouvement
     */
    public function mettreAJourUsurePneus(Vehicule $vehicule, float $distance): array
    {
        $resultats = [
            'pneus_mis_a_jour' => 0,
            'alertes_creees' => 0,
            'details' => []
        ];

        try {
            $pneus = $vehicule->pneus;

            foreach ($pneus as $pneu) {
                $ancienKilometrage = $pneu->kilometrage;
                $ancienTauxUsure = $pneu->calculerTauxUsure();

                // Mettre à jour le kilométrage
                $pneu->kilometrage += $distance;
                $nouveauTauxUsure = $pneu->calculerTauxUsure();
                $pneu->save();

                $resultats['pneus_mis_a_jour']++;
                $resultats['details'][] = [
                    'pneu_id' => $pneu->id,
                    'numero_serie' => $pneu->numero_serie,
                    'ancien_kilometrage' => $ancienKilometrage,
                    'nouveau_kilometrage' => $pneu->kilometrage,
                    'ancien_taux_usure' => $ancienTauxUsure,
                    'nouveau_taux_usure' => $nouveauTauxUsure,
                    'distance_ajoutee' => $distance
                ];

                // Vérifier si des alertes doivent être créées
                $alertesCreees = $this->verifierEtCreerAlertes($pneu, $ancienTauxUsure, $nouveauTauxUsure);
                $resultats['alertes_creees'] += $alertesCreees;

                Log::info('Pneu mis à jour', [
                    'pneu_id' => $pneu->id,
                    'numero_serie' => $pneu->numero_serie,
                    'distance_ajoutee' => $distance,
                    'nouveau_taux_usure' => $nouveauTauxUsure
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Erreur mise à jour usure pneus', [
                'vehicule_id' => $vehicule->id,
                'distance' => $distance,
                'error' => $e->getMessage()
            ]);
        }

        return $resultats;
    }

    /**
     * Vérifier et créer des alertes si nécessaire
     */
    private function verifierEtCreerAlertes(Pneu $pneu, float $ancienTaux, float $nouveauTaux): int
    {
        $alertesCreees = 0;

        // Alerte critique : dépassement de 90%
        if ($ancienTaux < 90 && $nouveauTaux >= 90) {
            $this->creerAlerteUsure($pneu, 'critique', 'danger', $nouveauTaux);
            $alertesCreees++;
        }
        // Alerte haute : dépassement de 80%
        elseif ($ancienTaux < 80 && $nouveauTaux >= 80) {
            $this->creerAlerteUsure($pneu, 'haute', 'warning', $nouveauTaux);
            $alertesCreees++;
        }
        // Alerte moyenne : dépassement de 70%
        elseif ($ancienTaux < 70 && $nouveauTaux >= 70) {
            $this->creerAlerteUsure($pneu, 'moyenne', 'warning', $nouveauTaux);
            $alertesCreees++;
        }

        return $alertesCreees;
    }

    /**
     * Créer une alerte d'usure
     */
    private function creerAlerteUsure(Pneu $pneu, string $priorite, string $type, float $tauxUsure): void
    {
        try {
            Alerte::create([
                'titre' => 'Usure ' . ucfirst($priorite) . ' du Pneu',
                'message' => "Le pneu {$pneu->numero_serie} ({$pneu->marque}) a atteint {$tauxUsure}% d'usure lors du dernier mouvement.",
                'type' => $type,
                'priorite' => $priorite,
                'statut' => 'active',
                'categorie' => 'usure',
                'pneu_id' => $pneu->id,
                'vehicule_id' => $pneu->vehicule_id,
                'donnees_contexte' => [
                    'taux_usure' => $tauxUsure,
                    'kilometrage' => $pneu->kilometrage,
                    'duree_vie' => $pneu->duree_vie,
                    'vehicule' => $pneu->vehicule?->immatriculation,
                    'declencheur' => 'mouvement_automatique'
                ]
            ]);

            Log::info('Alerte d\'usure créée automatiquement', [
                'pneu_id' => $pneu->id,
                'taux_usure' => $tauxUsure,
                'priorite' => $priorite
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur création alerte usure', [
                'pneu_id' => $pneu->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Obtenir un résumé des mises à jour d'usure
     */
    public function obtenirResumeMiseAJour(array $resultats): string
    {
        $message = "Mise à jour effectuée : {$resultats['pneus_mis_a_jour']} pneu(s) mis à jour";
        
        if ($resultats['alertes_creees'] > 0) {
            $message .= ", {$resultats['alertes_creees']} alerte(s) créée(s)";
        }

        return $message;
    }
}
