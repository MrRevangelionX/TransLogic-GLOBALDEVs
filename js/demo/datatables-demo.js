$(document).ready( function () {
  $('#acarreosTable').DataTable( {
    dom: 'Bfrtip',
    buttons: [
        'print', 'excel', 'pdf'
    ]
} );
} );