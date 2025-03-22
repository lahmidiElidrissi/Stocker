<!-- New Fournisseur Modal -->
<div class="modal fade" id="newFournisseurModal" tabindex="-1" role="dialog" aria-labelledby="newFournisseurModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newFournisseurModalLabel">Créer un Nouveau Fournisseur</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="new_fournisseur_form">
                    <div class="form-group mb-3">
                        <label for="new_fournisseur_name">Nom du Fournisseur</label>
                        <input type="text" class="form-control" id="new_fournisseur_name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="new_fournisseur_email">Email</label>
                        <input type="email" class="form-control" id="new_fournisseur_email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="new_fournisseur_telephone">Téléphone</label>
                        <input type="text" class="form-control" id="new_fournisseur_telephone" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="new_fournisseur_image">Image</label>
                        <input type="file" class="form-control h-auto" id="new_fournisseur_image" accept="image/*">
                        <div id="fournisseur_image_preview_container" class="mt-2"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="createNewFournisseur()">Créer et Sélectionner</button>
            </div>
        </div>
    </div>
</div>