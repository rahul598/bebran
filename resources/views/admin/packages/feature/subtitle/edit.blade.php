@extends('layouts.admin')
@section('content')
  <!-- Content Header (Category header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{ __('Edit Package Feature Sub Title') }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin')}}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Edit Package Feature Sub Title') }}</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
<style type="text/css">
  .card-title{font-weight: 600;}
  .control-label{font-weight: 400 !important;}
</style>
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">  
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header with-border">
            <h3 class="card-title">Update</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" action="{{ url(Admin_Prefix.'feature-sub-title/update/') }}"  method="post" enctype="multipart/form-data" class="customValidate">
            @csrf
            <input type="hidden" name="id" value="{{$list->id}}">
            <div class="card-body">
              
            <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Pages</label>
                <div class="col-sm-10">
                  <select class="form-control" name="page_id" id="page_id" required>
                    @foreach($all_pages as $pages)
                      <option value="{{ $pages->id }}" @if($pages->id == $list->page_id){{ 'selected' }}@endif >{{ $pages->page_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Category</label>
                <div class="col-sm-10">
                  <select class="form-control" name="category_id" id="category_id" required>
                    @foreach($package_category as $category)
                      <option value="{{ $category->id }}" @if($category->id == $list->category_id) selected @endif>{{ $category->title }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Title</label>
                <div class="col-sm-10">
                  <select class="form-control" name="title_id" id="title_id" required>
                    @foreach($title as $value)
                      <option value="{{ $value->id }}" @if($value->id == $list->title_id ){{ 'selected' }}@endif >{{ $value->title }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Sub Title</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="sub_title" id="sub_title" placeholder="Enter ..." value="{{ $list->sub_title }}" required>
                </div>
              </div>

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Rank</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="rank" id="rank" placeholder="Enter ..." value="{{ $list->rank }}" >
                </div>
              </div>

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Status</label>
                <div class="col-sm-10">
                  <select name="status" id="status" class="form-control">
                    <option value="1" {!!$list->status=='1'?'selected':''!!}>Active</option>
                    <option value="0" {!!$list->status=='0'?'selected':''!!}>Inactive</option>
                  </select>
                </div>
              </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
              </div>

            </form>
          </div>
          <!-- /.card -->

        </div>


      </div>
      <!-- /.row -->
  </div>
    </section>
    <!-- /.content -->

  <!-- /.content-wrapper -->

@endsection
