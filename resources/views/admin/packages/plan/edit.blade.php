@extends('layouts.admin')
@section('content')
  <!-- Content Header (Category header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{ __('Edit Package Plan') }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin')}}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Edit Package Plan') }}</li>
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
          <form role="form" action="{{ url(Admin_Prefix.'package-plan/update/') }}"  method="post" enctype="multipart/form-data" class="customValidate">
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
                      <option value="{{ $category->id }}" @if($category->id == $list->category_id){{ 'selected' }}@endif >{{ $category->title }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Title</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="title" id="title" placeholder="Enter ..." value="{{ $list->title }}" required>
                </div>
              </div>

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Sub Title</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="sub_title" id="sub_title" placeholder="Enter ..." value="{{ $list->sub_title }}">
                </div>
              </div>

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Price</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="price" id="price" placeholder="Enter ..." value="{{ $list->price }}">
                </div>
              </div>

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Discount Price</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="discount_price" id="discount_price" placeholder="Enter ..." value="{{ $list->discount_price }}">
                </div>
              </div>

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Discount Persentage</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="discount_percentage" id="discount_percentage" placeholder="Enter ..." value="{{ $list->discount_percentage }}">
                </div>
              </div>

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Content Title</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="content_title" id="content_title" placeholder="Enter ..." value="{{ $list->content_title }}">
                </div>
              </div>

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Content Title</label>
                <div class="col-sm-10">
                  <textarea class="form-control ckeditor" name="content" id="content" placeholder="Enter ...">{{ $list->content }}</textarea>
                </div>
              </div>

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Button Text</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="button_text" id="button_text" placeholder="Enter ..." value="{{ $list->button_text }}" required>
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
