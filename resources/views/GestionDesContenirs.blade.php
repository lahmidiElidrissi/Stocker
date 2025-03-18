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
</style>
    <!-- ajouter Contenir -->
    <div class="model-background my-element" id="ModelBackgroundAjouter" style="display: none;">
        <div class="row mt-5 tech" style="position: absolute;width: 100%;z-index: 6;">
            <div class="col-md-3"></div>
            <div class="col-md-5">
              <div class="card" id="bgimage">
                <div class="card-body">
                  <h2>{{__('gestionContenir.Ajouter-un-Contenir')}}</h2><br>
                  <p class="card-description">
                    {{__('gestionContenir.les-champs-de-*')}}
                  </p>
                  <form class="forms-sample" action="{{route('viewaddContenir')}}" method="POST">
                    @csrf
                    <div class="form-group">
                      <label>{{__('gestionContenir.referance')}}</label>
                      <input type="text" class="form-control form-control-lg" name="referance" placeholder="Code de Contenir" required>
                    </div>
                    <div class="form-group">
                      <label>{{__('gestionContenir.Paye-de-Contenir')}}</label>
                      <select class="form-control form-control-lg SelectSearch" name="pays" required>
                        @foreach($pays as $pay)
                          <option value="{{$pay->nom_en_gb}}">{{$pay->nom_en_gb}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>{{__('gestionContenir.ladate')}}</label>
                        <input id="testhere" type="date" class="form-control form-control-lg" name="dateDeEntree" style="color: #d7d6d6;" required value="">
                    </div>
                    <div class="form-group">
                      <label>{{__('gestionContenir.Fournisseur')}}</label>
                      <select class="form-control form-control-lg SelectSearch" name="fournisseur" style="padding: 20px;" required>
                        @foreach($fournisseurs as $fournisseur)
                        <option value="{{$fournisseur->id}}">{{$fournisseur->Nom}}</option>
                        @endforeach
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">{{__('gestionContenir.ajouter')}}</button>
                    <button type="reset" class="btn btn-light" id="btnAnnulerAjouter">{{__('gestionContenir.annuler')}}</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <!-- end ajouter Contenir -->
    <!-- Modifier Contenir -->
    <div class="model-background my-element" id="ModelBackgroundModifier" style="display: none;">
      <div class="row mt-5 tech" style="position: absolute;width: 100%;z-index: 6;">
          <div class="col-md-3"></div>
          <div class="col-md-5">
            <div class="card" id="bgimage">
              <div class="card-body">
                <h2>{{__('gestionContenir.modifier-un-Fournisseur')}}</h2><br>
                <p class="card-description">
                    {{__('gestionContenir.les-champs-de-*')}}
                </p>
                <form class="forms-sample" method="POST" action="{{route('viewUpdateContenir')}}">
                  @csrf
                  <input type="text" name="idDeContenir" style="display:none;" value="">
                  <div class="form-group">
                    <label>{{__('gestionContenir.referance')}}</label>
                    <input type="text" class="form-control form-control-lg" name="referance" placeholder="Code de Contenir" required>
                  </div>
                  <div class="form-group">
                    <label>{{__('gestionContenir.Paye-de-Contenir')}}</label>
                    <select id="optionPayes" class="form-control form-control-lg" name="pays" required>
                      @foreach($pays as $pay)
                      <option value="{{$pay->nom_en_gb}}">{{$pay->nom_en_gb}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>{{__('gestionContenir.ladate')}}</label>
                      <input type="date" class="form-control form-control-lg" name="dateDeEntree" style="color: #d7d6d6;" required value="">
                  </div>
                  <div class="form-group">
                    <label>{{__('gestionContenir.Fournisseur')}}</label>
                    <select class="form-control form-control-lg" id="optionFournissuer" name="fournisseur" required>
                      @foreach($fournisseurs as $fournisseur)
                      <option value="{{$fournisseur->id}}">{{$fournisseur->Nom}}</option>
                      @endforeach
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary me-2">{{__('gestionContenir.modifier')}}</button>
                  <button type="reset" class="btn btn-light" id="btnAnnulerModifier">{{__('gestionContenir.annuler')}}</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-2"></div>
      </div>
  </div>
  <!-- end Modifier Contenir -->
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
                <h4 class="card-title">{{__('gestionContenir.GC')}}</h4>

                  <button class="btn btn-primary" style="padding: 7px 13px 7px 13px;" id="btnAjoutez"><div class="d-flex"><i class="mdi mdi-plus"></i>
                      <span style="padding-top: 1px;">{{__('gestionContenir.ajouter')}}</span></div></button>
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
                                       url:"{{ Route('ContenirSelectionDelete') }}",
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
                              <input type="checkbox" id="checkAll">
                            </label>
                          </div>
                        </th>
                        <th>
                            {{__('gestionContenir.referance')}}
                        </th>
                        <th>
                            {{__('gestionContenir.Paye-de-Contenir')}}
                        </th>
                        <th>
                            {{__('gestionContenir.ladate')}}
                        </th>
                        <th>
                            {{__('gestionContenir.Fournisseur')}}
                        </th>
                        <th>
                            {{__('gestionContenir.action')}}
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($contenirs as $contenir)
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" onclick="clickOnInputDel()" value="{{$contenir->id}}">
                            </label>
                          </div>
                        </td>
                        <td class="py-1" onclick="update({{$contenir->id}})" style="cursor:pointer;">
                          {{$contenir->Referance}}
                        </td>
                        <td onclick="update({{$contenir->id}})" style="cursor:pointer;">
                          {{$contenir->PayeOrigine}}
                        </td>
                        <td onclick="update({{$contenir->id}})" style="cursor:pointer;">
                          {{$contenir->DateEntree}}
                        </td>
                        <td onclick="update({{$contenir->id}})" style="cursor:pointer;">
                            @if ($contenir->fournisseur)
                            {{$contenir->fournisseur->Nom}}
                            @endif
                        </td>
                        <td>
                          <button class="btn btn-primary me-2 buttontr" onclick="update({{$contenir->id}})"><i class="mdi mdi-lead-pencil"></i></button>
                          <button class="btn btn-danger me-2 buttontr" onclick="del({{$contenir->id}})"><i class="mdi mdi-delete "></i></button>
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
               url:"{{ Route('viewGetInfoContenir') }}",
               data: {
                '_token' : "{{csrf_token()}}" ,
                'id': id ,
              },
               success:function(data) {
                $('#ModelBackgroundModifier').css("display", "block");
                  $('input[name="idDeContenir"]').val(data['id']);
                  $('input[name="referance"]').val(data['Referance']);
                  $('input[name="dateDeEntree"]').val(data['DateEntree']);
                  var payeSelected = data['PayeOrigine'];
                  var payes = $('#optionPayes').children('option');
                  for (let i = 0; i < payes.length; i++) {
                    if (payes[i].value == payeSelected) {
                      payes[i].selected = 'selected';
                    }
                  }

                  var FournissuerSelected = data['fournisseur_id'];
                  var Fournissuers = $('#optionFournissuer').children('option');
                  $('#optionPayes').val(data['PayeOrigine']);
                  $('#optionPayes').trigger('change');
               }
            });
        }

    function del(id) {
          $.ajax({
               type:'POST',
               url:"{{ Route('viewdeleteContenir') }}",
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
          clickOnInputDel();
        });

                                   } );

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
        $('.SelectSearch').select2();
        
        $('#optionPayes').select2()
        
        $("#btnAnnulerAjouter").click(function(){
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
                var inputsFormM = document.querySelectorAll("#ModelBackgroundModifier input");
                for(var i = 1 ; i<inputsFormM.length ; i++){
                    inputsFormM[i].value = "";
                }
                var inputsForm = document.querySelectorAll("#ModelBackgroundAjouter input");
                for(var i = 1 ; i<inputsForm.length ; i++){
                    inputsForm[i].value = "";
                }
            }); 
</script>
@stop
