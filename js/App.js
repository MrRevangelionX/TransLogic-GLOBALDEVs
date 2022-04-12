$(document).ready(function () {
  
});

function closeSession(){
Swal.fire({
  title: 'Seguro que desea salir de la aplicación?',
  text: "Deberá hacer loggin para ingresar de nuevo!",
  icon: 'error',
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