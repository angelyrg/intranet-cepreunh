
// document.addEventListener('DOMContentLoaded', function() {
$(document).ready(function() {

   /**
    *  date:20240808|dev:nesk
    *  app:carreras|start
    */

   $('body').on('click','.btnEditCarrera', function(){
      console.log('holaaaaaaaaaaaaaa');
   });

   const modalCarrera = "#modalCarrera";
   const buttonsTblCarreras = document.getElementById('tblCarreras');

   buttonsTblCarreras.addEventListener('click', function(e) {
      const editButton = e.target.closest('.btnEditCarrera');
      if (editButton) {
         console.log(' x3');
         
         e.preventDefault();
         const carreraId = editButton.getAttribute('data-id');
         console.log(carreraId);
         openEditModal(carreraId);
      }
   });
   

   function openEditModal(carreraId) {
      fetch(`/carreras/${carreraId}/edit`)
         .then(response => response.json())
         .then(data => {
            document.getElementById('inputId').value = data.id;
            document.getElementById('inputArea').value = data.area_id;
            document.getElementById('inputCarrera').value = data.descripcion;
            
            $(modalCarrera).modal('show');
         })
         .catch(error => console.error('Error:', error));
   }

   const formCarrera = document.getElementById('formCarrera');

   formCarrera.addEventListener('submit', async function(e) {
      e.preventDefault();
      const carreraId = document.getElementById('inputId').value;
      const formData = new FormData(this);
      
      const isEditing = carreraId !== '';
      let url = this.getAttribute('action');
      
      if(isEditing){
         formData.append('_method', 'PATCH');
         url = `/carreras/${carreraId}`;
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
            $('#tblCarreras tbody').html(data.datatable);
            $(modalCarrera).modal('hide');
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

   // function displayErrors(errors) {
   //    document.querySelectorAll('.text-danger').forEach(el => el.remove());

   //    for (let field in errors) {
   //          const inputField = document.querySelector(`[name="${field}"]`);
   //          if (inputField) {
   //             const errorDiv = document.createElement('div');
   //             errorDiv.classList.add('text-danger');
   //             errorDiv.textContent = errors[field][0];
   //             inputField.parentNode.appendChild(errorDiv);
   //          }
   //    }
   // }

   // const formCarrera = document.getElementById('formCarrera')
   // formCarrera.addEventListener('submit', async function(e) {
   //    e.preventDefault();      
   //    const carreraId = document.getElementById('inputId').value;
   //    const formData = new FormData(this);
   //    formData.append('_method', 'PATCH');
      
   //    try {
   //       const response = await fetch(`/carreras/${carreraId}`, {
   //          method: 'POST',
   //          body: formData,
   //          headers: {
   //             // 'Content-Type': 'application/json',
   //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
   //             // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
   //          }
   //       }).then(response => {
   //          console.log(response);
   //          if (!response.ok) {
   //             if (response.status === 422) {
   //                return response.json().then(errors => {
   //                      displayErrors(errors.errors);
   //                });
   //             }
   //             throw new Error('Error en la solicitud');
   //          }
   //          return response.json();
   //       });

   //       console.log(response);
         
   //       if (!response.ok) { throw new Error('Error en la respuesta del servidor'); }
         
   //       const result = await response.json();
   //       console.log('Carrera actualizada:', result);
         
   //    } catch (error) {
   //       console.error('Error:', error);
   //    }
   // });

   const newButtonContainer = document.getElementById('btnActionGeneral');
   newButtonContainer.addEventListener('click', function(e) {
      const addButton = e.target.closest('.btnAddCarrera');
      if (addButton) {
         
         document.getElementById('inputId').value = '';
         document.getElementById('inputArea').value = '';
         document.getElementById('inputCarrera').value = '';
         
         // document.getElementById('modalCarreraLabel').textContent = 'Formulario de registro';
         
         $(modalCarrera).modal('show');
      }
   });

   // alerta avanzada
   // editButtonContainer.addEventListener('click', function(e) {
   //    const editButton = e.target.closest('.btnDeleteCarrera');

   //    if (editButton) {
   //       const titleValue = 'Confirmación';
   //       const textValue = '¿Desea eliminar este registro?';
   //       const typeAlert = 'question';
   //       const typeIcon = '';

   //       const buttonOptions = {
   //          cancelButtonText: { text: 'Cancelar', color: 'btn-label-secondary' },
   //          denyButtonText: { text: 'Nuevo', color: 'btn-info' },
   //          confirmButtonText: { text: 'Confirmar!', color: 'btn-primary' },
   //       };

   //       showAlertAdvanced(titleValue, textValue, typeAlert, typeIcon, buttonOptions).then((respuesta) => {
   //          if (respuesta.isConfirmed) {               
   //          } else if (respuesta.isDenied) {                  
   //          } else if (respuesta.dismissReason === Swal.DismissReason.cancel) {
   //          }
   //       }).catch((error) => {
   //          console.error('Error al mostrar la alerta:', error);
   //       });

   //    } else {

   //    }
   // });
   buttonsTblCarreras.addEventListener('click', async function(e) { // Marcamos la función como async
      const deleteButton = e.target.closest('.btnDeleteCarrera');
      if (deleteButton) {
         let carreraId = deleteButton.getAttribute('data-id');
         let titleValue = '¿Desea eliminar este registro?';
         let textValue = '¡Ya no podrá visualizar en los registros!';
         let typeAlert = 'question';
         let typeIcon = '';

         try {
            const respuesta = await showAlert(titleValue, textValue, typeAlert, typeIcon); // Esperamos la respuesta de la alerta
            if (respuesta.isConfirmed) {
               try {
                  const formData = new FormData();
                  formData.append('_method', 'PATCH');
                  formData.append('estado', 5);

                  // TODO: Set deleted_at correctamente para el softdelete
                  const currentDate = new Date().toISOString().slice(0, 19).replace('T', ' '); // Formato: YYYY-MM-DD HH:mm:ss
                  formData.append('deleted_at', currentDate);

                  for (let [key, value] of formData.entries()) {
                     console.log(`${key}: ${value}`);
                  }

                  const response = await fetch(`/carreras/${carreraId}`, {
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
                     showToastr(data.message, 'success');
                     $('#tblCarreras tbody').html(data.datatable);                     
         
                  } else {
                     showAlertSimple('Error', 'Hubo un problema al eliminar el registro', 'error');
                  }

                  // if (response.ok) {
                  //    showToastr('El registro ha sido eliminado con éxito', 'success');
                  //    showAlertSimple('Eliminado', 'El registro ha sido eliminado con éxito', 'success');
                  // } else {
                  //    showAlertSimple('Error', 'Hubo un problema al eliminar el registro', 'error');
                  // }
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
    *  app:carreras|end
    */

});