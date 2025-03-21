<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Commande #{{ $commande->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 200px;
            margin-bottom: 10px;
        }
        h1 {
            font-size: 24px;
            color: #333;
            margin: 5px 0;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .row {
            display: flex;
            margin-bottom: 20px;
        }
        .col {
            flex: 1;
        }
        .bordered {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f8f8f8;
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .section-title {
            margin-top: 20px;
            font-size: 16px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
        }
        .summary {
            float: right;
            width: 250px;
            margin-top: 20px;
        }
        .notes {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bon de Commande</h1>
        <p>Commande #{{ $commande->id }} - {{ \Carbon\Carbon::parse($commande->date)->format('d/m/Y') }}</p>
    </div>
    
    <table width="100%" style="border-collapse: collapse;margin-bottom: 20px">
        <tr>
            <td class="bordered" style="padding: 10px; width: 50%; vertical-align: top;">
                <strong>Informations Société :</strong><br>
                Khalid Electro<br>
                Carage alal Casablanca<br>
                +212690591681<br>
            </td>
            <td class="bordered" style="padding: 10px; width: 50%; vertical-align: top;">
                <strong>Client :</strong><br>
                {{ $commande->client->Nom ?? 'N/A' }}<br>
                {{ $commande->client->Adresse ?? '' }}<br>
                {{ $commande->client->Telephone ?? '' }}<br>
                {{ $commande->client->Email ?? '' }}
            </td>
        </tr>
    </table>    

    <div class="info-section">
        <table>
            <tr>
                <th>N° Commande</th>
                <th>Référence</th>
                <th>Date</th>
            </tr>
            <tr>
                <td>{{ $commande->id }}</td>
                <td>{{ $commande->reference ?: 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($commande->date)->format('d/m/Y') }}</td>
            </tr>
        </table>
    </div>

    <h3 class="section-title">Articles</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Article</th>
                <th class="text-center">Quantité</th>
                <th class="text-right">Prix Unitaire</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($commande->articles) && count($commande->articles) > 0)
                @foreach($commande->articles as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->article->Nome ?? 'Article inconnu' }}</td>
                        <td class="text-center">{{ $item->Quantite }}</td>
                        <td class="text-right">{{ number_format($item->CustomPrix, 2) }} Dh</td>
                        <td class="text-right">{{ number_format($item->Quantite * $item->CustomPrix, 2) }} Dh</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">Aucun article dans cette commande</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="summary">
        <table>
            <tr>
                <th>Sous-total</th>
                <td class="text-right">{{ number_format($commande->subtotal, 2) }} Dh</td>
            </tr>
            <tr>
                <th>TVA ({{ $commande->tax_rate }}%)</th>
                <td class="text-right">{{ number_format($commande->tax_amount, 2) }} Dh</td>
            </tr>
            <tr>
                <th>Total</th>
                <td class="text-right">{{ number_format($commande->total, 2) }} Dh</td>
            </tr>
            <tr>
                <th>Payé</th>
                <td class="text-right">{{ number_format($commande->paye, 2) }} Dh</td>
            </tr>
            <tr>
                <th>Reste à payer</th>
                <td class="text-right">{{ number_format($commande->du, 2) }} Dh</td>
            </tr>
        </table>
    </div>

    <div style="clear:both;"></div>

    @if($commande->notes)
        <div class="notes">
            <strong>Notes:</strong>
            <p>{{ $commande->notes }}</p>
        </div>
    @endif

    <div class="footer">
        <p>Merci pour votre confiance!</p>
        <p>Ce document a été généré automatiquement le {{ date('d/m/Y H:i') }}.</p>
    </div>
</body>
</html>