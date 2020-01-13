@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <form action="{{route('administrator.users')}}" method="post">
                @csrf

                <div class="row mb-1">

                    <div class="col">
                        <input type="text" class="form-control" id=search value="{{ request('search', null) }}" name="search" placeholder="Search...">
                    </div>

                    <div class="col">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">{{ __('Role') }}</label>
                            </div>
                            <select class="custom-select" id="role_name" name="role_name" onchange="this.form.submit()">
                                <option value="0"> - {{ __('All') }} - </option>
                                @foreach ($roles as $key => $role)
                                <option value="{{$key}}" {{ request('role_name', null) == $key ? 'selected' : '' }}>{{$role}}</option>
                                @endforeach                            
                            </select>
                        </div>
                    </div>

                    <div class="col">
                        <button id="goBtn" name="goBtn" class="btn btn-primary">Go</button>
                        <button id="clearBtn" name="clearBtn" class="btn" onclick="$('#search').val('');">Clear</button>
                    </div>
                </div>

                {{ $users->appends([
                    'search' => request('search', null),
                ])->links() }}     
            </form>

            <div class="btn-toolbar mb-1" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group mr-2" role="group" aria-label="First group">                    
                    <a type="button" class="btn btn-success" href="{{ route('administrator.users.create') }}">{{ __('New') }}</a>
                </div>
                <div class="btn-group mr-2" role="group" aria-label="Second group">
                    <button type="button" id="btn-bulk-delete" class="btn btn-danger">{{ __('Delete') }}</button>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
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
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Roles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr data-id="{{ $user->id }}">
                                <td>
                                    <input type="checkbox" class="bulk-select">
                                </td>
                                <td><a href="{{ route('administrator.users.edit', ['user' => $user]) }}">{{ $user->name }}</a></td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                    {{ $role->name }}<br/>
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                        </tbody>                        
                    </table>
                </div>
            </div>
        </div>
    </div>

    @component('components.modal_bulk_delete')
    @endcomponent

</div>
@endsection
