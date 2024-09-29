
// document.addEventListener('DOMContentLoaded', function() {
$(document).ready(function() {

   /**
    *  date:20240808|dev:nesk
    *  app:docentes|start
    */

   const modalDocente = "#modalDocente";

   const buttonsTblDocentes = document.getElementById('tblDocentes');

   buttonsTblDocentes.addEventListener('click', function(e) {
      const editButton = e.target.closest('.btnEditDocente');
      if (editButton) {         
         e.preventDefault();
         const docenteId = editButton.getAttribute('data-id');
         openEditModal(docenteId);
      }
   });   

   function openEditModal(docenteId) {
      fetch(`/docentes/${docenteId}/edit`)
         .then(response => response.json())
         .then(data => {
            console.log(data);
            document.getElementById('inputId').value = data.id;
            document.getElementById('inputApellidos').value = data.apellidos;
            document.getElementById('inputNombres').value = data.nombres;
            document.getElementById('inputGradoacademico').value = data.gradoacademico_id;
            document.getElementById('inputGenero').value = data.genero;
            
            $(modalDocente).modal('show');
         })
         .catch(error => console.error('Error:', error));
   }

   const formDocente = document.getElementById('formDocente');

   formDocente.addEventListener('submit', async function(e) {
      e.preventDefault();
      const docenteId = document.getElementById('inputId').value;
      const formData = new FormData(this);
      
      const isEditing = docenteId !== '';
      let url = this.getAttribute('action');
      
      if(isEditing){
         formData.append('_method', 'PATCH');
         url = `/docentes/${docenteId}`;
      }
   
      try {
         const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                  'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
         })

         if (!response.ok) {
            if (response.status === 422) {
                  const errors = await response.json();
                  displayErrors(errors.errors);
                  return;
            }
            throw new Error('Error en la solicitud');
         }

         const data = await response.json();
         console.log('Respuesta del servidor:', data);

         if (data.success) {            
            $('#tblDocentes tbody').html(data.datatable);
            $(modalDocente).modal('hide');
            showToastr(data.message, 'success');

         } else {
            console.error('Error al registrar/editar:', data.message);
         }
      } catch (error) {
         console.error('Error:', error.message);
         try {
            const parsedError = JSON.parse(error.message);
            console.error('Detalles del error:', parsedError);
         } catch (e) {
            console.error('No se pudo analizar el error como JSON:', error.message);
         }
      }
   });

   const newButtonContainer = document.getElementById('btnActionGeneral');
   newButtonContainer.addEventListener('click', function(e) {
      const addButton = e.target.closest('.btnAddDocente');
      if (addButton) {

         document.getElementById('inputApellidos').value = '';
         document.getElementById('inputNombres').value = '';
         document.getElementById('inputGradoacademico').value = '';
         document.getElementById('inputGenero').value = '';
         
         // document.getElementById('modalCarreraLabel').textContent = 'Formulario de registro';
         
         $(modalDocente).modal('show');
      }
   });

   buttonsTblDocentes.addEventListener('click', async function(e) {
      const deleteButton = e.target.closest('.btnDeleteDocente');
      if (deleteButton) {
         let carreraId = deleteButton.getAttribute('data-id');
         let titleValue = '¿Desea eliminar este registro?';
         let textValue = '¡Ya no podrá visualizar en los registros!';
         let typeAlert = 'question';
         let typeIcon = '';

         try {
            const respuesta = await showAlert(titleValue, textValue, typeAlert, typeIcon);
            if (respuesta.isConfirmed) {
               try {
                  const formData = new FormData();
                  formData.append('_method', 'PATCH');
                  formData.append('estado', 5);

                  const response = await fetch(`/docentes/${carreraId}`, {
                     method: 'POST',
                     body: formData,
                     headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        // 'Content-Type': 'application/json',
                        // 'X-CSRF-TOKEN': '{{ csrf_token() }}',
                     }
                  });

                  if (!response.ok) {
                     if (response.status === 422) {
                           const errors = await response.json();
                           displayErrors(errors.errors);
                           return;
                     }
                     throw new Error('Error en la solicitud');
                  }

                  const data = await response.json();

                  if (data.success) {            
                     $('#tblDocentes tbody').html(data.datatable);
                     $(modalDocente).modal('hide');
                     showToastr(data.message, 'success');
         
                  } else {
                     showAlertSimple('Error', 'Hubo un problema al eliminar el registro', 'error');
                  }

               } catch (error) {
                  console.error('Error al eliminar el registro:', error);
                  showAlertSimple('Error', 'No se pudo completar la operación', 'error');
               }
            } else if (respuesta.dismissReason === Swal.DismissReason.cancel) {
                  showAlertSimple('Cancelado', 'No se actualizó el proceso', 'error');
            }
         } catch (error) {
            console.error('Error al mostrar la alerta:', error);
         }
      }
   });
  
  
   /**
    *  app:docentes|end
    */

});