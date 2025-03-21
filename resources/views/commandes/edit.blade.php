@extends('master')

@section('partialContent')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Overall theming */
        .content-wrapper {
            background-color: #f8f9fc !important;
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 20px;
        }

        .card-header {
            background: linear-gradient(40deg, #4e73df, #224abe);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.5rem;
            border: none;
        }

        .card-body {
            padding: 1.5rem;
        }

        .btn-primary {
            background: linear-gradient(40deg, #4e73df, #224abe);
            border: none;
            box-shadow: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.2);
        }

        .btn-secondary {
            background: linear-gradient(40deg, #858796, #6e707e);
            border: none;
        }

        .btn-danger {
            background: linear-gradient(40deg, #e74a3b, #be392e);
            border: none;
        }

        .btn-success {
            background: linear-gradient(40deg, #1cc88a, #169a6b);
            border: none;
        }

        /* Form styling */
        label {
            font-weight: 500;
            color: #5a5c69;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d3e2;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }

        .text-danger {
            color: #e74a3b !important;
        }

        /* Table styling */
        .table {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .table thead th {
            background-color: #f8f9fc;
            color: #5a5c69;
            font-weight: 700;
            border-bottom: 2px solid #e3e6f0;
            padding: 0.75rem 1rem;
        }

        .table tbody td {
            vertical-align: middle;
            padding: 0.75rem 1rem;
            border-color: #e3e6f0;
        }

        /* Total section styling */
        .total-section {
            background-color: #f8f9fc;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .total-section .form-control {
            font-weight: bold;
            text-align: right;
            background-color: #fff;
        }

        .total-section .text-danger {
            font-weight: bold;
        }

        /* Select2 styling */
        .select2-container--default .select2-selection--single {
            height: 48px;
            padding: 0.5rem 1rem;
            border: 1px solid #d1d3e2;
            border-radius: 8px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
            width: 30px;
        }

        .select2-container--open .select2-dropdown {
            border-color: #4e73df;
            box-shadow: 0 0.5rem 1.5rem 0 rgba(58, 59, 69, 0.3);
            border-radius: 8px;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #4e73df;
        }

        .select2-container--open {
            z-index: 1060 !important;
        }

        /* Article section styling */
        .article-search-section {
            background-color: #f8f9fc;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        /* Modal styling */
        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0.5rem 1.5rem 0 rgba(58, 59, 69, 0.3);
        }

        .modal-header {
            background: linear-gradient(40deg, #4e73df, #224abe);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            border: none;
        }

        .modal-header .close {
            color: white;
        }

        .preview-image {
            max-width: 120px;
            max-height: 120px;
            margin-top: 10px;
            border-radius: 8px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        /* Improved buttons */
        .btn {
            border-radius: 8px;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
        }

        /* Icons */
        .mdi {
            margin-right: 0.25rem;
        }
    </style>

    <div class="content-wrapper">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="m-0 font-weight-bold">
                                    <i class="mdi mdi-cart-outline"></i> Modifier la Commande
                                </h2>
                                <a href="{{ route('commandes.index') }}" class="btn btn-light">
                                    <i class="mdi mdi-arrow-left"></i> Retour
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('commandes.update', $commande->id) }}" id="commande-form">
                                @csrf
                                @method('PUT')
                                <div class="row mb-4">
                                    <div class="col-md-8">
                                        <!-- Article Search Section -->
                                        <div class="article-search-section mb-4">
                                            <h4 class="mb-3">
                                                <i class="mdi mdi-basket"></i> Ajouter des Articles
                                            </h4>

                                            <div class="row g-3" style="align-items: center;">
                                                <div class="col-md-9">
                                                    <div class="form-group mb-0">
                                                        <select class="form-control select2-articles" id="article_select">
                                                            <option value="">Rechercher un article par nom ou
                                                                code-barres</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="button" class="btn btn-primary w-100"
                                                        data-bs-toggle="modal" data-bs-target="#newArticleModal">
                                                        <i class="mdi mdi-plus-circle"></i> Nouvel Article
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Articles Table Section -->
                                        <div class="card mb-4">
                                            <div class="card-body">
                                                <h4 class="card-title mb-3">
                                                    <i class="mdi mdi-format-list-bulleted"></i> Articles de la Commande
                                                </h4>

                                                <div class="table-responsive">
                                                    <table class="table table-hover" id="articles-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Code-barres</th>
                                                                <th>Article</th>
                                                                <th>Prix Unitaire</th>
                                                                <th>Quantité</th>
                                                                <th>Total</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- JS will add rows here -->
                                                            <tr id="no-articles-row"
                                                                style="{{ count($commandeArticles) > 0 ? 'display: none;' : '' }}">
                                                                <td colspan="6" class="text-center py-4 text-muted">
                                                                    <i class="mdi mdi-information-outline"
                                                                        style="font-size: 1.5rem;"></i>
                                                                    <p>Aucun article ajouté. Utilisez la recherche ci-dessus
                                                                        pour ajouter des articles.</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- Hidden inputs to store article data -->
                                                <div id="article_inputs_container"></div>
                                            </div>
                                        </div>


                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title mb-4">Informations de la Commande</h4>

                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="date">
                                                                <i class="mdi mdi-calendar"></i> Date <span
                                                                    class="text-danger">*</span>
                                                            </label>
                                                            <input type="date"
                                                                class="form-control @error('date') is-invalid @enderror"
                                                                id="date" name="date"
                                                                value="{{ old('date', $commande->date) }}" required>
                                                            @error('date')
                                                                <span class="invalid-feedback"
                                                                    role="alert">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="reference">
                                                                <i class="mdi mdi-pound"></i> Référence
                                                            </label>
                                                            <input type="text"
                                                                class="form-control @error('reference') is-invalid @enderror"
                                                                id="reference" name="reference"
                                                                value="{{ old('reference', $commande->reference) }}"
                                                                readonly>
                                                            @error('reference')
                                                                <span class="invalid-feedback"
                                                                    role="alert">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="client_id">
                                                        <i class="mdi mdi-account"></i> Client <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <select
                                                            class="form-control select2 @error('client_id') is-invalid @enderror"
                                                            id="client_id" name="client_id" required>
                                                            <option value="">Sélectionner un client</option>
                                                            @foreach ($clients as $client)
                                                                <option value="{{ $client->id }}"
                                                                    {{ old('client_id', $commande->client_id) == $client->id ? 'selected' : '' }}>
                                                                    {{ $client->Nom }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('client_id')
                                                        <span class="invalid-feedback"
                                                            role="alert">{{ $message }}</span>
                                                    @enderror
                                                    <button type="button" class="btn btn-primary mt-3"
                                                        data-bs-toggle="modal" data-bs-target="#newClientModal">
                                                        <i class="mdi mdi-account-plus"></i> Ajouter un client
                                                    </button>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="notes">
                                                        <i class="mdi mdi-note-text"></i> Notes
                                                    </label>
                                                    <textarea class="form-control" rows="3" id="notes" name="notes" rows="3"
                                                        style="height: auto !important" placeholder="Informations supplémentaires sur la commande...">{{ old('notes', $commande->notes) }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <div class="card total-section">
                                            <div class="card-body">
                                                <h4 class="card-title mb-4">Détails de Commande</h4>

                                                <div class="form-group row mb-2">
                                                    <label for="subtotal" class="col-sm-6 col-form-label">Total
                                                        HT:</label>
                                                    <div class="col-sm-6">
                                                        <input type="number" step="0.01" class="form-control"
                                                            id="subtotal" name="subtotal"
                                                            value="{{ old('subtotal', $commande->subtotal) }}" readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-2">
                                                    <label for="total" class="col-sm-6 col-form-label fw-bold">Total
                                                        TTC:</label>
                                                    <div class="col-sm-6">
                                                        <input type="number" step="0.01" class="form-control fw-bold"
                                                            id="total" name="total"
                                                            value="{{ old('total', $commande->total) }}" readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-2">
                                                    <label for="paye" class="col-sm-6 col-form-label">Montant
                                                        Payé:</label>
                                                    <div class="col-sm-6">
                                                        <input type="number" step="0.01" class="form-control"
                                                            id="paye" name="paye"
                                                            value="{{ old('paye', $commande->paye) }}"
                                                            onchange="updateDueAmount()">
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-0">
                                                    <label for="du"
                                                        class="col-sm-6 col-form-label text-danger fw-bold">Credit:</label>
                                                    <div class="col-sm-6">
                                                        <input type="number" step="0.01"
                                                            class="form-control text-danger fw-bold" id="du"
                                                            name="du" value="{{ old('du', $commande->du) }}"
                                                            readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-3 mt-2">
                                                    <div class="col-sm-12">
                                                        <button type="button" class="btn btn-success w-100" id="mark-as-paid-btn" onclick="markAsPaid()">
                                                            <i class="mdi mdi-check-circle"></i> Marquer comme Payé
                                                        </button>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="form-group row mb-2">
                                                    <label for="tax_rate" class="col-sm-6 col-form-label">TVA (%):</label>
                                                    <div class="col-sm-6">
                                                        <input type="number" step="0.01" class="form-control"
                                                            id="tax_rate" name="tax_rate"
                                                            value="{{ old('tax_rate', $commande->tax_rate) }}"
                                                            onchange="calculateTotals()">
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-2">
                                                    <label for="tax_amount" class="col-sm-6 col-form-label">Montant
                                                        TVA:</label>
                                                    <div class="col-sm-6">
                                                        <input type="number" step="0.01" class="form-control"
                                                            id="tax_amount" name="tax_amount"
                                                            value="{{ old('tax_amount', $commande->tax_amount) }}"
                                                            readonly>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="mdi mdi-content-save"></i> Mettre à jour la Commande
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- New Article Modal -->
    <div class="modal fade" id="newArticleModal" tabindex="-1" role="dialog" aria-labelledby="newArticleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newArticleModalLabel">
                        <i class="mdi mdi-plus-circle"></i> Créer un Nouvel Article
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="new_article_form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="new_article_name">
                                        <i class="mdi mdi-tag"></i> Nom de l'Article <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="new_article_name" required
                                        placeholder="Saisir le nom de l'article">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="new_article_code">
                                        <i class="mdi mdi-barcode"></i> Code-barres
                                    </label>
                                    <input type="text" class="form-control" id="new_article_code"
                                        placeholder="Saisir le code-barres">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="new_article_price">
                                        <i class="mdi mdi-cash"></i> Prix <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" class="form-control" id="new_article_price" min="0"
                                        step="0.01" required placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="prix_gros">
                                        <i class="mdi mdi-cash-multiple"></i> Prix de gros
                                    </label>
                                    <input type="number" class="form-control" id="prix_gros" min="0"
                                        step="0.01" required placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="prix_achat">
                                        <i class="mdi mdi-cash-usd"></i> Prix d'achat
                                    </label>
                                    <input type="number" class="form-control" id="prix_achat" min="0"
                                        step="0.01" required placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="new_article_category">
                                        <i class="mdi mdi-folder"></i> Catégorie
                                    </label>
                                    <select class="form-control select2" id="new_article_category">
                                        <option value="">Sélectionner une Catégorie</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->NomeCategorie }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="new_article_image">
                                        <i class="mdi mdi-image"></i> Image
                                    </label>
                                    <input type="file" class="form-control h-auto" id="new_article_image"
                                        accept="image/*">
                                </div>
                            </div>
                        </div>

                        <div id="image_preview_container" class="text-center mt-2"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="mdi mdi-close"></i> Annuler
                    </button>
                    <button type="button" class="btn btn-primary" onclick="createNewArticle()">
                        <i class="mdi mdi-content-save"></i> Créer et Ajouter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this hidden iframe for client form submission -->
    <iframe name="clientSubmitFrame" style="display:none;"></iframe>

    <div class="modal fade" id="newClientModal" tabindex="-1" role="dialog" aria-labelledby="newClientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newClientModalLabel">
                        <i class="mdi mdi-account-plus"></i> Créer un Nouveau Client
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="new_client_form" action="{{ route('viewaddClient') }}" method="POST"
                        target="clientSubmitFrame" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nomDeClient">
                                        <i class="mdi mdi-account"></i> Nom <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="nomDeClient" name="nomDeClient"
                                        required placeholder="Nom du client">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="TelephoneDeCLient">
                                        <i class="mdi mdi-phone"></i> Téléphone
                                    </label>
                                    <input type="text" class="form-control" id="TelephoneDeCLient"
                                        name="TelephoneDeCLient" placeholder="Numéro de téléphone">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="EmailDeClient">
                                        <i class="mdi mdi-email"></i> Email
                                    </label>
                                    <input type="email" class="form-control" id="EmailDeClient" name="EmailDeClient"
                                        placeholder="Adresse email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="SocieteDeCLient">
                                        <i class="mdi mdi-office-building"></i> Société
                                    </label>
                                    <input type="text" class="form-control" id="SocieteDeCLient"
                                        name="SocieteDeCLient" placeholder="Nom de la société">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="ImageDeCLient">
                                <i class="mdi mdi-image"></i> Image
                            </label>
                            <input type="file" class="form-control" id="ImageDeCLient" name="ImageDeCLient"
                                accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="submitClientBtn">
                            <i class="mdi mdi-content-save"></i> Créer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>

    <script>
        // Array to store added articles
        let commandeArticles = [];
        let articleCounter = 0;

        // Initialize Select2
        $(document).ready(function() {
            // Load existing articles from the database
            @foreach ($commandeArticles as $article)
                addArticleToTable(
                    {{ $article->article_id }},
                    "{{ $article->article->barcode ?? 'N/A' }}",
                    "{{ $article->article->Nome }}",
                    {{ $article->CustomPrix }},
                    {{ $article->Quantite }}
                );
            @endforeach

            // Basic Select2
            $('.select2').select2({
                width: '100%',
                dropdownParent: $('body')
            });

            // Articles Select2 with AJAX
            $('.select2-articles').select2({
                width: '100%',
                placeholder: 'Rechercher un article par nom ou code-barres',
                allowClear: true,
                dropdownParent: $('body'),
                ajax: {
                    url: '{{ route('api.articles.search') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;

                        return {
                            results: data.articles.map(function(article) {
                                return {
                                    id: article.id,
                                    text: article.Nome + (article.barcode ? ' (' + article
                                        .barcode + ')' : ''),
                                    code: article.barcode,
                                    name: article.Nome,
                                    price: article.prix_gros
                                };
                            }),
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1,
                templateResult: formatArticle
            }).on('select2:select', function(e) {
                const data = e.params.data;

                if (data.id) {
                    addArticleToTable(
                        data.id,
                        data.code,
                        data.name,
                        data.price,
                        1
                    );

                    // Reset select2 after adding article
                    $(this).val(null).trigger('change');
                }
            });

            // Format article in dropdown
            function formatArticle(article) {
                if (!article.id) {
                    return article.text;
                }

                let $article = $(
                    '<div class="select2-result-article">' +
                    '<div class="select2-result-article__title">' + article.name + '</div>' +
                    (article.code ? '<div class="select2-result-article__code">Code: ' + article.code +
                        '</div>' : '') +
                    '<div class="select2-result-article__price">Prix de gros: ' + parseFloat(article.price)
                    .toFixed(2) +
                    '</div>' +
                    '</div>'
                );

                return $article;
            }

            // Image preview
            $('#new_article_image').on('change', function() {
                let preview = document.getElementById('image_preview_container');
                preview.innerHTML = '';

                if (this.files && this.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'preview-image';
                        preview.appendChild(img);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Calculate totals on page load
            calculateTotals();
            updateDueAmount();
        });

        // Create new article
        function createNewArticle() {
            // Create FormData object for handling the file upload
            const formData = new FormData();
            formData.append('Nome', document.getElementById('new_article_name').value);
            formData.append('barcode', document.getElementById('new_article_code').value);
            formData.append('Prix', document.getElementById('new_article_price').value);
            formData.append('prix_gros', document.getElementById('prix_gros').value);
            formData.append('prix_achat', document.getElementById('prix_achat').value);
            formData.append('categorie_id', document.getElementById('new_article_category').value);

            // Append image if it exists
            const imageFile = document.getElementById('new_article_image').files[0];
            if (imageFile) {
                formData.append('image', imageFile);
            }

            if (!formData.get('Nome') || !formData.get('Prix')) {
                alert('Le nom et le prix sont obligatoires');
                return;
            }

            // Show loading state
            const saveButton = document.querySelector('#newArticleModal .btn-primary');
            const originalText = saveButton.innerHTML;
            saveButton.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> Création en cours...';
            saveButton.disabled = true;

            // AJAX call to create new article
            fetch('{{ route('api.articles.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Reset button state
                    saveButton.innerHTML = originalText;
                    saveButton.disabled = false;

                    if (data.success) {
                        // Add the newly created article to the table
                        addArticleToTable(
                            data.product.id,
                            data.product.barcode,
                            data.product.Nome,
                            data.product.prix_gros,
                            1
                        );

                        // Close modal and reset form
                        $('#newArticleModal').modal('hide');
                        document.getElementById('new_article_form').reset();
                        document.getElementById('image_preview_container').innerHTML = '';

                        alert('Article créé avec succès');
                    } else {
                        alert('Erreur: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue lors de la création de l\'article');

                    // Reset button state
                    saveButton.innerHTML = originalText;
                    saveButton.disabled = false;
                });
        }

        // Add article to table
        function addArticleToTable(id, code, name, price, quantity) {
            // Hide no articles row if visible
            document.getElementById('no-articles-row').style.display = 'none';

            // Check if article already exists in the table
            const existingArticleIndex = commandeArticles.findIndex(a => a.id === id);

            if (existingArticleIndex !== -1) {
                // Update quantity if article already exists
                commandeArticles[existingArticleIndex].quantity += quantity;
                updateArticleRow(existingArticleIndex);
            } else {
                // Add new article row
                const articleData = {
                    id: id,
                    code: code || 'N/A',
                    name: name,
                    price: parseFloat(price),
                    quantity: parseInt(quantity),
                    index: articleCounter++
                };

                commandeArticles.push(articleData);

                const tableBody = document.querySelector('#articles-table tbody');
                const newRow = document.createElement('tr');
                newRow.id = `article_row_${articleData.index}`;
                tableBody.appendChild(newRow);

                newRow.innerHTML = `
            <td>${articleData.code}</td>
            <td style="text-wrap: unset;">${articleData.name}</td>
            <td>
                <div class="input-group">
                    <span class="input-group-text">DH</span>
                    <input type="number" class="form-control price-input" 
                        value="${articleData.price.toFixed(2)}" min="0" step="0.01" 
                        onchange="updateArticlePrice(${articleData.index}, this.value)">
                </div>
            </td>
            <td>
                <div class="input-group">
                    <input type="number" class="form-control quantity-input text-center" style="height: auto;" 
                        value="${articleData.quantity}" min="1" step="1" 
                        onchange="updateArticleQuantity(${articleData.index}, this.value)">
                </div>
            </td>
            <td>
                <span class="fw-bold" id="article_total_${articleData.index}">${(articleData.price * articleData.quantity).toFixed(2)}</span> DH
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeArticle(${articleData.index})">
                    <i class="mdi mdi-delete"></i>
                </button>
            </td>
        `;
            }

            updateHiddenInputs();
            calculateTotals();
        }

        // Update article quantity
        function updateArticleQuantity(index, newQuantity) {
            const articleIndex = commandeArticles.findIndex(a => a.index === index);
            if (articleIndex !== -1) {
                commandeArticles[articleIndex].quantity = parseInt(newQuantity);
                updateArticleRow(articleIndex);
                updateHiddenInputs();
                calculateTotals();
            }
        }

        // Update article price
        function updateArticlePrice(index, newPrice) {
            const articleIndex = commandeArticles.findIndex(a => a.index === index);
            if (articleIndex !== -1) {
                commandeArticles[articleIndex].price = parseFloat(newPrice);
                updateArticleRow(articleIndex);
                updateHiddenInputs();
                calculateTotals();
            }
        }

        // Update article row display
        function updateArticleRow(index) {
            const article = commandeArticles[index];
            const totalCell = document.getElementById(`article_total_${article.index}`);
            if (totalCell) {
                totalCell.textContent = (article.price * article.quantity).toFixed(2);
            }
        }

        // Remove article from table
        function removeArticle(index) {
            const articleIndex = commandeArticles.findIndex(a => a.index === index);
            if (articleIndex !== -1) {
                // Remove row
                const row = document.getElementById(`article_row_${index}`);
                if (row) {
                    row.remove();

                    // Show "no articles" message if no articles left
                    if (commandeArticles.length === 1) { // 1 because we're removing it after this check
                        document.getElementById('no-articles-row').style.display = '';
                    }
                }

                // Remove from array
                commandeArticles.splice(articleIndex, 1);

                updateHiddenInputs();
                calculateTotals();
            }
        }

        // Update hidden inputs for form submission
        function updateHiddenInputs() {
            const container = document.getElementById('article_inputs_container');
            container.innerHTML = '';

            // Make sure we're generating proper input fields with array notation
            commandeArticles.forEach((article, index) => {
                container.innerHTML += `
            <input type="hidden" name="articles[${index}][article_id]" value="${article.id}">
            <input type="hidden" name="articles[${index}][Quantite]" value="${article.quantity}">
            <input type="hidden" name="articles[${index}][CustomPrix]" value="${article.price}">
        `;
            });
        }

        // Calculate totals
        function calculateTotals() {
            // Calculate subtotal
            const subtotal = commandeArticles.reduce((sum, article) => {
                return sum + (article.price * article.quantity);
            }, 0);

            // Get tax rate
            const taxRate = parseFloat(document.getElementById('tax_rate').value) || 0;

            // Calculate tax amount
            const taxAmount = subtotal * (taxRate / 100);

            // Calculate total
            const total = subtotal + taxAmount;

            // Update fields
            document.getElementById('subtotal').value = subtotal.toFixed(2);
            document.getElementById('tax_amount').value = taxAmount.toFixed(2);
            document.getElementById('total').value = total.toFixed(2);

            // Update due amount
            updateDueAmount();
        }

        // Update due amount
        function updateDueAmount() {
            const total = parseFloat(document.getElementById('total').value) || 0;
            const paid = parseFloat(document.getElementById('paye').value) || 0;
            document.getElementById('du').value = (total - paid).toFixed(2);

            // Visual indicator for due amount (negative or positive)
            const dueAmount = total - paid;
            const duInput = document.getElementById('du');

            if (dueAmount <= 0) {
                duInput.classList.remove('text-danger');
                duInput.classList.add('text-success');
            } else {
                duInput.classList.remove('text-success');
                duInput.classList.add('text-danger');
            }
        }

        // Document ready functions
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the form
            updateDueAmount();

            // Form validation
            document.getElementById('commande-form').addEventListener('submit', function(e) {
                if (commandeArticles.length === 0) {
                    e.preventDefault();
                    alert('Veuillez ajouter au moins un article à la commande.');
                    return false;
                }

                // Additional check to make sure hidden inputs are properly set
                updateHiddenInputs();
                return true;
            });


            const clientForm = document.getElementById('new_client_form');

            clientForm.addEventListener('submit', function(e) {
                // Show loading state
                const submitBtn = document.getElementById('submitClientBtn');
                submitBtn.innerHTML = '<i class="mdi mdi-loading mdi-spin"></i> Création en cours...';
                submitBtn.disabled = true;

                // After form is submitted to the iframe, we'll reload the clients list
                setTimeout(function() {
                    // This will fetch an updated list of clients
                    fetchClients();

                    // Reset form and close modal
                    clientForm.reset();
                    $('#newClientModal').modal('hide');

                    // Reset button
                    submitBtn.innerHTML = '<i class="mdi mdi-content-save"></i> Créer';
                    submitBtn.disabled = false;

                    alert('Client ajouté avec succès');
                }, 2000);
            });
        });

        function fetchClients() {
            fetch('{{ route('clients.list') }}')
                .then(response => response.json())
                .then(data => {
                    // Update client dropdown
                    const clientSelect = document.getElementById('client_id');

                    // Keep the empty option
                    const emptyOption = clientSelect.querySelector('option[value=""]');
                    clientSelect.innerHTML = '';
                    clientSelect.appendChild(emptyOption);

                    // Add clients
                    data.forEach(client => {
                        const option = new Option(client.Nom, client.id);
                        clientSelect.appendChild(option);
                    });

                    // Refresh Select2
                    $(clientSelect).trigger('change');
                })
                .catch(error => {
                    console.error('Error fetching clients:', error);
                    // If fetch fails, just reload the page
                    window.location.reload();
                });
        }

        function markAsPaid() {
            const totalAmount = parseFloat(document.getElementById('total').value) || 0;
            const paidAmount = parseFloat(document.getElementById('paye').value) || 0;
            const dueAmount = parseFloat(document.getElementById('du').value) || 0;

            if (dueAmount <= 0) {
                alert('Ce compte est déjà payé intégralement.');
                return;
            }

            // Update the paid amount by adding the current due amount
            document.getElementById('paye').value = (paidAmount + dueAmount).toFixed(2);

            // Recalculate due amount (should be 0)
            updateDueAmount();
        }
    </script>
@endsection
