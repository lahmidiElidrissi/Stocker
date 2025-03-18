@extends('master')

@section('css')
<style>
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .image-preview {
        background-color: #f8f9fa;
        border: 1px dashed #dee2e6 !important;
        border-radius: 0.375rem;
        padding: 1rem !important;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .image-preview:hover {
        border-color: #6c757d !important;
    }
    
    .image-preview img {
        max-height: 180px;
        object-fit: contain;
    }
    
    .custom-file-input {
        cursor: pointer;
    }
    
    .section-divider {
        position: relative;
        text-align: left;
        margin-top: 2rem;
        margin-bottom: 1.5rem;
        font-weight: 600;
        color: #495057;
    }
    
    .section-divider:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -0.5rem;
        width: 3rem;
        height: 0.25rem;
        background: #0d6efd;
        border-radius: 0.25rem;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        font-weight: 500;
    }
    
    .btn-primary {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
    
    .price-field {
        transition: all 0.2s ease-in-out;
    }
    
    .price-field:focus-within {
        transform: translateY(-2px);
    }
    
    .btn {
        border-radius: 0.375rem;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .btn-outline-secondary:hover {
        transform: translateY(-2px);
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .select2-container--default .select2-selection--single {
        height: 38px;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
</style>
@endsection

@section('partialContent')
<div class="content-wrapper py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-12">
                <div class="card shadow">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 fw-bold">Modifier l'Article</h4>
                        <a href="{{ route('articles.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Retour
                        </a>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row gx-4 gy-4">
                                <!-- Left column for image -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Image du produit</label>
                                        <div class="image-preview mb-3">
                                            @if($article->image)
                                                <img src="{{ asset($article->image) }}" 
                                                    alt="Article Image" class="img-fluid">
                                            @else
                                                <img src="{{ asset('images/no-image.png') }}" 
                                                    alt="Aucune image" class="img-fluid">
                                            @endif
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" name="image" class="form-control h-auto" id="customFile" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Right column for product details -->
                                <div class="col-md-8">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nom Article</label>
                                            <input type="text" name="Nome" class="form-control" value="{{ $article->Nome }}" required>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label class="form-label">Code barres</label>
                                            <input type="text" name="Referance" class="form-control" value="{{ $article->barcode }}" required>
                                        </div>
                                        
                                        <div class="col-12">
                                            <label class="form-label">Catégorie</label>
                                            <select name="categorie_id" class="form-select" id="category-select">
                                                <option value="">Sélectionner une catégorie</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" 
                                                        {{ $article->categorie_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->NomeCategorie }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                        
                                    <h5 class="section-divider mt-4 pt-2">Informations de prix</h5>
                                    <hr>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Prix de vente</label>
                                            <div class="input-group price-field">
                                                <input type="number" name="Prix" step="0.01" class="form-control" value="{{ $article->Prix }}" required>
                                                <span class="input-group-text">Dh</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label class="form-label">Prix de gros</label>
                                            <div class="input-group price-field">
                                                <input type="number" name="prix_gros" step="0.01" class="form-control" value="{{ $article->prix_gros }}">
                                                <span class="input-group-text">Dh</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label class="form-label">Prix d'achat</label>
                                            <div class="input-group price-field">
                                                <input type="number" name="prix_achat" step="0.01" class="form-control" value="{{ $article->prix_achat }}">
                                                <span class="input-group-text">Dh</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Submit Buttons -->
                            <div class="d-flex justify-content-end gap-3 mt-5">
                                <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary">
                                    Annuler
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Mettre à jour
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('vendors/select2/select2.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2 for the category dropdown
        $('#category-select').select2({
            placeholder: "Sélectionner une catégorie",
            width: '100%',
            dropdownParent: $('#category-select').parent()
        });

        @if($article->categorie_id)
            $('#category-select').val('{{ $article->categorie_id }}').trigger('change');
        @endif
        
        // Preview uploaded image
        $('#customFile').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('.image-preview img').attr('src', e.target.result);
                    $('.image-preview').addClass('border-primary').removeClass('border-dashed');
                    
                    // Reset border after 1 second
                    setTimeout(function() {
                        $('.image-preview').removeClass('border-primary').addClass('border-dashed');
                    }, 1000);
                }
                reader.readAsDataURL(file);
            }
        });
        
        // Make the image upload box clickable
        $('.image-preview').on('click', function() {
            $('#customFile').click();
        });
        
        // Improve number input experience
        $('input[type="number"]').on('wheel', function(e) {
            e.preventDefault();
        });
    });
</script>
@endsection