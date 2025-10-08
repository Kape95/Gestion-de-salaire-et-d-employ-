<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin de Paie - {{ $payslip['employer']->prenom }} {{ $payslip['employer']->nom }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: white;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .info-section {
            margin-bottom: 30px;
        }
        .info-section h3 {
            background: #f5f5f5;
            padding: 10px;
            margin: 0 0 15px 0;
            font-size: 16px;
            border-left: 4px solid #333;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            color: #666;
        }
        .info-value {
            font-weight: normal;
        }
        .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .salary-table th,
        .salary-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .salary-table th {
            background: #f5f5f5;
            font-weight: bold;
        }
        .salary-table .total-row {
            background: #f0f0f0;
            font-weight: bold;
        }
        .signature-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 40px;
        }
        .signature-box {
            text-align: center;
            border-top: 1px solid #333;
            padding-top: 20px;
        }
        .footer {
            margin-top: 30px;
            padding: 15px;
            background: #f9f9f9;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BULLETIN DE PAIE</h1>
        <p>Période : {{ $payslip['periode'] }}</p>
        <p>Généré le : {{ $payslip['date_generation'] }}</p>
    </div>

    <div class="info-grid">
        <div class="info-section">
            <h3>Informations Employé</h3>
            <div class="info-item">
                <span class="info-label">Nom et Prénom:</span>
                <span class="info-value">{{ $payslip['employer']->prenom }} {{ $payslip['employer']->nom }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Matricule:</span>
                <span class="info-value">{{ $payslip['employer']->id }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Département:</span>
                <span class="info-value">{{ $payslip['employer']->departement->name ?? 'Non assigné' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Poste:</span>
                <span class="info-value">{{ $payslip['employer']->poste ?? 'Non défini' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Date d'embauche:</span>
                <span class="info-value">{{ $payslip['employer']->date_embauche ? \Carbon\Carbon::parse($payslip['employer']->date_embauche)->format('d/m/Y') : 'Non définie' }}</span>
            </div>
        </div>

        <div class="info-section">
            <h3>Informations de Paie</h3>
            <div class="info-item">
                <span class="info-label">Période:</span>
                <span class="info-value">{{ $payslip['periode'] }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Jours travaillés:</span>
                <span class="info-value">{{ $payslip['jours_travail'] }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Salaire journalier:</span>
                <span class="info-value">{{ number_format($payslip['employer']->montant_journalier, 2) }} XOF</span>
            </div>
            <div class="info-item">
                <span class="info-label">Salaire brut:</span>
                <span class="info-value">{{ number_format($payslip['salaire_brut'], 2) }} XOF</span>
            </div>
        </div>
    </div>

    <div class="info-section">
        <h3>Détail du Salaire</h3>
        <table class="salary-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th style="text-align: right;">Montant</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Salaire de base ({{ $payslip['jours_travail'] }} jours)</td>
                    <td style="text-align: right;">{{ number_format($payslip['salaire_brut'], 2) }} XOF</td>
                </tr>
                <tr>
                    <td>Charges sociales (CNSS, Impôts) - 10%</td>
                    <td style="text-align: right; color: #d32f2f;">-{{ number_format($payslip['charges'], 2) }} XOF</td>
                </tr>
                <tr class="total-row">
                    <td><strong>SALAIRE NET À PAYER</strong></td>
                    <td style="text-align: right; color: #2e7d32; font-size: 16px;"><strong>{{ number_format($payslip['salaire_net'], 2) }} XOF</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p><strong>Signature de l'employé</strong></p>
        </div>
        <div class="signature-box">
            <p><strong>Signature de l'employeur</strong></p>
        </div>
    </div>

    <div class="footer">
        <p>Ce bulletin de paie est généré automatiquement par le système de gestion des salaires.</p>
        <p>Pour toute question, veuillez contacter le service des ressources humaines.</p>
    </div>
</body>
</html>
