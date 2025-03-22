@extends('master')

@section('partialContent')

<!-- Responsive CSS Additions -->
<style>
    @media (max-width: 767.98px) {
        .table-responsive {
            overflow-x: auto;
        }
        
        .card-title {
            font-size: 1.25rem;
        }
        
        .btn {
            padding: 0.375rem 0.5rem;
        }
        
        .card-header h5 {
            font-size: 1rem;
        }
    }
    
    @media (max-width: 575.98px) {
        .card-body {
            padding: 0.75rem;
        }
        
        .table td, .table th {
            padding: 0.5rem;
        }
    }
</style>

<div class="content-wrapper">
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12">
                <!-- Header with Responsive Actions -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-md-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-3 mb-md-0">
                                <i class="mdi mdi-eye"></i> Détails de la Commande #{{ $commande->id }}
                            </h4>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('commandes.pdf.view', $commande->id) }}" class="btn btn-info" target="_blank">
                                    <i class="mdi mdi-eye"></i> <span class="d-none d-sm-inline">Voir PDF</span>
                                </a>
                                <a href="{{ route('commandes.pdf.download', $commande->id) }}" class="btn btn-success">
                                    <i class="mdi mdi-download"></i> <span class="d-none d-sm-inline">Télécharger PDF</span>
                                </a>
                                <a href="{{ route('commandes.edit', $commande->id) }}" class="btn btn-primary">
                                    <i class="mdi mdi-pencil"></i> <span class="d-none d-sm-inline">Modifier</span>
                                </a>
                                <a href="{{ route('commandes.index') }}" class="btn btn-secondary">
                                    <i class="mdi mdi-arrow-left"></i> <span class="d-none d-sm-inline">Retour</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Information Section -->
                <div class="row g-4 mb-4">
                    <!-- General Information Card -->
                    <div class="col-12 col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0">Informations Générales</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                            <tr>
                                                <th width="40%" class="bg-light">Référence</th>
                                                <td>{{ $commande->reference ?: 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Date</th>
                                                <td>{{ \Carbon\Carbon::parse($commande->date)->format('d/m/Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Client</th>
                                                <td>
                                                    @if($commande->client)
                                                        {{ $commande->client->Nom }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Financial Summary Card -->
                    <div class="col-12 col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0">Détails de Commande</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                            <tr>
                                                <th width="40%" class="bg-light">Total HT</th>
                                                <td class="text-end">{{ number_format($commande->subtotal, 2) }} Dh</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">TVA ({{ $commande->tax_rate }}%)</th>
                                                <td class="text-end">{{ number_format($commande->tax_amount, 2) }} Dh</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light fw-bold">Total TTC</th>
                                                <td class="text-end fw-bold">{{ number_format($commande->total, 2) }} Dh</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Montant Payé</th>
                                                <td class="text-end">{{ number_format($commande->paye, 2) }} Dh</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light text-danger fw-bold">Credit</th>
                                                <td class="text-end text-danger fw-bold">{{ number_format($commande->du, 2) }} Dh</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order Items Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Articles de la Commande</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="bg-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Article</th>
                                        <th class="text-center">Quantité</th>
                                        <th class="text-end">Prix Unitaire</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($commande->articles) && count($commande->articles) > 0)
                                        @foreach($commande->articles as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->article->Nome ?? 'Article inconnu' }}</td>
                                                <td class="text-center">{{ $item->Quantite }}</td>
                                                <td class="text-end">{{ number_format($item->CustomPrix, 2) }} Dh</td>
                                                <td class="text-end">{{ number_format($item->Quantite * $item->CustomPrix, 2) }} Dh</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">Aucun article dans cette commande</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <td colspan="4" class="text-end fw-bold">Total HT :</td>
                                        <td class="text-end fw-bold">{{ number_format($commande->subtotal, 2) }} Dh</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end">TVA ({{ $commande->tax_rate }}%):</td>
                                        <td class="text-end">{{ number_format($commande->tax_amount, 2) }} Dh</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end fw-bold">Total TTC :</td>
                                        <td class="text-end fw-bold">{{ number_format($commande->total, 2) }} Dh</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Notes Section (if notes exist) -->
                @if($commande->notes)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Notes</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $commande->notes }}</p>
                        </div>
                    </div>
                @endif
                
                <!-- Payment Status -->
                @if($commande->du > 0)
                    <div class="alert alert-warning">
                        <i class="mdi mdi-alert-circle me-2"></i>
                        Il reste <strong>{{ number_format($commande->du, 2) }} Dh</strong> à payer sur cette commande.
                    </div>
                @else
                    <div class="alert alert-success">
                        <i class="mdi mdi-check-circle me-2"></i>
                        Cette commande a été entièrement réglée.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection