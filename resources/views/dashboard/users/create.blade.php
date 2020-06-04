@extends('layouts.dashboard.app')
@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.users')</h1>

            <ol class="breadcrumb">
            <li class="active"> <a href='{{route("dashboard.index")}}'> <i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
             <li class="active"> <a href='{{route("dashboard.users.index")}}'> <i class="fa fa-user"></i> @lang('site.users')</a></li>
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
                 <form action='{{route("dashboard.users.store")}}' method='post' enctype='multipart/form-data' >
                    @csrf
                    <div class='form-group'>
                       <lable >@lang('site.first_name')</lable>
                       <input type='text' name='first_name' class='form-control'value='{{old("first_name")}}'/>                          
                    </div>
                    <div class='form-group'>
                       <lable >@lang('site.last_name')</lable>
                       <input type='text' name='last_name' class='form-control'value='{{old("last_name")}}'/>                          
                    </div>
                    <div class='form-group'>
                       <lable >@lang('site.email')</lable>
                       <input type='email' name='email' class='form-control'value='{{old("email")}}'/>                          
                    </div>
                    <div class='form-group'>
                       <lable >@lang('site.password')</lable>
                       <input type='password' name='password' class='form-control' />                          
                    </div>
                    <div class='form-group'>
                       <lable >@lang('site.password_confirmation')</lable>
                       <input type='password' name='password_confirmation' class='form-control' />                          
                    </div>
                    <div class='form-group'>
                       <lable >@lang('site.image')</lable>
                       <input type='file' name='image' class='form-control' onchange="loadFile(event)" />                          
                    </div>
                    <div class='form-group'>
                       <img id="output" src='{{asset("uploads/users_images/default.jpg")}}' style='width:100px' alt='' />                        
                    </div>

                    <div class="form-group">
                            <label>@lang('site.permissions')</label>
                            <div class="nav-tabs-custom">

                                @php
                                    $models = ['users', 'categories', 'products', 'clients', 'orders'];
                                    $maps = ['create', 'read', 'update', 'delete'];
                                @endphp

                                <ul class="nav nav-tabs">
                                    @foreach ($models as $index=>$model)
                                        <li class="{{ $index == 0 ? 'active' : '' }}"><a href="#{{ $model }}" data-toggle="tab">@lang('site.' . $model)</a></li>
                                    @endforeach
                                </ul>

                                <div class="tab-content">

                                @foreach ($models as $index=>$model)

                                        <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="{{ $model }}">

                                            @foreach ($maps as $map)
                                                <label><input type="checkbox" name="permissions[]" value="{{ $map . '_' . $model }}"> @lang('site.' . $map)</label>
                                            @endforeach

                                        </div>

                                 @endforeach

                                </div><!-- end of tab content -->
                                
                            </div><!-- end of nav tabs -->
                            
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
 