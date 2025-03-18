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
   <!-- start article model -->
    <div class="model-background my-element" id="ModelBackgroundAjouter" style="display: none;">
        <div class="row mt-5 tech" style="position: absolute;width: 100%;z-index: 6;">
            <div class="col-md-3"></div>
            <div class="col-md-5">
              <div class="card" id="bgimage">
                <div class="card-body">
                  <h2>{{__('gestionArticle.ajouter-un-article')}}</h2><br>
                  <p class="card-description">
                    {{__('gestionArticle.les-champs-de-*')}}
                  </p>
                  <form class="forms-sample needs-validation" method="POST" action="{{route('viewaddArticle')}}" enctype="multipart/form-data" novalidate>
                    @csrf
                    
                    <div class="form-group has-validation">
                          <label for="exampleInputEmail1">{{__('gestionArticle.lenom-article')}}</label>
                          <input type="text" name="NomDeArticle" class="form-control form-control-lg" placeholder="Nom De Article" value="" required>
                          <div class="invalid-feedback">
                            Champ Nom D'Article Obligatoire
                          </div>
                    </div>
                    
                    <div class="d-flex">
                      <div class="form-group col-md-5 has-validation">
                          <label for="exampleInputEmail1">{{__('gestionArticle.Prix')}}</label>
                          <input type="number" name="PrixDeArticle" class="form-control form-control-lg" placeholder="Prix De Article" value="" required>
                          <div class="invalid-feedback">
                            Champ Prix Obligatoire
                          </div>
                      </div>
                      <div class="col-md-1"></div>
                      <div class="form-group col-md-5">
                          <label for="exampleInputEmail1">{{__('gestionArticle.Referance')}}</label>
                          <input type="text" name="ReferanceDeArticle" class="form-control form-control-lg" placeholder="Code de Referance" value="">
                      </div>
                    </div>
                    <div class="form-group has-validation">
                      <label for="exampleInputPassword1">{{__('gestionArticle.Categorie')}}</label>
                      <select class="form-control form-control-lg" name="CategorieDeArticle" id="SelectAjouter" required>
                        @foreach($categories as $categorie)
                        <option value="{{$categorie->id}}">{{$categorie->NomeCategorie}}</option>
                        @endforeach
                      </select>
                      <div class="invalid-feedback">
                            Champ Categorie Obligatoire , pour ajouter une categorie <a href="{{route('viewGestionDesCategories')}}">cliquer ici</a>
                      </div>
                    </div>
                    <div class="d-flex">
                      <div class="form-group col-md-12">
                          <label>{{__('gestionArticle.image-article')}}</label>
                          <div class="input-group col-xs-12">
                            <input  type="file" class="form-control form-control-lg" name="ImageDeArticle" placeholder="Upload Image">
                          </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-2" id="submit-for-validation">{{__('gestionArticle.ajouter')}}</button>
                    <button type="reset" class="btn btn-light" id="btnAnnulerAjouter">{{__('gestionArticle.annuler')}}</button>
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
      <div class="row mt-5 tech" style="position: absolute;width: 100%;z-index: 6;">
          <div class="col-md-3"></div>
          <div class="col-md-5">
            <div class="card" id="bgimage">
              <div class="card-body">
                <h2>{{__('gestionArticle.modifier')}}</h2><br>
                <p class="card-description">
                    {{__('gestionArticle.les-champs-de-*')}}
                </p>
                <form class="forms-sample" method="POST" action="{{route('viewUpdateArticle')}}" enctype="multipart/form-data">
                  @csrf
                  <input type="text" name="idDeArticle" style="display:none;" value="">
                  <div class="form-group">
                        <label for="exampleInputEmail1">{{__('gestionArticle.lenom-article')}}</label>
                        <input type="text" name="NomDeArticle" class="form-control form-control-lg" placeholder="Nom De Article" required>
                  </div>
                  <div class="d-flex">
                    <div class="form-group col-md-5">
                        <label for="exampleInputEmail1">{{__('gestionArticle.Prix')}}</label>
                        <input type="number" name="PrixDeArticle" class="form-control form-control-lg" placeholder="Prix De Article" required>
                    </div><div class="col-md-1"></div>
                    <div class="form-group col-md-5">
                        <label for="exampleInputEmail1">{{__('gestionArticle.Referance')}}</label>
                        <input type="text" name="ReferanceDeArticle" class="form-control form-control-lg" placeholder="Code de Referance" >
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">{{__('gestionArticle.Categorie')}}</label>
                    <select class="form-control form-control-lg" name="CategorieDeArticle" id="SelectModifier">
                      @foreach($categories as $categorie)
                      <option value="{{$categorie->id}}">{{$categorie->NomeCategorie}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="d-flex">
                    <div class="form-group col-md-12">
                        <label>{{__('gestionArticle.image-article')}}</label>
                        <div class="input-group col-xs-12">
                          <input  type="file" class="form-control form-control-lg" name="ImageDeArticle" placeholder="Upload Image">
                        </div>
                      </div>
                  </div>
                  <button type="submit" class="btn btn-primary me-2">{{__('gestionArticle.modifier')}}</button>
                  <button type="reset" class="btn btn-light" id="btnAnnulerModifier">{{__('gestionArticle.annuler')}}</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-2"></div>
      </div>
  </div>
  <!-- end article model -->
  <div class="model-background my-element" id="ModelShow" style="display: none;">
                 <div class="row mt-5 tech" style="position: absolute;width: 100%;z-index: 6;">
                                   <div class="col-md-3"></div>
                                                 <div class="col-md-5">
                                                           <div class="card" id="bgimage" style="margin-top:100px">
                                                                       <div class="card-body">
                 <div class="row" style="float:right;cursor:pointer;" onclick="anyClose()"> <i class="mdi mdi-close-circle-outline" style="transform: scale(1.3);"></i> </div>
                 <table class="table">
                      <thead>
                          <th>{{__('gestionArticle.lenom-article')}}</th>
                          <th>{{__('gestionArticle.Referance')}}</th>
                          <th>{{__('gestionArticle.Prix')}}</th>
                          <th>{{__('gestionArticle.image-article')}}</th>
                      </thead>
                        <tbody>
                        <tr>
                        <td><label name="NArticle"></label></td>
                        <td><label name="RDeArticle"></label></td>
                        <td> <label name="PArticle" ></label></td>
                        <td width='400px' style="height: 200px;"><img src='' id='IDeArticle' style="width: 250px; height: auto;"></td>
                        </tr>
                        </tbody>
                  </table>
                                                                       </div>
                                                           </div>
                                                 </div>
                                   <div class="col-md-2"></div>
                 </div>
  </div>
  @if ($errors->any())
  <div class="alert alert-danger">
     <ul>
         @foreach ($errors->all() as $error)
             <li>{{ $error }}</li>
         @endforeach
     </ul>
  </div>
  @endif
    <div class="content-wrapper" style="background: #F4F5F778;" >
        <div class="d-flex justify-content-center">
          <div class="card col-md-10 col-sm-12">
            <div class="card-body">
              <h4 class="card-title">{{__('gestionArticle.GArt')}}</h4>

                <button class="btn btn-primary" style="padding: 7px 13px 7px 13px;" id="btnAjoutez"><div class="d-flex"><i class="mdi mdi-plus"></i>
                    <span style="padding-top: 1px;">{{__('gestionArticle.ajouter')}}</span></div></button>
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
                                       url:"{{ Route('ArticleSelectionDelete') }}",
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
                        {{__('gestionArticle.image-article')}}
                      </th>
                      <th>
                        {{__('gestionArticle.lenom-article')}}
                      </th>
                      <th>
                        {{__('gestionArticle.Prix')}}
                      </th>
                      <th>
                        {{__('gestionArticle.Referance')}}
                      </th>
                      <th>
                        {{__('gestionArticle.Categorie')}}
                      </th>
                      <th>
                        <center>
                            {{__('gestionArticle.action')}}
                        </center>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($articles as $article)
                    <tr>
                      <td onclick="show({{$article->id}})" style="cursor:pointer;">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" onclick="clickOnInputDel()" value="{{$article->id}}">
                          </label>
                        </div>
                      </td>
                      <td class="py-1" onclick="show({{$article->id}})" style="cursor:pointer;">
                        <img src="{{$article->image}}" alt="image" style="width: 52px; height: 49px;">
                      </td>
                      <td onclick="show({{$article->id}})" style="cursor:pointer;">
                        {{$article->Nome}}
                      </td>
                      <td onclick="show({{$article->id}})" style="cursor:pointer;">
                        {{$article->Prix}}
                      </td>
                      <td onclick="show({{$article->id}})" style="cursor:pointer;">
                        {{$article->Referance}}
                      </td>
                      <td onclick="show({{$article->id}})" style="cursor:pointer;">
                        @if ($article->categorie)
                        {{$article->categorie->NomeCategorie}}
                        @endif
                      </td>
                      <td>
                        <center>
                          <button class="btn btn-primary me-2 buttontr" onclick="update({{$article->id}})"><i class="mdi mdi-lead-pencil"></i></button>
                          <button class="btn btn-danger me-2 buttontr" onclick="del({{$article->id}})"><i class="mdi mdi-delete "></i></button>
                        </center>
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
<script src="js/validation-bootstrap.js"></script>
<!-- End custom js for this page-->->

<script>
    $('#SelectAjouter').select2();
    $('#SelectModifier').select2();

    function update(id) {
          $.ajax({
               type:'POST',
               url:"{{ Route('viewGetInfoArticle') }}",
               data: {
                '_token' : "{{csrf_token()}}" ,
                'id': id ,
              },
              success:function(data) {
                $('#ModelBackgroundModifier').css("display", "block");
                  //console.log(data);
                  $('input[name="idDeArticle"]').val(data['id']);
                  $('input[name="NomDeArticle"]').val(data['Nome']);
                  $('input[name="PrixDeArticle"]').val(data['Prix']);
                  $('input[name="ReferanceDeArticle"]').val(data['Referance']);
                  var categorieSelected = data['categorie_id'];
                  $('#SelectModifier').val(data['categorie_id']);
                  $('#SelectModifier').trigger('change');
               }
            });
        }
        function del(id) {
          $.ajax({
               type:'POST',
               url:"{{ Route('viewdeleteArticle') }}",
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
        $("#checkAll").click(function(){
          var allCheckInput = document.querySelectorAll(".form-check-input");
          if(allCheckInput[0].checked ==  false){
            for (let i = 0; i < allCheckInput.length; i++) {
            allCheckInput[i].checked = false;
          }
          }
          if(allCheckInput[0].checked == true){
            for (let i = 0; i < allCheckInput.length; i++) {
            allCheckInput[i].checked = true;
          }
          }
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
        function show(id){
            
             $.ajax({
               type:'POST',
               url:"{{ Route('viewGetInfoArticle') }}",
               data: {
                '_token' : "{{csrf_token()}}" ,
                'id': id ,
              },
              success:function(data) {
                  console.log(data);
                $('#ModelShow').css("display", "block");
                  $('label[name="NArticle"]').text(data['Nome']);
                  $('label[name="PArticle"]').text(data['Prix']);
                  $('label[name="RDeArticle"]').text(data['Referance']);
                  $('#IDeArticle').attr("src",data['image']);
               }
            });
        }
        function anyClose(){
             $('#ModelShow').css("display", "none");
        }
        
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
