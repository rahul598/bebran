@extends('layouts.admin')
@section('content')
@php
    $page_display_in_array = unserialize(Page_Display_In_Array);
    $page_template_array = unserialize(Page_Template_Array);
    
    $page_section_array = unserialize(Page_Section_Array);
    
    $category_id = $page->category->pluck('id')->toArray();
@endphp
  <!-- Content Header (Blog header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{ __('Edit Portfolio') }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin')}}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Edit Portfolio') }}</li>
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
          <form role="form" action="{{ url(Admin_Prefix.'page/update/') }}"  method="post" enctype="multipart/form-data" class="customValidate">
            @csrf
            <input type="hidden" name="id" value="{{$page->id}}">
            <input type="hidden" name="posttype" value="portfolio">
            <input type="hidden" name="display_in" value="{{$page->display_in}}">

            <div class="card-body">

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Title</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control module_name" name="page_name" id="page_name" required placeholder="Enter ..." value="{{$page->page_name}}">
                </div>
              </div>

              <!--@if($page->id!='1')-->
              <!--<div class="form-group row clearfix">-->
              <!--  <label class="col-sm-2 control-label">Title</label>-->
              <!--  <div class="col-sm-10">-->
              <!--    <input type="text" class="form-control" name="page_title" id="page_title" placeholder="Enter ..." value="{{$page->page_title}}">-->
              <!--  </div>-->
              <!--</div>-->
              <!--@endif-->

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Slug</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control module_slug" name="slug" id="slug" placeholder="Enter ..." value="{{ $page->slug }}" required @if(1>=$page->id) readonly @endif>
                </div>
              </div>

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Category</label>
                <div class="col-sm-10">
                  <select name="category_id" class="form-control select2" data-placeholder="Select">
                    <option value="">Select Category</option>
                    @foreach($portfolio_categories as $key => $value)
                    <option value="{!! $value->id !!}" @if($value->id == $page->portfolio_category) selected @endif>{!! $value->name !!}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Meta Tag</label>
                <div class="col-sm-10">
                  <textarea type="text" class="form-control" name="meta_tag" placeholder="Enter ...">{{ $page->meta_tag }}</textarea>
                </div>
              </div>

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Meta Title</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="meta_title" placeholder="Enter ..." value="{{ $page->meta_title }}">
                </div>
              </div>

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Meta Keyword</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="meta_keyword" placeholder="Enter ...">{{ $page->meta_keyword }}</textarea>
                </div>
              </div>
               <div class="form-group row clearfix">
                @if($page->id>1)
                <label class="col-sm-2 control-label">Status</label>
                <div class="col-sm-2">
                  <select name="status" id="status" class="form-control">
                    <option value="1" {!!$page->status=='1'?'selected':''!!}>Active</option>
                    <option value="0" {!!$page->status=='0'?'selected':''!!}>Inactive</option>
                  </select>
                </div>
                @endif
              </div> 
              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Meta Description</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="meta_description" placeholder="Enter ...">{{ $page->meta_description }}</textarea>
                </div>
              </div>
                    <div class="form-group row clearfix">
                      <label class="col-sm-2 control-label">Page Content</label>
                      <div class="col-sm-10">
                        <textarea name="body" class="ckeditor" placeholder="Enter ...">{!! $page->body !!}</textarea>
                      </div>
                    </div>
         
                <div class="form-group row clearfix bannerimage">
                    <label class="col-sm-2 control-label">Image</label>
                    <div class="col-sm-10">
                      <input type="file" name="bannerimage" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
                      Mime Type: webp, Max image upload size 2 Mb<br>
                      <div class="clearfix">
                        <?php
                        if($page->bannerimage && File::exists(public_path('uploads/'.$page->bannerimage)) )
                          {
                            ?>
                            <img src="{{ asset('/uploads/'.$page->bannerimage) }}" style="margin: 10px 0 0 0;max-width: 300px;">
                            <?php
                          }
                          ?>
                        </div>
                    </div>
                </div>
                
                <div class="form-group row clearfix bannerimage">
                  <label class="col-sm-2 control-label">Image 2</label>
                    <div class="col-sm-10">
                      <input type="file" name="image2" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
                      Mime Type: webp, Max image upload size 2 Mb<br>
                      <div class="clearfix">
                        <?php
                        if($page->image2 && File::exists(public_path('uploads/'.$page->image2)) )
                          {
                            ?>
                            <img src="{{ asset('/uploads/'.$page->image2) }}" style="margin: 10px 0 0 0;max-width: 300px;">
                            <?php
                          }
                          ?>
                        </div>
                    </div>
                </div>

                <?php $type=''; $i=0;$content_count=0;$banner_count=0;$type_count=0;
                $all_type = [];
                ?>
                  <div class="section_1">
                @foreach($page_extra as $val)
                  @if($val->type!='0')
                  <?php
                  if (!in_array($val->type, $all_type)) {
                    $all_type[] = $val->type;
                  }
                  if (($type=='' || $type!=$val->type)) {    $i++;
                    if ($type!='' && $type!=$val->type) {
                      $content_count=0;
                      echo '</div><div class="section_'.$val->type.'">';
                    }
                  ?>
                  <div class="card-header with-border" style="margin-bottom: 15px;">
                    <h3 class="card-title {{$val->type}}">Section
                      {{-- @if($val->type==6 && $page->id=='1') {{$type_count}} Boxes
                        @elseif($val->type==8 && $page->id=='1') {{$type_count}} Content
                        @elseif($val->type==4 && $page->page_template=='4') FAQ
                        @else  --}}
                        @php($type_count++)
                        {{$type_count}} 
                        {{-- @endif  --}}
                    </h3>
                  </div>
                  <?php
                  }
                  $content_count++;
                  ?>
                  @if($val->status_show=='1')
                    <div class="form-group row clearfix">
                      <label class="col-sm-2 control-label">Show/Hide</label>
                      <div class="col-sm-10">
                        <input type="checkbox" name="section_status_{{$val->id}}" value="1" data-bootstrap-switch data-off-color="danger" data-on-color="success" {{$val->status==1?'checked':''}}>
                      </div>
                    </div>
                  @else
                  <input type="hidden" name="section_status_{{$val->id}}" value="{{$val->status}}">
                  @endif
                  <?php
                  $type = $val->type
                  ?>
                  @if($val->section_type!=3 && $val->section_type!=4 && $val->section_type!=5 && $val->section_type!=6 && $val->section_type!=23)
                    <div class="form-group row clearfix">
                      <label class="col-sm-2 control-label">{{$val->section_type==1 && $page->id==1?'1st Tab Title':'Section Title'}}</label>
                      <div class="{{$content_count>1 && $page->page_template== 4?'col-sm-8':($content_count>1?'col-sm-8':'col-sm-8')}}">
                        <input type="text" class="form-control" name="section_title_{{$val->id}}" placeholder="Enter ..." value="{{$val->title}}">
                      </div>
                      @if($content_count>1)
                      <div class="col-sm-1">
                        <input type="text" class="form-control" name="section_rank_{{$val->id}}" placeholder="Enter ..." value="{{$val->rank}}" data-validation-engine="validate[custom[integer]]">
                      </div>
                      <div class="col-sm-1">
                        <a href="{{ url(Admin_Prefix.'page-extra/delete/'.$val->id) }}"><i class="fa fa-window-close"></i></a>
                      </div>
                      @if($page->page_template==4) 
                      <div class="col-sm-1">
                        <a href="{{ url(Admin_Prefix.'page-extra/delete/'.$val->id) }}"><i class="fa fa-window-close"></i></a>
                      </div>
                      @endif
                      @endif
                    </div>
                  @endif
                  @if($val->section_type==8 || $val->section_type==9 || $val->section_type==10 || $val->section_type==11 || $val->section_type==12 || $val->section_type==14 || $val->section_type==15 || $val->section_type==16 || $val->section_type==17 || $val->section_type==18 || $val->section_type==19 || $val->section_type==20 || ($val->section_type==1))
                    <div class="form-group row clearfix">
                      <label class="col-sm-2 control-label">{{$val->section_type==20?'Location':($val->section_type==1 && $page->id==1?'2nd Tab Title':'Sub Title')}}</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="section_sub_title_{{$val->id}}" placeholder="Enter ..." value="{{$val->sub_title}}">
                      </div>
                    </div>
                  @endif
                  @if($val->section_type==9 || $val->section_type==10 || $val->section_type==11 || $val->section_type==12 || $val->section_type==16 || $val->section_type==17 || $val->section_type==18 || $val->section_type==19 || $val->section_type==21)
                    <div class="form-group row clearfix">
                      <label class="col-sm-2 control-label">Image</label>
                      <div class="col-sm-10">
                        <input type="file" class="form-control" name="section_file_{{$val->id}}" data-rule-extension="webp">
                        Mime Type: webp, Max image upload size 2 Mb<br>

                        <div class="clearfix">
                          <?php
                          if($val->image && File::exists(public_path('uploads/'.$val->image)) )
                            {
                              ?>
                              <img src="{{ asset('/uploads/'.$val->image) }}" style="margin: 10px 0 0 0;max-width: 200px;">
                          <?php
                            }
                          ?>
                        </div>
                      </div>
                    </div>
                  @endif
                  @if($val->section_type==11 || $val->section_type==12 || $val->section_type==18 || $val->section_type==19)
                    <div class="form-group row clearfix">
                      <label class="col-sm-2 control-label">Image 2</label>
                      <div class="col-sm-10">
                        <input type="file" class="form-control" name="section_file2_{{$val->id}}" data-rule-accept="pdf">
                        Mime Type: webp, Max image upload size 2 Mb<br>

                        <div class="clearfix">
                          <?php
                          if($val->image2 && File::exists(public_path('uploads/'.$val->image2)) ){
                              ?>
                              <img src="{{ asset('/uploads/'.$val->image2) }}" style="margin: 10px 0 0 0;">
                          <?php
                            }
                          ?>
                        </div>
                      </div>
                    </div>
                  @endif
                  @if(($val->section_type=="11111" && $page->id>1) || $val->section_type==4 || $val->section_type==13 || $val->section_type==14 || $val->section_type==15 || $val->section_type==16 || $val->section_type==17 || $val->section_type==18 || $val->section_type==19 || $val->section_type==21 || $val->section_type==22)
                    <div class="form-group row clearfix">
                      <label class="col-sm-2 control-label">Content</label>
                      <div class="{{$val->section_type==4 && $content_count>1?'col-sm-8':'col-sm-8'}}">
                        <textarea name="section_body_{{$val->id}}" class="ckeditor" placeholder="Enter ...">{!!$val->body!!}</textarea>
                      </div>
                      @if($val->section_type==4)
                      <div class="col-sm-1">
                        <input type="text" class="form-control" name="section_rank_{{$val->id}}" placeholder="Enter ..." value="{{$val->rank}}" data-validation-engine="validate[custom[integer]]">
                      </div>
                        
                        <div class="col-sm-1">
                          <a href="{{ url(Admin_Prefix.'page-extra/delete/'.$val->id) }}"><i class="fa fa-window-close"></i></a>
                        </div>
                       
                      @endif
                    </div>
                  @endif 
                  @if($val->section_type==23)
                    <div class="form-group row clearfix">                   
                        <div class="col-sm-12">
                          <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">Video Url </label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="section_video_url{{$val->id}}" placeholder="Enter ..." value="{{$val->video_url}}">
                            </div>
                          </div>
                          <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">{{$val->section_type==1 && $page->id==1?'1st Tab Title':'Name'}}</label>
                            <div class="{{$content_count>1 && $page->page_template== 4?'col-sm-8':($content_count>1?'col-sm-8':'col-sm-8')}}">
                              <input type="text" class="form-control" name="section_title_{{$val->id}}" placeholder="Enter ..." value="{{$val->title}}">
                            </div>
                            @if($content_count>1)
                            <div class="col-sm-1">
                              <input type="text" class="form-control" name="section_rank_{{$val->id}}" placeholder="Enter ..." value="{{$val->rank}}" data-validation-engine="validate[custom[integer]]">
                            </div>
                            <div class="col-sm-1">
                              <a href="{{ url(Admin_Prefix.'page-extra/delete/'.$val->id) }}"><i class="fa fa-window-close"></i></a>
                            </div>
                            @if($page->page_template==4) 
                            <div class="col-sm-1">
                              <a href="{{ url(Admin_Prefix.'page-extra/delete/'.$val->id) }}"><i class="fa fa-window-close"></i></a>
                            </div>
                            @endif
                            @endif
                          </div>
                          <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">Image</label>
                            <div class="col-sm-10">
                              <input type="file" class="form-control" name="section_file_{{$val->id}}" data-rule-extension="webp">
                              Mime Type: webp, Max image upload size 2 Mb<br>
      
                              <div class="clearfix">
                                <?php
                                if($val->image && File::exists(public_path('uploads/'.$val->image)) )
                                  {
                                    ?>
                                    <img src="{{ asset('/uploads/'.$val->image) }}" style="margin: 10px 0 0 0;max-width: 200px;">
                                <?php
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">{{$val->section_type==20?'Location':($val->section_type==1 && $page->id==1?'2nd Tab Title':'Company Name')}}</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="section_sub_title_{{$val->id}}" placeholder="Enter ..." value="{{$val->sub_title}}">
                            </div>
                          </div>
                          <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">Video Image</label>
                            <div class="col-sm-10">
                              <input type="file" class="form-control" name="section_video_img{{$val->id}}" data-rule-extension="webp">
                              Mime Type: webp, Max image upload size 2 Mb<br>
                              <div class="clearfix">
                                <?php
                                if($val->video_img && File::exists(public_path('uploads/'.$val->video_img)) )
                                  { ?>
                                    <img src="{{ asset('/uploads/'.$val->video_img) }}" style="margin: 10px 0 0 0;max-width: 200px;">
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">Content</label>
                            <div class="{{$val->section_type==4 && $content_count>1?'col-sm-8':'col-sm-8'}}">
                              <textarea name="section_body_{{$val->id}}" class="ckeditor" placeholder="Enter ...">{!!$val->body!!}</textarea>
                            </div>
                            @if($val->section_type==4)
                            <div class="col-sm-1">
                              <input type="text" class="form-control" name="section_rank_{{$val->id}}" placeholder="Enter ..." value="{{$val->rank}}" data-validation-engine="validate[custom[integer]]">
                            </div>
                              <div class="col-sm-1">
                                <a href="{{ url(Admin_Prefix.'page-extra/delete/'.$val->id) }}"><i class="fa fa-window-close"></i></a>
                              </div>
                            @endif
                          </div>
                          {{-- <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">Video</label>
                            <div class="col-sm-10">
                              <input type="file" class="form-control" name="section_video_file_{{$val->id}}" data-rule-extension="mp4">
                              <div class="clearfix">
                                <?php if($val->video && File::exists(public_path('uploads/'.$val->video)) ) { ?>
                                    <video width="320" height="240" controls> <source src="{{ asset('/uploads/'.$val->video) }}" type="video/mp4">
                                <?php } ?>
                              </div>
                            </div>
                          </div> --}}
                        </div>
                    </div>
                  @endif 
                 
                  @if(($val->section_type=="1" && $page->id>1) || $val->section_type==5 || $val->section_type==6 || $val->section_type==7 || $val->section_type==10 || $val->section_type==12 || $val->section_type==15 || $val->section_type==17 || $val->section_type==19 || $val->section_type==20 || $val->section_type==22)
                    <div class="form-group row clearfix">
                      <label class="col-sm-2 control-label">{{$val->section_type==20?'Phone':'Button Text'}}</label>
                      <div class="{{$val->section_type==55 || $val->section_type==66?'col-sm-8':'col-sm-10'}}">
                        <input type="text" class="form-control" name="section_btn_text_{{$val->id}}" placeholder="Enter ..." value="{{ $val->btn_text }}">
                      </div>
                      @if($val->section_type==55 || $val->section_type==66)
                      <div class="col-sm-1">
                        <input type="text" class="form-control" name="section_rank_{{$val->id}}" placeholder="Enter ..." value="{{$val->rank}}" data-validation-engine="validate[custom[integer]]">
                      </div>
                      <div class="col-sm-1">
                        <a href="{{ url(Admin_Prefix.'page-extra/delete/'.$val->id) }}"><i class="fa fa-window-close"></i></a>
                      </div>
                      @endif
                    </div>
                    @if($val->section_type!=6)
                      @if($val->section_type==7 && $val->status_show=='1')
                      @else
                        @if($val->btn_url)
                        <div class="form-group row clearfix">
                          <label class="col-sm-2 control-label">{{$val->section_type==20?'Email':'Button URL'}}</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="section_btn_url_{{$val->id}}" placeholder="Enter ..." value="{{ $val->btn_url }}">
                          </div>
                        </div>
                        @endif
                      @endif
                    @endif
                  @endif
                  @if($val->section_type==24)
                    <div class="form-group row clearfix">                   
                        <div class="col-sm-12">
                          <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">Video Url </label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="section_video_url{{$val->id}}" placeholder="Enter ..." value="{{$val->video_url}}">
                            </div>
                          </div>
                          <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">{{$val->section_type==1 && $page->id==1?'1st Tab Title':'Name'}}</label>
                            <div class="{{$content_count>1 && $page->page_template== 4?'col-sm-8':($content_count>1?'col-sm-8':'col-sm-8')}}">
                              <input type="text" class="form-control" name="section_title_{{$val->id}}" placeholder="Enter ..." value="{{$val->title}}">
                            </div>
                            @if($content_count>1)
                            <div class="col-sm-1">
                              <input type="text" class="form-control" name="section_rank_{{$val->id}}" placeholder="Enter ..." value="{{$val->rank}}" data-validation-engine="validate[custom[integer]]">
                            </div>
                            <div class="col-sm-1">
                              <a href="{{ url(Admin_Prefix.'page-extra/delete/'.$val->id) }}"><i class="fa fa-window-close"></i></a>
                            </div>
                            @if($page->page_template==4) 
                            <div class="col-sm-1">
                              <a href="{{ url(Admin_Prefix.'page-extra/delete/'.$val->id) }}"><i class="fa fa-window-close"></i></a>
                            </div>
                            @endif
                            @endif
                          </div>
                          <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">Image</label>
                            <div class="col-sm-10">
                              <input type="file" class="form-control" name="section_file_{{$val->id}}" data-rule-extension="webp">
                              Mime Type: webp, Max image upload size 2 Mb<br>
      
                              <div class="clearfix">
                                <?php
                                if($val->image && File::exists(public_path('uploads/'.$val->image)) )
                                  {
                                    ?>
                                    <img src="{{ asset('/uploads/'.$val->image) }}" style="margin: 10px 0 0 0;max-width: 200px;">
                                <?php
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">{{$val->section_type==20?'Location':($val->section_type==1 && $page->id==1?'2nd Tab Title':'Company Name')}}</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="section_sub_title_{{$val->id}}" placeholder="Enter ..." value="{{$val->sub_title}}">
                            </div>
                          </div>
                          <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">Video Image</label>
                            <div class="col-sm-10">
                              <input type="file" class="form-control" name="section_video_img{{$val->id}}" data-rule-extension="webp">
                              Mime Type: webp, Max image upload size 2 Mb<br>
                              <div class="clearfix">
                                <?php
                                if($val->video_img && File::exists(public_path('uploads/'.$val->video_img)) )
                                  { ?>
                                    <img src="{{ asset('/uploads/'.$val->video_img) }}" style="margin: 10px 0 0 0;max-width: 200px;">
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">Content</label>
                            <div class="{{$val->section_type==4 && $content_count>1?'col-sm-8':'col-sm-8'}}">
                              <textarea name="section_body_{{$val->id}}" class="ckeditor" placeholder="Enter ...">{!!$val->body!!}</textarea>
                            </div>
                            @if($val->section_type==4)
                            <div class="col-sm-1">
                              <input type="text" class="form-control" name="section_rank_{{$val->id}}" placeholder="Enter ..." value="{{$val->rank}}" data-validation-engine="validate[custom[integer]]">
                            </div>
                              <div class="col-sm-1">
                                <a href="{{ url(Admin_Prefix.'page-extra/delete/'.$val->id) }}"><i class="fa fa-window-close"></i></a>
                              </div>
                            @endif
                          </div>
                          {{-- <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">Video</label>
                            <div class="col-sm-10">
                              <input type="file" class="form-control" name="section_video_file_{{$val->id}}" data-rule-extension="mp4">
                              <div class="clearfix">
                                <?php if($val->video && File::exists(public_path('uploads/'.$val->video)) ) { ?>
                                    <video width="320" height="240" controls> <source src="{{ asset('/uploads/'.$val->video) }}" type="video/mp4">
                                <?php } ?>
                              </div>
                            </div>
                          </div> --}}
                        </div>
                    </div>
                  @endif 

                  @if($val->section_type==1 || $val->section_type==3)
                  <?php
                  if ($val->section_type==1) {
                    $banner_count++;
                  }
                  ?>
                    <div class="form-group row clearfix">
                      <label class="col-sm-2 control-label">{{$val->section_type==1?'Background ':''}} Image</label>
                      <div class="{{$val->section_type==3 && $content_count>1?'col-sm-8':'col-sm-10'}}">
                        <input type="file" class="form-control" name="section_file_{{$val->id}}" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
                        Mime Type: webp, Max image upload size 2 Mb<br>

                        <div class="clearfix">
                          <?php
                          if($val->image && File::exists(public_path('uploads/'.$val->image)) )
                            {
                              ?>
                              <img src="{{ asset('/uploads/'.$val->image) }}" style="margin: 10px 0 0 0;max-width: 200px;">
                          <?php
                            }
                          ?>
                        </div>
                      </div>
                      @if($val->section_type==3 && $content_count>1)
                      <div class="col-sm-1">
                        <input type="text" class="form-control" name="section_rank_{{$val->id}}" placeholder="Enter ..." value="{{$val->rank}}" data-validation-engine="validate[custom[integer]]">
                      </div>
                      @endif
                    </div>
                  @endif
                  @endif
                @endforeach
                  </div>
              <div class="section_new">
                <div class="card-header with-border" style="margin-bottom: 15px;">
                  <h3 class="card-title">New Section
                  </h3>
                </div>
                <div class="form-group row clearfix">
                  <label class="col-sm-2 control-label">Section</label>
                  <div class="col-sm-2">
                    <select name="sn_type" class="form-control select2 sn_type">
                      <option value="">Select Section</option>
                      @foreach($all_type as $key => $value)
                      <option value="{!! $value !!}">Section {!! ($value==4 && $page->page_template=='4')?'FAQ':$value !!}</option>
                      @endforeach
                      <option value="add">New Section Add</option>
                    </select>
                  </div>
                  <label class="col-sm-2 control-label">Section Type</label>
                  <div class="col-sm-4">
                    <select name="sn_section_type" class="form-control select2 sn_section_type">
                      <option value="">Select Section Type</option>
                      @foreach($page_section_array as $key => $value)
                      <option value="{!! $key !!}">{!! $value !!}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <button type="button" class="btn btn-default add_section_btn">Add Section</button>
                  </div> 
                </div> 
                <div class="add_section"></div>              
              </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
  </div>
</section>
<div class="copy type000 d-none">  
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="1">
      <input type="hidden" name="section_new_img2[]" value="">
      <input type="hidden" name="section_new_t[]" value="">
      <input type="hidden" name="section_new_st[]" value="">
      <input type="hidden" name="section_new_c[]" value="">
      <input type="hidden" name="section_new_btn_text[]" value="">
      <input type="hidden" name="section_new_btn_url[]" value="">
      <label class="col-sm-2 control-label">Banner Image</label>
      <div class="col-sm-9">
        <input type="file" name="section_new_img[]" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
        Mime Type: webp, Max image upload size 2 Mb<br>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div>
  </div>
</div>

<div class="copy type1 d-none"> 
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="1">
      <input type="hidden" name="section_new_st[]" value="">
      <input type="hidden" name="section_new_img2[]" value="">
      <input type="hidden" name="section_new_btn_url[]" value="">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Image</label>
      <div class="col-sm-10">
        <input type="file" name="section_new_img[]" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
        Mime Type: webp, Max image upload size 2 Mb<br>
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Content</label>
      <div class="col-sm-10">
        <textarea class="form-control ckeditor" name="section_new_c[]" placeholder="Enter ..."></textarea>
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Button Text</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_btn_text[]" placeholder="Enter ..." value="">
      </div>
    </div>
  </div>
</div>

<div class="copy type2 d-none"> 
  <div class="sn">    
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="2">
      <input type="hidden" name="section_new_img[]" value="">
      <input type="hidden" name="section_new_img2[]" value="">
      <input type="hidden" name="section_new_st[]" value="">
      <input type="hidden" name="section_new_c[]" value="">
      <input type="hidden" name="section_new_btn_text[]" value="">
      <input type="hidden" name="section_new_btn_url[]" value="">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div>
  </div>
</div>

<div class="copy type3 d-none">  
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="3">
      <input type="hidden" name="section_new_img2[]" value="">
      <input type="hidden" name="section_new_t[]" value="">
      <input type="hidden" name="section_new_st[]" value="">
      <input type="hidden" name="section_new_c[]" value="">
      <input type="hidden" name="section_new_btn_text[]" value="">
      <input type="hidden" name="section_new_btn_url[]" value="">
      <label class="col-sm-2 control-label">Image</label>
      <div class="col-sm-9">
        <input type="file" name="section_new_img[]" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
        Mime Type: webp, Max image upload size 2 Mb<br>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div>
  </div>
</div>

<div class="copy type4 d-none">  
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="4">
      <input type="hidden" name="section_new_img[]" value="">
      <input type="hidden" name="section_new_img2[]" value="">
      <input type="hidden" name="section_new_t[]" value="">
      <input type="hidden" name="section_new_st[]" value="">
      <input type="hidden" name="section_new_btn_text[]" value="">
      <input type="hidden" name="section_new_btn_url[]" value="">
      <label class="col-sm-2 control-label">Content</label>
      <div class="col-sm-9">
        <textarea class="form-control ckeditor" name="section_new_c[]" placeholder="Enter ..."></textarea>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div>
  </div>
</div>

<div class="copy type5 d-none">  
  <div class="sn">    
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="5">
      <input type="hidden" name="section_new_img[]" value="">
      <input type="hidden" name="section_new_img2[]" value="">
      <input type="hidden" name="section_new_t[]" value="">
      <input type="hidden" name="section_new_st[]" value="">
      <input type="hidden" name="section_new_c[]" value="">
      <label class="col-sm-2 control-label">Button Text</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_btn_text[]" placeholder="Enter ..." value="">
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Banner Button URL</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_btn_url[]" placeholder="Enter ..." value="">
      </div>
    </div>
  </div>
</div>

<div class="copy type6 d-none"> 
  <div class="sn">    
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="6">
      <input type="hidden" name="section_new_img[]" value="">
      <input type="hidden" name="section_new_img2[]" value="">
      <input type="hidden" name="section_new_t[]" value="">
      <input type="hidden" name="section_new_st[]" value="">
      <input type="hidden" name="section_new_c[]" value="">
      <input type="hidden" name="section_new_btn_url[]" value="">
      <label class="col-sm-2 control-label">Button Text</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_btn_text[]" placeholder="Enter ..." value="">
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div>
  </div>
</div>

<div class="copy type7 d-none"> 
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="7">
      <input type="hidden" name="section_new_img[]" value="">
      <input type="hidden" name="section_new_img2[]" value="">
      <input type="hidden" name="section_new_st[]" value="">
      <input type="hidden" name="section_new_c[]" value="">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div> 
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Button Text</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_btn_text[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Banner Button URL</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_btn_url[]" placeholder="Enter ..." value="">
      </div>
    </div>
  </div>
</div>

<div class="copy type8 d-none"> 
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="8">
      <input type="hidden" name="section_new_img[]" value="">
      <input type="hidden" name="section_new_img2[]" value="">
      <input type="hidden" name="section_new_c[]" value="">
      <input type="hidden" name="section_new_btn_text[]" value="">
      <input type="hidden" name="section_new_btn_url[]" value="">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div> 
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Sub Title</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_st[]" placeholder="Enter ..." value="">
      </div>
    </div>
  </div>
</div>

<div class="copy type9 d-none"> 
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="9">
      <input type="hidden" name="section_new_img2[]" value="">
      <input type="hidden" name="section_new_c[]" value="">
      <input type="hidden" name="section_new_btn_text[]" value="">
      <input type="hidden" name="section_new_btn_url[]" value="">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div> 
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Sub Title</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_st[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Image</label>
      <div class="col-sm-10">
        <input type="file" name="section_new_img[]" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
        Mime Type: webp, Max image upload size 2 Mb<br>
      </div>
    </div>
  </div>
</div>

<div class="copy type10 d-none"> 
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="10">
      <input type="hidden" name="section_new_img2[]" value="">
      <input type="hidden" name="section_new_c[]" value="">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div> 
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Sub Title</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_st[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Image</label>
      <div class="col-sm-10">
        <input type="file" name="section_new_img[]" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
        Mime Type: webp, Max image upload size 2 Mb<br>
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Button Text</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_btn_text[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Banner Button URL</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_btn_url[]" placeholder="Enter ..." value="">
      </div>
    </div>
  </div>
</div>

<div class="copy type11 d-none"> 
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="11">
      <input type="hidden" name="section_new_c[]" value="">
      <input type="hidden" name="section_new_btn_text[]" value="">
      <input type="hidden" name="section_new_btn_url[]" value="">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div> 
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Sub Title</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_st[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Image</label>
      <div class="col-sm-10">
        <input type="file" name="section_new_img[]" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
        Mime Type: webp, Max image upload size 2 Mb<br>
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Image 2</label>
      <div class="col-sm-10">
        <input type="file" name="section_new_img2[]" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
        Mime Type: webp, Max image upload size 2 Mb<br>
      </div>
    </div>
  </div>
</div>

<div class="copy type12 d-none"> 
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="12">
      <input type="hidden" name="section_new_c[]" value="">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div> 
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Sub Title</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_st[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Image</label>
      <div class="col-sm-10">
        <input type="file" name="section_new_img[]" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
        Mime Type: webp, Max image upload size 2 Mb<br>
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Image 2</label>
      <div class="col-sm-10">
        <input type="file" name="section_new_img2[]" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
        Mime Type: webp, Max image upload size 2 Mb<br>
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Button Text</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_btn_text[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Banner Button URL</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_btn_url[]" placeholder="Enter ..." value="">
      </div>
    </div>
  </div>
</div>

<div class="copy type13 d-none"> 
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="13">
      <input type="hidden" name="section_new_img[]" value="">
      <input type="hidden" name="section_new_img2[]" value="">
      <input type="hidden" name="section_new_st[]" value="">
      <input type="hidden" name="section_new_btn_text[]" value="">
      <input type="hidden" name="section_new_btn_url[]" value="">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div> 
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Content</label>
      <div class="col-sm-10">
        <textarea class="form-control ckeditor" name="section_new_c[]" placeholder="Enter ..."></textarea>
      </div>
    </div>
  </div>
</div>

<div class="copy type14 d-none"> 
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="14">
      <input type="hidden" name="section_new_img[]" value="">
      <input type="hidden" name="section_new_img2[]" value="">
      <input type="hidden" name="section_new_btn_text[]" value="">
      <input type="hidden" name="section_new_btn_url[]" value="">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div> 
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Sub Title</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_st[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Content</label>
      <div class="col-sm-10">
        <textarea class="form-control ckeditor" name="section_new_c[]" placeholder="Enter ..."></textarea>
      </div>
    </div>
  </div>
</div>

<div class="copy type15 d-none"> 
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="15">
      <input type="hidden" name="section_new_img[]" value="">
      <input type="hidden" name="section_new_img2[]" value="">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div> 
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Sub Title</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_st[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Content</label>
      <div class="col-sm-10">
        <textarea class="form-control ckeditor" name="section_new_c[]" placeholder="Enter ..."></textarea>
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Button Text</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_btn_text[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Banner Button URL</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_btn_url[]" placeholder="Enter ..." value="">
      </div>
    </div>
  </div>
</div>

<div class="copy type16 d-none"> 
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="16">
      <input type="hidden" name="section_new_img2[]" value="">
      <input type="hidden" name="section_new_btn_text[]" value="">
      <input type="hidden" name="section_new_btn_url[]" value="">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div> 
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Sub Title</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_st[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Image</label>
      <div class="col-sm-10">
        <input type="file" name="section_new_img[]" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
        Mime Type: webp, Max image upload size 2 Mb<br>
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Content</label>
      <div class="col-sm-10">
        <textarea class="form-control ckeditor" name="section_new_c[]" placeholder="Enter ..."></textarea>
      </div>
    </div>
  </div>
</div>

<div class="copy type17 d-none"> 
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="17">
      <input type="hidden" name="section_new_img2[]" value="">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div> 
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Sub Title</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_st[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Image</label>
      <div class="col-sm-10">
        <input type="file" name="section_new_img[]" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
        Mime Type: webp, Max image upload size 2 Mb<br>
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Content</label>
      <div class="col-sm-10">
        <textarea class="form-control ckeditor" name="section_new_c[]" placeholder="Enter ..."></textarea>
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Button Text</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_btn_text[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Banner Button URL</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_btn_url[]" placeholder="Enter ..." value="">
      </div>
    </div>
  </div>
</div>

<div class="copy type18 d-none"> 
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="18">
      <input type="hidden" name="section_new_btn_text[]" value="">
      <input type="hidden" name="section_new_btn_url[]" value="">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div> 
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Sub Title</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_st[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Image</label>
      <div class="col-sm-10">
        <input type="file" name="section_new_img[]" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
        Mime Type: webp, Max image upload size 2 Mb<br>
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Image 2</label>
      <div class="col-sm-10">
        <input type="file" name="section_new_img2[]" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
        Mime Type: webp, Max image upload size 2 Mb<br>
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Content</label>
      <div class="col-sm-10">
        <textarea class="form-control ckeditor" name="section_new_c[]" placeholder="Enter ..."></textarea>
      </div>
    </div>
  </div>
</div>

<div class="copy type19 d-none"> 
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="19">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div> 
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Sub Title</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_st[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Image</label>
      <div class="col-sm-10">
        <input type="file" name="section_new_img[]" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
        Mime Type: webp, Max image upload size 2 Mb<br>
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Image 2</label>
      <div class="col-sm-10">
        <input type="file" name="section_new_img2[]" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
        Mime Type: webp, Max image upload size 2 Mb<br>
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Content</label>
      <div class="col-sm-10">
        <textarea class="form-control ckeditor" name="section_new_c[]" placeholder="Enter ..."></textarea>
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Button Text</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_btn_text[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Banner Button URL</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_btn_url[]" placeholder="Enter ..." value="">
      </div>
    </div>
  </div>
</div>

<div class="copy type20 d-none"> 
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="20">
      <input type="hidden" name="section_new_img[]" value="">
      <input type="hidden" name="section_new_img2[]" value="">
      <input type="hidden" name="section_new_c[]" value="">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div> 
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Location</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_st[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Phone</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_btn_text[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Email</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_btn_url[]" placeholder="Enter ..." value="">
      </div>
    </div>
    
  </div>
</div>

<div class="copy type21 d-none"> 
  <div class="sn">   
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="21">
      <input type="hidden" name="section_new_st[]" value="">
      <input type="hidden" name="section_new_img2[]" value="">
      <input type="hidden" name="section_new_btn_text[]" value="">
      <input type="hidden" name="section_new_btn_url[]" value="">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Image</label>
      <div class="col-sm-10">
        <input type="file" name="section_new_img[]" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
        Mime Type: webp, Max image upload size 2 Mb<br>
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Content</label>
      <div class="col-sm-10">
        <textarea class="form-control ckeditor" name="section_new_c[]" placeholder="Enter ..."></textarea>
      </div>
    </div>
  </div>
</div>

<div class="copy type22 d-none"> 
  <div class="sn">    
    <div class="form-group row clearfix">
      <input type="hidden" name="type[]" value="">
      <input type="hidden" name="section_type[]" value="2">
      <input type="hidden" name="section_new_img[]" value="">
      <input type="hidden" name="section_new_img2[]" value="">
      <input type="hidden" name="section_new_st[]" value="">
      <label class="col-sm-2 control-label">Title</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
      </div>
      <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Content</label>
      <div class="col-sm-10">
        <textarea class="form-control ckeditor" name="section_new_c[]" placeholder="Enter ..."></textarea>
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Button Text</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_btn_text[]" placeholder="Enter ..." value="">
      </div>
    </div>
    <div class="form-group row clearfix">
      <label class="col-sm-2 control-label">Banner Button URL</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="section_new_btn_url[]" placeholder="Enter ..." value="">
      </div>
    </div>
  </div>
</div>

  <div class="copy type23 d-none">
    <div class="sn">    
      <div class="form-group row clearfix">
        <input type="hidden" name="type[]" value="">
        <input type="hidden" name="section_type[]" value="23">
        <input type="hidden" name="section_new_img[]" value="">
        <input type="hidden" name="section_new_img2[]" value="">
        <input type="hidden" name="section_new_st[]" value="">
        <input type="hidden" name="section_new_cat[]" value="">
        <label class="col-sm-2 control-label">Table of contents</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
        </div>
        <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
      </div>
      <div class="form-group row clearfix">
        <label class="col-sm-2 control-label">Content</label>
        <div class="col-sm-10">
          <textarea class="form-control ckeditor" name="section_new_c[]" placeholder="Enter ..."></textarea>
        </div>
      </div>
      <div class="form-group row clearfix">
        <label class="col-sm-2 control-label">Parent</label>
        <div class="col-sm-10">
          @if(!empty($parent_extra))
          <select name="section_new_cat[]" class="form-control">
            <option value="">Select</option>
              @foreach ($parent_extra as $key => $value)
                <option value="{{ $value->id }}">{{ $value->title }}</option>
              @endforeach
          @endif
          </select>
        </div>
      </div>
      <div class="form-group row clearfix">
        <label class="col-sm-2 control-label">Image</label>
        <div class="col-sm-10">
          <input type="file" name="section_new_img[]" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
          Mime Type: webp, Max image upload size 2 Mb<br>
        </div>
      </div>
      <div class="form-group row clearfix">
        <label class="col-sm-2 control-label">Image 2</label>
        <div class="col-sm-10">
          <input type="file" name="section_new_img2[]" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
          Mime Type: webp, Max image upload size 2 Mb<br>
        </div>
      </div>
      <div class="form-group row clearfix">
        <label class="col-sm-2 control-label">Button Text</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="section_new_btn_text[]" placeholder="Enter ..." value="">
        </div>
      </div>
      <div class="form-group row clearfix">
        <label class="col-sm-2 control-label">Banner Button URL</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="section_new_btn_url[]" placeholder="Enter ..." value="">
        </div>
      </div>
    </div>
  </div>
@endsection
@section('more-scripts')
<script type="text/javascript">
$(document).ready(function() {
  var wrapper       = $(".add_section"); //Fields wrapper
  var add_button      = $(".add_section_btn"); //Add button ID

  $(add_button).click(function(e){ //on add input button click
    e.preventDefault();
    sn_section_type = $(".sn_section_type").val();
    sn_type = $(".sn_type").val();
    var html = '';
    if (sn_section_type>0 && sn_type) {
      $(".type"+sn_section_type).find('input[name="type[]"]').val(sn_type);
      html = $(".type"+sn_section_type).html();
    }
    if (html) {
      $(wrapper).append(html); //add input box
    }
    
  });
  
  $(wrapper).on("click",".remove_field", function(e){ //Company click on remove text
    e.preventDefault(); 
    //$(this).parent('div').parent('div').parent('div').remove();
    $(this).parents('.sn').remove();
  })
});
</script>
@stop

