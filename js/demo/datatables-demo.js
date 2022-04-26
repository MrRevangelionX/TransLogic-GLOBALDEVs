$(document).ready( function () {
  $('#dataTablePlugin').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'print', 'excel', 'pdf'
    ]
  });
});