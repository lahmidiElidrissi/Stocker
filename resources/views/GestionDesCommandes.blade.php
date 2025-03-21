@extends('master')

@section('partialContent')
<style>
    .dataTables_length{
        display: none;
    }
    tr{
        height:60px;
    }
    .buttontr{
        height:30px;
    }
    .model-background{
        background:#4b4b4b39;
        position: absolute;
        width: 100%;
        z-index: 6;
        height: 90%;
    }
    
    @media only screen and (max-width: 768px) {
             .commandeSize{
                width: 30%;
                padding: 1px;
            }
            .commandeSizeL{
                width: 40%;
                padding: 1px;
            }
            .size50{
                width: 50%;
            }
            .size50 .btn-primary{
                margin-left: 0px !important;
                padding: ;: 0px !important;
            }
    }
    
</style>
    <div class="d-none">
        <div id="BeforeLinesElement">
            <div class="row">
            <div class="form-group col-md-4 commandeSizeL">
                <label>{{__('gestionDesCommandes.article')}}</label><br>
                <select name="Article[]" class="form-control form-control-lg" onchange="GetTotalAjouter()">
                @foreach ($Articles as $Article)
                <option value="{{$Article->id}}"> {{$Article->Nome}} </option>
                @endforeach
                </select>
            </div>
            <div class="form-group col-md-4 commandeSize">
                <label>{{__('gestionDesCommandes.quantite')}}</label>
                <input type="number" name="quantite[]" class="form-control form-control-lg"  placeholder="Quantite" required>
            </div>
            <div class="form-group col-md-4 commandeSize">
                <label>Prix</label>
                <input type="number" class="form-control form-control-lg PrixAjouter"  placeholder="Prix" required name='CustomPrix[]'>
            </div>
            
            </div>
        </div>
    </div>

    <div class="d-none">
        <div id="BeforeLinesElementModifier">
            <div class="row">
              <div class="form-group col-lg-4 commandeSizeL">
                <label>{{__('gestionDesCommandes.article')}}</label><br>
                <select name="ArticleModifier[]" id="optionArticles" class="form-control form-control-lg modifierArticle" 
                onchange="GetTotal()">
                  @foreach ($Articles as $Article)
                  <option value="{{$Article->id}}"> {{$Article->Nome}} </option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-lg-4 commandeSize ">
                <label>{{__('gestionDesCommandes.quantite')}}</label>
                <input type="number" name="quantitesModifier[]" class="form-control form-control-lg modifierQuantite"  placeholder="Quantite" required onchange="GetTotal()">
              </div>
              <div class="form-group col-lg-4 commandeSize">
                  <label>Prix</label>
                  <input type="number" class="form-control form-control-lg prixM"  placeholder="Prix" required name='CustomPrix[]'>
                </div>
            </div>
          </div>
    </div>


    <!-- start article model -->
    <div class="model-background my-element" id="ModelBackgroundAjouter" style="display: none;">
        <div class="row mt-2 tech" style="position: absolute;width: 100%;z-index: 6;">
            <div class="col-md-3"></div>
            <div class="col-md-5">
              <div class="card" id="bgimage" style="max-height: 650px; overflow-y: scroll;">
                <div class="card-body">
                  <h2>{{__('gestionDesCommandes.ajouter-un-commande')}}</h2><br>
                  <p class="card-description">
                    {{__('gestionDesCommandes.les-champs-de-*')}}
                  </p>
                  <form class="forms-sample" method="POST" action="{{route('viewaddCommande')}}">
                    @csrf
                    <div class="row">
                      <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label>{{__('gestionDesCommandes.ladate')}}</label>
                        <input type="date" name="laDate" class="form-control form-control-lg" style="color: #d7d6d6;" required>
                      </div>
                      <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label>{{__('gestionDesCommandes.client')}}</label><br>
                        <select name="Client" class="form-control form-control-lg SelectSearch">
                          @foreach ($Clients as $Client)
                          <option value="{{$Client->id}}"> {{$Client->Nom}} </option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                      </div>
                    </div>
                  <div>
                  <!-- Add Article -->
                    <div class="row">
                      <div class="form-group col-md-4 commandeSizeL">
                        <label>{{__('gestionDesCommandes.article')}}</label><br>
                        <select name="Article[]" class="form-control form-control-lg SelectSearch" onchange="GetTotalAjouter()">
                          @foreach ($Articles as $Article)
                          <option value="{{$Article->id}}"> {{$Article->Nome}} </option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group col-md-4 commandeSize">
                        <label>{{__('gestionDesCommandes.quantite')}}</label>
                        <input type="number" name="quantite[]" class="form-control form-control-lg"  placeholder="Quantite" required>
                      </div>
                      <div class="form-group col-md-4 commandeSize">
                        <label>Prix</label>
                        <input type="number" class="form-control form-control-lg PrixAjouter"  placeholder="Prix" required name='CustomPrix[]'>
                      </div>
                      
                    </div>
                  </div>

                    <div class="row col-md-12" id="addLinesFrom">
                      <div class="col-md-3 col-sm-0"></div>
                        <div class="d-flex col-md-6 col-sm-12" style="align-items: center;">
                        <button type="button" onclick="addLine()" class="btn" style=" margin-left: 20%;border: #1f3bb357 solid 1px;border-radius: 10px;"><i class="dropdown-item-icon mdi mdi-plus text-primary me-2"></i><span >{{__('gestionDesCommandes.ajouter-une-line')}}</span></button>
                      </div>
                      <div class="col-md-3 col-sm-0"></div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 size50">
                          <label>{{__('gestionDesCommandes.total')}}</label>
                          <input type="number" name="totel" class="form-control form-control-lg"  placeholder="Montent" id="totelCommandeAjouter">
                        </div>
                        <div class="form-group col-md-6 col-sm-6 size50">
                          <button class="btn btn-primary" style="margin-top: 33px ;margin-left: 59px;"
                          onclick="GetTotalAjouter()"
                          >
                             Calculer Total
                          </button>
                        </div>
                    </div>
                    
                    <div class="row">
                      <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label>{{__('gestionDesCommandes.paye')}}</label>
                        <input type="number" name="paye" style="color: #d7d6d6;" class="form-control form-control-lg" placeholder="Payé" required>
                        </div>
                        <div class="form-group col-lg-6 col-md-12 col-sm-12">
                          <label>{{__('gestionDesCommandes.du')}}</label>
                        <input type="number" name="du" style="color: #d7d6d6;" class="form-control form-control-lg" placeholder="Dû" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">{{__('gestionDesCommandes.ajouter')}}</button>
                    <button type="reset" id="btnAnnulerAjouter" class="btn btn-light">{{__('gestionDesCommandes.annuler')}}</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <!-- end article model -->

    <!-- start article model -->
    <div class="model-background my-element" id="ModelBackgroundModifier" style="display: none;">
      <div class="row mt-2 tech" style="position: absolute;width: 100%;z-index: 6;">
          <div class="col-md-3"></div>
          <div class="col-md-5">
            <div class="card" id="bgimage" style="max-height: 650px; overflow-y: scroll;">
              <div class="card-body">
                <div class="d-flex">
                </div>
                <div class="modal-header" style="border: #d7d6d6">
                  <h2 class="modal-title">{{__('gestionDesCommandes.modifier-un-commande')}}</h2> 
                  <button type="button" class="close" style="border: white;background-color: white;"
                  onclick="closeModal()"
                  >
                    <i class="mdi mdi-close" style="font-size: 25px;"></i>
                  </button>
                </div>
                <br>
                <p class="card-description">
                    {{__('gestionDesCommandes.les-champs-de-*')}}
                </p>
                <form class="forms-sample" method="POST" action="{{route('viewUpdateCommande')}}">
                  @csrf
                  <input type="text" name="idDeCommande" style="display:none;">
                  <div class="row">
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                      <label>{{__('gestionDesCommandes.ladate')}}</label>
                      <input type="date" name="laDate" class="form-control form-control-lg" style="color: #d7d6d6;">
                    </div>
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                      <label>{{__('gestionDesCommandes.client')}}</label><br>
                      <select name="Client" id="optionClinets" class="form-control form-control-lg SelectSearch">
                        @foreach ($Clients as $Client)
                        <option value="{{$Client->id}}"> {{$Client->Nom}} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-lg-4 commandeSizeL">
                      <label>{{__('gestionDesCommandes.article')}}</label><br>
                      <select name="ArticleModifier[]" id="optionArticles" class="form-control form-control-lg articles" 
                      onchange="GetTotal()">
                        @foreach ($Articles as $Article)
                        <option value="{{$Article->id}}"> {{$Article->Nome}} </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-lg-4 commandeSize ">
                      <label>{{__('gestionDesCommandes.quantite')}}</label>
                      <input type="number" name="quantitesModifier[]" class="form-control form-control-lg quantites"  placeholder="Quantite" required>
                    </div>
                    <div class="form-group col-lg-4 commandeSize">
                        <label>Prix</label>
                        <input type="number" class="form-control form-control-lg PrixModifier"  placeholder="Prix" required name='CustomPrix[]'>
                      </div>
                  </div>

                  <div class="row col-md-12" id="addLinesFromModifier">
                    <div class="col-md-3 col-sm-0"></div>
                      <div class="d-flex col-md-6 col-sm-12" style="align-items: center;">
                      <button type="button" onclick="addLineModifer()" class="btn" style=" margin-left: 20%;border: #1f3bb357 solid 1px;border-radius: 10px;"><i class="dropdown-item-icon mdi mdi-plus text-primary me-2"></i><span >{{__('gestionDesCommandes.ajouter-une-line')}}</span></button>
                    </div>
                    <div class="col-md-3 col-sm-0"></div>
                  </div>

                  <div class="row">
                  <div class="form-group form-group col-md-6 col-sm-6 size50">
                    <label>{{__('gestionDesCommandes.total')}}</label>
                    <input type="number" name="totel" class="form-control form-control-lg"  placeholder="Montent" id="totelCommande">
                  </div>
                  <div class="form-group col-md-6 col-sm-6 size50">
                          <button type="button" class="btn btn-primary" style="margin-top: 33px ;margin-left: 59px ;"
                          onclick="GetTotal()"
                          >
                             Calculer Total
                          </button>
                  </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                      <label>{{__('gestionDesCommandes.paye')}}</label>
                      <input type="number" name="paye" style="color: #d7d6d6;" class="form-control form-control-lg" placeholder="Payé" required>
                      </div>
                      <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label>{{__('gestionDesCommandes.du')}}</label>
                      <input type="number" name="du" style="color: #d7d6d6;" class="form-control form-control-lg" placeholder="Dû" required>
                      </div>
                  </div>
                  <button type="submit" class="btn btn-primary me-2">{{__('gestionDesCommandes.modifier')}}</button>
                  <button type="reset" id="btnAnnulerModifier" class="btn btn-light">{{__('gestionDesCommandes.annuler')}}</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-2"></div>
      </div>
  </div>
  <!-- end article model -->
    @if ($errors->any())
  <div class="alert alert-danger">
     <ul>
         @foreach ($errors->all() as $error)
             <li>{{ $error }}</li>
         @endforeach
     </ul>
  </div>
  @endif
    <div class="content-wrapper" style="background: #F4F5F778;">
        <div class="d-flex justify-content-center">
          <div class="card col-md-10 col-sm-12">
            <div class="card-body">
                <h4 class="card-title">{{__('gestionDesCommandes.GCommandes')}}</h4>
                  <button class="btn btn-primary" style="padding: 7px 13px 7px 13px;" id="btnAjoutez"><div class="d-flex"><i class="mdi mdi-plus"></i>
                      <span style="padding-top: 1px;">{{__('gestionDesCommandes.ajouter')}}</span></div></button>
                      <div class="row" style="display: none;" id="hiddenIcon">
                        <div class="col-md-1">
                            <button class="btn btn-danger me-2 buttontr" onclick="selectDel()" title="Supprimer" style="padding: inherit;
                            margin-top: 20px;">
                                <i class="mdi mdi-delete"></i>
                            </button>
                        </div>
                        <script>
                            function selectDel() {
                                var allCheckInput = document.querySelectorAll(".form-check-input");
                                var Selections = [];
                                for (let i = 0; i < allCheckInput.length; i++)
                                {
                                  if(allCheckInput[i].checked == true)
                                  {
                                    var index = allCheckInput[i].value;
                                    Selections.push(parseInt(index));
                                  }
                                }

                                if(Selections.length != 0)
                                {
                                    $.ajax({
                                       type:'POST',
                                       url:"{{ Route('commandeSelectionDelete') }}",
                                       data: {
                                        '_token' : "{{csrf_token()}}" ,
                                        'Selections': Selections ,
                                      },
                                      success:function(data) {
                                        if(data == 1){
                                        location.reload();
                                        }
                                       }
                                    });
                                }

                            }
                        </script>
                    </div>
                <div class="table-responsive">
                  <table class="table table-striped" id="tableArticle">
                    <thead>
                      <tr>
                        <th>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="checkbox"  id="checkAll">
                            </label>
                          </div>
                        </th>
                        <th>
                            {{__('gestionDesCommandes.ladate')}}
                        </th>
                        <th>
                            {{__('gestionDesCommandes.client')}}
                        </th>
                        <th>
                            {{__('gestionDesCommandes.total')}}
                        </th>
                        <th>
                            {{__('gestionDesCommandes.paye')}}
                        </th>
                        <th>
                            {{__('gestionDesCommandes.du')}}
                        </th>
                        <th>
                            {{__('gestionDesCommandes.action')}}
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($Commandes as $Commande)
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" onclick="clickOnInputDel()" value="{{$Commande->id}}">
                            </label>
                          </div>
                        </td>
                        <script>

                          </script>
                        <td onclick="update({{$Commande->id}})" style="cursor:pointer;">
                          {{$Commande->date}}
                        </td>
                        <td onclick="update({{$Commande->id}})" style="cursor:pointer;">
                          {{$Commande->client->Nom}}
                        </td>
                        <td class="py-1" onclick="update({{$Commande->id}})" style="cursor:pointer;">
                          {{$Commande->total}} DH
                        </td>
                        <td class="py-1" onclick="update({{$Commande->id}})" style="cursor:pointer;">
                          {{$Commande->paye}} DH
                        </td>
                        <td class="py-1" onclick="update({{$Commande->id}})" style="cursor:pointer;">
                          {{$Commande->du}} DH
                        </td>
                        <td>
                          <button class="btn btn-primary me-2 buttontr" onclick="update({{$Commande->id}})" title="Modifier">
                              <i class="mdi mdi-lead-pencil"></i>
                          </button>
                          <button class="btn btn-danger me-2 buttontr" onclick="del({{$Commande->id}})" title="Supprimer">
                              <i class="mdi mdi-delete "></i>
                          </button>
                                            <form action="{{route('makepdfCommande')}}" method="POST" 
                                            style="display: initial;" formtarget="_blank" target="_blank">
                                            @csrf
                                            <input type="text" name="id" value="{{$Commande->id}}" style="display: none;">
                                            <button type="submit" class="btn btn-success me-2 buttontr" title="Genere une Facture">
                                                <i class="mdi mdi-file-xml "></i>
                                            </button>
                                            </form>
                          
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
        </div>
        </div>
    </div>

@stop

@section("js")
<!-- plugins:js -->
<script src="vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
<script src="vendors/select2/select2.min.js"></script>
<script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="js/off-canvas.js"></script>
<script src="js/hoverable-collapse.js"></script>
<script src="js/template.js"></script>
<script src="js/settings.js"></script>
<script src="js/todolist.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="js/file-upload.js"></script>
<script src="js/typeahead.js"></script>
<script src="js/select2.js"></script>
<script type="text/javascript" src="/vendors/DataTables/datatables.min.js"></script>
<!-- End custom js for this page-->->

<script>
        function update(id) {
          $.ajax({
               type:'POST',
               url:"{{ Route('viewGetInfoCommande') }}",
               data: {
                '_token' : "{{csrf_token()}}" ,
                'id': id ,
              },
              success:function(data) {                  
                $('#ModelBackgroundModifier').css("display", "block");
                  $('input[name="idDeCommande"]').val(data['id']);
                  $('input[name="laDate"]').val(data['date']);
                  $('input[name="totel"]').val(data['total']);
                  $('input[name="paye"]').val(data['paye']);
                  $('input[name="du"]').val(data['du']);
                  $('#optionClinets').val(data['client_id']);
                  $('#optionClinets').trigger('change');
                  getArticlesQuantite(data['id']);
               }
            });
        }
        function del(id) {
          $.ajax({
               type:'POST',
               url:"{{ Route('viewdeleteCommande') }}",
               data: {
                '_token' : "{{csrf_token()}}" ,
                'id': id ,
               },
               success:function(data) {
                if(data == 1)
                {
                  location.reload();
                }
               }
            });
        }
        function getArticlesQuantite(id) {
          $.ajax({
               type:'POST',
               url:"{{ Route('viewGetArticlesDeCommande') }}",
               data: {
                '_token' : "{{csrf_token()}}" ,
                'id': id ,
               },
               success:function(datas) {
                var quantites = document.querySelectorAll(".articles"); for(var i = 1 ; i<quantites.length ; i++){
                var tempElement = quantites[i].parentElement; var tempElement2 = tempElement.parentElement; tempElement2.remove();
                }
                
				for (let i = 1; i < datas.length; i++) {
                  var addLineElementdata = $('#BeforeLinesElementModifier').html();
                  document.getElementById('addLinesFromModifier').insertAdjacentHTML("beforebegin",addLineElementdata);
				 }	
				 
				var articlesSelection = document.querySelectorAll('#ModelBackgroundModifier .modifierArticle');
                var modifierQuantite = document.querySelectorAll('#ModelBackgroundModifier .modifierQuantite');
                var modifierPrix = document.querySelectorAll('#ModelBackgroundModifier .prixM');
                
                for (let i = 0; i < articlesSelection.length; i++) {
                    articlesSelection[i].classList.add("articles");
                }
                for (let i = 0; i < modifierQuantite.length; i++) {
                    modifierQuantite[i].classList.add("quantites");
                }
                for (let i = 0; i < modifierPrix.length; i++) {
                    modifierPrix[i].classList.add("PrixModifier");
                }

                var articles = document.querySelectorAll(".articles");
                var quantites = document.querySelectorAll(".quantites");
                var prixs = document.querySelectorAll(".PrixModifier");
                        for (let i = 0; i < datas.length; i++) {
                            var optionArticles = articles[i].children;
                            var ArticleSelected = datas[i];
                            quantites[i].value = datas[i].Quantite;
                            prixs[i].value = datas[i].CustomPrix;
                                    for (let i = 0; i < optionArticles.length; i++) {
                                        if (optionArticles[i].value == ArticleSelected.article_id) {
                                        optionArticles[i].selected = 'selected';
                                        }
                                    }
                        }

               }
            });
        }

        function addLine() {
          var addLineElement = $('#BeforeLinesElement').html();
          document.getElementById('addLinesFrom').insertAdjacentHTML("beforebegin",addLineElement);
          $('#ModelBackgroundAjouter select').select2();
        }

        function addLineModifer() {
          var addLineElement = $('#BeforeLinesElementModifier').html();
          document.getElementById('addLinesFromModifier').insertAdjacentHTML("beforebegin",addLineElement);

          var articlesSelection = document.querySelectorAll('#ModelBackgroundModifier .modifierArticle');
          var modifierQuantite = document.querySelectorAll('#ModelBackgroundModifier .modifierQuantite');
          var modifierPrix = document.querySelectorAll('#ModelBackgroundModifier .prixM');
          
          for (let i = 0; i < articlesSelection.length; i++) {
              articlesSelection[i].classList.add("articles");
          }
          for (let i = 0; i < modifierQuantite.length; i++) {
              modifierQuantite[i].classList.add("quantites");
          }
          for (let i = 0; i < modifierPrix.length; i++) {
              modifierPrix[i].classList.add("PrixModifier");
          }
        }
        
        var parentInputes = document.getElementById('checkAll');
        $("#checkAll").click(function(){
          var allCheckInput = document.querySelectorAll(".form-check-input");
          if(parentInputes.checked ==  false){
            for (let i = 0; i < allCheckInput.length; i++) {
            allCheckInput[i].checked = false;
          }
          }
          if(parentInputes.checked == true){
            for (let i = 0; i < allCheckInput.length; i++) {
            allCheckInput[i].checked = true;
          }
          }
          clickOnInputDel();
        });

    $(document).ready( function () {

      $("#btnAjoutez").click(function(){
        $('#ModelBackgroundAjouter').css("display", "block");
                                    });

        $("#btnAnnulerAjouter").click(function(){
        $('#ModelBackgroundAjouter').css("display", "none");
                                    });

        $("#btnAnnulerModifier").click(function(){
        $('#ModelBackgroundModifier').css("display", "none");
                                    });
        var parentInputes = document.getElementById('checkAll');
        $("#checkAll").click(function(){
          var allCheckInput = document.querySelectorAll(".form-check-input");
          if(parentInputes.checked ==  false){
            for (let i = 0; i < allCheckInput.length; i++) {
            allCheckInput[i].checked = false;
          }
          }
          if(parentInputes.checked == true){
            for (let i = 0; i < allCheckInput.length; i++) {
            allCheckInput[i].checked = true;
          }
          }
        });

         $('.SelectSearch').select2();

          } );
          
          

        $("#btnAjouterClient").click(function(){
        $('#AjoutezClientInCommande').css("display", "block");
                                    });
         $("#btnAnnulerAjouterClient").click(function(){
        $('#AjoutezClientInCommande').css("display", "none");
                                    });


        function clickOnInputDel()
        {
         var hiddenIcon = document.getElementById("hiddenIcon");
         hiddenIcon.style.display = "block";

         var allCheckInput = document.querySelectorAll(".form-check-input");
           let ok =  0;
           for (let i = 0; i < allCheckInput.length; i++) {
             if(allCheckInput[i].checked ==  false){
                 ok++;
             }
             }
             if(ok ==  allCheckInput.length){
                 hiddenIcon.style.display = "none";
             }
        }

            $("#btnAnnulerAjouter").click(function(){

                    var quantites = document.querySelectorAll("[name='quantite[]']"); for(var i = 2 ; i<quantites.length ; i++){
                          if(quantites[i].value == ""){ var tempElement = quantites[i].parentElement; var tempElement2 = tempElement.parentElement; tempElement2.remove();
                          }
                    }

                    var inputsFormM = document.querySelectorAll("#ModelBackgroundModifier input");
                    for(var i = 1 ; i<inputsFormM.length ; i++){
                        inputsFormM[i].value = "";
                    }

                    var inputsForm = document.querySelectorAll("#ModelBackgroundAjouter input");
                    for(var i = 1 ; i<inputsForm.length ; i++){
                        inputsForm[i].value = "";
                    }
                }); 
            
            $("#btnAnnulerModifier").click(function(){
                 var quantites = document.querySelectorAll("[name='quantitesModifier[]']"); for(var i = 2 ; i<quantites.length ; i++){
                 var tempElement = quantites[i].parentElement; var tempElement2 = tempElement.parentElement; tempElement2.remove();
                 }
                var inputsFormM = document.querySelectorAll("#ModelBackgroundModifier input");
                for(var i = 1 ; i<inputsFormM.length ; i++){
                    inputsFormM[i].value = "";
                }
                var inputsForm = document.querySelectorAll("#ModelBackgroundAjouter input");
                for(var i = 1 ; i<inputsForm.length ; i++){
                    inputsForm[i].value = "";
                }
            }); 
            
            function GetTotal(){
                var quantites = document.querySelectorAll(".quantites");
                var Prixs = document.querySelectorAll(".PrixModifier");
                var Total = 0;
                for(var i = 0 ; i<quantites.length ; i++){
                    var qte = quantites[i].value;
                    var prix = Prixs[i].value;
                    var PrixNumber = parseFloat(qte) * parseFloat(prix);
                    Total = Total + PrixNumber;
                }
                console.log(Total);
                var TotalInput = document.getElementById("totelCommande");
                TotalInput.value = Total;
            }
            
            
            
            function GetTotalAjouter(){
                var quantites = document.querySelectorAll("[name='quantite[]']");
                var Prixs = document.querySelectorAll(".PrixAjouter");
                var Total = 0;
                for(var i = 0 ; i<quantites.length ; i++){
                    var qte = quantites[i].value;
                    var prix = Prixs[i].value;
                    var PrixNumber = parseFloat(qte) * parseFloat(prix);
                    Total = Total + PrixNumber;
                }
                var TotalInput = document.getElementById("totelCommandeAjouter");
                TotalInput.value = Total;
            }
            
</script>
@stop
