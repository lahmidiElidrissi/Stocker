@extends('master')

@section('partialContent')

<style>
    .info-label {
        font-weight: bold;
        color: #555;
    }
    .badge-pending {
        background-color: #ffc107;
        color: #212529;
    }
    .badge-paid {
        background-color: #28a745;
        color: white;
    }
    .badge-partial {
        background-color: #17a2b8;
        color: white;
    }
    .total-row {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    .signature-area {
        border-top: 1px dashed #ccc;
        margin-top: 40px;
        padding-top: 20px;
    }
    .purchase-header {
        border-bottom: 2px solid #007bff;
        margin-bottom: 20px;
        padding-bottom: 10px;
    }
    .purchase-meta {
        background-color: #f8f9fa;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .articles-section {
        margin-top: 30px;
    }
    @media print {
        .btn {
            display: none;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>

<div class="content-wrapper" style="background: #F4F5F778;">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>Détails de l'Achat</h2>
                        <div>
                            <a href="{{ route('achats.pdf', $achat->id) }}" class="btn btn-danger mr-2" target="_blank">
                                <i class="fa fa-file-pdf"></i> Générer PDF
                            </a>
                            <a href="{{ route('achats.edit', $achat->id) }}" class="btn btn-primary mr-2">
                                <i class="fa fa-edit"></i> Modifier
                            </a>
                            <a href="{{ route('achats.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Retour
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Purchase Header -->
                    <div class="purchase-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="mb-1">Bon d'Achat #{{ $achat->id }}</h3>
                                <p class="text-muted">Date: {{ $achat->date ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <h4>
                                    @if($achat->total <= $achat->paye)
                                        <span class="badge badge-paid">Payé</span>
                                    @elseif($achat->paye > 0)
                                        <span class="badge badge-partial">Partiellement Payé</span>
                                    @else
                                        <span class="badge badge-pending">En attente</span>
                                    @endif
                                </h4>
                            </div>
                        </div>
                    </div>

                    <!-- Purchase Meta Information -->
                    <div class="purchase-meta">
                        <div class="row">
                            <div class="col-md-6">
                                @if($achat->fournisseur)
                                <div class="mb-3">
                                    <span class="info-label">Nom de fournisseur:</span>
                                    <span>{{ $achat->fournisseur->Nom ?? 'Non spécifié' }}</span>
                                </div>
                                <div class="mb-3">
                                    <span class="info-label">Contact:</span>
                                    <span>{{ $achat->fournisseur->telephone ?? 'Non spécifié' }}</span>
                                </div>
                                <div class="mb-3">
                                    <span class="info-label">Email:</span>
                                    <span>{{ $achat->fournisseur->email ?? 'Non spécifiée' }}</span>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <span class="info-label">TVA ({{ number_format($achat->tax_rate ?? 0, 2) }}%):</span>
                                    <span>{{ number_format($achat->tax_amount ?? 0, 2) }} Dh</span>
                                </div>
                                <div class="mb-3">
                                    <span class="info-label">Total HT:</span>
                                    <span>{{ number_format($achat->subtotal ?? 0, 2) }} Dh</span>
                                </div>
                                <div class="mb-3">
                                    <span class="info-label">Total TTC:</span>
                                    <span class="font-weight-bold">{{ number_format($achat->total, 2) }} Dh</span>
                                </div>
                                <div class="mb-3">
                                    <span class="info-label">Montant payé:</span>
                                    <span>{{ number_format($achat->paye, 2) }} Dh</span>
                                </div>
                                <div class="mb-3">
                                    <span class="info-label">Reste à payer:</span>
                                    <span class="font-weight-bold {{ $achat->du > 0 ? 'text-danger' : '' }}">
                                        {{ number_format($achat->du, 2) }} Dh
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Articles Section -->
                    <div class="articles-section">
                        <h4 class="mb-3">Articles achetés</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="bg-light">
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
                                            <td>{{ $item->article->Nome }}</td>
                                            <td>{{ number_format($item->Prix, 2) }} Dh</td>
                                            <td>{{ $item->Quantite }}</td>
                                            <td>{{ number_format($item->Prix * $item->Quantite, 2) }} Dh</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-3">Aucun article trouvé pour cet achat.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr class="total-row">
                                        <td colspan="4" class="text-right">Total:</td>
                                        <td>{{ $achat->articles->sum('Quantite') }}</td>
                                        <td>{{ number_format($achat->articles->sum(function($item) { 
                                            return $item->Prix * $item->Quantite; 
                                        }), 2) }} Dh</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Notes and Signature Section -->
                    <div class="signature-area">
                        <div class="row">
                            <div class="col-md-6">
                                @if($achat->notes)
                                    <h5>Notes</h5>
                                    <p>{{ $achat->notes }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop