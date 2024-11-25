// notify|toastr-init.js

// Toastr|
function showToastr(message, tipoAlerta, title = false) {

   toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": true,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
   };
   
   switch(tipoAlerta) {
       case 'success':
           toastr.success(message, (title)?"Éxito":'');
           break;
       case 'error':
           toastr.error(message, (title)?"Error":'');
           break;
       case 'warning':
           toastr.warning(message, (title)?"Advertencia":'');
           break;
       case 'info':
           toastr.info(message, (title)?"Información":'');
           break;
       default:
            toastr.info(message, (title)?"Notificación":'');
   }
   
}


// SwalAlert|

function showAlertAdvanced(title, message, typeAlert, typeIcon = '', buttonOptions = {}) {
   const {
       cancelButtonText = { text: 'Cancelar', color: 'btn-label-secondary' },
       denyButtonText = { text: 'Denegar', color: 'btn-info' },
       confirmButtonText = { text: 'Confirmar', color: 'btn-primary' },
   } = buttonOptions;

   
   return Swal.fire({
       title: title,
       text: message,
       icon: typeAlert,
       iconHtml: (typeIcon) ? `<i class="${typeIcon}"></i>` : '',
       showCancelButton: true,
       showDenyButton: true,
       cancelButtonText: cancelButtonText.text,
       denyButtonText: denyButtonText.text,
       confirmButtonText: confirmButtonText.text,
       customClass: {
           cancelButton: `btn ${cancelButtonText.color} waves-effect waves-light`,
           denyButton: `btn ${denyButtonText.color} waves-effect waves-light`,
           confirmButton: `btn ${confirmButtonText.color} me-2 waves-effect waves-light`,
       },
       buttonsStyling: false
   }).then((result) => {
       return { isConfirmed: result.isConfirmed, isDenied: result.isDenied, dismissReason: result.dismiss };
   });

}


function showAlert(title, message, typeAlert, typeIcon = '') {

   return Swal.fire({
       title: title,
       text: message,
       icon: typeAlert,
       iconHtml: (typeIcon) ? `<i class="${typeIcon}"></i>` : '',
       showCancelButton: true,
       cancelButtonText: 'Cancelar',
       confirmButtonText: 'Confirmar',
       customClass: {
         cancelButton: 'btn mb-1 waves-effect waves-light btn-light',
         confirmButton: 'btn mb-1 waves-effect waves-light btn-danger',
       },
       buttonsStyling: true

   }).then((result) => {
       return { isConfirmed: result.isConfirmed, dismissReason: result.dismiss };
   });

   // type alert
   // 'success': Icono de éxito (verificación verde).
   // 'error': Icono de error (cruz roja).
   // 'warning': Icono de advertencia (triángulo amarillo).
   // 'info': Icono de información (círculo azul con una "i").
   // 'question': Icono de pregunta (signo de interrogación).
}

function showAlertSimple(title, message, typeAlert, typeIcon = '') {
   return Swal.fire({
       title: title,
       text: message,
       icon: typeAlert,
       iconHtml: (typeIcon) ? `<i class="${typeIcon}"></i>` : '',
       customClass: {
           confirmButton: 'btn btn-success waves-effect waves-light'
       }
   });
}

// others toolsCustom

function displayErrors(errors){
    Object.keys(errors).forEach((key) => {
        const element = document.querySelector(`[name="${key}"]`);
        const controlsContainer = element.closest('.controls');        
        const helpBlock = controlsContainer.querySelector('.help-block');
        helpBlock.innerHTML = `<ul role="alert"><li>${errors[key]}</li></ul>`;

        const validBlock = element.closest('.form-group');
        validBlock.classList.remove('validate');
        validBlock.classList.add('error');

    });
}

function clearInputsForm(form){
    form.querySelectorAll('input, select, textarea').forEach(element => {
        if (element.name !== '_token') {
            element.value = '';
        }
    });
}