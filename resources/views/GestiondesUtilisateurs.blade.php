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
                  <h2>{{__('gestionUser.Ajouter-un-utilisateur')}}</h2><br>
                  <p class="card-description">
                    {{__('gestionUser.les-champs-de-*')}}
                  </p>
                  <form class="forms-sample" method="POST" action="{{route("viewaddUser")}}">
                    @csrf
                    <div class="form-group">
                      <label> {{__('gestionUser.Le-nom-user')}}</label>
                      <input type="text" class="form-control form-control-lg" name="name" placeholder="Le nom de Utilisateur">
                    </div>
                    <div class="form-group">
                      <label> {{__('gestionUser.email')}}</label>
                      <input type="email" class="form-control form-control-lg" name="email"  placeholder="Email de Utilisateur">
                    </div>
                    <div class="form-group">
                        <label> {{__('gestionUser.Mot-de-passe')}}</label>
                        <input type="password" class="form-control form-control-lg" name="password"  placeholder="Mot de passe">
                      </div>
                    <button type="submit" class="btn btn-primary me-2">{{__('gestionUser.ajouter')}}</button>
                    <button type="reset" class="btn btn-light" id="btnAnnulerAjouter">{{__('gestionUser.annuler')}}</button>
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
                <h2>{{__('gestionUser.modifier-un-user')}}</h2><br>
                <p class="card-description">
                    {{__('gestionUser.les-champs-de-*')}}
                </p>
                <form class="forms-sample" action="{{route('viewUpdateUser')}}" method="POST">
                  @csrf
                  <input type="text" name="idDeUser" style="display:none;">
                  <div class="form-group">
                    <label>{{__('gestionUser.Le-nom-user')}}</label>
                    <input type="text" class="form-control form-control-lg" name="name" placeholder="Le nom de Utilisateur">
                  </div>
                  <div class="form-group">
                    <label>{{__('gestionUser.email')}}</label>
                    <input type="email" class="form-control form-control-lg" name="email"  placeholder="Email de Utilisateur">
                  </div>
                  <div class="form-group">
                      <label>{{__('gestionUser.Mot-de-passe')}}</label>
                      <input type="password" class="form-control form-control-lg" name="password"  placeholder="Mot de passe">
                    </div>
                  <button type="submit" class="btn btn-primary me-2">{{__('gestionUser.modifier')}}</button>
                  <button type="reset" class="btn btn-light" id="btnAnnulerModifier">{{__('gestionUser.annuler')}}</button>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-2"></div>
      </div>
  </div>
  <!-- end article model -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @if ($errors->any())
         @foreach ($errors->all() as $error)
             <script>
                var error = '{{$error}}';
                Swal.fire({
                  title: 'Error!',
                  text: error,
                  icon: 'error',
                  confirmButtonText: 'Ok'
                });
             </script>
         @endforeach
  @endif
    <div class="content-wrapper" style="background: #F4F5F778;">
        <div class="d-flex justify-content-center">
          <div class="card col-md-9 col-sm-12">
            <div class="card-body">
                <h4 class="card-title">{{__('gestionUser.GUser')}}</h4>

                  <button class="btn btn-primary" style="padding: 7px 13px 7px 13px;" id="btnAjoutez"><div class="d-flex"><i class="mdi mdi-plus"></i>
                      <span style="padding-top: 1px;">{{__('gestionUser.ajouter')}}</span></div></button>
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
                                       url:"{{ Route('UserSelectionDelete') }}",
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
                  <table class="table table-striped " id="tableArticle">
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
                            {{__('gestionUser.Le-nom-user')}}
                          </th>
                          <th>
                            {{__('gestionUser.email')}}
                          </th>
                        <th>
                          <span style="float: right;">{{__('gestionUser.action')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach( $Users as $User)
                      <tr>
                        <td>
                            <div class="form-check">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" onclick="clickOnInputDel()" value="{{$User->id}}">
                            </label>
                          </div></td>
                          <td onclick="update({{$User->id}})" style="cursor:pointer;">
                            {{ $User->name }}
                        </td>
                        <td onclick="update({{$User->id}})" style="cursor:pointer;">
                            {{ $User->email }}
                        </td>
                        <td>
                          <button class="btn btn-primary me-2 buttontr" style="float: right;" onclick="update({{$User->id}})"><i class="mdi mdi-lead-pencil"></i></button>
                          <button class="btn btn-danger me-2 buttontr" style="float: right;" onclick="del({{$User->id}})"><i class="mdi mdi-delete "></i></button>
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
               url:"{{ Route('viewGetInfoUser') }}",
               data: {
                '_token' : "{{csrf_token()}}" ,
                'id': id ,
              },
               success:function(data) {
                console.log(data);
                $('#ModelBackgroundModifier').css("display", "block");
                   $('input[name="idDeUser"]').val(data['id']);
                   $('input[name="name"]').val(data['name']);
                   $('input[name="email"]').val(data['email']);
               }
            });
        }

    function del(id) {
          $.ajax({
               type:'POST',
               url:"{{ Route('viewdeleteUser') }}",
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
