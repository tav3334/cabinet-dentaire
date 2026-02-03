<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour de votre rendez-vous</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border: 1px solid #dee2e6;
        }
        .appointment-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-label {
            font-weight: bold;
            width: 150px;
            color: #666;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 12px;
        }
        .badge-confirmed {
            display: inline-block;
            padding: 5px 15px;
            background: #198754;
            color: white;
            border-radius: 20px;
            font-weight: bold;
        }
        .badge-canceled {
            display: inline-block;
            padding: 5px 15px;
            background: #dc3545;
            color: white;
            border-radius: 20px;
            font-weight: bold;
        }
        .badge-pending {
            display: inline-block;
            padding: 5px 15px;
            background: #ffc107;
            color: #000;
            border-radius: 20px;
            font-weight: bold;
        }
        .status-message {
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .status-confirmed {
            background: #d1e7dd;
            color: #0f5132;
        }
        .status-canceled {
            background: #f8d7da;
            color: #842029;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Cabinet Dentaire</h1>
        <p>Mise à jour de votre rendez-vous</p>
    </div>

    <div class="content">
        <p>Bonjour <strong>{{ $appointment->name }}</strong>,</p>

        @if($newStatus == 'confirmed')
            <div class="status-message status-confirmed">
                <h2>Votre rendez-vous est confirmé !</h2>
            </div>
            <p>Nous sommes heureux de vous confirmer votre rendez-vous.</p>
        @elseif($newStatus == 'canceled')
            <div class="status-message status-canceled">
                <h2>Votre rendez-vous a été annulé</h2>
            </div>
            <p>Nous sommes désolés de vous informer que votre rendez-vous a été annulé. N'hésitez pas à nous contacter pour reprogrammer.</p>
        @else
            <p>Le statut de votre rendez-vous a été mis à jour.</p>
        @endif

        <div class="appointment-details">
            <div class="detail-row">
                <span class="detail-label">Date :</span>
                <span>{{ $appointment->appointment_date->format('d/m/Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Heure :</span>
                <span>{{ $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') : 'À confirmer' }}</span>
            </div>
            @if($appointment->service)
            <div class="detail-row">
                <span class="detail-label">Service :</span>
                <span>{{ $appointment->service->title }}</span>
            </div>
            @endif
            <div class="detail-row">
                <span class="detail-label">Statut :</span>
                <span class="badge-{{ $newStatus }}">
                    @if($newStatus == 'confirmed')
                        Confirmé
                    @elseif($newStatus == 'canceled')
                        Annulé
                    @else
                        En attente
                    @endif
                </span>
            </div>
        </div>

        @if($newStatus == 'confirmed')
            <p><strong>Rappel :</strong> Merci de vous présenter 10 minutes avant l'heure de votre rendez-vous.</p>
        @endif

        <p>Si vous avez des questions, n'hésitez pas à nous contacter au <strong>01 23 45 67 89</strong>.</p>

        <p>Cordialement,<br>
        <strong>L'équipe du Cabinet Dentaire</strong></p>
    </div>

    <div class="footer">
        <p>Cabinet Dentaire - 123 Rue de la Santé, 75000 Paris</p>
        <p>Tél: 01 23 45 67 89 | Email: contact@cabinet-dentaire.fr</p>
    </div>
</body>
</html>
