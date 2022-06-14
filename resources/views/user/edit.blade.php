@extends('layout.main') @section('content')

@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.Update')}} {{trans('file.User')}}</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        {!! Form::open(['route' => ['users.update', $lsms_user_data->id], 'method' => 'put', 'files' => true]) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>{{trans('file.Name')}} *</strong> </label>
                                        <input type="text" name="name" required class="form-control" value="{{$lsms_user_data->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>{{trans('file.UserName')}} *</strong> </label>
                                        <input type="text" name="username" required class="form-control" value="{{$lsms_user_data->username}}">
                                        @if($errors->has('username'))
                                       <span>
                                           <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label><strong>{{trans('file.Password')}}</strong> </label>
                                        <div class="input-group">
                                            <input type="password" name="password" class="form-control">
                                            <div class="input-group-append">
                                                <button id="genbutton" type="button" class="btn btn-default">{{trans('file.Generate')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>{{trans('file.Address')}} *</strong></label>
                                        <textarea name="address" rows="5" class="form-control">{{$lsms_user_data->address}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>{{trans('file.Email')}} *</strong></label>
                                        <input type="email" name="email" value="{{$lsms_user_data->email}}" required class="form-control">
                                        @if($errors->has('email'))
                                       <span>
                                           <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label><strong>{{trans('file.Phone Number')}} *</strong></label>
                                        <input type="text" name="phone" required class="form-control" value="{{$lsms_user_data->phone}}">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>{{trans('file.Company Name')}} *</strong></label>
                                        <input type="text" name="company_name" class="form-control" required value="{{$lsms_user_data->company_name}}">
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="role_hidden" value="{{$lsms_user_data->role}}">
                                        <label><strong>{{trans('file.Role')}} *</strong></label>
                                        <select name="role" required class="selectpicker form-control"data-live-search="true" data-live-search-style="begins" title="Select Role...">
                                          @foreach($lsms_role_list as $role)
                                              <option value="{{$role->id}}">{{$role->name}}</option>
                                          @endforeach
                                        </select>
                                    </div>
                                </div>                              
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

    $("ul#user").siblings('a').attr('aria-expanded','true');
    $("ul#user").addClass("show");
    
    $('.selectpicker').selectpicker({
      style: 'btn-link',
    });

    $("select[name='role']").val($("input[name='role_hidden']").val());
    $('.selectpicker').selectpicker('refresh');

    $('#genbutton').on("click", function(){
      $.get('genpass', function(data){
        $("input[name='password']").val(data);
      });
    });
</script>
@endsection