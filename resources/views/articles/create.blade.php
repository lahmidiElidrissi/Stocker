@extends('master')

@section('partialContent')
<div class="content-wrapper" style="background: #F4F5F778;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Ajouter un Article</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom Article</label>
                                <input type="text" name="Nome" class="form-control" value="{{ old('Nome') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prix d'achat</label>
                                <input type="number" name="prix_achat" step="0.01" class="form-control" value="{{ old('prix_achat') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prix de gros</label>
                                <input type="number" name="prix_gros" step="0.01" class="form-control" value="{{ old('prix_gros') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prix</label>
                                <input type="number" name="Prix" step="0.01" class="form-control" value="{{ old('Prix') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Code barres</label>
                                <input type="text" name="barcode" class="form-control" value="{{ old('barcode') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Catégorie</label>
                                <select name="categorie_id" class="form-control">
                                    <option value="">Sélectionner une catégorie</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->NomeCategorie }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" name="image" class="form-control h-auto" accept="image/*">
                            </div>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('articles.index') }}" class="btn btn-secondary me-2">Annuler</a>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection