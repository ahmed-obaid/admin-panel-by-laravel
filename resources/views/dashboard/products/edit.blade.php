@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.products')</h1>

            <ol class="breadcrumb">
                <li><a href=" "><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.products.index') }}"> @lang('site.products')</a></li>
                <li class="active">@lang('site.edit')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.edit')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.products.update', $product->id) }}" method="post" enctype='multipart/form-data' >

                        {{ csrf_field() }}
                        {{ method_field('put') }}

                        <div class="form-group">
                            <label>@lang('site.ar.name')</label>
                            <input type="text" name="name_ar" class="form-control" value="{{ $product->name_ar }}">
                        </div>
                        <div class="form-group">
                            <label>@lang('site.en.name')</label>
                            <input type="text" name="name_en" class="form-control" value="{{ $product->name_en }}">
                        </div>
                        <div class="form-group">
                            <label>@lang('site.ar.description')</label>
                            <input type="text" name="desc_ar" class="form-control" value="{{ $product->desc_ar }}">
                        </div>
                        <div class="form-group">
                            <label>@lang('site.en.description')</label>
                            <input type="text" name="desc_en" class="form-control" value="{{ $product->desc_en }}">
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
                       <input type='text' name='purchase_price' step='0.01'  class='form-controll'value='{{$product->purchase_price}}'/>                          
                    </div>
                    <div class='form-group'>
                       <lable >@lang('site.sale_price')</lable>
                       <input type='text' name='sale_price' step='0.01'  class='form-controll'value='{{ $product->sale_price}}'/>                          
                    </div>
                    <div class='form-group'>
                       <lable >@lang('site.stock')</lable>
                       <input type='text' name='stock' class='form-controll' value='{{$product-> stock}}'/>                          
                    </div>
                    <div class='form-group'>
                       <lable >@lang('site.image')</lable>
                       <input type='file' name='image' class='form-controll' onchange="loadFile(event)" />                          
                    </div>

                    <div class='form-group'>
                      
                       <img id='output' src='{{asset("uploads/products_images/".$product->image)}}'style='width:100px' />                          
                    </div>
                     
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
