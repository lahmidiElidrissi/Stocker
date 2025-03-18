@extends('master')

@section('partialContent')
<style>
    .dataTables_length{
        display: none;
    }
    tr{
        height:60px;
    }
    #tableArticle_filter{
        display: none;
    }
</style>
<div class="content-wrapper" style="background: #F4F5F778;">
    <div class="d-flex justify-content-center">
      <div class="card col-md-9 col-sm-12">
        <div class="card-body">
            <h4 class="card-title d-flex justify-content-center">Notification</h4>
            <div class="table-responsive">
              <table class="table table-striped " id="tableArticle">
                <thead>
                  <tr>
                    <th>

                    </th>
                    <th>

                    </th>
                    <th>
                        
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($TopProductForSale as $TopProductForSaleOne)
                  <tr>
                    <td>
                     <b>{{$TopProductForSaleOne->Nome}}</b>
                    </td>
                    <td>
                    <b>{{$TopProductForSaleOne->Total_Quantite}}</b>
                    </td>
                    <td>
                     <b> {{$TopProductForSaleOne->Total_Prix}} DH</b>
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
        $('#tableArticle').DataTable(
              {"ordering": false;"paging": false}
         );
                           } );
</script>
@stop
