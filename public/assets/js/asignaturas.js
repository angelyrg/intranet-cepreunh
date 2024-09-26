
// document.addEventListener('DOMContentLoaded', function() {
$(document).ready(function() {

   /**
    *  date:20240808|dev:nesk
    *  app:docentes|start
    */

   // variables
   // const modalAsignatura = "#modalAsignatura";
   const config = {
      titleSelector: "Asignatura",
      modalSelector: "#modalAsignatura",
      formSelector: '#formAsignatura',
      tableSelector: 'tblAsignatura',
      addButtonSelector: '.btnAddAsignatura',
      editButtonSelector: '.btnEditAsignatura',
      deleteButtonSelector: '.btnDeleteAsignatura',
      baseUrl: '/asignaturas'
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

   const updateTableUI = (data) => {
      console.log('data ==> ', data);
      $(`#${config.tableSelector} tbody`).html(data.datatable);
      $(config.modalSelector).modal('hide');
      showToastr(data.message, 'success');
   };

   const clearForm = (form) => {
      form.reset();

      const hiddenIdField = form.querySelector('#id'+config.titleSelector);
      if (hiddenIdField) hiddenIdField.value = '';

      form.querySelectorAll('.form-group').forEach(function(group) {
         group.classList.remove('error');
         group.classList.add('validate');
       });
       form.querySelectorAll('.help-block').forEach(function(helpBlock) {
         helpBlock.innerHTML = '';
       });
       form.querySelectorAll('input, select, textarea').forEach(function(field) {
         field.setAttribute('aria-invalid', 'false');
       });
     
   };

   const fillForm = (form, data) => {
      console.log('response dta ==> ' , data);
      Object.keys(data).forEach(key => {
         console.log('response key #==> ' , key);
         const input = form.querySelector(`#${key}${config.titleSelector}`);
         
         console.log('response data[key] ==> ' , data[key]);

         if (input) {
            if (input.type === 'checkbox') {
               input.checked = !!data[key];
            } else if (input.type === 'radio') {
               const radio = form.querySelector(`#${key}[value="${data[key]}"]`);
               if (radio) radio.checked = true;
            } else if (input.tagName === 'SELECT') {
               input.value = data[key];
               input.dispatchEvent(new Event('change'));
            } else {
               input.value = data[key];
            }
         }
         // if (input) input.value = data[key];
      });
   };
   
   // insert|update
   const formAsignatura = document.getElementById('formAsignatura');   
   formAsignatura.addEventListener('submit', async function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      // formData.append('estado', '1');
      const id  = document.getElementById(`id${config.titleSelector}`).value;
      const url = id ? `${config.baseUrl}/${id}` : this.getAttribute('action');
      if (id) formData.append('_method', 'PATCH');

      try {
         const data = await handleRequest(url, 'POST', formData);
         console.log(data);
         if (data.success) {
            updateTableUI(data);
         } else {
            console.error('Error al procesar:', data.message);
         }
      } catch (error) {
            console.error('Error:', error.message);
      }
   });

   // openMondel [New]
   const newButtonContainer = document.getElementById('btnActionGeneral');
   newButtonContainer.addEventListener('click', function(e) {
      const addButton = e.target.closest('.btnAddAsignatura');
      if (addButton) {
         clearForm(formAsignatura);
         // formAsignatura.reset();
         // formAsignatura.querySelector('#inputId').value = '';
         $(modalAsignatura).modal('show');
      }
   });

   // openModel [Edit|delete]
   const actionsTbl = document.getElementById(config.tableSelector);
   actionsTbl.addEventListener('click', async function(e) {

      const editButton = e.target.closest('.btnEditAsignatura');
      if (editButton) {         
         e.preventDefault();
         const id = editButton.getAttribute('data-id');
         try {
            
            const data = await handleRequest(`${config.baseUrl}/${id}/edit`, 'GET');
            
            fillForm($(config.formSelector)[0], data);
            $(config.modalSelector).modal('show');

        } catch (error) {
            console.error('Error al cargar datos:', error);
        }
      }

      const deleteButton = e.target.closest('.btnDeleteAsignatura');
      if (deleteButton) {
         const result = await showAlert('¿Desea eliminar este registro?', '¡Ya no podrá visualizar en los registros!', 'question');
         if (result.isConfirmed) {
            e.preventDefault();
            const id = deleteButton.getAttribute('data-id');
            try {
                  const formData = new FormData();
                  formData.append('_method', 'PATCH');
                  formData.append('estado', 5);
                  const data = await handleRequest(`${config.baseUrl}/${id}/eliminar`, 'POST', formData);
                  if (data.success) {
                     updateTableUI(data);
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
   
   /**
    *  app:docentes|end
    */

});