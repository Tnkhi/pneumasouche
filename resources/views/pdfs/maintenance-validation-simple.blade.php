<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation de Maintenance - {{ $numero_document }}</title>
    <style>
        @page {
            margin: 20mm;
            size: A4;
        }
        
        body {
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
        }
        
        .company-logos {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        
        .logo {
            height: 45px;
            width: auto;
            max-width: 120px;
            margin: 0 8px;
            object-fit: contain;
        }
        
        .main-title {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            margin: 10px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .document-info {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 25px;
        }
        
        .document-number {
            font-size: 16px;
            font-weight: bold;
            color: #667eea;
            text-align: center;
            margin-bottom: 10px;
        }
        
        .document-date {
            text-align: center;
            color: #666;
            font-size: 11px;
        }
        
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .section-title {
            background: #667eea;
            color: white;
            padding: 8px 15px;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
            border-radius: 3px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            width: 30%;
            padding: 8px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            font-weight: bold;
            vertical-align: top;
        }
        
        .info-value {
            display: table-cell;
            padding: 8px;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-validated {
            background: #d4edda;
            color: #155724;
        }
        
        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }
        
        .signature-box {
            border: 3px solid #667eea;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            position: relative;
            overflow: visible;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .signature-title {
            font-size: 18px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .signature-line {
            border-bottom: 3px solid #333;
            width: 250px;
            margin: 25px auto;
            height: 50px;
            position: relative;
        }
        
        .signature-info {
            font-size: 12px;
            color: #333;
            margin-top: 15px;
            font-weight: 500;
        }
        
        .approval-stamp {
            position: absolute;
            top: -15px;
            right: -15px;
            width: 100px;
            height: 100px;
            border: 4px solid #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(40, 167, 69, 0.15);
            transform: rotate(-12deg);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }
        
        .stamp-text {
            font-size: 9px;
            font-weight: bold;
            color: #28a745;
            text-align: center;
            line-height: 1.3;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
        }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 60px;
            color: rgba(102, 126, 234, 0.1);
            font-weight: bold;
            z-index: -1;
            pointer-events: none;
        }
        
        .important-note {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
        
        .important-note-title {
            font-weight: bold;
            color: #856404;
            margin-bottom: 5px;
        }
        
        .important-note-text {
            color: #856404;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <!-- Watermark -->
    <div class="watermark">APPROUVÉ</div>
    
    <!-- Header -->
    <div class="header">
        <div class="company-logos">
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
        <div class="main-title">PNEUMA-SOUCHE</div>
        <div class="subtitle">Système de Gestion Pneumatique</div>
    </div>
    
    <!-- Document Info -->
    <div class="document-info">
        <div class="document-number">DOCUMENT DE VALIDATION DE MAINTENANCE</div>
        <div class="document-date">Numéro: {{ $numero_document }} | Généré le: {{ $date_generation }}</div>
    </div>
    
    <!-- Informations de la Maintenance -->
    <div class="section">
        <div class="section-title">📋 INFORMATIONS DE LA MAINTENANCE</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Numéro de Référence</div>
                <div class="info-value">{{ $maintenance->numero_reference ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Date de Déclaration</div>
                <div class="info-value">{{ $maintenance->date_declaration ? $maintenance->date_declaration->format('d/m/Y H:i') : 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Motif de Maintenance</div>
                <div class="info-value">{{ $maintenance->motif_maintenance }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Description du Problème</div>
                <div class="info-value">{{ $maintenance->description_probleme ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Statut</div>
                <div class="info-value">
                    <span class="status-badge status-validated">VALIDÉE</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Informations du Pneu -->
    <div class="section">
        <div class="section-title">🛞 INFORMATIONS DU PNEU</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Numéro de Série</div>
                <div class="info-value">{{ $pneu->numero_serie }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Marque</div>
                <div class="info-value">{{ $pneu->marque }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Dimensions</div>
                <div class="info-value">{{ $pneu->largeur }}/{{ $pneu->hauteur_flanc }} R{{ $pneu->diametre_interieur }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Indices</div>
                <div class="info-value">Vitesse: {{ $pneu->indice_vitesse }} | Charge: {{ $pneu->indice_charge }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Kilométrage Actuel</div>
                <div class="info-value">{{ number_format($pneu->kilometrage, 0, ',', ' ') }} km</div>
            </div>
            <div class="info-row">
                <div class="info-label">Taux d'Usure</div>
                <div class="info-value">{{ number_format($pneu->calculerTauxUsure(), 1) }}%</div>
            </div>
        </div>
    </div>
    
    <!-- Informations du Véhicule -->
    <div class="section">
        <div class="section-title">🚗 INFORMATIONS DU VÉHICULE</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Immatriculation</div>
                <div class="info-value">{{ $vehicule->immatriculation }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Marque</div>
                <div class="info-value">{{ $vehicule->marque }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Modèle</div>
                <div class="info-value">{{ $vehicule->modele }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Chauffeur</div>
                <div class="info-value">{{ $vehicule->chauffeur ?? 'N/A' }}</div>
            </div>
        </div>
    </div>
    
    <!-- Informations du Fournisseur -->
    <div class="section">
        <div class="section-title">🏢 INFORMATIONS DU FOURNISSEUR</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nom</div>
                <div class="info-value">{{ $fournisseur->nom }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Contact</div>
                <div class="info-value">{{ $fournisseur->contact ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Téléphone</div>
                <div class="info-value">{{ $fournisseur->telephone ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $fournisseur->email ?? 'N/A' }}</div>
            </div>
        </div>
    </div>
    
    <!-- Informations Financières -->
    <div class="section">
        <div class="section-title">💰 INFORMATIONS FINANCIÈRES</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Bon Nécessaire</div>
                <div class="info-value">{{ $maintenance->bon_necessaire ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Prix de Maintenance</div>
                <div class="info-value">{{ number_format($maintenance->prix_maintenance ?? 0, 0, ',', ' ') }} FCFA</div>
            </div>
            <div class="info-row">
                <div class="info-label">Prix d'Achat du Pneu</div>
                <div class="info-value">{{ number_format($pneu->prix_achat, 0, ',', ' ') }} FCFA</div>
            </div>
        </div>
    </div>
    
    <!-- Personnel Impliqué -->
    <div class="section">
        <div class="section-title">👥 PERSONNEL IMPLIQUÉ</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Mécanicien</div>
                <div class="info-value">{{ $mecanicien->name }} ({{ $mecanicien->role_name }})</div>
            </div>
            <div class="info-row">
                <div class="info-label">Déclarateur</div>
                <div class="info-value">{{ $declarateur->name ?? 'N/A' }} ({{ $declarateur->role_name ?? 'N/A' }})</div>
            </div>
            <div class="info-row">
                <div class="info-label">Direction</div>
                <div class="info-value">{{ $direction->name ?? 'N/A' }} ({{ $direction->role_name ?? 'N/A' }})</div>
            </div>
        </div>
    </div>
    
    <!-- Note Importante -->
    <div class="important-note">
        <div class="important-note-title">⚠️ NOTE IMPORTANTE</div>
        <div class="important-note-text">
            Ce document certifie que la maintenance du pneu {{ $pneu->numero_serie }} a été validée par la direction. 
            La maintenance peut maintenant être effectuée par le mécanicien. Ce document doit être conservé dans les archives de l'entreprise.
        </div>
    </div>
    
    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="approval-stamp">
                <div class="stamp-text">
                    ✓ APPROUVÉ<br>
                    DIRECTION<br>
                    {{ now()->format('d/m/Y') }}
                </div>
            </div>
            <div class="signature-title">SIGNATURE ET CACHET DE LA DIRECTION</div>
            <div style="margin: 20px 0; font-size: 14px; color: #666;">
                Je soussigné(e), <strong>{{ $direction->name ?? 'N/A' }}</strong>, 
                {{ $direction->role_name ?? 'N/A' }}, certifie par la présente avoir 
                examiné et approuvé la demande de maintenance ci-dessus.
            </div>
            <div class="signature-line"></div>
            <div class="signature-info">
                <strong>Nom et Prénom:</strong> {{ $direction->name ?? 'N/A' }}<br>
                <strong>Fonction:</strong> {{ $direction->role_name ?? 'N/A' }}<br>
                <strong>Date de signature:</strong> {{ now()->format('d/m/Y') }}<br>
                <strong>Heure:</strong> {{ now()->format('H:i') }}
            </div>
            <div style="margin-top: 20px; font-size: 11px; color: #888; font-style: italic;">
                Cachet et signature de la direction requis pour validation
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <p><strong>PNEUMA-SOUCHE</strong> - Système de Gestion Pneumatique</p>
        <p>Document généré automatiquement le {{ $date_generation }} | Numéro: {{ $numero_document }}</p>
        <p>Ce document est confidentiel et destiné uniquement à l'usage interne de l'entreprise.</p>
    </div>
</body>
</html>
