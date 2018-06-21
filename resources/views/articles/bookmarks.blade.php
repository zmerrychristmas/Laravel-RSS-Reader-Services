@extends('layouts.admin')

@section('title', 'Category Management')

@section('content_header')
  <h1>
    Articles Management
    <small>articles table</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Articles</a></li>
    <li class="active">Articles table</li>
  </ol>
@stop

@section('content')
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Bookmarks</h3>
            </div>
            <div class="box-body">
              <table id="example2" class="table table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Link</th>
                  <th>PubDate</th>
                  <th>Bookmark</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td><a href="{{$item->url}}">{{$item->title}}</a></td>
                            <td>{{strftime('%m/%d/%Y %I:%M %p', strtotime($item->pub_date))}}</td>
                            <td><input type="checkbox" value="{{$item->link}}" name="article_link" data-url="{{$item->url}}" data-pubdate="{{$item->pub_date}}" data-title="{{$item->title}}" class=" bookmark" checked="checked"></td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->

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
    $('.bookmark').on('change', function() {
      if($(this).is(':checked')) {
        var title = $(this).data('title');
        var url = $(this).data('url');
        var pubdate = $(this).data('pubdate');
        $.ajax({
            url: "{{route('articles.add')}}",
            method: 'POST',
            data: {
                '_token': "{{csrf_token()}}",
                'url': url,
                'title': title,
                'pubdate': pubdate,
            },
            error: function (xhr, error) {
                console.log(error);
                self.loading = false;
                //location.reload();
            },
            success: function () {
            }
        });
      } else {
        var url = $(this).data('url');
        $.ajax({
            url: "{{route('articles.delete')}}",
            method: 'POST',
            data: {
                '_token': "{{csrf_token()}}",
                'url': url
            },
            error: function (xhr, error) {
                console.log(error);
                self.loading = false;
            },
            success: function () {
            }
        });
      }
    });
  })
</script>
@stop