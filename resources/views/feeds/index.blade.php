@extends('layouts.admin')

@section('title', 'Feed Management')

@section('content_header')
  <h1>
    Feeds Management
    <small>feeds tables</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Feeds</a></li>
    <li class="active">Feeds table</li>
  </ol>
@stop

@section('content')
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Feed List</h3>
              <button type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#modal-default">
                Add Feed
              </button>
              <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                  <form action="{{route('feeds.create')}}" method="POST">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Feeds</h4>
                    </div>
                    <div class="modal-body">
                      <label for="title">Title</label>
                      <input type="text" class="form-control" id="feed_title" name="title" value="{{old('url')}}" placeholder="Enter RSS Title">

                      <label for="url">RSS URL</label>
                      {{ csrf_field() }}
                      <input type="hidden" name="id" id="feed_id">
                      <input type="text" class="form-control" id="feed_url" name="url" value="{{old('url')}}" placeholder="Enter RSS URL">

                      <label for="category_id" class="">Category</label>
                      <select name="category_id" id="category_id" class="form-control">
                        @foreach($cats as $cat)
                          <option value="{{$cat->id}}">{{$cat->name}}</option>
                        @endforeach
                      </select>
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
            <form method="POST" action="{{route('feeds.destroy')}}" id="form_item">
            {{ csrf_field() }}
            <div class="box-body">
              <table id="example2" class="table table-hover">
                <thead>
                <tr>
                  <th width="5%">ID</th>
                  <th>Title</th>
                  <th>Category</th>
                  <th>URL</th>
                  <th width="5%">Articles</th>
                  <th width="5%">Edit</th>
                  <th width="5%">Delete</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->title}}</td>
                            <td data-cat-id="{{ $item->categories()->first() ? $item->categories()->first()->id : ''}}" >{{$item->categories()->first() ? $item->categories()->first()->name : ''}}</td>
                            <td>{{$item->url}}</td>
                            <td><span data-toggle="tooltip" title="Articles"><a class="btn btn-primary btn-xs" data-title="Articles"  href="{{route('feeds.articles', $item->id)}}"  ><span class="glyphicon glyphicon-book"></span></a></span>
                            </td>
                           <td>
                              <button type="button" class="btn btn-primary btn-xs edit-button" data-toggle="modal" data-target="#modal-default"><span class="glyphicon glyphicon-pencil"></span></button>
                            </td>
                            <td><p data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs item_delete" data-title="Delete" name="item_delete" value="{{$item->id}}"><span class="glyphicon glyphicon-trash"></span></button></p></td>
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
      var url = $(this).parent().prev().prev().text();
      var feed_title = $(this).parent().prev().prev().prev().prev().text();
      var feed_id = $(this).parent().prev().prev().prev().prev().prev().text();
      var cat_id = $(this).parent().prev().prev().prev().data('cat-id');
      $('#feed_url').val(url);
      $('#category_id').val(cat_id);
      $('#feed_title').val(feed_title);
      $('#feed_id').val(feed_id);
    });

    $('.item_delete').on('click', function(e) {
      if (confirm("Delete Feed")) {
        $('#form_item').submit();
      } else {
      }
    });
  })
</script>
@stop