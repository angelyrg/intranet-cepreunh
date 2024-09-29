logos/dark-logo.svg
function initSelect2Icons($selector) {

   $($selector).select2({
      minimumResultsForSearch: Infinity,
      placeholder: "Seleccione una carrera",
      allowClear: true,
      templateResult: iconFormat,
      templateSelection: iconFormat,
      escapeMarkup: function (es) {
         return es;
      },
   });
}
function iconFormat(ficon) {
   var originalOption = ficon.element;
   if (!ficon.id) {
   return ficon.text;
   }
   var $ficon = "<i class='ti ti-" + $(ficon.element).data("flag") + "'></i>" +
   ficon.text;
   return $ficon;
}

$(document).ready(function() {

   /**
    *  date:20240808|dev:nesk
    *  app:docentes|start
    */

   // $(".select2").select2();
   // $("#select2-icons").select2({
   //    minimumResultsForSearch: Infinity,
   //    templateResult: iconFormat,
   //    templateSelection: iconFormat,
   //    escapeMarkup: function (es) {
   //    return es;
   //    },
   // });

   initSelect2Icons('.select2-icons');   


   // variables | Carreraciclo
   const config = {
      modalSelector: "#modalCarreraciclo",
      formSelector: '#formCarreraciclo',
      tableSelector: '#tblCarreraciclo tbody',
      addButtonSelector: '.btnAddCarreraciclo',
      editButtonSelector: '.btnEditCarreraciclo',
      deleteButtonSelector: '.btnDeleteCarreraciclo',
      baseUrl: '/intranet/carreraciclo'
   };

   // funciones
   const handleRequest = async (url, method, formData) => {
      const response = await fetch(url, {
         method,
         body: formData,
         headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
         }
      });

      if (!response.ok) {
         
         const errorData = await response.json();
         if (response.status === 422) {

            displayErrors(errorData.errors);
         }
         throw new Error(errorData.message || 'Error en la solicitud');
      }

      return response.json();
   };

   // const updateTableUI = (data) => {
   //    console.log(data);
   //    $(config.tableSelector).html(data.datatable);
   //    $(config.modalSelector).modal('hide');
   //    showToastr(data.message, 'success');
   // };

   // const clearForm = (form) => {
   //    form.reset();

   //    const hiddenIdField = form.querySelector('#id');
   //    if (hiddenIdField) hiddenIdField.value = '';

   //    form.querySelectorAll('.form-group').forEach(function(group) {
   //       group.classList.remove('error');
   //       group.classList.add('validate');
   //     });
   //     form.querySelectorAll('.help-block').forEach(function(helpBlock) {
   //       helpBlock.innerHTML = '';
   //     });
   //     form.querySelectorAll('input, select, textarea').forEach(function(field) {
   //       field.setAttribute('aria-invalid', 'false');
   //     });
     
   // };

   // const fillForm = (form, data) => {
   //    Object.keys(data).forEach(key => {
   //       console.log(key);
   //       const input = form.querySelector(`#${key}`);
   //       if (input) {
   //          if (input.type === 'checkbox') {
   //             input.checked = !!data[key];
   //          } else if (input.type === 'radio') {
   //             const radio = form.querySelector(`#${key}[value="${data[key]}"]`);
   //             if (radio) radio.checked = true;
   //          } else if (input.tagName === 'SELECT') {
   //             input.value = data[key];
   //             input.dispatchEvent(new Event('change'));
   //          } else {
   //             input.value = data[key];
   //          }
   //       }
   //       // if (input) input.value = data[key];
   //    });
   // };
   
   // insert|update
   
   const formAsignatura = document.getElementById('formCarreraciclo');   
   formAsignatura.addEventListener('submit', async function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      const id  = document.getElementById('id').value;
      const url = id ? `${config.baseUrl}/${id}` : this.getAttribute('action');
      if (id) formData.append('_method', 'PATCH');

      try {
         const data = await handleRequest(url, 'POST', formData);
         console.log(data);
         if (data.success) {
            showToastr(data.message, 'success');
            $('#tblCarreraciclo').html(data.datatable);
            $('#carrera_idCarreraciclo').html(data.sltCarreras);
            initSelect2Icons('.select2-icons');
            // updateTableUI(data);
         } else {
            console.error('Error al procesar:', data.message);
         }
      } catch (error) {
            console.error('Error:', error.message);
      }
   });

   // openEdit|delete
   const buttonsTblCarreraciclo = document.getElementById('tblCarreraciclo');
   buttonsTblCarreraciclo.addEventListener('click', async function(e) {

      const deleteButton = e.target.closest('.btnDeleteCarreraCiclo');
      if (deleteButton) {
         const result = await showAlert('¿Desea eliminar este registro?', '¡Recuerda que una vez aprobado la asignación de carrera no podrá asignar ni eliminar!', 'question');
         if (result.isConfirmed) {
            e.preventDefault();
            const id = deleteButton.getAttribute('data-id');
            try {
               const checkboxes = document.querySelectorAll(`#tblAreaCiclo_${id} input[name="carreraciclo[]"]`);
               const idCiclo = document.getElementById('ciclo_idCarreraciclo').value;

               let selectedValues = [];
    
               checkboxes.forEach(checkbox => {
                  if (checkbox.checked) {
                     selectedValues.push({
                        id: checkbox.getAttribute('data-id')
                     });
                  }
               });
               
               // Verifica qué datos se están enviando (opcional)
               console.log(selectedValues);

               const formData = new FormData();
               formData.append('_method', 'PATCH');
               formData.append('ciclo_id', idCiclo);
               formData.append('estado', 5);
               formData.append('selectedValues', JSON.stringify(selectedValues)); 
               const data = await handleRequest(`${config.baseUrl}/${id}/eliminar`, 'POST', formData);
               if (data.success) {
                  // updateTableUI(data);
                  showToastr(data.message, 'success');
                  $('#tblCarreraciclo').html(data.datatable);
                  $('#carrera_idCarreraciclo').html(data.sltCarreras);
                  initSelect2Icons('.select2-icons');
               } else {
                  showAlertSimple('Error', 'Hubo un problema al eliminar el registro', 'error');
               }
            } catch (error) {
               console.error('Error al eliminar:', error);
               showToastr('No se pudo completar la operación','warning');
            }
         } else if (result.dismissReason == Swal.DismissReason.cancel) {
            showToastr('No se actualizó el proceso','info');
         }
      }
   });

   document.body.addEventListener('click', function(event) {
      if (event.target.classList.contains('btnRemoveCarreraAll')) {
         let elemento = event.target;
         let idArea = elemento.getAttribute('data-idarea');
         let idTableArea = document.querySelector(`#tblAreaCiclo_${idArea}`).id;

         let buttons = document.querySelectorAll(`#${idTableArea} .btnDeleteCarreraCiclo`);
         let cantCarreraArea = document.querySelectorAll(`#${idTableArea} tbody .inputCarrera${idArea}`).length;
         let isAllCheckedCarrera = document.querySelectorAll(`#${idTableArea} thead .inputCarrera${idArea}:checked`).length > 0;

         if(cantCarreraArea){
            buttons.forEach(button => {
               if (isAllCheckedCarrera) {
               document.querySelectorAll(`#${idTableArea} tbody .inputCarrera${idArea}`).forEach(function(checkbox) { checkbox.checked = true; });
   
                  button.style.opacity = 0;
                  button.style.transition = 'opacity 0.4s';
                  button.style.opacity = 1;
                  setTimeout(() => button.style.display = 'inline-block', 200);
               } else {
               document.querySelectorAll(`#${idTableArea} tbody .inputCarrera${idArea}`).forEach(function(checkbox) { checkbox.checked = false; });
   
                  button.style.opacity = 1;
                  button.style.transition = 'opacity 0.4s';
                  button.style.opacity = 0;
                  setTimeout(() => button.style.display = 'none', 400);
               }
            });
         }else{
            showToastr('No hay carreras asignadas en esta área', 'info');
            
         }

      }

      if (event.target.classList.contains('btnRemoveCarrera')) {
         let elemento = event.target;
         let idArea = elemento.getAttribute('data-idarea');

         let idTableArea = document.querySelector(`#tblAreaCiclo_${idArea}`).id;
         let buttons = document.querySelectorAll(`#${idTableArea} .btnDeleteCarreraCiclo`);

         let cantCarreraArea = document.querySelectorAll(`#${idTableArea} tbody .inputCarrera${idArea}`).length;
         let isCheckedCarrera = document.querySelectorAll(`#${idTableArea} tbody .inputCarrera${idArea}:checked`).length;

         buttons.forEach(button => {
            if (isCheckedCarrera > 0) {
               button.style.opacity = 0;
               button.style.transition = 'opacity 0.4s';
               button.style.opacity = 1;
               setTimeout(() => button.style.display = 'inline-block', 200);
            } else {
               $(`#${idTableArea} thead .inputCarrera${idArea}`).prop('checked',false);

               button.style.opacity = 1;
               button.style.transition = 'opacity 0.4s';
               button.style.opacity = 0;
               setTimeout(() => button.style.display = 'none', 400);
            }
         });
         
         if(cantCarreraArea == isCheckedCarrera){
            $(`#${idTableArea} thead .inputCarrera${idArea}`).prop('checked',true);
         }else{
            $(`#${idTableArea} thead .inputCarrera${idArea}`).prop('checked',false);
         }
         
      }

      if(event.target.classList.contains('selectAllOptions')) {
         let isChecked = event.target.checked;

         // Encuentra el elemento <select> con id 'carrera_idCarreraciclo'
         let selectElement = document.getElementById('carrera_idCarreraciclo');

         let validOptions = Array.from(selectElement.options).filter(option => !option.disabled).map(option => option.value);

         if (isChecked) {
            $(selectElement).val(validOptions).trigger('change');
            $('.txtAllOptions').text('Desmarcar todo');
            
         }else{
            $('.txtAllOptions').text('Seleccionar todo');
            $(selectElement).val([]).trigger('change');
         }

      }

   });

   document.body.addEventListener('change', async function(event) {
      if (event.target.id === 'ciclo_idCarreraciclo') {
            const idCiclo = event.target.value;
            console.log(idCiclo);

            try {

               const formData = new FormData();
               formData.append('id', idCiclo);
               const data = await handleRequest(`${config.baseUrl}/carreras`, 'POST', formData);
               console.log(data);
               if (data.success) {
                  // updateTableUI(data);
                  showToastr(data.message, 'success');
                  $('#tblCarreraciclo').html(data.datatable);
                  $('#carrera_idCarreraciclo').html(data.sltCarreras);
                  initSelect2Icons('.select2-icons');
               } else {
                  showAlertSimple('Error', 'Hubo un problema al eliminar el registro', 'error');
               }
            } catch (error) {
               console.error('Error al eliminar:', error);
               showToastr('No se pudo completar la operación','warning');
            }

      }
      
   });
    

     
   
   /**
    *  app:docentes|end
    */

});