<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Document de Validation de Maintenance</title>
    <style>
        body {
            margin: 0;
            padding: 15px;
            background-color: #ffffff;
            color: #2c3e50;
            line-height: 1.5;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 4px solid #3498db;
            padding-bottom: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            padding: 20px;
        }
        
        .company-logos {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
            gap: 25px;
        }
        
        .logo {
            max-height: 50px;
            max-width: 100px;
            object-fit: contain;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .main-title {
            font-size: 32px;
            font-weight: bold;
            color: #2c3e50;
            margin: 15px 0 8px 0;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        .subtitle {
            font-size: 16px;
            color: #7f8c8d;
            font-style: italic;
            margin-bottom: 10px;
        }
        
        .document-title {
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            color: #2c3e50;
            margin: 25px 0 15px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        .document-info {
            text-align: center;
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 25px;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        
        .section {
            margin-bottom: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #ffffff;
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            padding: 15px 20px;
            margin: 0;
            border: none;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .section-content {
            padding: 20px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .info-table th {
            background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
            color: white;
            padding: 15px 12px;
            text-align: left;
            font-weight: bold;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-table td {
            padding: 12px;
            border: 1px solid #e9ecef;
            font-size: 13px;
            background-color: #ffffff;
        }
        
        .info-table tr:nth-child(even) td {
            background-color: #f8f9fa;
        }
        
        .info-table tr:hover td {
            background-color: #e3f2fd;
        }
        
        .status-validated {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 2px solid #28a745;
            display: inline-block;
        }
        
        .actions-section {
            margin-top: 25px;
        }
        
        .action-item {
            margin-bottom: 12px;
            padding: 15px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-left: 5px solid #17a2b8;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .action-date {
            font-size: 11px;
            color: #6c757d;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .action-user {
            font-size: 12px;
            color: #495057;
            font-weight: bold;
            margin: 5px 0;
        }
        
        .action-description {
            font-size: 12px;
            color: #212529;
            margin-top: 8px;
            line-height: 1.4;
        }
        
        .approval-section {
            margin-top: 35px;
            text-align: center;
            page-break-inside: avoid;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 30px;
            border-radius: 15px;
            border: 2px solid #dee2e6;
        }
        
        .approval-stamp {
            display: inline-block;
            width: 200px;
            height: 200px;
            border: 8px solid #1e7e34;
            border-radius: 50%;
            background: linear-gradient(135deg, #28a745 0%, #20c997 50%, #17a2b8 100%);
            position: relative;
            margin: 25px auto;
            box-shadow: 0 10px 20px rgba(0,0,0,0.3), inset 0 2px 4px rgba(255,255,255,0.2);
        }
        
        .stamp-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: #ffffff;
            font-weight: bold;
            width: 100%;
        }
        
        .stamp-text {
            font-size: 20px;
            line-height: 1.2;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.8);
            margin-bottom: 12px;
            letter-spacing: 1px;
        }
        
        .stamp-date {
            font-size: 16px;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.8);
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        
        .approval-title {
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        .approval-text {
            font-size: 14px;
            color: #6c757d;
            margin-top: 25px;
            font-style: italic;
            line-height: 1.4;
        }
        
        .footer {
            margin-top: 35px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            border-top: 3px solid #3498db;
            padding-top: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            padding: 20px;
        }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(52, 152, 219, 0.08);
            font-weight: bold;
            z-index: -1;
            pointer-events: none;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        .highlight-box {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 2px solid #ffc107;
            border-radius: 10px;
            padding: 15px;
            margin: 15px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .highlight-box .highlight-title {
            font-weight: bold;
            color: #856404;
            font-size: 14px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .highlight-box .highlight-content {
            color: #856404;
            font-size: 13px;
            line-height: 1.4;
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
        <div class="section-content">
            <table class="info-table">
                <tr>
                    <th>Numéro de Référence</th>
                    <td><strong>{{ $maintenance->numero_reference }}</strong></td>
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
    </div>
    
    <!-- Informations du pneu -->
    <div class="section">
        <div class="section-title">INFORMATIONS DU PNEU</div>
        <div class="section-content">
            <table class="info-table">
                <tr>
                    <th>Numéro de Série</th>
                    <td><strong>{{ $pneu->numero_serie }}</strong></td>
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
                    <td><strong>{{ number_format($pneu->kilometrage) }} km</strong></td>
                </tr>
                <tr>
                    <th>Taux d'Usure</th>
                    <td><strong>{{ $pneu->taux_usure }}%</strong></td>
                </tr>
            </table>
        </div>
    </div>
    
    <!-- Informations du véhicule -->
    <div class="section">
        <div class="section-title">INFORMATIONS DU VÉHICULE</div>
        <div class="section-content">
            <table class="info-table">
                <tr>
                    <th>Immatriculation</th>
                    <td><strong>{{ $vehicule->immatriculation }}</strong></td>
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
    </div>
    
    <!-- Informations des utilisateurs -->
    <div class="section">
        <div class="section-title">INFORMATIONS DES UTILISATEURS</div>
        <div class="section-content">
            <table class="info-table">
                <tr>
                    <th>Mécanicien</th>
                    <td><strong>{{ $mecanicien->name ?? 'N/A' }}</strong> ({{ $mecanicien->role_name ?? 'N/A' }})</td>
                </tr>
                <tr>
                    <th>Déclarateur</th>
                    <td><strong>{{ $declarateur->name ?? 'N/A' }}</strong> ({{ $declarateur->role_name ?? 'N/A' }})</td>
                </tr>
                <tr>
                    <th>Direction</th>
                    <td><strong>{{ $direction->name ?? 'N/A' }}</strong> ({{ $direction->role_name ?? 'N/A' }})</td>
                </tr>
            </table>
        </div>
    </div>
    
    <!-- Historique des actions -->
    @if($maintenance->actions && count($maintenance->actions) > 0)
    <div class="section actions-section">
        <div class="section-title">HISTORIQUE DES ACTIONS</div>
        <div class="section-content">
            @foreach($maintenance->actions as $action)
            <div class="action-item">
                <div class="action-date">{{ $action['date'] }}</div>
                <div class="action-user">{{ $action['user'] }}</div>
                <div class="action-description">{{ $action['description'] }}</div>
            </div>
            @endforeach
        </div>
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
