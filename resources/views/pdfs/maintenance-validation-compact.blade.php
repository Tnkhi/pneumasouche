<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Document de Validation de Maintenance</title>
    <style>
        body {
            margin: 0;
            padding: 10px;
            background-color: #ffffff;
            color: #333;
            line-height: 1.2;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 8px;
        }
        
        .company-info {
            flex: 1;
        }
        
        .company-logos {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 5px;
        }
        
        .logo {
            max-height: 30px;
            max-width: 60px;
            object-fit: contain;
        }
        
        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin: 2px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .company-subtitle {
            font-size: 10px;
            color: #7f8c8d;
            font-style: italic;
        }
        
        .document-info {
            text-align: right;
            flex: 1;
        }
        
        .document-title {
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .document-details {
            font-size: 10px;
            color: #666;
            line-height: 1.2;
        }
        
        .content-grid {
            display: flex;
            gap: 15px;
            margin-bottom: 12px;
        }
        
        .left-column {
            flex: 1;
        }
        
        .right-column {
            flex: 1;
        }
        
        .info-section {
            margin-bottom: 10px;
        }
        
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #2c3e50;
            background-color: #f8f9fa;
            padding: 5px 8px;
            margin-bottom: 5px;
            border-left: 3px solid #3498db;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }
        
        .info-table th {
            background-color: #34495e;
            color: white;
            padding: 4px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 8px;
            text-transform: uppercase;
        }
        
        .info-table td {
            padding: 4px 6px;
            border: 1px solid #dee2e6;
            background-color: #ffffff;
        }
        
        .info-table tr:nth-child(even) td {
            background-color: #f8f9fa;
        }
        
        .status-badge {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            padding: 2px 6px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 8px;
            text-transform: uppercase;
            border: 1px solid #28a745;
            display: inline-block;
        }
        
        .approval-section {
            text-align: center;
            margin-top: 10px;
            padding: 12px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            border: 2px solid #dee2e6;
        }
        
        .approval-title {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .approval-stamp {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 120px;
            height: 120px;
            border: 4px solid #dc3545;
            border-radius: 50%;
            background: transparent;
            position: relative;
            margin: 5px auto;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            text-align: center;
        }
        
        .approval-stamp::before {
            content: '';
            position: absolute;
            top: 8px;
            left: 8px;
            right: 8px;
            bottom: 8px;
            border: 2px solid #dc3545;
            border-radius: 50%;
            opacity: 0.7;
        }
        
        .approval-stamp::after {
            content: '';
            position: absolute;
            top: 16px;
            left: 16px;
            right: 16px;
            bottom: 16px;
            border: 1px dashed #dc3545;
            border-radius: 50%;
            opacity: 0.5;
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
            font-size: 9px;
            line-height: 1.0;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
            margin-bottom: 2px;
        }
        
        .stamp-date {
            font-size: 7px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
            font-weight: bold;
        }
        
        .approval-text {
            font-size: 8px;
            color: #6c757d;
            margin-top: 5px;
            font-style: italic;
        }
        
        .footer {
            margin-top: 8px;
            text-align: center;
            font-size: 7px;
            color: #6c757d;
            border-top: 1px solid #3498db;
            padding-top: 5px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 3px;
            padding: 5px;
        }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 60px;
            color: rgba(52, 152, 219, 0.05);
            font-weight: bold;
            z-index: -1;
            pointer-events: none;
        }
        
        .highlight-box {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 1px solid #ffc107;
            border-radius: 3px;
            padding: 4px;
            margin: 3px 0;
            font-size: 8px;
        }
        
        .highlight-title {
            font-weight: bold;
            color: #856404;
            margin-bottom: 2px;
            text-transform: uppercase;
            font-size: 7px;
        }
        
        .highlight-content {
            color: #856404;
            line-height: 1.2;
        }
    </style>
</head>
<body>
    <div class="watermark">APPROUVÉ</div>
    
    <!-- En-tête avec logos et informations -->
    <div class="header">
        <div class="company-info">
            <div class="company-logos">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('8Ptransit.png'))) }}" alt="8P Transit" class="logo">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('Quifeurou.png'))) }}" alt="Quifeurou" class="logo">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('Sesa SA.png'))) }}" alt="Sesa SA" class="logo">
            </div>
            <div class="company-name">PNEUMA-SOUCHE</div>
            <div class="company-subtitle">Système de Gestion Pneumatique</div>
        </div>
        
        <div class="document-info">
            <div class="document-title">VALIDATION</div>
            <div class="document-details">
                <strong>Référence:</strong> {{ $maintenance->numero_reference }}<br>
                <strong>Version:</strong> 1.0<br>
                <strong>Date de validation:</strong> {{ now()->format('d/m/Y') }}<br>
                <strong>Statut:</strong> <span class="status-badge">{{ strtoupper($maintenance->statut) }}</span>
            </div>
        </div>
    </div>
    
    <!-- Contenu principal en deux colonnes -->
    <div class="content-grid">
        <!-- Colonne gauche -->
        <div class="left-column">
            <!-- Informations de la maintenance -->
            <div class="info-section">
                <div class="section-title">Informations de la Maintenance</div>
                <table class="info-table">
                    <tr>
                        <th>Référence</th>
                        <td><strong>{{ $maintenance->numero_reference }}</strong></td>
                    </tr>
                    <tr>
                        <th>Date de déclaration</th>
                        <td>{{ $maintenance->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Motif</th>
                        <td>{{ $maintenance->motif }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $maintenance->description_probleme }}</td>
                    </tr>
                </table>
            </div>
            
            <!-- Informations du pneu -->
            <div class="info-section">
                <div class="section-title">Informations du Pneu</div>
                <table class="info-table">
                    <tr>
                        <th>Numéro de série</th>
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
                        <th>Kilométrage</th>
                        <td><strong>{{ number_format($pneu->kilometrage) }} km</strong></td>
                    </tr>
                    <tr>
                        <th>Taux d'usure</th>
                        <td><strong>{{ $pneu->taux_usure }}%</strong></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- Colonne droite -->
        <div class="right-column">
            <!-- Informations du véhicule -->
            <div class="info-section">
                <div class="section-title">Informations du Véhicule</div>
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
            
            <!-- Informations des utilisateurs -->
            <div class="info-section">
                <div class="section-title">Personnel Impliqué</div>
                <table class="info-table">
                    <tr>
                        <th>Mécanicien</th>
                        <td><strong>{{ $mecanicien->name ?? 'N/A' }}</strong><br>
                            <small>{{ $mecanicien->role_name ?? 'N/A' }}</small></td>
                    </tr>
                    <tr>
                        <th>Déclarateur</th>
                        <td><strong>{{ $declarateur->name ?? 'N/A' }}</strong><br>
                            <small>{{ $declarateur->role_name ?? 'N/A' }}</small></td>
                    </tr>
                    <tr>
                        <th>Direction</th>
                        <td><strong>{{ $direction->name ?? 'N/A' }}</strong><br>
                            <small>{{ $direction->role_name ?? 'N/A' }}</small></td>
                    </tr>
                </table>
            </div>
            
            <!-- Historique des actions -->
            @if($maintenance->actions && count($maintenance->actions) > 0)
            <div class="info-section">
                <div class="section-title">Historique des Actions</div>
                @foreach($maintenance->actions as $action)
                <div class="highlight-box">
                    <div class="highlight-title">{{ $action['date'] }}</div>
                    <div class="highlight-content">
                        <strong>{{ $action['user'] }}</strong><br>
                        {{ $action['description'] }}
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    
    <!-- Section d'approbation -->
    <div class="approval-section">
        <div class="approval-title">Approbation de la Direction</div>
        
        <div class="approval-stamp">
            <!-- Texte central -->
            <div class="stamp-text" style="color: #dc3545; font-weight: bold; font-size: 14px; line-height: 1.2; z-index: 10; position: relative;">
                APPROUVÉE
            </div>
            <div class="stamp-date" style="color: #dc3545; font-size: 10px; margin-top: 3px; z-index: 10; position: relative;">
                {{ now()->format('d/m/Y') }}
            </div>
            
            <!-- Texte répété autour du cercle -->
            <div class="stamp-outer-text" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border-radius: 50%; overflow: hidden;">
                <div style="position: absolute; top: 5px; left: 50%; transform: translateX(-50%); color: #dc3545; font-weight: bold; font-size: 8px; text-align: center;">APPROUVÉE</div>
                <div style="position: absolute; right: 5px; top: 50%; transform: translateY(-50%) rotate(90deg); color: #dc3545; font-weight: bold; font-size: 8px;">APPROUVÉE</div>
                <div style="position: absolute; bottom: 5px; left: 50%; transform: translateX(-50%) rotate(180deg); color: #dc3545; font-weight: bold; font-size: 8px; text-align: center;">APPROUVÉE</div>
                <div style="position: absolute; left: 5px; top: 50%; transform: translateY(-50%) rotate(-90deg); color: #dc3545; font-weight: bold; font-size: 8px;">APPROUVÉE</div>
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
        Document généré automatiquement le {{ now()->format('d/m/Y H:i') }} | Référence: {{ $maintenance->numero_reference }}
    </div>
</body>
</html>
