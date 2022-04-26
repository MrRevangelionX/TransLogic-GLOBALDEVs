function closeSession(){
Swal.fire({
  title: 'Seguro que desea salir de la aplicación?',
  text: "Deberá hacer loggin para ingresar de nuevo!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#AA0b0b',
  cancelButtonColor: '#000000',
  confirmButtonText: 'Si, Salir!'
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire(
      'Saliste!',
      'Sesion finalizada correctamente.',
      'success'
    )
    location.href = './check-logout.php';
  }
})
};

function asignarPIN(contratista){
  Swal.fire({
    title: 'Ingrese el nuevo PIN del Contratista',
    input: 'text',
    inputLabel: 'Nuevo PIN:',
    showCancelButton: true,
    inputValidator: (value) => {
        if (!value) {
          return 'No se permiten campos vacios!'
        }
    }
  }).then((result) => {
  if (result.isConfirmed) {
    Swal.fire({
        title: 'Seguro que desea cambiar el PIN de este contratista?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1c8509',
        cancelButtonColor: '#000000',
        confirmButtonText: 'Si, Cambiar!'
      }).then((comfirm) => {
      if (comfirm.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "./API/wsChangePIN.php",
          data: {"contratista": contratista, "pin":result.value},
          dataType: "JSON",
          success: function(){
            Swal.fire({
              title: 'PIN Cambiado correctamente',
              icon: 'success',
              showComfirmButton: false,
              timer: 1500
            })
          }
        });
      }
    })
  }
})
};