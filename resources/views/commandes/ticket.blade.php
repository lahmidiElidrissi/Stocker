<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Commande #{{ $commande->id }}</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 9pt;
            line-height: 1.1;
            margin: 0;
            padding: 0;
            width: 57mm; /* Popular standard receipt width - 57mm (2.25 inches) */
            max-width: 57mm;
        }
        .receipt {
            padding: 5mm;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 3mm;
        }
        .header h1 {
            font-size: 11pt;
            margin: 0;
        }
        .header p {
            margin: 2mm 0;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 2mm 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 1mm 0;
        }
        .item-name {
            width: 50%;
            font-size: 9pt;
        }
        .item-qty {
            width: 10%;
            text-align: center;
            font-size: 9pt;
        }
        .item-price, .item-total {
            width: 20%;
            text-align: right;
            font-size: 9pt;
        }
        .totals {
            text-align: right;
            margin: 2mm 0;
        }
        .total-line {
            display: flex;
            justify-content: space-between;
        }
        .grand-total {
            font-weight: bold;
            font-size: 10pt;
        }
        .payment-status {
            text-align: center;
            margin-top: 3mm;
            font-weight: bold;
        }
        .payment-due {
            color: #dc3545;
        }
        .payment-complete {
            color: #28a745;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                width: 100%;
                max-width: 80mm;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h1>BON COMMANDE</h1>
            <p><strong>Commande #{{ $commande->id }}</strong></p>
            <p>Ref: {{ $commande->reference ?: 'N/A' }}<br>
            Date: {{ \Carbon\Carbon::parse($commande->date)->format('d/m/Y') }}</p>
        </div>
        
        <div class="divider"></div>
        
        <p><strong>Client:</strong> {{ $commande->client ? $commande->client->Nom : 'N/A' }}</p>
        
        <div class="divider"></div>
        
        <table>
            <thead>
                <tr>
                    <th class="item-name">Article</th>
                    <th class="item-qty">Qté</th>
                    <th class="item-price">Prix</th>
                    <th class="item-total">Total</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($commande->articles) && count($commande->articles) > 0)
                    @foreach($commande->articles as $index => $item)
                        <tr>
                            <td class="item-name">{{ $item->article->Nome ?? 'Article inconnu' }}</td>
                            <td class="item-qty">{{ $item->Quantite }}</td>
                            <td class="item-price">{{ number_format($item->CustomPrix, 2) }}</td>
                            <td class="item-total">{{ number_format($item->Quantite * $item->CustomPrix, 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" style="text-align: center;">Aucun article dans cette commande</td>
                    </tr>
                @endif
            </tbody>
        </table>
        
        <div class="divider"></div>
        
        <div class="totals">
            <div class="total-line">
                <span>Total HT:</span>
                <span>{{ number_format($commande->subtotal, 2) }} Dh</span>
            </div>
            <div class="total-line">
                <span>TVA ({{ $commande->tax_rate }}%):</span>
                <span>{{ number_format($commande->tax_amount, 2) }} Dh</span>
            </div>
            <div class="total-line grand-total">
                <span>Total TTC:</span>
                <span>{{ number_format($commande->total, 2) }} Dh</span>
            </div>
            <div class="total-line">
                <span>Payé:</span>
                <span>{{ number_format($commande->paye, 2) }} Dh</span>
            </div>
            <div class="total-line grand-total">
                <span>Reste à payer:</span>
                <span>{{ number_format($commande->du, 2) }} Dh</span>
            </div>
        </div>
        
        <div class="divider"></div>
        
        @if($commande->notes)
            <p><strong>Notes:</strong> {{ $commande->notes }}</p>
            <div class="divider"></div>
        @endif
        
        <div class="payment-status">
            @if($commande->du > 0)
                <p class="payment-due">Il reste {{ number_format($commande->du, 2) }} Dh à payer</p>
            @else
                <p class="payment-complete">Commande entièrement réglée</p>
            @endif
        </div>
        
        <div class="footer">
            <p>Merci pour votre commande!</p>
        </div>
    </div>
</body>
</html>