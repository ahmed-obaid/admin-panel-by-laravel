@extends('layouts.dashboard.app')
@section('content')
 
    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.products')</h1>

            <ol class="breadcrumb">
              <li class="active">  <a href='{{route("dashboard.index")}}'> <i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
              <li class="active">  <i class="fa fa-user"></i> @lang('site.products')</li>
            </ol>
        </section>

        <section class="content">
          <div  class='box box-primary' >
               <div class='box-header with-border'>
                   <h3 class='box-title'>@lang('site.products')({{$products->count()}})</h3>
                   <form>
                     
                     <div class='row'>
                        <div class='col-md-4'>
                          <input type='text'name='search'placeholder='@lang("search")' class='form-control' value='{{request()->search}}'/>
                        </div>

                        <div class='col-md-4' class='form-group' >
                           <select name='category_id' class='form-control'>
                             @foreach($categories as $category)                          
                                <option value='{{$category->id}}' {{request()->category_id==$category->id?'selected':''}}> {{$category->name_ar}} </option>                                                                                                    
                             @endforeach
                           </select>                           
                        </div>
                       
                        <div class='col-md-4'>
                        <button class='btn btn-primary btn-sm' type='submit'> <i class=' fa fa-search' ></i>@lang('site.search')</button>
                        @if(auth()->user()->haspermission('create_products'))
                        <a href='{{route("dashboard.products.create" )}}' class='btn btn-info btn-sm'><i class=' fa fa-plus' ></i> @lang('site.add')</a>
                        @else
                        <a  class='btn btn-info btn-sm disabled'><i class=' fa fa-plus' ></i> @lang('site.add')</a>
                        @endif
                        </div>                                                            
                     </div>                                    
                   </form>
                   
                  
               
               </div>
               <div class='box-body'>
               @if($products->count()>0)
               <table class="table table-bordered">
                  <thead>                  
                    <tr>
                                 <th>#</th>  
                      
                      
                                <th>@lang('site.name')</th>
                                <th>@lang('site.description')</th>
                                <th>@lang('site.category')</th>
                                <th>@lang('site.image')</th>
                                <th>@lang('site.purchase_price')</th>
                                <th>@lang('site.sale_price')</th>
                                <th>@lang('site.profit_percent') %</th>
                                <th>@lang('site.stock')</th>
                                <th>@lang('site.action')</th>
                  
                    </tr>
                  </thead>
                  <tbody>
                  
                  @foreach($products as $index=>$product)
                  
                  <tr>
                   <td>{{$index +1}}</td>
                   <td>{{$product->name}}</td>
                   @if(App()->getlocale()=='ar')
                    
                     <td>{{$product->desc_ar}}</td>
                   @endif
                   @if(App()->getlocale()=='en')
                     
                     <td>{{$product->desc_en}}</td>
                   @endif 
                   <td> {{$product->category->name_ar}}  </td>  
                   <td> <img src="{{asset('uploads/products_images/'.$product->image)}}" style='width:100px' />  </td>
                   <td> {{$product->purchase_price}}  </td> 
                   <td> {{$product->sale_price}} </td> 
                   <td>% {{$product->profit}}  </td>
                   <td> {{$product->stock}} </td>               
                   <td> 
                      @if(auth()->user()->haspermission('update_products'))
                       <a href='{{route("dashboard.products.edit",$product->id)}}'   class='btn btn-info btn-sm'><i class='fa fa-edit'></i> @lang('site.edit')</a>
                       @else
                       <a class='btn btn-info btn-sm disabled'><i class='fa fa-edit'></i> @lang('site.edit')</a>
                      @endif
                      @if(auth()->user()->haspermission('delete_products'))
                       <form action='{{route("dashboard.products.destroy",$product->id)}}' style="display:inline-block"  method='post'>
                         @csrf  
                         {{method_field('delete')}}
                         <button class='btn btn-danger btn-sm delete' type='submit'> <i class='fa fa-trash'></i> @lang('site.delete')</button>
                       </form>
                       @else
                       <a class='btn btn-info btn-sm disabled'><i class='fa fa-trash'></i> @lang('site.delete')</a>
                      @endif
                   </td>                 
                  </tr>
                  @endforeach
                  </tbody>
               </table>
               {{$products->appends(request()->query())->links()}}
               @else
                <h3>@lang('site.no_data_found')</h3>
                @endif
               </div>
          
          
          </div>

            

             

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
 