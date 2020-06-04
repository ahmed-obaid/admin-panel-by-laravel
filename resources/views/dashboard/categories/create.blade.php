@extends('layouts.dashboard.app')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.categories')</h1>

            <ol class="breadcrumb">
            <li class="active"> <a href='{{route("dashboard.index")}}'> <i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
             <li class="active"> <a href='{{route("dashboard.categories.index")}}'> <i class="fa fa-user"></i> @lang('site.categories')</a></li>
             <li class="active"> <i class="fa fa-plus"></i> @lang('site.add')</li>
            </ol>
        </section>

        <section class="content">
        <section class="content">
          <div  class='box box-primary' >
               <div class='box-header with-border'>
                   <h3 class='box-title'>@lang('site.add')</h3>
                                
               </div>
               <div class='box-body'>
                @include('partials._errors')
                 <form action='{{route("dashboard.categories.store")}}' method='post'   >
                    @csrf
                    <div class='form-group'>
                       <lable >@lang('site.ar.name')</lable>
                       <input type='text' name='name_ar' class='form-controll'value='{{old("name_ar")}}'/>                          
                    </div> 
                    <div class='form-group'>
                       <lable >@lang('site.en.name')</lable>
                       <input type='text' name='name_en' class='form-controll'value='{{old("name_en")}}'/>                          
                    </div> 
                    <div class='form-group'>
                       <lable >@lang('site.ar.description')</lable>
                       <input type='text' name='desc_ar' class='form-controll'value='{{old("desc_ar")}}'/>                          
                    </div> 
                    <div class='form-group'>
                       <lable >@lang('site.en.description')</lable>
                       <input type='text' name='desc_en' class='form-controll'value='{{old("desc_en")}}'/>                          
                    </div>             

                   <div class="form-group">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                   </div>
                    
                 
                 </form> 
               
              
               </div>
          
          
          </div>

            

             

        </section><!-- end of content -->

            

             

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection

@push('scripts')

    <script>

        //line chart
        var line = new Morris.Line({
            element: 'line-chart',
            resize: true,
            data: [
                 
                {
                    ym: " "
                },
                
            ],
            xkey: 'ym',
            ykeys: ['sum'],
            labels: ['@lang('site.total')'],
            lineWidth: 2,
            hideHover: 'auto',
            gridStrokeWidth: 0.4,
            pointSize: 4,
            gridTextFamily: 'Open Sans',
            gridTextSize: 10
        });
    </script>

@endpush 
 