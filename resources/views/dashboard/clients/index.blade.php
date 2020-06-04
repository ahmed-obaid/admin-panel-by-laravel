@extends('layouts.dashboard.app')
@section('content')
 
    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.clients')</h1>

            <ol class="breadcrumb">
              <li class="active">  <a href='{{route("dashboard.index")}}'> <i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
              <li class="active">  <i class="fa fa-user"></i> @lang('site.clients')</li>
            </ol>
        </section>

        <section class="content">
          <div  class='box box-primary' >
               <div class='box-header with-border'>
                   <h3 class='box-title'>@lang('site.clients')({{$clients->count()}})</h3>
                   <form>
                      @csrf
                     <div class='row'>
                        <div class='col-md-4'>
                          <input type='text'name='search'placeholder='@lang("search")' class='form-control' value='{{request()->search}}'/>
                        </div>
                        <div class='col-md-4'>
                        <button class='btn btn-primary btn-sm' type='submit'> <i class=' fa fa-search' ></i>@lang('site.search')</button>
                        @if(auth()->user()->haspermission('create_clients'))
                        <a href='{{route("dashboard.clients.create" )}}' class='btn btn-info btn-sm'><i class=' fa fa-plus' ></i> @lang('site.add')</a>
                        @else
                        <a  class='btn btn-info btn-sm disabled'><i class=' fa fa-plus' ></i> @lang('site.add')</a>
                        @endif
                        </div>                                                            
                     </div>                                    
                   </form>
                  
               
               </div>
               <div class='box-body'>
               @if($clients->count()>0)
               <table class="table table-bordered">
                  <thead>                  
                    <tr>
                       <th>#</th>
                       <th>@lang('site.name')</th>
                       <th>@lang('site.phone')</th>
                       <th>@lang('site.add_order')</th>
                       <th>@lang('site.address')</th> 
                       <th>@lang('site.action')</th>                      
                    </tr>
                  </thead>
                  <tbody>
                  
                  @foreach($clients as $index=>$client)
                  <tr>
                     <td>{{$index +1}}</td>
                  
                     <td>{{$client->name}}</td>
                     {{--------- implode(array_filter($client->phone),'-') ----------- ---------}}
                     <td>{{$client->phone[1]}}-{{$client->phone[0]}}</td>
                     <td>
                     @if(auth()->user()->haspermission('create_orders'))
                      <a href='{{route("dashboard.clients.order.create",$client->id)}}' class='btn btn-info'> @lang('site.add_order') </a> 
                      @else
                      <a href=' #' class='btn btn-info disabled'> @lang('site.add_order') </a> 
                      @endif
                    </td> 
                     <td>{{$client->address}} </td>                   
                                            
                   <td> 
                      @if(auth()->user()->haspermission('update_clients'))
                       <a href='{{route("dashboard.clients.edit",$client->id)}}'   class='btn btn-info btn-sm'><i class='fa fa-edit'></i> @lang('site.edit')</a>
                       @else
                       <a class='btn btn-info btn-sm disabled'><i class='fa fa-edit'></i> @lang('site.edit')</a>
                      @endif
                      @if(auth()->user()->haspermission('delete_clients'))
                       <form action='{{route("dashboard.clients.destroy",$client->id)}}' style="display:inline-block"  method='post'>
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
               {{$clients->appends(request()->query())->links()}}
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
 