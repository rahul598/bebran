@extends('layouts.admin')
@section('content')
@php
$page_display_in_array = unserialize(Page_Display_In_Array);
$page_template_array = unserialize(Page_Template_Array);
$page_section_array = unserialize(Page_Section_Array);
@endphp
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">{{ __('Edit Page') }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('admin')}}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Edit Page') }}</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  
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
          <form role="form" action="{{ url(Admin_Prefix.'seo-landing/update/') }}"  method="post" enctype="multipart/form-data" class="customValidate">
            @csrf
            <input type="hidden" name="id" value="{{$page->id}}">
            <input type="hidden" name="posttype" value="seo">
            <input type="hidden" name="display_in" value="{{$page->display_in}}">

            <div class="card-body">

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control module_name" name="page_name" id="page_name" required placeholder="Enter ..." value="{{$page->page_name}}">
                </div>
              </div>

              @if($page->id!='1')
              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Title</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="page_title" id="page_title" placeholder="Enter ..." value="{{$page->page_title}}">
                </div>
              </div>
              @endif

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Slug</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control module_slug" name="slug" id="slug" placeholder="Enter ..." value="{{ $page->slug }}" required @if(1>=$page->id) readonly @endif>
                </div>
              </div>
                <div class="form-group row clearfix">
                    <label class="col-sm-2 control-label">Category</label>
                    <div class="col-sm-10">
                      <!--<input type="text" class="form-control" name="business_category" placeholder="Enter ..." value="{{$page->business_category}}">-->
                         
                           <select class="form-control d-none" name="seo_category" id="seo_category">
                                <?php 
                                    $category_name = DB::table('seoResultCategory')->where('id', $page->business_category)->first(); 
                                ?>
                             
                                    <option value="{{ isset($category_name->id) }}" selected>{{ (isset($category_name->name))?$category_name->name:'' }}</option> 
                                
                                @foreach($seo_category as $category)
                                    @if(!$category_name || $category->id != $category_name->id)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select> 
                            
                            <select class="select_new" name="seo_category[]" multiple placeholder="Choose skills" data-allow-clear="1">
                                <?php  
                                    // Decode the JSON string, default to an empty array if it's null
                                    $cat_new = json_decode($page->business_category, true) ?? [];
                                    
                                    // Ensure $cat_new is an array
                                    if (!is_array($cat_new)) {
                                        $cat_new = [];
                                    }
                            
                                    // Get the categories from the database
                                    $category_names = DB::table('seoResultCategory')->whereIn('id', $cat_new)->get();
                                ?>
                                
                                @foreach($category_names as $category_name)
                                    <option value="{{ $category_name->id }}" selected>{{ $category_name->name }}</option>
                                @endforeach
                                
                                @foreach($seo_category as $category)
                                    @if(!$category_names->contains('id', $category->id))
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                             
                    </div>
                </div>  

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Menu Order</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control required" data-rule-digits="true" name="menu_order" id="menu_order" placeholder="Enter ..." value="{{ $page->menu_order }}">
                </div>
                <label class="col-sm-2 control-label">Page Template</label>
                <div class="col-sm-2">
                  <select name="page_template" class="form-control">
                    <option value="0">Select Template</option>
                    @foreach($page_template_array as $key => $value)
                    <option value="{!!$key!!}" @if($key==$page->page_template) selected @endif>{!!$value!!}</option>
                    @endforeach
                  </select>
                </div>
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

              <div class="form-group row clearfix"><?php /**/ ?>
                <label class="col-sm-2 control-label">Display in</label>
                <div class="col-sm-10">
                @foreach($page_display_in_array as $key => $value)
                  <div class="custom-control custom-radio d-inline">
                    <input class="custom-control-input" type="radio" id="customRadio{{$key}}" name="display_in" value="{{$key}}" @if($key==$page->display_in) checked @endif>
                    <label for="customRadio{{$key}}" class="custom-control-label">{!! $value !!}</label>
                  </div>
                @endforeach
                </div>
              </div>

              {{-- <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Menu Icon</label>
                <div class="col-sm-10">
                  <input type="file" class="form-control" name="menu_image" data-rule-extension="webp">
                  Mime Type: webp, Max image upload size 2 Mb<br>

                  <div class="clearfix">
                    <?php
                    if($page->menu_image && File::exists(public_path('uploads/'.$page->menu_image)) )
                      {
                        ?>
                        <img src="{{ asset('/uploads/'.$page->menu_image) }}" style="margin: 10px 0 0 0;max-width: 200px;background-color: #0e25ca;padding: 8px;"> <a href="{{ url(Admin_Prefix.'page-extra/content-delete/menu_image/'.$page->id) }}" data-confirm="You want to delete this image!"><i class="fa fa-window-close"></i></a>
                    <?php
                      }
                    ?>
                  </div>
                </div>
              </div> --}}

              <div class="form-group row clearfix">
                <label class="col-sm-2 control-label">Redirected to</label>
                <div class="col-sm-10">
                  <select name="redirect_to" id="redirect_to" class="form-control">
                    <option value="">Select</option>
                    @foreach ($redirect_page as $key => $value)
                        <option value="{{ $value->id }}" {{ $value->id == $page->redirect_to ? 'selected' : '' }}>
                            {{ $value->page_name }}
                        </option>
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
                <label class="col-sm-2 control-label">Meta Description</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="meta_description" placeholder="Enter ...">{{ $page->meta_description }}</textarea>
                </div>
              </div>
              <div class="form-group row clearfix bannerimage">
                <label class="col-sm-2 control-label">Feature Image</label>
                <div class="col-sm-4">
                  <input type="file" name="image2" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
                  Mime Type: webp, Max image upload size 5 Mb<br>
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
              <div class="form-group row clearfix bannerimage">
                <label class="col-sm-2 control-label">Country Image</label>
                <div class="col-sm-4">
                  <input type="file" name="bannerimage" data-validation-engine="validate[,custom[validateMIME[image/webp]]]">
                  Mime Type: webp, Max image upload size 5 Mb<br>
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
                <div class="form-group row clearfix">
                  <label class="col-sm-2 control-label">Country Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="banner_text_value" id="banner_text_value" required placeholder="Enter ..." value="{{$page->bannertext}}">
                  </div>
                </div>
                <div class="form-group row clearfix py-3">
                  <label class="col-sm-2 control-label">Results Overview CSV</label>
                  <div class="col-sm-10">
                     <input type="file" name="result_overview"> <span>Upload CSV Only Download Sample</span> 
                     <a href="{{ route('download_csv') }}" class="btn btn-sm btn-primary" download>Download Sample</a>
                     <a href="{{ route('result_overview', ['id'=> $page->id]) }}" class="btn btn-sm btn-success">Current Data</a>
                  </div>
                </div>
                <div class="form-group row clearfix py-3">
                  <label class="col-sm-2 control-label">Keyword CSV</label>
                  <div class="col-sm-10">
                     <input type="file" name="keyword_csv"> <span>Upload CSV Only Download Sample</span> 
                     <a href="{{ route('keyword_download_csv') }}" class="btn btn-sm btn-primary" download>Download Sample</a>
                     <a href="{{ route('keyword_data_csv', ['id'=> $page->id]) }}" class="btn btn-sm btn-success">Current Data</a>
                  </div>
                </div>
                <div class="form-group row clearfix py-3">
                  <label class="col-sm-2 control-label">Keyword Growth CSV</label>
                  <div class="col-sm-10">
                     <input type="file" name="keyword_growth_csv"> <span>Upload CSV Only Download Sample</span> 
                     <a href="{{ route('keyword_growth_download_csv') }}" class="btn btn-sm btn-primary" download>Download Sample</a>
                     <a href="{{ route('keyword_growth_csv', ['id'=> $page->id]) }}" class="btn btn-sm btn-success">Current Data</a>
                  </div>
                </div>
                <div class="form-group row clearfix">
                  <label class="col-sm-2 control-label">Button Text</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="author_url" id="author_url" placeholder="Enter ..." value="{{$page->author_url}}">
                  </div>
                </div>

                @if($page->id>1 && $page->page_template!=1)
                   @if($page->body) 
                    <div class="form-group row clearfix">
                      <label class="col-sm-2 control-label">Content</label>
                      <div class="col-sm-10">
                        <textarea name="body" class="ckeditor" placeholder="Enter ...">{!! $page->body !!}</textarea>
                      </div>
                    </div>
                   @endif  
                @endif

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
                  @if($val->section_type!=3 && $val->section_type!=4 && $val->section_type!=26 && $val->section_type!=5 && $val->section_type!=6 && $val->section_type!=23)
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
                              <input type="text" class="form-control" name="section_video_url_{{$val->id}}" placeholder="Enter ..." value="{{$val->video_url}}">
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
                              <input type="file" class="form-control" name="section_video_img_{{$val->id}}" data-rule-extension="webp">
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
                  @if($val->section_type==25)
                    <div class="form-group row clearfix">                   
                        <div class="col-sm-12">
                          <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">Link</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="section_link_{{$val->id}}" placeholder="Enter ..." value="{{$val->link}}">
                            </div>
                          </div>
                          <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">Founder</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="section_founder_{{$val->id}}" placeholder="Enter ..." value="{{$val->founder}}">
                            </div>
                          </div> 
                          <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">Business Category</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="section_business_category_{{$val->id}}" placeholder="Enter ..." value="{{$val->business_category}}">
                            </div>
                          </div>
                          <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">Competition</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="section_competition_{{$val->id}}" placeholder="Enter ..." value="{{$val->competition}}">
                            </div>
                          </div>
                          <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">Seo Package</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="section_seo_package_{{$val->id}}" placeholder="Enter ..." value="{{$val->seo_package}}">
                            </div>
                          </div>
                        
                          <div class="form-group row clearfix">
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
                          <!-- <div class="form-group row clearfix">
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
                          </div> -->
                        </div>
                    </div>
                  @endif 
                  @if($val->section_type==26)
                    <div class="form-group row clearfix">                   
                        <div class="col-sm-12">
                          <div class="form-group row clearfix">
                            <label class="col-sm-2 control-label">Excel</label>
                            <div class="col-sm-9">
                              <input type="file" class="form-control" name="section_excel_{{$val->id}}" placeholder="Enter ..." value="{{$val->excel}}">
                            </div>
                          </div>
                          <div class="form-group row clearfix">
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
                        
                          <!-- <div class="form-group row clearfix">
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
                          </div> -->
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
                    <div class="form-group row clearfix">
                      <label class="col-sm-2 control-label">{{$val->section_type==20?'Email':'Button URL'}}</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="section_btn_url_{{$val->id}}" placeholder="Enter ..." value="{{ $val->btn_url }}">
                      </div>
                    </div>
                    @endif
                    @endif
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
                        @if($content_count>1)
                        <div class="col-sm-1">
                          <a href="{{ url(Admin_Prefix.'page-extra/delete/'.$val->id) }}"><i class="fa fa-window-close"></i></a>
                        </div>
                      @endif

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


<div class="copy type1 d-none">  
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
      <input type="hidden" name="section_type[]" value="22">
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
<div class="copy type24 d-none">
    <div class="sn">   
      <div class="form-group row clearfix">
        <input type="hidden" name="type[]" value="">
        <input type="hidden" name="section_type[]" value="24">
        <input type="hidden" name="section_new_img2[]" value="">
        <input type="hidden" name="section_new_btn_text[]" value="">
        <input type="hidden" name="section_new_btn_url[]" value="">
        <input type="hidden" name="section_new_st[]" value="">
        <label class="col-sm-2 control-label">Name</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="section_new_t[]" placeholder="Enter ..." value="" required>
        </div>
        <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
      </div>
      
      <div class="form-group row clearfix">
        <label class="col-sm-2 control-label">Company Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="section_new_st[]" placeholder="Enter ..." value="">
        </div>
      </div>
      <div class="form-group row clearfix">
        <label class="col-sm-2 control-label">Video Url</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="video_url[]" placeholder="Enter ..." value="">
        </div>
        <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
      </div>
      <div class="form-group row clearfix">
        <label class="col-sm-2 control-label">Country Image</label>
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
      
      {{-- <div class="form-group row clearfix">
        <label class="col-sm-2 control-label">Video</label>
        <div class="col-sm-10">
          <input type="file" name="video_file[]" class="form-control">
        </div>
      </div> --}}
      <div class="form-group row clearfix">
        <label class="col-sm-2 control-label">Video Image</label>
        <div class="col-sm-10">
          <input type="file" name="video_img[]" class="form-control">
        </div>
      </div>
    </div>
  </div>
<div class="copy type25 d-none">
    <div class="sn">   
      <div class="form-group row clearfix">
        <input type="hidden" name="type[]" value="">
        <input type="hidden" name="section_type[]" value="25">
        <input type="hidden" name="section_new_img2[]" value="">
        <input type="hidden" name="section_new_btn_text[]" value="">
        <input type="hidden" name="section_new_btn_url[]" value="">
        <input type="hidden" name="section_new_st[]" value="">
        <label class="col-sm-2 control-label">Link</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="new_link[]" placeholder="Enter ..." value="" required>
        </div>
        <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
      </div>
      <div class="form-group row clearfix">
        <label class="col-sm-2 control-label">Founder</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="new_founder[]" placeholder="Enter ..." value="">
        </div>
      </div>
      <div class="form-group row clearfix">
        <label class="col-sm-2 control-label">Business Category</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="business_category[]" placeholder="Enter ..." value="">
        </div>
        <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
      </div>
      <div class="form-group row clearfix">
        <label class="col-sm-2 control-label">Competition</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="competition[]" placeholder="Enter ...">
        </div>
      </div>
      <div class="form-group row clearfix">
        <label class="col-sm-2 control-label">Seo Package</label>
        <div class="col-sm-10">
          <input class="form-control ckeditor" name="seo_package[]" placeholder="Enter ..."></input>
        </div>
      </div>
      <div class="form-group row clearfix">
        <label class="col-sm-2 control-label">Image</label>
        <div class="col-sm-10">
          <input type="file" name="section_new_img[]" class="form-control">
        </div>
      </div>
    </div>
  </div>
<div class="copy type26 d-none">
    <div class="sn">   
      <div class="form-group row clearfix">
        <input type="hidden" name="type[]" value="">
        <input type="hidden" name="section_type[]" value="25">
        <input type="hidden" name="section_new_img2[]" value="">
        <input type="hidden" name="section_new_btn_text[]" value="">
        <input type="hidden" name="section_new_btn_url[]" value="">
        <input type="hidden" name="section_new_st[]" value="">
        <label class="col-sm-2 control-label">Excel</label>
        <div class="col-sm-9">
          <input type="file" class="form-control" name="new_excel[]" placeholder="Enter ..." value="">
        </div>
        <div class="col-sm-1"><a href="javascript:;" class="remove_field">Remove</a></div>
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
  
//    select 2 js
$(function () {
  $('.select_new').each(function () {
    $(this).select2({
      theme: 'bootstrap4',
      width: 'style',
      placeholder: $(this).attr('placeholder'),
      allowClear: Boolean($(this).data('allow-clear')),
    });
  });
});
});
</script>
@stop

