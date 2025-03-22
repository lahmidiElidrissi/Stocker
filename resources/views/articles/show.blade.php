@extends('master')

@section('partialContent')
<style>
    .article-image-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        padding: 20px;
    }
    .article-image {
        max-width: 100%;
        max-height: 300px;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .article-details {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .article-section {
        margin-bottom: 20px;
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 15px;
    }
    .article-section:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }
    .article-label {
        font-weight: bold;
        color: #495057;
        margin-bottom: 5px;
    }
    .article-value {
        font-size: 16px;
        margin-bottom: 15px;
    }
    .price-card {
        background-color: white;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        height: 100%;
    }
    .price-title {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 8px;
    }
    .price-value {
        font-size: 18px;
        font-weight: bold;
        color: #212529;
    }
    .back-button {
        margin-right: 10px;
    }
    .section-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
        color: #343a40;
    }
</style>

<div class="content-wrapper" style="background: #F4F5F778;">
    <div class="row justify-content-center">
        <div class="col-md-10 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">Détails de l'Article</h4>
                        <div>
                            <a href="{{ route('articles.index') }}" class="btn btn-secondary back-button">
                                <i class="mdi mdi-arrow-left"></i> Retour
                            </a>
                            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-primary">
                                <i class="mdi mdi-pencil"></i> Modifier
                            </a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="article-details">
                        <div class="row">
                            <!-- Image Section -->
                            <div class="col-md-4">
                                <div class="article-image-container">
                                    @if($article->image)
                                        <img src="{{ asset($article->image) }}" alt="{{ $article->Nome }}" class="article-image">
                                    @else
                                        <img src="{{ asset('images/no-image.png') }}" alt="{{ $article->Nome }}" class="article-image">
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Basic Information Section -->
                            <div class="col-md-8">
                                <div class="article-section">
                                    <div class="section-title">Informations de base</div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="article-label">Barecode</div>
                                            <div class="article-value">{{ $article->barcode }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="article-label">Nom Article</div>
                                            <div class="article-value">{{ $article->Nome }}</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="article-label">Catégorie</div>
                                            <div class="article-value">{{ $article->categorie->NomeCategorie ?? 'N/A' }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="article-label">Créé le</div>
                                            <div class="article-value">{{ $article->created_at->format('d/m/Y H:i') }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Pricing Section -->
                                <div class="article-section">
                                    <div class="section-title">Information sur les prix</div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="price-card">
                                                <div class="price-title">Prix detail</div>
                                                <div class="price-value">{{ number_format($article->Prix, 2) }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="price-card">
                                                <div class="price-title">Prix de gros</div>
                                                <div class="price-value">{{ number_format($article->prix_gros, 2) }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="price-card">
                                                <div class="price-title">Prix d'importation</div>
                                                <div class="price-value">{{ number_format($article->prix_importation, 2) }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="price-card">
                                                <div class="price-title">Prix d'achat</div>
                                                <div class="price-value">{{ number_format($article->prix_achat, 2) }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="price-card">
                                                <div class="price-title">Stock disponible</div>
                                                <div class="price-value">
                                                    @if($article->stock <= 0)
                                                        <span class="badge bg-danger">{{ $article->stock }}</span>
                                                    @elseif($article->stock < 10)
                                                        <span class="badge bg-warning">{{ $article->stock }}</span>
                                                    @else
                                                        <span class="badge bg-success">{{ $article->stock }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Description Section (if available) -->
                                @if($article->description)
                                <div class="article-section">
                                    <div class="section-title">Description</div>
                                    <div class="article-value">{{ $article->description }}</div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection