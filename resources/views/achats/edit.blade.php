@extends('master')

@section('partialContent')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 5px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .select2-container--open {
            z-index: 1060 !important;
        }

        .preview-image {
            max-width: 100px;
            max-height: 100px;
            margin-top: 10px;
        }
    </style>

    <div class="content-wrapper" style="background: #F4F5F778;">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2>Modifier l'Achat</h2>
                            <a href="{{ route('achats.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Retour
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('achats.update', $achat->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="date">Date</label>
                                        <input type="date" class="form-control" id="date" name="date"
                                            value="{{ old('date', $achat->date) }}" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="fournisseur_id">Fournisseur</label>
                                        <select class="form-control select2" id="fournisseur_id" name="fournisseur_id">
                                            <option value="">Sélectionner un Fournisseur</option>
                                            @foreach ($fournisseurs as $fournisseur)
                                                <option value="{{ $fournisseur->id }}"
                                                    {{ old('fournisseur_id', $achat->fournisseur_id) == $fournisseur->id ? 'selected' : '' }}>
                                                    {{ $fournisseur->Nom }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#newFournisseurModal">
                                                <i class="mdi mdi-plus"></i>
                                            </button>
                                        </div>

                                    </div>

                                    @include('achats.createFournisseurModal')

                                    <div class="form-group mb-3">
                                        <label for="contenir_id">Contenir</label>
                                        <select class="form-control select2" id="contenir_id" name="contenir_id">
                                            <option value="">Sélectionner un Contenir</option>
                                            @foreach ($contenirs as $contenir)
                                                <option value="{{ $contenir->id }}"
                                                    {{ old('contenir_id', $achat->contenir_id) == $contenir->id ? 'selected' : '' }}>
                                                    {{ $contenir->Referance }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="subtotal">Total HT</label>
                                        <input type="number" class="form-control" id="subtotal" name="subtotal"
                                            value="{{ old('subtotal', $achat->subtotal) }}" readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="total">Total TTC</label>
                                        <input type="number" class="form-control" id="total" name="total"
                                            value="{{ old('total', $achat->total) }}" readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tax_rate">Taux de TVA (%)</label>
                                        <input type="number" class="form-control" id="tax_rate" name="tax_rate"
                                            value="{{ old('tax_rate', $achat->tax_rate) }}" min="0" max="100"
                                            step="0.01" onchange="calculateTotals()">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="tax_amount">Montant TVA</label>
                                        <input type="number" class="form-control" id="tax_amount" name="tax_amount"
                                            value="{{ old('tax_amount', $achat->tax_amount) }}" readonly>
                                    </div>

                                </div>
                            </div>

                            <!-- Article Search with Select2 -->
                            <div class="row mb-3" style="align-items: center;">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="article_select">Rechercher/Ajouter un Article</label>
                                        <select class="form-control select2-articles" id="article_select">
                                            <option value="">Rechercher un article par nom ou code-barres</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                                        data-bs-target="#newArticleModal">
                                        <i class="fa fa-plus"></i> Nouvel Article
                                    </button>
                                </div>
                            </div>

                            <!-- Articles Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered" id="articles_table">
                                    <thead>
                                        <tr>
                                            <th>Code-barres</th>
                                            <th>Article</th>
                                            <th>Prix</th>
                                            <th>Prix de gros</th>
                                            <th>Prix d'achat</th>
                                            <th>Prix importation</th>
                                            <th>Quantité</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Article rows will be added here dynamically -->
                                    </tbody>
                                </table>
                            </div>

                            <!-- Hidden inputs to store article data -->
                            <div id="article_inputs_container"></div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Enregistrer les Modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Article Modal -->
    <!-- New Article Modal -->
    <div class="modal fade" id="newArticleModal" tabindex="-1" role="dialog" aria-labelledby="newArticleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newArticleModalLabel">Créer un Nouvel Article</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="new_article_form">
                        <div class="form-group">
                            <label for="new_article_name">Nom de l'Article</label>
                            <input type="text" class="form-control" id="new_article_name" required>
                        </div>
                        <div class="form-group">
                            <label for="new_article_code">Code-barres</label>
                            <input type="text" class="form-control" id="new_article_code">
                        </div>
                        <div class="form-group">
                            <label for="new_article_price">Prix</label>
                            <input type="number" class="form-control" id="new_article_price" min="0"
                                step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="prix_importation">Prix d'importation</label>
                            <input type="number" class="form-control" id="prix_importation" min="0"
                                step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="prix_gros">Prix de gros</label>
                            <input type="number" class="form-control" id="prix_gros" min="0" step="0.01"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="prix_achat">Prix d'achat</label>
                            <input type="number" class="form-control" id="prix_achat" min="0" step="0.01"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="new_article_category">Catégorie</label>
                            <select class="form-control select2" id="new_article_category">
                                <option value="">Sélectionner une Catégorie</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->NomeCategorie }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="new_article_image">Image</label>
                            <input type="file" class="form-control h-auto" id="new_article_image" accept="image/*">
                            <div id="image_preview_container"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="createNewArticle()">Créer et Ajouter</button>
                </div>
            </div>
        </div>
    </div>

@stop


@section('js')

    <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

    <script>
        // Array to store added articles
        let commandeArticles = [];
        let articleCounter = 0;

        // Initialize Select2
        $(document).ready(function() {
            // Basic Select2
            $('.select2').select2({
                width: '100%'
            });

            // Articles Select2 with AJAX
            $('.select2-articles').select2({
                width: '100%',
                placeholder: 'Rechercher un article par nom ou code-barres',
                allowClear: true,
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
                                    price: article.Prix,
                                    prix_gros: article.prix_gros || 0,
                                    prix_achat: article.prix_achat || 0,
                                    prix_importation: article.prix_importation || 0
                                };
                            }),
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1
            }).on('select2:select', function(e) {
                const data = e.params.data;

                if (data.id) {
                    addArticleToTable(
                        data.id,
                        data.code,
                        data.name,
                        data.price,
                        data.prix_gros,
                        data.prix_achat,
                        data.prix_importation,
                        1
                    );

                    // Reset select2 after adding article
                    $(this).val(null).trigger('change');
                }
            });

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

            // Load existing purchase items
            loadExistingArticles();
        });

        // Load existing purchase articles
        function loadExistingArticles() {
            @if (isset($achat) && $achat->articles)
                @foreach ($achat->articles as $articleItem)
                    addArticleToTable(
                        {{ $articleItem->article_id }},
                        "{{ $articleItem->article->barcode ?? 'N/A' }}",
                        "{{ $articleItem->article->Nome }}",
                        {{ $articleItem->CustomPrix ?? $articleItem->article->Prix }},
                        {{ $articleItem->prix_gros ?? ($articleItem->article->prix_gros ?? 0) }},
                        {{ $articleItem->prix_achat ?? ($articleItem->article->prix_achat ?? 0) }},
                        {{ $articleItem->prix_importation ?? ($articleItem->article->prix_importation ?? 0) }},
                        {{ $articleItem->Quantite }}
                    );
                @endforeach
            @endif

            // Calculate totals after loading
            calculateTotals();
        }

        // Create new article
        function createNewArticle() {
            // Create FormData object for handling the file upload
            const formData = new FormData();
            formData.append('Nome', document.getElementById('new_article_name').value);
            formData.append('barcode', document.getElementById('new_article_code').value);
            formData.append('Prix', document.getElementById('new_article_price').value);
            formData.append('prix_gros', document.getElementById('prix_gros').value);
            formData.append('prix_achat', document.getElementById('prix_achat').value);
            formData.append('prix_importation', document.getElementById('prix_importation').value);
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

            // AJAX call to create new article
            fetch('{{ route('api.articles.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        // Don't set Content-Type here, FormData will set it with boundary
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Add the newly created article to the table
                        addArticleToTable(
                            data.product.id,
                            data.product.barcode,
                            data.product.Nome,
                            data.product.Prix,
                            data.product.prix_gros,
                            data.product.prix_achat,
                            data.product.prix_importation,
                            1
                        );

                        // Close modal and reset form
                        $('#newArticleModal').modal('hide');
                        document.getElementById('new_article_form').reset();
                        document.getElementById('image_preview_container').innerHTML = '';

                        // Show success message
                        alert('Article créé avec succès');
                    } else {
                        alert('Erreur: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue lors de la création de l\'article');
                });
        }

        // Add article to table
        function addArticleToTable(id, code, name, price, prix_gros, prix_achat, prix_importation, quantity) {
            // Check if article already exists in the table
            const existingArticleIndex = commandeArticles.findIndex(a => a.id === id);

            if (existingArticleIndex !== -1) {
                // Update quantity if article already exists
                commandeArticles[existingArticleIndex].quantity += parseInt(quantity);
                updateArticleRow(existingArticleIndex);
            } else {
                // Add new article row
                const articleData = {
                    id: id,
                    code: code,
                    name: name,
                    price: parseFloat(price),
                    prix_gros: parseFloat(prix_gros),
                    prix_achat: parseFloat(prix_achat),
                    prix_importation: parseFloat(prix_importation || price), // Use price as fallback
                    quantity: parseInt(quantity),
                    index: articleCounter++
                };

                commandeArticles.push(articleData);

                const tableBody = document.querySelector('#articles_table tbody');
                const newRow = tableBody.insertRow();
                newRow.id = `article_row_${articleData.index}`;

                newRow.innerHTML = `
            <td>${code || 'N/A'}</td>
            <td>${name}</td>
            <td>
                <input type="number" class="form-control price-input" 
                    value="${price}" min="0" step="0.01" 
                    onchange="updateArticlePrice(${articleData.index}, this.value)">
            </td>
            <td>
                <input type="number" class="form-control prix-gros-input" 
                    value="${prix_gros}" min="0" step="0.01" 
                    onchange="updateArticlePrixGros(${articleData.index}, this.value)">
            </td>
            <td>
                <input type="number" class="form-control prix-achat-input" 
                    value="${prix_achat}" min="0" step="0.01" 
                    onchange="updateArticlePrixAchat(${articleData.index}, this.value)">
            </td>
            <td>
                <input type="number" class="form-control prix-importation-input" 
                    value="${prix_importation}" min="0" step="0.01" 
                    onchange="updateArticlePrixImportation(${articleData.index}, this.value)">
            </td>
            <td>
                <input type="number" class="form-control quantity-input" 
                    value="${quantity}" min="1" step="1" 
                    onchange="updateArticleQuantity(${articleData.index}, this.value)">
            </td>
            <td id="article_total_${articleData.index}">${(prix_importation * quantity).toFixed(2)}</td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeArticle(${articleData.index})">
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
                updateHiddenInputs();
            }
        }

        // Update article row display
        function updateArticleRow(index) {
            const article = commandeArticles[index];
            const totalCell = document.getElementById(`article_total_${article.index}`);
            if (totalCell) {
                // Use prix_importation for total calculation
                totalCell.textContent = (article.prix_importation * article.quantity).toFixed(2);
            }
        }

        // Remove article from table
        function removeArticle(index) {
            const articleIndex = commandeArticles.findIndex(a => a.index === index);
            if (articleIndex !== -1) {
                commandeArticles.splice(articleIndex, 1);
                const row = document.getElementById(`article_row_${index}`);
                if (row) {
                    row.remove();
                }
                updateHiddenInputs();
                calculateTotals();
            }
        }

        // Update hidden inputs for form submission
        function updateHiddenInputs() {
            const container = document.getElementById('article_inputs_container');
            container.innerHTML = '';

            commandeArticles.forEach((article, index) => {
                container.innerHTML += `
            <input type="hidden" name="articles[${index}][article_id]" value="${article.id}">
            <input type="hidden" name="articles[${index}][Quantite]" value="${article.quantity}">
            <input type="hidden" name="articles[${index}][CustomPrix]" value="${article.price}">
            <input type="hidden" name="articles[${index}][prix_gros]" value="${article.prix_gros}">
            <input type="hidden" name="articles[${index}][prix_achat]" value="${article.prix_achat}">
            <input type="hidden" name="articles[${index}][prix_importation]" value="${article.prix_importation}">
        `;
            });
        }

        // Calculate totals
        function calculateTotals() {
            // Calculate subtotal using prix_importation
            const subtotal = commandeArticles.reduce((sum, article) => {
                return sum + (article.prix_importation * article.quantity);
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
        }

        function updateArticlePrixGros(index, newPrixGros) {
            const articleIndex = commandeArticles.findIndex(a => a.index === index);
            if (articleIndex !== -1) {
                commandeArticles[articleIndex].prix_gros = parseFloat(newPrixGros);
                updateHiddenInputs();
            }
        }


        function updateArticlePrixAchat(index, newPrixAchat) {
            const articleIndex = commandeArticles.findIndex(a => a.index === index);
            if (articleIndex !== -1) {
                commandeArticles[articleIndex].prix_achat = parseFloat(newPrixAchat);
                updateHiddenInputs();
            }
        }

        function updateArticlePrixImportation(index, newPrixImportation) {
            const articleIndex = commandeArticles.findIndex(a => a.index === index);
            if (articleIndex !== -1) {
                commandeArticles[articleIndex].prix_importation = parseFloat(newPrixImportation);
                updateArticleRow(articleIndex);
                updateHiddenInputs();
                calculateTotals();
            }
        }


        //----------------------------------------------
        // create a new fournisseur JS section

        // Initialize image preview for fournisseur
        $('#new_fournisseur_image').on('change', function() {
            let preview = document.getElementById('fournisseur_image_preview_container');
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

        // Function to create a new fournisseur
        function createNewFournisseur() {
            // Create FormData object for handling the file upload
            const formData = new FormData();
            formData.append('Nom', document.getElementById('new_fournisseur_name').value);
            formData.append('email', document.getElementById('new_fournisseur_email').value);
            formData.append('telephone', document.getElementById('new_fournisseur_telephone').value);

            // Append image if it exists
            const imageFile = document.getElementById('new_fournisseur_image').files[0];
            if (imageFile) {
                formData.append('image', imageFile);
            }

            // Validate form
            if (!formData.get('Nom') || !formData.get('email') || !formData.get('telephone')) {
                alert('Tous les champs sont obligatoires');
                return;
            }

            // AJAX call to create new fournisseur
            fetch('{{ route('api.fournisseurs.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Add the newly created fournisseur to the select dropdown
                        const option = new Option(data.fournisseur.Nom, data.fournisseur.id, true, true);
                        $('#fournisseur_id').append(option).trigger('change');

                        // Close modal and reset form
                        $('#newFournisseurModal').modal('hide');
                        $("#newFournisseurModal input").val("");
                        document.getElementById('fournisseur_image_preview_container').innerHTML = '';

                        // Show success message
                        alert('Fournisseur créé avec succès');
                    } else {
                        alert('Erreur: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue lors de la création du fournisseur');
                });
        }
    </script>

@stop
