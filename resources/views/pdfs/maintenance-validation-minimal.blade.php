<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Validation de Maintenance</title>
    <style>
        body { margin: 20px; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .logo { height: 40px; margin: 0 10px; }
        .title { font-size: 20px; font-weight: bold; margin: 10px 0; }
        .section { margin-bottom: 20px; }
        .section-title { background: #333; color: white; padding: 8px; font-weight: bold; margin-bottom: 10px; }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { border: 1px solid #ccc; padding: 8px; }
        .info-label { background: #f5f5f5; font-weight: bold; width: 30%; }
        .signature-box { border: 2px solid #333; padding: 20px; text-align: center; margin-top: 30px; }
        .stamp { position: absolute; top: 10px; right: 10px; width: 80px; height: 80px; border: 3px solid #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: rgba(40, 167, 69, 0.1); transform: rotate(-15deg); }
        .stamp-text { font-size: 8px; font-weight: bold; color: #28a745; text-align: center; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; border-top: 1px solid #ccc; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            @if(file_exists(public_path('8Ptransit.png')))
                <img src="{{ public_path('8Ptransit.png') }}" alt="8P Transit" class="logo">
            @endif
            @if(file_exists(public_path('Quifeurou.png')))
                <img src="{{ public_path('Quifeurou.png') }}" alt="Quifeurou" class="logo">
            @endif
            @if(file_exists(public_path('Sesa SA.png')))
                <img src="{{ public_path('Sesa SA.png') }}" alt="Sesa SA" class="logo">
            @endif
        </div>
        <div class="title">PNEUMA-SOUCHE</div>
        <div>Système de Gestion Pneumatique</div>
    </div>

    <div style="background: #f8f9fa; padding: 15px; margin-bottom: 20px; text-align: center;">
        <div style="font-size: 16px; font-weight: bold; color: #333;">DOCUMENT DE VALIDATION DE MAINTENANCE</div>
        <div style="color: #666;">Numéro: {{ $numero_document }} | Généré le: {{ $date_generation }}</div>
    </div>

    <div class="section">
        <div class="section-title">INFORMATIONS DE LA MAINTENANCE</div>
        <table class="info-table">
            <tr>
                <td class="info-label">Numéro de Référence</td>
                <td>{{ $maintenance->numero_reference ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="info-label">Date de Déclaration</td>
                <td>{{ $maintenance->date_declaration ? $maintenance->date_declaration->format('d/m/Y H:i') : 'N/A' }}</td>
            </tr>
            <tr>
                <td class="info-label">Motif de Maintenance</td>
                <td>{{ $maintenance->motif_maintenance }}</td>
            </tr>
            <tr>
                <td class="info-label">Description du Problème</td>
                <td>{{ $maintenance->description_probleme ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="info-label">Statut</td>
                <td><strong>VALIDÉE</strong></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">INFORMATIONS DU PNEU</div>
        <table class="info-table">
            <tr>
                <td class="info-label">Numéro de Série</td>
                <td>{{ $pneu->numero_serie }}</td>
            </tr>
            <tr>
                <td class="info-label">Marque</td>
                <td>{{ $pneu->marque }}</td>
            </tr>
            <tr>
                <td class="info-label">Dimensions</td>
                <td>{{ $pneu->largeur }}/{{ $pneu->hauteur_flanc }} R{{ $pneu->diametre_interieur }}</td>
            </tr>
            <tr>
                <td class="info-label">Kilométrage Actuel</td>
                <td>{{ number_format($pneu->kilometrage, 0, ',', ' ') }} km</td>
            </tr>
            <tr>
                <td class="info-label">Taux d'Usure</td>
                <td>{{ number_format($pneu->calculerTauxUsure(), 1) }}%</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">INFORMATIONS DU VÉHICULE</div>
        <table class="info-table">
            <tr>
                <td class="info-label">Immatriculation</td>
                <td>{{ $vehicule->immatriculation }}</td>
            </tr>
            <tr>
                <td class="info-label">Marque</td>
                <td>{{ $vehicule->marque }}</td>
            </tr>
            <tr>
                <td class="info-label">Modèle</td>
                <td>{{ $vehicule->modele }}</td>
            </tr>
            <tr>
                <td class="info-label">Chauffeur</td>
                <td>{{ $vehicule->chauffeur ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">INFORMATIONS FINANCIÈRES</div>
        <table class="info-table">
            <tr>
                <td class="info-label">Bon Nécessaire</td>
                <td>{{ $maintenance->bon_necessaire ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="info-label">Prix de Maintenance</td>
                <td>{{ number_format($maintenance->prix_maintenance ?? 0, 0, ',', ' ') }} FCFA</td>
            </tr>
            <tr>
                <td class="info-label">Prix d'Achat du Pneu</td>
                <td>{{ number_format($pneu->prix_achat, 0, ',', ' ') }} FCFA</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">PERSONNEL IMPLIQUÉ</div>
        <table class="info-table">
            <tr>
                <td class="info-label">Mécanicien</td>
                <td>{{ $mecanicien->name }} ({{ $mecanicien->role_name }})</td>
            </tr>
            <tr>
                <td class="info-label">Déclarateur</td>
                <td>{{ $declarateur->name ?? 'N/A' }} ({{ $declarateur->role_name ?? 'N/A' }})</td>
            </tr>
            <tr>
                <td class="info-label">Direction</td>
                <td>{{ $direction->name ?? 'N/A' }} ({{ $direction->role_name ?? 'N/A' }})</td>
            </tr>
        </table>
    </div>

    <div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; margin: 20px 0;">
        <div style="font-weight: bold; color: #856404; margin-bottom: 5px;">⚠️ NOTE IMPORTANTE</div>
        <div style="color: #856404; font-size: 11px;">
            Ce document certifie que la maintenance du pneu {{ $pneu->numero_serie }} a été validée par la direction. 
            La maintenance peut maintenant être effectuée par le mécanicien. Ce document doit être conservé dans les archives de l'entreprise.
        </div>
    </div>

    <div class="signature-box" style="position: relative;">
        <div class="stamp">
            <div class="stamp-text">
                ✓ APPROUVÉ<br>
                DIRECTION<br>
                {{ now()->format('d/m/Y') }}
            </div>
        </div>
        <div style="font-size: 16px; font-weight: bold; margin-bottom: 20px;">SIGNATURE ET CACHET DE LA DIRECTION</div>
        <div style="margin: 20px 0; font-size: 14px;">
            Je soussigné(e), <strong>{{ $direction->name ?? 'N/A' }}</strong>, 
            {{ $direction->role_name ?? 'N/A' }}, certifie par la présente avoir 
            examiné et approuvé la demande de maintenance ci-dessus.
        </div>
        <div style="border-bottom: 2px solid #333; width: 250px; margin: 20px auto; height: 40px;"></div>
        <div style="font-size: 12px; margin-top: 15px;">
            <strong>Nom et Prénom:</strong> {{ $direction->name ?? 'N/A' }}<br>
            <strong>Fonction:</strong> {{ $direction->role_name ?? 'N/A' }}<br>
            <strong>Date de signature:</strong> {{ now()->format('d/m/Y') }}<br>
            <strong>Heure:</strong> {{ now()->format('H:i') }}
        </div>
        <div style="margin-top: 20px; font-size: 11px; color: #888; font-style: italic;">
            Cachet et signature de la direction requis pour validation
        </div>
    </div>

    <div class="footer">
        <p><strong>PNEUMA-SOUCHE</strong> - Système de Gestion Pneumatique</p>
        <p>Document généré automatiquement le {{ $date_generation }} | Numéro: {{ $numero_document }}</p>
        <p>Ce document est confidentiel et destiné uniquement à l'usage interne de l'entreprise.</p>
    </div>
</body>
</html>
