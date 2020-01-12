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
                    <button type="button" id="btn-bulk-delete" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary">2</button>
                    <button type="button" class="btn btn-secondary">3</button>
                    <button type="button" class="btn btn-secondary">4</button>
                </div>
                <div class="btn-group mr-2" role="group" aria-label="Second group">
                    <button type="button" class="btn btn-secondary">5</button>
                    <button type="button" class="btn btn-secondary">6</button>
                    <button type="button" class="btn btn-secondary">7</button>
                </div>
                <div class="btn-group" role="group" aria-label="Third group">
                    <button type="button" class="btn btn-secondary">8</button>
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
    
    {{-- Modal Bulk Delete --}}
    <div class="modal fade" id="bulk-delete" tabindex="-1" role="dialog" aria-labelledby="bulkDeleteMembersModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header clearfix">
                    <h4 class="modal-title pull-left text-danger" id="bulkDeleteMembersModalLabel">Delete Selected Items</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <p class="alert alert-danger">
                        Are you sure you want to delete the selected items?
                    </p>
                </div>

                <div class="modal-footer">
                    <form id="frmBulkDeleteMembers" method="get" action="{{ route('administrator.users.delete') }}">
                        @csrf

                        <div class="d-none" style="display: none">
                            <input id="delete-bulk_ids" name="bulk_ids" type="text">
                        </div>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger btn-ok text-white">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
