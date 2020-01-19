{{-- Modal Bulk Trash --}}
<div class="modal fade" id="bulk-trash" tabindex="-1" role="dialog" aria-labelledby="bulkTrashMembersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix">
                <h4 class="modal-title pull-left text-danger" id="bulkTrashMembersModalLabel">{{ __('Trash Selected Items') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <p class="alert alert-danger">
                    {{ __('Are you sure you want to trash the selected items?') }}
                </p>
            </div>

            <div class="modal-footer">
                <form id="frmBulkTrashMembers" method="get" action="{{ route($slot.'.trash', $vars) }}">
                    @csrf

                    <div class="d-none" style="display: none">
                        <input id="trash-bulk_ids" name="bulk_ids" type="text">
                    </div>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
                    <button type="submit" class="btn btn-danger btn-ok text-white">{{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Bulk Delete --}}
<div class="modal fade" id="bulk-delete" tabindex="-1" role="dialog" aria-labelledby="bulkDeleteMembersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix">
                <h4 class="modal-title pull-left text-danger" id="bulkDeleteMembersModalLabel">{{ __('Delete Selected Items') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <p class="alert alert-danger">
                    {{ __('Are you sure you want to delete the selected items?') }}
                </p>
            </div>

            <div class="modal-footer">
                <form id="frmBulkDeleteMembers" method="get" action="{{ route($slot.'.delete', $vars) }}">
                    @csrf

                    <div class="d-none" style="display: none">
                        <input id="delete-bulk_ids" name="bulk_ids" type="text">
                    </div>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
                    <button type="submit" class="btn btn-danger btn-ok text-white">{{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Bulk Restore --}}
<div class="modal fade" id="bulk-restore" tabindex="-1" role="dialog" aria-labelledby="bulkRestoreMembersModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix">
                <h4 class="modal-title pull-left text-danger" id="bulkRestoreMembersModalLabel">{{ __('Restore Selected Items') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <p class="alert alert-danger">
                    {{ __('Are you sure you want to restore the selected items?') }}
                </p>
            </div>

            <div class="modal-footer">
                <form id="frmBulkRestoreMembers" method="get" action="{{ route($slot.'.restore', $vars) }}">
                    @csrf

                    <div class="d-none" style="display: none">
                        <input id="restore-bulk_ids" name="bulk_ids" type="text">
                    </div>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
                    <button type="submit" class="btn btn-danger btn-ok text-white">{{ __('Yes') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>