@extends('master')

@section('partialContent')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<style>
    tr{
        height:60px;
    }
    #articles-table_info{
        display: none;
    }
    input[type="checkbox"] + .input-helper:before{
      background: #d7d7d7 !important;
    }
    input[type="checkbox"]:checked + .input-helper:before
    {
      background: #1F3BB3 !important;
    }
    tr{
        height:60px;
    }
    .buttontr{
        height:30px;
    }
    .article-thumbnail {
        width: 52px;
        height: 49px;
        object-fit: cover;
    }
</style>

<div class="content-wrapper" style="background: #F4F5F778;">
    <div class="row justify-content-center">
        <div class="card col-md-10 col-sm-12">
            <div class="card-body">
                <h4 class="card-title d-flex justify-content-center">Gestion des Articles</h4>
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                
                <div class="table-responsive">
                    <div class="d-flex gap-2">
                        <a href="{{ route('articles.create') }}" class="btn btn-primary">Ajouter</a>
                        <button type="button" id="bulk_delete" class="btn btn-danger" disabled>
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                    <br>
                    <table class="table table-striped" id="articles-table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="check_all"></th>
                                <th>Image</th>
                                <th>Nome</th>
                                <th>Prix</th>
                                <th>Prix de gros</th>
                                <th>Prix d'achat</th>
                                <th>Categorie</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation de suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer ces articles?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Supprimer</button>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    // DataTable initialization
    var table = $('#articles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('articles.index') }}",
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'image', name: 'image', orderable: false, searchable: false},
            {data: 'Nome', name: 'Nome'},
            {data: 'Prix', name: 'Prix'},
            {data: 'prix_gros', name: 'prix_gros'},
            {data: 'prix_achat', name: 'prix_achat'},
            {data: 'categorie', name: 'categorie', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        language: {
            url: '/datatableTrans/fr-FR.json'
        }
    });

    // Handle check all checkbox
    $('#check_all').on('click', function() {
        $('.dt-checkboxes').prop('checked', $(this).prop('checked'));
        toggleBulkDeleteButton();
    });

    // Toggle bulk delete button based on checkbox selection
    function toggleBulkDeleteButton() {
        if($('.dt-checkboxes:checked').length > 0) {
            $('#bulk_delete').prop('disabled', false);
        } else {
            $('#bulk_delete').prop('disabled', true);
        }
    }

    // Listen for checkbox changes
    $(document).on('change', '.dt-checkboxes', function() {
        toggleBulkDeleteButton();
    });

    // Handle bulk delete button click
    $('#bulk_delete').on('click', function() {
        $('#confirmDeleteModal').modal('show');
    });

    // Confirm delete button click
    $('#confirmDelete').on('click', function() {
        var article_ids = [];
        
        $('.dt-checkboxes:checked').each(function() {
            article_ids.push($(this).val());
        });
        
        $.ajax({
            url: "{{ route('destroyMultiple') }}",
            method: "POST",
            data: {
                ids: article_ids,
                _token: "{{ csrf_token() }}"
            },
            success: function(result) {
                if (result.success) {
                    $('#confirmDeleteModal').modal('hide');
                    table.ajax.reload();
                    $('#check_all').prop('checked', false);
                    $('#bulk_delete').prop('disabled', true);
                    
                    // Show success message
                    const alertHtml = `<div class="alert alert-success">${article_ids.length} article(s) supprimé(s) avec succès</div>`;
                    $('.card-body').prepend(alertHtml);
                    
                    // Remove alert after 3 seconds
                    setTimeout(function() {
                        $('.alert').fadeOut('slow', function() {
                            $(this).remove();
                        });
                    }, 3000);
                }
            }
        });
    });

    // Handle single delete form submission
    $(document).on('click', '.delete-article', function() {
        var articleId = $(this).data('id');
        
        if (confirm('Êtes-vous sûr de vouloir supprimer cet article?')) {
            $.ajax({
                url: `/articles/${articleId}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    if (result.success) {
                        table.ajax.reload();
                        // Show success message
                        const alertHtml = `<div class="alert alert-success">Article supprimé avec succès</div>`;
                        $('.card-body').prepend(alertHtml);
                        
                        // Remove alert after 3 seconds
                        setTimeout(function() {
                            $('.alert').fadeOut('slow', function() {
                                $(this).remove();
                            });
                        }, 3000);
                    }
                }
            });
        }
    });
});
</script>
@stop