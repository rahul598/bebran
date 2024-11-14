@extends('layouts.app')

@section('content')
    
<div class="innerbanner-area"> 
    @foreach ($extra_data as $val)
      @if($val->section_type==1)
            <img src="{{ asset('uploads/'.$val->image) }}" alt="be-bran-innerbanner2">
      @endif
    @endforeach
     <nav class="breadcrumb"> 
      <div class="container">
        <a class="breadcrumb-item" href="{{url('/')}}">home</a> 
        @if($page->page_title)<span class="breadcrumb-item active">{!! $page->page_title !!}</span> @endif
      </div>
    </nav>
  </div>
  
  <section class="innerabout_area">
   <div class="about-area pt-90 pt-0">
    <div class="container">
      @foreach ($extra_data as $val)
        @if($val->section_type==4)
            {!! $val->body !!}
        @endif
      @endforeach
    </div>
  </div>
  </section>
  
@endsection

@section('more-scripts')

@stop


