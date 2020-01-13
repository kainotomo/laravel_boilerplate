
// Select all
$('#bulk-select-all').click(function (e) {
    var table = $(e.target).closest('table');
    $('td input.bulk-select:checkbox', table).prop('checked', this.checked);
});

/**
 * Handle bulk action (ban or delete the selected members).
 *
 * @param $action ("ban", "delete")
 */
function handleBulkAction($action) {
    var $selected = $('input.bulk-select:checked');
    var $ids = [];

    $selected.each(function () {
        $ids.push($(this).closest('tr').data('id'));
    });

    if ($ids.length > 0) {
        $('#bulk-' + $action + ' #' + $action + '-bulk_ids').val($ids.reverse());
        $('#bulk-' + $action).modal('show');
    } else {
        $('#bulk-select-all').prop('checked', false);
        alert('There\'s nothing to ' + $action + '. Please select members you want to ' + $action + '.');
    }
}

// BULK ACTION: Trash items
$('#btn-bulk-trash').click(function (e) {
    handleBulkAction('trash');
});

// BULK ACTION: Delete items
$('#btn-bulk-delete').click(function (e) {
    handleBulkAction('delete');
});

// BULK ACTION: Restore items
$('#btn-bulk-restore').click(function (e) {
    handleBulkAction('restore');
});


// When modal closes - uncheck all checkboxes
$('#bulk-trash, #bulk-delete, #bulk-restore').each(function () {
    $(this).on('hidden.bs.modal', function (e) {
        $('#bulk-select-all').prop('checked', false);
        $('input.bulk-select').prop('checked', false);
    })
});