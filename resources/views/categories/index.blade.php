@extends('layouts.admin')

@section('title', 'Category Management')

@section('content_header')
  <h1>
    Categories Management
    <small>categories table</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Categories</a></li>
    <li class="active">Categories table</li>
  </ol>
@stop

@section('content')
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Feed List</h3>
              <button type="button" class="btn btn-default pull-right" id="add-category" data-toggle="modal" data-target="#modal-default">
                Add Category
              </button>
              <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                  <form action="{{route('categories.create')}}" method="POST">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Categories</h4>
                    </div>
                    <div class="modal-body">
                      <label for="url">Name</label>
                      {{ csrf_field() }}
                      <input type="hidden" name="id" id="category_id">
                      <input type="text" class="form-control" id="category_name" name="name" value="{{old('name')}}" placeholder="Enter Category">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
                  </form>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            </div>

            <!-- /.box-header -->
            <form method="POST" action="{{route('categories.destroy')}}" id="categories-destroy">
            {{ csrf_field() }}
            <input type="hidden" name="delete_id" id="delete_id">
            <div class="box-body">
              <table id="example2" class="table table-hover">
                <thead>
                <tr>
                  <th width="5%">ID</th>
                  <th>Name</th>
                  <th width="5%">Edit</th>
                  <th width="5%">Delete</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>
                              <button type="button" class="btn btn-primary btn-xs edit-button" data-toggle="modal" data-target="#modal-default"><span class="glyphicon glyphicon-pencil"></span></button>
                            </td>
                            <td><p data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs category_delete" data-title="Delete" name="category_delete" value="{{$item->id}}"><span class="glyphicon glyphicon-trash"></span></button></p></td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
            </form>

          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
@stop
@section('js')
<script>
  $(function () {
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
    $('.edit-button').on('click', function() {
      var cat_name = $(this).parent().prev().text();
      var cat_id = $(this).parent().prev().prev().text();
      $('#category_name').val(cat_name);
      $('#category_id').val(cat_id);
    });
    $('#add-category').on('click', function(e) {
      $('#category_id').val('');
    });
    $('.category_delete').on('click', function(e) {
      if (confirm("Delete Category")) {
        $('#categories-destroy').submit();
      } else {
      }
    });
  })
</script>
@stop