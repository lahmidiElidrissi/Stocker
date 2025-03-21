@extends('master')

@section('partialContent')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<style>
    tr {
        height: 60px;
    }
    #commandes-table_info {
        display: none;
    }
    input[type="checkbox"] + .input-helper:before {
      background: #d7d7d7 !important;
    }
    input[type="checkbox"]:checked + .input-helper:before {
      background: #1F3BB3 !important;
    }
    .buttontr {
        height: 30px;
    }
</style>

<div class="content-wrapper" style="background: #F4F5F778;">
    <div class="row justify-content-center">
        <div class="card col-md-10 col-sm-12">
            <div class="card-body">
                <h4 class="card-title d-flex justify-content-between align-items-center">
                    Gestion des Commandes
                    <a href="{{ route('commandes.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus"></i> Nouvelle Commande
                    </a>
                </h4>
                
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
                    <div class="d-flex mb-3">
                        <button type="button" id="bulk_delete" class="btn btn-danger" disabled>
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                    
                    <table class="table table-striped" id="commandes-table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="check_all"></th>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Référence</th>
                                <th>Client</th>
                                <th>Total</th>
                                <th>Payé</th>
                                <th>Credit</th>
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
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer ces commandes?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Supprimer</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // DataTable initialization
    var table = $('#commandes-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('commandes.index') }}",
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'id', name: 'id'},
            {data: 'date', name: 'date'},
            {data: 'reference', name: 'reference'},
            {data: 'client', name: 'client'},
            {data: 'total', name: 'total', render: function(data) { return data + ' Dh'; }},
            {data: 'paye', name: 'paye', render: function(data) { return data + ' Dh'; }},
            {data: 'du', name: 'du', render: function(data) { return data + ' Dh'; }},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
            { data: 'updated_at', title: 'Last Updated', orderable: true, visible: false }
        ],
        language: {
            url: '/datatableTrans/fr-FR.json'
        },
        order: [[9, 'desc']]
    });

    // Handle check all checkbox
    $('#check_all').on('click', function() {
        $('.commande_checkbox').prop('checked', $(this).prop('checked'));
        toggleBulkDeleteButton();
    });

    // Toggle bulk delete button based on checkbox selection
    function toggleBulkDeleteButton() {
        if($('.commande_checkbox:checked').length > 0) {
            $('#bulk_delete').prop('disabled', false);
        } else {
            $('#bulk_delete').prop('disabled', true);
        }
    }

    // Listen for checkbox changes
    $(document).on('change', '.commande_checkbox', function() {
        toggleBulkDeleteButton();
    });

    // Handle bulk delete button click
    $('#bulk_delete').on('click', function() {
        $('#confirmDeleteModal').modal('show');
    });

    // Confirm delete button click
    $('#confirmDelete').on('click', function() {
        var commande_ids = [];
        
        $('.commande_checkbox:checked').each(function() {
            commande_ids.push($(this).val());
        });
        
        $.ajax({
            url: "{{ route('commandes.multi-delete') }}",
            method: "POST",
            data: {
                commande_ids: commande_ids,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                $('#confirmDeleteModal').modal('hide');
                table.ajax.reload();
                $('#check_all').prop('checked', false);
                $('#bulk_delete').prop('disabled', true);
                
                // Show success message
                const alertHtml = `<div class="alert alert-success">${commande_ids.length} commande(s) supprimée(s) avec succès</div>`;
                $('.card-body').prepend(alertHtml);
                
                // Remove alert after 3 seconds
                setTimeout(function() {
                    $('.alert').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 3000);
            }
        });
    });

    // Handle single delete button click
    $(document).on('click', '.delete-commande', function() {
        var commandeId = $(this).data('id');
        
        if (confirm('Êtes-vous sûr de vouloir supprimer cette commande?')) {
            $.ajax({
                url: `/commandes/${commandeId}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    if (result.success) {
                        table.ajax.reload();
                        // Show success message
                        const alertHtml = `<div class="alert alert-success">Commande supprimée avec succès</div>`;
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
@endsection