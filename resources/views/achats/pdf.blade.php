<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Achat #{{ $achat->id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #333;
            line-height: 1.5;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .company-info {
            float: left;
            width: 60%;
        }
        .purchase-info {
            float: right;
            width: 40%;
            text-align: right;
        }
        .clear {
            clear: both;
        }
        .meta-section {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .supplier-info {
            float: left;
            width: 50%;
        }
        .payment-info {
            float: right;
            width: 50%;
            text-align: right;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-paid {
            background-color: #28a745;
            color: white;
        }
        .badge-partial {
            background-color: #17a2b8;
            color: white;
        }
        .badge-pending {
            background-color: #ffc107;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .text-danger {
            color: #dc3545;
        }
        .signature-area {
            margin-top: 40px;
            border-top: 1px dashed #ccc;
            padding-top: 20px;
        }
        .signature-box {
            float: right;
            width: 40%;
            text-align: right;
        }
        .notes-box {
            float: left;
            width: 60%;
        }
        .page-break {
            page-break-after: always;
        }
        .small-text {
            font-size: 10px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h2 style="margin: 0; color: #007bff;">Bon d'Achat #{{ $achat->id }}</h2>
                <p>Référence: {{ $achat->Referance ?? 'Non spécifiée' }}</p>
            </div>
            <div class="purchase-info">
                <h3 style="margin: 0;">
                    @if($achat->total <= $achat->paye)
                        <span class="badge badge-paid">Payé</span>
                    @elseif($achat->paye > 0)
                        <span class="badge badge-partial">Partiellement Payé</span>
                    @else
                        <span class="badge badge-pending">En attente</span>
                    @endif
                </h3>
                <p>Date: {{ \Carbon\Carbon::parse($achat->date)->format('d/m/Y') }}</p>
            </div>
            <div class="clear"></div>
        </div>
        
        <!-- Meta Information -->
        <div class="meta-section">
            <div class="supplier-info">
                <p><span class="label">Fournisseur:</span> {{ $achat->fournisseur->Nom ?? 'Non spécifié' }}</p>
                @if($achat->fournisseur)
                    <p><span class="label">Contact:</span> {{ $achat->fournisseur->Telephone ?? 'Non spécifié' }}</p>
                    <p><span class="label">Adresse:</span> {{ $achat->fournisseur->Adresse ?? 'Non spécifiée' }}</p>
                @endif
            </div>
            <div class="payment-info">
                <p><span class="label">Sous-total:</span> {{ number_format($achat->subtotal ?? 0, 2) }} €</p>
                <p><span class="label">TVA ({{ number_format($achat->tax_rate ?? 0, 2) }}%):</span> {{ number_format($achat->tax_amount ?? 0, 2) }} €</p>
                <p><span class="label">Total:</span> <strong>{{ number_format($achat->total, 2) }} €</strong></p>
                <p><span class="label">Montant payé:</span> {{ number_format($achat->paye, 2) }} €</p>
                <p><span class="label">Reste à payer:</span> 
                    <strong class="{{ $achat->du > 0 ? 'text-danger' : '' }}">
                        {{ number_format($achat->du, 2) }} €
                    </strong>
                </p>
            </div>
            <div class="clear"></div>
        </div>
        
        <!-- Articles Table -->
        <h3>Articles achetés</h3>
        <table>
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="15%">Code-barres</th>
                    <th width="30%">Article</th>
                    <th width="15%">Prix unitaire</th>
                    <th width="15%">Quantité</th>
                    <th width="20%">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($achat->articles as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->article->barcode ?? 'N/A' }}</td>
                        <td>
                            <strong>{{ $item->article->Nome }}</strong>
                            @if($item->article->Referance)
                                <br><span class="small-text">Réf: {{ $item->article->Referance }}</span>
                            @endif
                        </td>
                        <td>{{ number_format($item->prix, 2) }} €</td>
                        <td>{{ $item->Quantite }}</td>
                        <td>{{ number_format($item->prix * $item->Quantite, 2) }} €</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Aucun article trouvé pour cet achat.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="4" class="text-right">Total:</td>
                    <td>{{ $achat->articles->sum('Quantite') }}</td>
                    <td>{{ number_format($achat->articles->sum(function($item) { 
                        return $item->prix * $item->Quantite; 
                    }), 2) }} €</td>
                </tr>
            </tfoot>
        </table>
        
        <!-- Signature Area -->
        <div class="signature-area">
            <div class="notes-box">
                @if($achat->notes)
                    <h4>Notes</h4>
                    <p>{{ $achat->notes }}</p>
                @endif
            </div>
            <div class="signature-box">
                <p style="margin-bottom: 50px;">Signature:</p>
                <p>____________________________</p>
                <p>Date: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
            </div>
            <div class="clear"></div>
        </div>
        
        <!-- Footer -->
        <div style="margin-top: 50px; text-align: center;">
            <p class="small-text">Ce document a été généré automatiquement et ne nécessite pas de signature manuscrite.</p>
        </div>
    </div>
</body>
</html>