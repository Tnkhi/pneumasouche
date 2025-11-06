# Configuration Google Maps API

## 🔑 **Configuration de la clé API Google Maps**

Le système de calcul automatique de distance fonctionne **TOUJOURS**, même sans clé API Google Maps grâce au système de fallback intégré.

### 1. **Système Hybride (Recommandé)**

Le système utilise une approche en deux étapes :

1. **Google Maps API** (si configuré) : Calcul précis via géocodage
2. **Coordonnées prédéfinies** (fallback) : 20+ villes du Cameroun

### 2. **Configuration Google Maps (Optionnel)**

Pour une précision maximale, ajoutez la clé API dans votre fichier `.env` :

```env
GOOGLE_MAPS_API_KEY=votre_cle_api_google_maps_ici
```

**Obtenir une clé API :**
1. Allez sur [Google Cloud Console](https://console.cloud.google.com/)
2. Créez un nouveau projet ou sélectionnez un projet existant
3. Activez l'API **Geocoding API**
4. Créez des identifiants (clé API)
5. Restreignez la clé API aux domaines autorisés

### 3. **Villes Supportées (Fallback)**

Le système inclut les coordonnées GPS pour ces villes du Cameroun :

- **Douala** → **Yaoundé** : 200.67 km
- **Yaoundé** → **Garoua** : 641.43 km
- **Douala** → **Bafoussam** : 177.09 km
- **Bamenda** → **Maroua** : 690.24 km
- **Ngaoundéré** → **Bertoua** : 308.93 km
- Et 15+ autres villes...

### 4. **Fonctionnement**

```php
// Le système essaie d'abord Google Maps
$coords = $this->obtenirCoordonneesGPS($adresse);

// Si échec, utilise les coordonnées prédéfinies
if (!$coords) {
    $coords = $this->obtenirCoordonneesPredefinies($adresse);
}

// Calcule la distance avec la formule de Haversine
$distance = $this->calculerDistanceHaversine($lat1, $lng1, $lat2, $lng2);
```

### 5. **Avantages du Système**

- ✅ **Toujours fonctionnel** : Même sans clé API
- ✅ **Précis** : Coordonnées GPS exactes pour les villes principales
- ✅ **Rapide** : Pas de latence réseau pour les villes prédéfinies
- ✅ **Économique** : Pas de coût pour les villes supportées
- ✅ **Extensible** : Facile d'ajouter de nouvelles villes

### 6. **Test du Système**

```bash
php artisan tinker
```

```php
$service = new \App\Services\DistanceUsureService(new \App\Services\AlerteIntelligenteService());

// Test avec villes prédéfinies
$distance = $service->calculerDistance('Douala', 'Yaoundé');
echo "Distance: " . $distance . " km"; // 200.67 km

// Test avec Google Maps (si configuré)
$distance = $service->calculerDistance('Ville inconnue', 'Autre ville');
echo "Distance: " . $distance . " km";
```

### 7. **Limites et Coûts**

- **Gratuit** : Toutes les villes prédéfinies (20+ villes)
- **Google Maps** : 40 000 requêtes/mois gratuites
- **Recommandation** : Le système fonctionne parfaitement sans clé API

### 8. **Sécurité**

- Restreignez votre clé API aux domaines autorisés
- Ne commitez jamais votre clé API dans le code source
- Le système fonctionne sans clé API (fallback automatique)
