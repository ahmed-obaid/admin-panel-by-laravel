@extends('layouts.dashboard.app')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.products')</h1>

            <ol class="breadcrumb">
            <li class="active"> <a href='{{route("dashboard.index")}}'> <i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
             <li class="active"> <a href='{{route("dashboard.products.index")}}'> <i class="fa fa-user"></i> @lang('site.products')</a></li>
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
                 <form action='{{route("dashboard.products.store")}}' method='post' enctype='multipart/form-data'   >
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
                    <div class='form-group'>
                        <lable >@lang('site.category')</lable>
                         <select name='category_id' class='form-control' >
                             @if(app()->getlocale()=='ar')
                                 @foreach($categories as $category)                           
                                     <option value='{{$category->id}}'>{{$category->name_ar}} </option>                                         
                                  @endforeach 
                             @else
                                 @foreach($categories as $category)
                                    <option value='{{$category->id}}'>{{$category->name_en}} </option> 
                                 @endforeach
                             @endif
                        </select>                       
                    </div>
                    <div class='form-group'>
                       <lable >@lang('site.purchase_price')</lable>
                       <input type='text' name='purchase_price' step='0.01' class='form-controll'value='{{old("purchase_price")}}'/>                          
                    </div>
                    <div class='form-group'>
                       <lable >@lang('site.sale_price')</lable>
                       <input type='text' name='sale_price' step='0.01'  class='form-controll'value='{{old("sale_price")}}'/>                          
                    </div>
                    <div class='form-group'>
                       <lable >@lang('site.stock')</lable>
                       <input type='text' name='stock' class='form-controll'value='{{old("stock")}}'/>                          
                    </div>
                    <div class='form-group'>
                       <lable >@lang('site.image')</lable>
                       <input type='file' name='image' class='form-controll' onchange="loadFile(event)" />                          
                    </div>

                    <div class='form-group'>
                       <img id="output" src='{{asset("uploads/products_images/default.jpg")}}' style='width:100px' alt='' />                        
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
 