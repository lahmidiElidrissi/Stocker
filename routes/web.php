<?php

use App\Http\Controllers\AchatController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ChequeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContenirController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\getLocal;
use App\Http\Controllers\LesRapportController;
use App\Http\Controllers\notification;
use App\Http\Controllers\UserController;
use App\Http\Controllers\welcome;
use App\Http\Middleware\lan;
use Illuminate\Support\Facades\Route;

Route::get('/lang', [getLocal::class, 'GetLocal'])->name('GetLocal');
Route::post('/Changelang', [getLocal::class, 'ChangeLan'])->name('changeLan');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/', [welcome::class, 'index'])->name('welcome')->middleware(lan::class);

    //Page Fournisseur with DB
    Route::get('/GestionDesFournisseurs', [FournisseurController::class, 'GetFournisseurs'])->name('viewGestionDesFournisseurs')->middleware(lan::class);
    //CRUD Fournisseur Model
    Route::Post('ajoute/fournisseur', [FournisseurController::class, 'addFournisseur'])->name('addFournisseur')->middleware(lan::class);
    Route::Post('update/fournisseur', [FournisseurController::class, 'UpdateFournisseur'])->name('UpdateFournisseur')->middleware(lan::class);
    Route::Post('delete/fournisseur', [FournisseurController::class, 'deleteFournisseur'])->name('deleteFournisseur')->middleware(lan::class);
    Route::Post('/GetInfoForUpdate/fournisseur', [FournisseurController::class, 'GetInfo'])->name('viewGetInfoFournisseurs')->middleware(lan::class);
    Route::Post('/Fournisseur/SelectionDelete', [FournisseurController::class, 'SelectionDelete'])->name('FournisseurSelectionDelete')->middleware(lan::class);

    //Page Client with DB
    Route::get('/GestionDesClients', [ClientController::class, 'GetClients'])->name('viewGestionDesClients')->middleware(lan::class);
    //CRUD Client Model
    Route::Post('ajoute/Client', [ClientController::class, 'addClient'])->name('viewaddClient')->middleware(lan::class);
    Route::Post('update/Client', [ClientController::class, 'UpdateClient'])->name('viewUpdateClient')->middleware(lan::class);
    Route::Post('delete/Client', [ClientController::class, 'deleteClient'])->name('viewdeleteClient')->middleware(lan::class);
    Route::Post('/GetInfoForUpdate/Client', [ClientController::class, 'GetInfo'])->name('viewGetInfoClient')->middleware(lan::class);
    Route::Post('/Client/SelectionDelete', [ClientController::class, 'SelectionDelete'])->name('ClientSelectionDelete')->middleware(lan::class);

    //Page Categorie with DB
    Route::get('/GestionDesCategories', [CategorieController::class, 'GetCategories'])->name('viewGestionDesCategories')->middleware(lan::class);
    //CRUD Categorie Model
    Route::Post('ajoute/Categorie', [CategorieController::class, 'addCategorie'])->name('viewaddCategorie')->middleware(lan::class);
    Route::Post('update/Categorie', [CategorieController::class, 'UpdateCategorie'])->name('viewUpdateCategorie')->middleware(lan::class);
    Route::Post('delete/Categorie', [CategorieController::class, 'deleteCategorie'])->name('viewdeleteCategorie')->middleware(lan::class);
    Route::Post('/GetInfoForUpdate/Categorie', [CategorieController::class, 'GetInfo'])->name('viewGetInfoCategorie')->middleware(lan::class);
    Route::Post('/Categorie/SelectionDelete', [CategorieController::class, 'SelectionDelete'])->name('CategorieSelectionDelete')->middleware(lan::class);

    //Page (Contenir) with DB
    Route::get('/GestionDesContenirs', [ContenirController::class, 'GetContenirs'])->name('viewGestionDesContenirs')->middleware(lan::class);
    //CRUD (Contenir) -Model-
    Route::Post('ajoute/Contenir', [ContenirController::class, 'addContenir'])->name('viewaddContenir')->middleware(lan::class);
    Route::Post('update/Contenir', [ContenirController::class, 'UpdateContenir'])->name('viewUpdateContenir')->middleware(lan::class);
    Route::Post('delete/Contenir', [ContenirController::class, 'deleteContenir'])->name('viewdeleteContenir')->middleware(lan::class);
    Route::Post('/GetInfoForUpdate/Contenir', [ContenirController::class, 'GetInfo'])->name('viewGetInfoContenir')->middleware(lan::class);
    Route::Post('/Contenir/SelectionDelete', [ContenirController::class, 'SelectionDelete'])->name('ContenirSelectionDelete')->middleware(lan::class);

    //Page (Article) with DB
    Route::resource('/articles', ArticleController::class)->middleware(lan::class);
    Route::post('/destroy-multiple', [ArticleController::class, 'destroyMultiple'])
         ->name('destroyMultiple');

    Route::resource('/achats', AchatController::class)->middleware(lan::class);
    Route::post('/achats/multi-delete', [AchatController::class, 'multiDelete'])
        ->name('achats.multi-delete')
        ->middleware(lan::class);
        
    Route::get('/api/products/search', [ArticleController::class, 'apiSearch'])->name('api.articles.search');
    Route::post('/api/products/store', [ArticleController::class, 'apiStore'])->name('api.articles.store');
    
    Route::get('achats/{achat}/pdf', [AchatController::class, 'generatePDF'])->name('achats.pdf');


    //Page (Commande) with DB
    Route::get('/GestionDesCommandes', [CommandeController::class, 'GetCommandes'])->name('viewGestionDCommandes')->middleware(lan::class);
    //CRUD (Commande) -Model-
    Route::Post('ajoute/Commande', [CommandeController::class, 'addCommande'])->name('viewaddCommande')->middleware(lan::class);
    Route::Post('update/Commande', [CommandeController::class, 'UpdateCommande'])->name('viewUpdateCommande')->middleware(lan::class);
    Route::Post('delete/Commande', [CommandeController::class, 'deleteCommande'])->name('viewdeleteCommande')->middleware(lan::class);
    Route::Post('/GetInfoForUpdate/Commande', [CommandeController::class, 'GetInfo'])->name('viewGetInfoCommande')->middleware(lan::class);
    Route::Post('/GetArticles/Commande', [CommandeController::class, 'ArticlesDeCommande'])->name('viewGetArticlesDeCommande')->middleware(lan::class);
    Route::Post('/commande/SelectionDelete', [CommandeController::class, 'SelectionDelete'])->name('commandeSelectionDelete')->middleware(lan::class);
    Route::Post('/commande/GetTotal', [CommandeController::class, 'GetTotal'])->name('GetTotal')->middleware(lan::class);
    Route::Post('/commande/makepdfCommande', [CommandeController::class, 'GetPDF'])->name('makepdfCommande')->middleware(lan::class);

    //Page (user) with DB
    Route::get('/GestiondesUtilisateurs', [UserController::class, 'GetUsers'])->name('viewGestiondesUtilisateurs')->middleware(lan::class);
    //CRUD (user) -Model-
    Route::Post('ajoute/User', [UserController::class, 'addUser'])->name('viewaddUser')->middleware(lan::class);
    Route::Post('update/User', [UserController::class, 'UpdateUser'])->name('viewUpdateUser')->middleware(lan::class);
    Route::Post('delete/User', [UserController::class, 'deleteUser'])->name('viewdeleteUser')->middleware(lan::class);
    Route::Post('/GetInfoForUpdate/User', [UserController::class, 'GetInfo'])->name('viewGetInfoUser')->middleware(lan::class);
    Route::Post('/User/SelectionDelete', [UserController::class, 'SelectionDelete'])->name('UserSelectionDelete')->middleware(lan::class);

    //Page (cheque) with DB
    Route::get('/GestiondesCheqes', [ChequeController::class, 'GetCheques'])->name('viewGestiondesCheqes')->middleware(lan::class);
    //CRUD (cheque) -Model-
    Route::Post('ajoute/Cheque', [ChequeController::class, 'addCheque'])->name('viewaddCheque')->middleware(lan::class);
    Route::Post('update/Cheque', [ChequeController::class, 'UpdateCheque'])->name('viewUpdateCheque')->middleware(lan::class);
    Route::Post('delete/Cheque', [ChequeController::class, 'deleteCheque'])->name('viewdeleteCheque')->middleware(lan::class);
    Route::Post('/GetInfoForUpdate/Cheque', [ChequeController::class, 'GetInfo'])->name('viewGetInfoCheque')->middleware(lan::class);
    Route::Post('/Cheque/SelectionDelete', [ChequeController::class, 'SelectionDelete'])->name('ChequeSelectionDelete')->middleware(lan::class);

    //les rapports
    Route::get('/ProduitPlusVente', [LesRapportController::class, 'index'])->name('produitPlusVente')->middleware(lan::class);
    Route::Post('/DashbordRapports', [LesRapportController::class, 'DashbordRapports'])->name('DashbordRapports')->middleware(lan::class);
    Route::Post('/DashbordRapports2', [LesRapportController::class, 'DashbordRapports2'])->name('DashbordRapports2')->middleware(lan::class);
    Route::Post('/DashbordRapportsStock', [LesRapportController::class, 'DashbordRapportsStock'])->name('DashbordRapportsStock')->middleware(lan::class);
    Route::get('/RapportDeVente', [LesRapportController::class, 'RapportDeVente'])->name('RapportDeVente')->middleware(lan::class);
    Route::get('/TopClient', [LesRapportController::class, 'TopClient'])->name('TopClient')->middleware(lan::class);

    //notification
    Route::get('/notificationApi', [notification::class, 'index'])->name('GetNotif');
});
