<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle demande de facture</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; color: #0a1628; line-height: 1.5;">
    <h2 style="margin: 0 0 16px;">Nouvelle demande de facture</h2>
    <p style="margin: 0 0 18px;">
        Reçue le {{ $submittedAt->format('d/m/Y à H:i') }}
    </p>

    <table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; width: 100%; max-width: 840px;">
        <tr><th align="left">Prénom</th><td>{{ $data['first_name'] }}</td></tr>
        <tr><th align="left">Nom</th><td>{{ $data['last_name'] }}</td></tr>
        <tr><th align="left">Email</th><td>{{ $data['email'] }}</td></tr>
        <tr><th align="left">Téléphone</th><td>{{ $data['phone'] }}</td></tr>
        <tr><th align="left">Entreprise</th><td>{{ $data['company'] ?? '—' }}</td></tr>
        <tr><th align="left">Ville</th><td>{{ $data['city'] ?? '—' }}</td></tr>
        <tr><th align="left">Pays</th><td>{{ $data['country'] ?? '—' }}</td></tr>
        <tr><th align="left">Contact préféré</th><td>{{ $data['preferred_contact'] }}</td></tr>
        <tr><th align="left">Sujet</th><td>{{ $data['service_subject'] }}</td></tr>
        <tr><th align="left">Plan d’intérêt</th><td>{{ $data['plan_interest'] ?? '—' }}</td></tr>
        <tr><th align="left">Budget</th><td>{{ $data['budget'] ?? '—' }}</td></tr>
        <tr><th align="left">Échéance</th><td>{{ $data['project_deadline'] ?? '—' }}</td></tr>
        <tr>
            <th align="left">Services sélectionnés</th>
            <td>
                <ul style="margin: 0; padding-left: 16px;">
                    @foreach($data['selected_services'] as $service)
                        <li>{{ $service }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        <tr>
            <th align="left">Détails du projet</th>
            <td>{!! nl2br(e($data['project_details'])) !!}</td>
        </tr>
        <tr>
            <th align="left">Médias joints</th>
            <td>
                @if(!empty($mediaFiles) && count($mediaFiles) > 0)
                    <ul style="margin: 0; padding-left: 16px;">
                        @foreach($mediaFiles as $file)
                            <li>
                                {{ $file['original_name'] ?? 'fichier' }}
                                @if(!empty($file['size']))
                                    ({{ number_format(((int) $file['size']) / 1024, 0, ',', ' ') }} Ko)
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    —
                @endif
            </td>
        </tr>
    </table>
</body>
</html>
