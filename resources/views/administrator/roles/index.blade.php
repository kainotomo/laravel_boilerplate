@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <form action="{{route('administrator.roles')}}" method="post">
                @csrf

                <div class="row mb-1">

                    <div class="col">
                        <input type="text" class="form-control" id=search value="{{ request('search', null) }}" name="search" placeholder="Search...">
                    </div>

                    <div class="col">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="permission_name">{{ __('Permission') }}</label>
                            </div>
                            <select class="custom-select" id="permission_name" name="permission_name" onchange="this.form.submit()">
                                <option value="0"> - {{ __('All') }} - </option>
                                @foreach ($permissions as $key => $permission)
                                <option value="{{$permission}}" {{ request('permission_name', null) == $permission ? 'selected' : '' }}>{{$permission}}</option>
                                @endforeach                            
                            </select>
                        </div>
                    </div>
                    
                    <div class="col">
                        <button id="goBtn" name="goBtn" class="btn btn-primary">Go</button>
                        <button id="clearBtn" name="clearBtn" class="btn" onclick="$('#search').val('');">Clear</button>
                    </div>
                </div>

                {{ $roles->appends([
                    'search' => request('search', null),
                ])->links() }}     
            </form>

            <div class="btn-toolbar mb-1" permission="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group mr-2" permission="group" aria-label="First group">                    
                    <a type="button" class="btn btn-success" href="{{ route('administrator.roles.create') }}">{{ __('New') }}</a>
                </div>
                <div class="btn-group mr-2" permission="group" aria-label="Second group">
                    <button type="button" id="btn-bulk-delete" class="btn btn-danger">{{ __('Delete') }}</button>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Roles</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" permission="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="bulk-select-all">
                                </th>
                                <th>Name</th>
                                <th>Guard</th>
                                <th>Permissions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            @if (request('permission_name'))
                            @if ($role->hasPermissionTo(request('permission_name')))
                            <tr data-id="{{ $role->id }}">
                                <td>
                                    <input type="checkbox" class="bulk-select">
                                </td>
                                <td><a href="{{ route('administrator.roles.edit', ['role' => $role]) }}">{{ $role->name }}</a></td>
                                <td>{{ $role->guard_name }}</td>
                                <td>
                                    @foreach ($role->permissions as $permission)
                                    {{ $permission->name }}<br/>
                                    @endforeach
                                </td>
                            </tr>
                            @endif
                            @else
                            <tr data-id="{{ $role->id }}">
                                <td>
                                    <input type="checkbox" class="bulk-select">
                                </td>
                                <td><a href="{{ route('administrator.roles.edit', ['role' => $role]) }}">{{ $role->name }}</a></td>
                                <td>{{ $role->guard_name }}</td>
                                <td>
                                    @foreach ($role->permissions as $permission)
                                    {{ $permission->name }}<br/>
                                    @endforeach
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>                        
                    </table>
                </div>
            </div>
            
        </div>
    </div>

    @component('components.modal_bulk')
    roles
    @endcomponent

</div>
@endsection
