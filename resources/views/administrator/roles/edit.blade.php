@extends('layouts.app')

@section('content')
<div class="container">    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Role') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('administrator.roles.update', ['role' => $role])}}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $role->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="guard_name" class="col-md-4 col-form-label text-md-right">{{ __('Guard Name') }}</label>

                            <div class="col-md-6">
                                <input id="guard_name" type="text" class="form-control @error('guard_name') is-invalid @enderror" name="guard_name" value="{{ $role->guard_name }}" required autocomplete="guard_name">

                                @error('guard_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Permissions') }}</label>
                        </div>

                        @foreach ($permissions as $key => $permission)
                        <div class="form-group row">
                            <label for="permission_{{$key}}" class="col-md-6 col-form-label text-md-right">{{ $permission }}</label>
                            <div class="col-md-6">                                     
                                <input class="form-check-input" type="checkbox" value="{{$permission}}" name="permission_{{$key}}" {{ $role->hasPermissionTo($permission) ? 'checked' : '' }}>
                            </div>
                        </div>
                        @endforeach

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="$('#save_close').val(1);">
                                    {{ __('Save & Close') }}
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                                <a href="{{ route('administrator.roles')}}" class="btn btn-secondary">
                                    {{ __('Close') }}
                                </a>
                                <input id="save_close" name="save_close" type="hidden" value="0"/>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
