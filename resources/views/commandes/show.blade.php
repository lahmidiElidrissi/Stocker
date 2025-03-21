@extends('master')

@section('partialContent')
<div class="content-wrapper" style="background: #F4F5F778;">
    <div class="row justify-content-center">
        <div class="card col-md-10 col-sm-12">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="mdi mdi-eye"></i> Détails de la Commande #{{ $commande->id }}
                    <div class="float-end">
                        <a href="{{ route('commandes.pdf', $commande->id) }}" class="btn btn-success me-2" target="_blank">
                            <i class="mdi mdi-file-pdf"></i> PDF
                        </a>
                        <a href="{{ route('commandes.edit', $commande->id) }}" class="btn btn-primary me-2">
                            <i class="mdi mdi-pencil"></i> Modifier
                        </a>
                        <a href="{{ route('commandes.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> Retour
                        </a>
                    </div>
                </h4>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Informations Générales</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
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
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Résumé Financier</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%" class="bg-light">Sous-total</th>
                                        <td class="text-end">{{ number_format($commande->subtotal, 2) }} Dh</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">TVA ({{ $commande->tax_rate }}%)</th>
                                        <td class="text-end">{{ number_format($commande->tax_amount, 2) }} Dh</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light fw-bold">Total</th>
                                        <td class="text-end fw-bold">{{ number_format($commande->total, 2) }} Dh</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Montant Payé</th>
                                        <td class="text-end">{{ number_format($commande->paye, 2) }} Dh</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-danger fw-bold">Reste à Payer</th>
                                        <td class="text-end text-danger fw-bold">{{ number_format($commande->du, 2) }} Dh</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Articles de la Commande</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
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
                    </div>
                </div>
                
                @if($commande->notes)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Notes</h5>
                                </div>
                                <div class="card-body">
                                    <p>{{ $commande->notes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection