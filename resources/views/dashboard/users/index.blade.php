@extends('layouts.dashboard.app')
@section('content')
 
    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.users')</h1>

            <ol class="breadcrumb">
              <li class="active">  <a href='{{route("dashboard.index")}}'> <i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
              <li class="active">  <i class="fa fa-user"></i> @lang('site.users')</li>
            </ol>
        </section>

        <section class="content">
          <div  class='box box-primary' >
               <div class='box-header with-border'>
                   <h3 class='box-title'>@lang('site.users')({{$users->count()}})</h3>
                   <form>
                      @csrf
                     <div class='row'>
                        <div class='col-md-4'>
                          <input type='text'name='search'placeholder='@lang("search")' class='form-control' value='{{request()->search}}'/>
                        </div>
                        <div class='col-md-4'>
                        <button class='btn btn-primary btn-sm' type='submit'> <i class=' fa fa-search' ></i>@lang('site.search')</button>
                        @if(auth()->user()->haspermission('create_users'))
                        <a href='{{route("dashboard.users.create" )}}' class='btn btn-info btn-sm'><i class=' fa fa-plus' ></i> @lang('site.add')</a>
                        @else
                        <a  class='btn btn-info btn-sm disabled'><i class=' fa fa-plus' ></i> @lang('site.add')</a>
                        @endif
                        </div>                                                            
                     </div>                                    
                   </form>
                  
               
               </div>
               <div class='box-body'>
               @if($users->count()>0)
               <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th>#</th>  
                      <th>@lang('site.first_name')</th>
                      <th>@lang('site.last_name')</th>
                      <th>@lang('site.email')</th>
                      <th>@lang('site.image')</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                  @foreach($users as $index=>$user)
                  <tr>
                   <td>{{$index +1}}</td>
                   <td>{{$user->first_name}}</td>
                   <td>{{$user->last_name}}</td>
                   <td>{{$user->email}}</td>
                   <td><img src='{{$user->image_path }}' alt='' style='width:100px'/></td>
                   <td> 
                      @if(auth()->user()->haspermission('update_users'))
                       <a href='{{route("dashboard.users.edit",$user->id)}}'   class='btn btn-info btn-sm'><i class='fa fa-edit'></i> @lang('site.edit')</a>
                       @else
                       <a class='btn btn-info btn-sm disabled'><i class='fa fa-edit'></i> @lang('site.edit')</a>
                      @endif
                      @if(auth()->user()->haspermission('delete_users'))
                       <form action='{{route("dashboard.users.destroy",$user->id)}}' style="display:inline-block"  method='post'>
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
               {{$users->appends(request()->query())->links()}}
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
 