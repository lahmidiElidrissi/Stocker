<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Commande #{{ $commande->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px; /* More readable font size */
            line-height: 1.4; /* Better line height for readability */
            margin: 0;
            padding: 15px; /* Increased padding */
            max-width: 100%;
        }
        .header {
            text-align: center;
            margin-bottom: 15px; /* Reduced margin */
        }
        .logo {
            max-width: 150px; /* Smaller logo */
            margin-bottom: 5px;
        }
        h1 {
            font-size: 22px; /* Larger heading */
            color: #333;
            margin: 5px 0;
        }
        .info-section {
            margin-bottom: 10px; /* Reduced margin */
        }
        .row {
            display: flex;
            margin-bottom: 10px;
        }
        .col {
            flex: 1;
        }
        .bordered {
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 5px; /* Reduced padding */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px; /* Increased cell padding */
        }
        th {
            background-color: #f8f8f8;
            text-align: left;
            font-size: 12px; /* Normal header text */
        }
        td {
            font-size: 12px; /* Normal cell text */
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .section-title {
            margin-top: 15px;
            font-size: 16px; /* Larger section title */
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }
        .footer {
            margin-top: 25px; /* Increased footer margin */
            text-align: center;
            font-size: 10px; /* More readable footer text */
        }
        .summary {
            float: right;
            width: 200px; /* Narrower summary */
            margin-top: 10px;
        }
        .notes {
            margin-top: 15px;
            padding: 8px;
            background-color: #f9f9f9;
            border-radius: 4px;
            font-size: 12px; /* Normal notes text */
        }
        /* Optimize for print */
        @media print {
            body {
                padding: 5px;
            }
            .page-break {
                page-break-before: always;
            }
            table.articles {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bon de Commande</h1>
        <p>Commande #{{ $commande->id }} - {{ \Carbon\Carbon::parse($commande->date)->format('d/m/Y') }}</p>
    </div>
    
    <table width="100%" style="border-collapse: collapse;margin-bottom: 10px">
        <tr>
            <td class="bordered" style="padding: 5px; width: 50%; vertical-align: top;">
                <strong>Informations Société :</strong><br>
                Khalid Electro<br>
                Carage alal Casablanca<br>
                +212690591681
            </td>
            <td class="bordered" style="padding: 5px; width: 50%; vertical-align: top;">
                <strong>Client :</strong><br>
                {{ $commande->client->Nom ?? 'N/A' }}<br>
                {{ $commande->client->Adresse ?? '' }}<br>
                {{ $commande->client->Telephone ?? '' }}{{ $commande->client->Email ? ', '.$commande->client->Email : '' }}
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
    <table class="articles">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="50%">Article</th>
                <th width="10%" class="text-center">Quantité</th>
                <th width="15%" class="text-right">Prix Unit.</th>
                <th width="20%" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($commande->articles) && count($commande->articles) > 0)
                @foreach($commande->articles as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->article->Nome ?? 'Article inconnu' }}</td>
                        <td class="text-center">{{ $item->Quantite }}</td>
                        <td class="text-right">{{ number_format($item->CustomPrix, 2) }}</td>
                        <td class="text-right">{{ number_format($item->Quantite * $item->CustomPrix, 2) }}</td>
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
                <th>Total HT</th>
                <td class="text-right">{{ number_format($commande->subtotal, 2) }} Dh</td>
            </tr>
            <tr>
                <th>TVA ({{ $commande->tax_rate }}%)</th>
                <td class="text-right">{{ number_format($commande->tax_amount, 2) }} Dh</td>
            </tr>
            <tr>
                <th>Total TTC</th>
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
        <p>Merci pour votre confiance! Ce document a été généré automatiquement le {{ date('d/m/Y H:i') }}.</p>
    </div>
</body>
</html>