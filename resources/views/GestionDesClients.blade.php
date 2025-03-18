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
        height: 100%;
    }
</style>
    <!-- start article model -->
    <div class="model-background my-element" id="ModelBackgroundAjouter" style="display: none;">
        <div class="row mt-1 tech" style="position: absolute;width: 100%;z-index: 6;">
            <div class="col-md-3"></div>
            <div class="col-md-5">
              <div class="card" id="bgimage">
                <div class="card-body">
                  <h2>{{__('gestionDClients.Ajouter-un-client')}}</h2><br>
                  <p class="card-description">
                    {{__('gestionDClients.les-champs-de-*')}}
                  </p>
                  <form class="forms-sample" action="{{route('viewaddClient')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label>{{__('gestionDClients.Lenom')}}</label>
                      <input type="text" class="form-control form-control-lg" name="nomDeClient" placeholder="Le Nom de Client" required>
                    </div>
                    <div class="form-group">
                      <label>{{__('gestionDClients.email')}}</label>
                      <input type="email" class="form-control form-control-lg" name="EmailDeClient" placeholder="Email">
                    </div>
                    <div class="form-group">
                      <label>{{__('gestionDClients.telephone')}}</label>
                      <input type="text" class="form-control form-control-lg" name="TelephoneDeCLient"  placeholder="Telephone">
                    </div>
                    <div class="form-group">
                      <label>{{__('gestionDClients.Societe')}}</label>
                      <input type="text" class="form-control form-control-lg" name="SocieteDeCLient"  placeholder="Societe De CLient">
                    </div>
                    <div class="form-group">
                      <label>{{__('gestionDClients.Image')}}</label>
                      <div class="input-group col-xs-12">
                        <input type="file" class="form-control form-control-lg" name="ImageDeCLient" placeholder="Upload Image">
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">{{__('gestionDClients.ajouter')}}</button>
                    <button type="reset" class="btn btn-light" id="btnAnnulerAjouter">{{__('gestionDClients.annuler')}}</button>
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
      <div class="row mt-1 tech" style="position: absolute;width: 100%;z-index: 6;">
          <div class="col-md-3"></div>
          <div class="col-md-5">
            <div class="card" id="bgimage">
              <div class="card-body">
                <h2>{{__('gestionDClients.modifier-un-Client')}}</h2><br>
                <p class="card-description">
                    {{__('gestionDClients.les-champs-de-*')}}
                </p>
                <form class="forms-sample" action="{{route('viewUpdateClient')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="text" name="idDeClient" style="display:none;">
                  <div class="form-group">
                    <label>{{__('gestionDClients.Lenom')}}</label>
                    <input type="text" class="form-control form-control-lg" name="nomDeClient" placeholder="Le Nom de Client" required>
                  </div>
                  <div class="form-group">
                    <label>{{__('gestionDClients.email')}}</label>
                    <input type="email" class="form-control form-control-lg" name="EmailDeClient" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <label>{{__('gestionDClients.telephone')}}</label>
                    <input type="text" class="form-control form-control-lg" name="TelephoneDeCLient"  placeholder="Telephone">
                  </div>
                  <div class="form-group">
                    <label>{{__('gestionDClients.Societe')}}</label>
                    <input type="text" class="form-control form-control-lg" name="SocieteDeCLient"  placeholder="Telephone">
                  </div>
                  <div class="form-group">
                    <label>{{__('gestionDClients.Image')}}</label>
                    <div class="input-group col-xs-12">
                      <input type="file" class="form-control form-control-lg" name="ImageDeCLient" placeholder="Upload Image">
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary me-2">{{__('gestionDClients.modifier')}}</button>
                  <button type="reset" class="btn btn-light" id="btnAnnulerModifier">{{__('gestionDClients.annuler')}}</button>
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
                <h4 class="card-title">{{__('gestionDClients.GClient')}}</h4>

                  <button class="btn btn-primary" style="padding: 7px 13px 7px 13px;" id="btnAjoutez"><div class="d-flex"><i class="mdi mdi-plus"></i>
                      <span style="padding-top: 1px;">{{__('gestionDClients.ajouter')}}</span></div></button>
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
                                       url:"{{ Route('ClientSelectionDelete') }}",
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
                            {{__('gestionDClients.Lenom')}}
                        </th>
                        <th>
                            {{__('gestionDClients.email')}}
                        </th>
                        <th>
                            {{__('gestionDClients.telephone')}}
                        </th>
                        <th>
                            {{__('gestionDClients.Societe')}}
                        </th>
                        <th>
                            {{__('gestionDClients.Image')}}
                        </th>
                        <th>
                            {{__('gestionDClients.action')}}
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($Clients as $Client)
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" onclick="clickOnInputDel()" value="{{$Client->id}}">
                            </label>
                          </div>
                        </td>
                        <td onclick="update({{$Client->id}})" style="cursor:pointer;">
                          {{$Client->Nom}}
                        </td>
                        <td onclick="update({{$Client->id}})" style="cursor:pointer;">
                          {{$Client->Email}}
                        </td>
                        <td onclick="update({{$Client->id}})" style="cursor:pointer;">
                          {{$Client->Telephone}}
                        </td>
                        <td onclick="update({{$Client->id}})" style="cursor:pointer;">
                          {{$Client->Societe}}
                        </td>
                        <td class="py-1" onclick="update({{$Client->id}})" style="cursor:pointer;">
                            <img src="{{$Client->image}}" alt="image">
                          </td>
                        <td>
                          <button class="btn btn-primary me-2 buttontr" onclick="update({{$Client->id}})"><i class="mdi mdi-lead-pencil"></i></button>
                          <button class="btn btn-danger me-2 buttontr" onclick="del({{$Client->id}})"><i class="mdi mdi-delete "></i></button>
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
               url:"{{ Route('viewGetInfoClient') }}",
               data: {
                '_token' : "{{csrf_token()}}" ,
                'id': id ,
              },
               success:function(data) {
                $('#ModelBackgroundModifier').css("display", "block");
                  $('input[name="idDeClient"]').val(data['id']);
                  $('input[name="nomDeClient"]').val(data['Nom']);
                  $('input[name="EmailDeClient"]').val(data['Email']);
                  $('input[name="TelephoneDeCLient"]').val(data['Telephone']);
                  $('input[name="SocieteDeCLient"]').val(data['Societe']);
               }
            });
        }

    function del(id) {
          $.ajax({
               type:'POST',
               url:"{{ Route('viewdeleteClient') }}",
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
