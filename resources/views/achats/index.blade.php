@extends('master')

@section('partialContent')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<style>
    tr{
        height:60px;
    }
    #tableArticle_filter{
        display: none;
    }
    #tableArticle_info{
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
</style>

<div class="content-wrapper" style="background: #F4F5F778;">
    <div class="row justify-content-center">
        <div class="card col-md-10 col-sm-12">
            <div class="card-body">
                <h4 class="card-title d-flex justify-content-center">{{__('master.GA')}}</h4>
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <div class="d-flex gap-2">
                        <a href="/achats/create" class="btn btn-primary">Ajouter</a>
                        <button type="button" id="bulk_delete" class="btn btn-danger" disabled>
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                    <br>
                    <table class="table table-striped" id="achats-table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="check_all"></th>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Fournisseur</th>
                                <th>Total</th>
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
                Êtes-vous sûr de vouloir supprimer ces achats?
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
    var table = $('#achats-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('achats.index') }}",
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'id', name: 'id', visible: false},
            {data: 'date', name: 'date'},
            {data: 'fournisseur', name: 'fournisseur'},
            {data: 'total', name: 'total', render: function(data) { return data + ' Dh'; }},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
            {data: 'updated_at', title: 'Last Updated', orderable: true, visible: false }
        ],
        language: {
            url: '/datatableTrans/fr-FR.json'
        },
        order: [[6, 'desc']]
    });

    // Handle check all checkbox
    $('#check_all').on('click', function() {
        $('.achat_checkbox').prop('checked', $(this).prop('checked'));
        toggleBulkDeleteButton();
    });

    // Toggle bulk delete button based on checkbox selection
    function toggleBulkDeleteButton() {
        if($('.achat_checkbox:checked').length > 0) {
            $('#bulk_delete').prop('disabled', false);
        } else {
            $('#bulk_delete').prop('disabled', true);
        }
    }

    // Listen for checkbox changes
    $(document).on('change', '.achat_checkbox', function() {
        toggleBulkDeleteButton();
    });

    // Handle bulk delete button click
    $('#bulk_delete').on('click', function() {
        $('#confirmDeleteModal').modal('show');
    });

    // Confirm delete button click
    $('#confirmDelete').on('click', function() {
        var achat_ids = [];
        
        $('.achat_checkbox:checked').each(function() {
            achat_ids.push($(this).val());
        });
        
        $.ajax({
            url: "{{ route('achats.multi-delete') }}",
            method: "POST",
            data: {
                achat_ids: achat_ids,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                $('#confirmDeleteModal').modal('hide');
                table.ajax.reload();
                $('#check_all').prop('checked', false);
                $('#bulk_delete').prop('disabled', true);
            }
        });
    });

    // Handle single delete form submission
    $(document).on('submit', '.delete-form', function(e) {
        e.preventDefault();
        
        if (confirm('Êtes-vous sûr de vouloir supprimer cet achat?')) {
            var form = $(this);
            
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    table.ajax.reload();
                }
            });
        }
    });


    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        
        if (confirm('Êtes-vous sûr de vouloir supprimer cet achat?')) {
            var deleteUrl = $(this).data('url');
            var token = $(this).data('token');
            
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {
                    '_method': 'DELETE',
                    '_token': token
                },
                success: function(response) {
                    // Reload the DataTable to reflect the changes
                    $('#achats-table').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Delete error:', error);
                    showWarningToast('Une erreur est survenue lors de la suppression.');
                }
            });
        }
    });
});
</script>
@stop