<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Document de Validation de Maintenance</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            background-color: #ffffff;
            color: #333;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 20px;
        }
        
        .company-logos {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            gap: 30px;
        }
        
        .logo {
            max-height: 60px;
            max-width: 120px;
            object-fit: contain;
        }
        
        .main-title {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            margin: 15px 0 10px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .subtitle {
            font-size: 14px;
            color: #7f8c8d;
            font-style: italic;
        }
        
        .document-title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            color: #2c3e50;
            margin: 30px 0;
            text-transform: uppercase;
        }
        
        .document-info {
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
            margin-bottom: 30px;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            background-color: #ecf0f1;
            padding: 10px;
            margin-bottom: 15px;
            border-left: 4px solid #3498db;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .info-table th {
            background-color: #34495e;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 12px;
        }
        
        .info-table td {
            padding: 12px;
            border: 1px solid #bdc3c7;
            font-size: 12px;
        }
        
        .info-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .status-validated {
            background-color: #d4edda;
            color: #155724;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 11px;
        }
        
        .actions-section {
            margin-top: 30px;
        }
        
        .action-item {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-left: 4px solid #17a2b8;
        }
        
        .action-date {
            font-size: 10px;
            color: #6c757d;
            font-weight: bold;
        }
        
        .action-user {
            font-size: 11px;
            color: #495057;
            font-weight: bold;
        }
        
        .action-description {
            font-size: 11px;
            color: #212529;
            margin-top: 5px;
        }
        
        .approval-section {
            margin-top: 40px;
            text-align: center;
            page-break-inside: avoid;
        }
        
        .approval-stamp {
            display: inline-block;
            width: 160px;
            height: 160px;
            border: 5px solid #1e7e34;
            border-radius: 50%;
            background: linear-gradient(135deg, #1e7e34 0%, #28a745 50%, #20c997 100%);
            position: relative;
            margin: 20px auto;
            box-shadow: 0 6px 12px rgba(0,0,0,0.3);
        }
        
        .stamp-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #ffffff;
            font-weight: 900;
            width: 100%;
            z-index: 10;
        }
        
        .stamp-text {
            font-size: 16px;
            line-height: 1.1;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
            letter-spacing: 0.5px;
        }
        
        .stamp-date {
            font-size: 13px;
            margin-top: 8px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
            font-weight: 700;
        }
        
        .approval-title {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        
        .approval-text {
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 20px;
            font-style: italic;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #bdc3c7;
            padding-top: 15px;
        }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 72px;
            color: rgba(52, 152, 219, 0.1);
            font-weight: bold;
            z-index: -1;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="watermark">APPROUVÉ</div>
    
    <!-- En-tête avec logos -->
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
    
    <div class="document-title">DOCUMENT DE VALIDATION DE MAINTENANCE</div>
    <div class="document-info">
        Numéro: {{ $maintenance->numero_reference }} | Généré le: {{ now()->format('d/m/Y H:i') }}
    </div>
    
    <!-- Informations de la maintenance -->
    <div class="section">
        <div class="section-title">INFORMATIONS DE LA MAINTENANCE</div>
        <table class="info-table">
            <tr>
                <th>Numéro de Référence</th>
                <td>{{ $maintenance->numero_reference }}</td>
            </tr>
            <tr>
                <th>Date de Déclaration</th>
                <td>{{ $maintenance->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Motif de Maintenance</th>
                <td>{{ $maintenance->motif }}</td>
            </tr>
            <tr>
                <th>Description du Problème</th>
                <td>{{ $maintenance->description_probleme }}</td>
            </tr>
            <tr>
                <th>Statut</th>
                <td><span class="status-validated">{{ strtoupper($maintenance->statut) }}</span></td>
            </tr>
        </table>
    </div>
    
    <!-- Informations du pneu -->
    <div class="section">
        <div class="section-title">INFORMATIONS DU PNEU</div>
        <table class="info-table">
            <tr>
                <th>Numéro de Série</th>
                <td>{{ $pneu->numero_serie }}</td>
            </tr>
            <tr>
                <th>Marque</th>
                <td>{{ $pneu->marque }}</td>
            </tr>
            <tr>
                <th>Modèle</th>
                <td>{{ $pneu->modele }}</td>
            </tr>
            <tr>
                <th>Dimension</th>
                <td>{{ $pneu->dimension }}</td>
            </tr>
            <tr>
                <th>Kilométrage Actuel</th>
                <td>{{ number_format($pneu->kilometrage) }} km</td>
            </tr>
            <tr>
                <th>Taux d'Usure</th>
                <td>{{ $pneu->taux_usure }}%</td>
            </tr>
        </table>
    </div>
    
    <!-- Informations du véhicule -->
    <div class="section">
        <div class="section-title">INFORMATIONS DU VÉHICULE</div>
        <table class="info-table">
            <tr>
                <th>Immatriculation</th>
                <td>{{ $vehicule->immatriculation }}</td>
            </tr>
            <tr>
                <th>Marque</th>
                <td>{{ $vehicule->marque }}</td>
            </tr>
            <tr>
                <th>Modèle</th>
                <td>{{ $vehicule->modele }}</td>
            </tr>
            <tr>
                <th>Type</th>
                <td>{{ $vehicule->type }}</td>
            </tr>
        </table>
    </div>
    
    <!-- Informations des utilisateurs -->
    <div class="section">
        <div class="section-title">INFORMATIONS DES UTILISATEURS</div>
        <table class="info-table">
            <tr>
                <th>Mécanicien</th>
                <td>{{ $mecanicien->name ?? 'N/A' }} ({{ $mecanicien->role_name ?? 'N/A' }})</td>
            </tr>
            <tr>
                <th>Déclarateur</th>
                <td>{{ $declarateur->name ?? 'N/A' }} ({{ $declarateur->role_name ?? 'N/A' }})</td>
            </tr>
            <tr>
                <th>Direction</th>
                <td>{{ $direction->name ?? 'N/A' }} ({{ $direction->role_name ?? 'N/A' }})</td>
            </tr>
        </table>
    </div>
    
    <!-- Historique des actions -->
    @if($maintenance->actions && count($maintenance->actions) > 0)
    <div class="section actions-section">
        <div class="section-title">HISTORIQUE DES ACTIONS</div>
        @foreach($maintenance->actions as $action)
        <div class="action-item">
            <div class="action-date">{{ $action['date'] }}</div>
            <div class="action-user">{{ $action['user'] }}</div>
            <div class="action-description">{{ $action['description'] }}</div>
        </div>
        @endforeach
    </div>
    @endif
    
    <!-- Section d'approbation avec cachet uniquement -->
    <div class="approval-section">
        <div class="approval-title">APPROBATION DE LA DIRECTION</div>
        
        <div class="approval-stamp">
            <div class="stamp-content">
                <div class="stamp-text">
                    ✓ APPROUVÉ<br>
                    DIRECTION
                </div>
                <div class="stamp-date">{{ now()->format('d/m/Y') }}</div>
            </div>
        </div>
        
        <div class="approval-text">
            Cachet de la direction requis pour validation<br>
            Document généré automatiquement le {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>
    
    <!-- Pied de page -->
    <div class="footer">
        <strong>PNEUMA-SOUCHE</strong> - Système de Gestion Pneumatique<br>
        Document généré automatiquement le {{ now()->format('d/m/Y H:i') }} | Numéro: {{ $maintenance->numero_reference }}
    </div>
</body>
</html>
