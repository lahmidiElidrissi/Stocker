@extends('master')

@section('partialContent')
<style>
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
    .model-background {
        position: absolute !important;
    }
</style>
<div class="content-wrapper" style="background: #F4F5F778;">
    <div class="d-flex justify-content-center">
      <div class="card col-md-9 col-sm-12">
      <div class="card-body">
            <h4 class="card-title d-flex justify-content-center">{{__('Dashbord.Top-Client')}}</h4>
            <div class="table-responsive">
              <table class="table table-striped" id="tableArticle">
                <thead>
                  <tr>
                    <th>
                      {{__('gestionDClients.Lenom')}}
                    </th>
                    <th>
                        {{__('gestionAchats.total')}}
                    </th>
                    <th>
                        {{__('gestionAchats.ladate')}}
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($TopClient as $TopClientOne)
                  <tr>
                    <td>
                        <b>{{$TopClientOne->name}}</b>
                    </td>
                    <td>
                     <b> {{$TopClientOne->totalprix}} DH </b>
                    </td>
                    <td>
                     <b> {{$TopClientOne->dates}} </b>
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
    $(document).ready( function () {
                           } );
</script>
@stop
