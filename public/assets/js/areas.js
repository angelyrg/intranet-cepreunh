
document.addEventListener('DOMContentLoaded', function() {
   
   /**
    *  date:20240808|dev:nesk
    *  app:|start
    */

   const title = 'Area';
   const ruta_base = '/areas';

   const modalFormulario = `#modal${title}`;

   const buttonsTbl = document.getElementById(`tbl${title}`);

   buttonsTbl.addEventListener('click', function(e) {
      const editButton = e.target.closest('.btnEdit');
      if (editButton) {         
         e.preventDefault();
         const id = editButton.getAttribute('data-id');
         openEditModal(id);
      }
   });   

   function openEditModal(id) {      
      fetch(`${ruta_base}/${id}/edit`)
         .then(response => response.json())
         .then(data => {
            
            document.getElementById('inputId').value = data.id;
            document.getElementById('inputDescripcion').value = data.descripcion;
            
            $(modalFormulario).modal('show');
         })
         .catch(error => console.error('Error:', error));
   }

   // ENVIAR FORMULARIO
   const formulario = document.getElementById(`form${title}`);
   formulario.addEventListener('submit', async function(e) {
      e.preventDefault();
      const itemId = document.getElementById('inputId').value;
      const formData = new FormData(this);
      
      const isEditing = itemId !== '';
      let url = this.getAttribute('action');
      
      if(isEditing){
         formData.append('_method', 'PATCH');
         url = `${ruta_base}/${itemId}`;
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
            $(`#tbl${title} tbody`).html(data.datatable);
            $(modalFormulario).modal('hide');
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

   // CREAR NUEVO REGISTRO
   const newButtonContainer = document.getElementById('btnActionGeneral');
   newButtonContainer.addEventListener('click', function(e) {
      const addButton = e.target.closest(`.btnAdd${title}`);
      if (addButton) {
         document.getElementById("inputId").value = "";
         document.getElementById('inputDescripcion').value = '';

         document.getElementById(`modal${title}Label`).textContent = 'Formulario de registro';         
         $(modalFormulario).modal('show');
      }
   });


   // Eliminar registro (estado==5)
   buttonsTbl.addEventListener('click', async function(e) {
      const deleteButton = e.target.closest('.btnDelete');
      if (deleteButton) {
         let id = deleteButton.getAttribute('data-id');
         let titleValue = '¿Desea eliminar este registro?';
         let textValue = '';
         let typeAlert = 'question';
         let typeIcon = '';

         try {
            const respuesta = await showAlert(titleValue, textValue, typeAlert, typeIcon);
            if (respuesta.isConfirmed) {
               try {
                  const formData = new FormData();
                  formData.append("_method", "PATCH");
                  formData.append('estado', 5);

                  const response = await fetch(`${ruta_base}/${id}/eliminar`, {
                     method: 'POST',
                     body: formData,
                     headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
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
                     $(`#tbl${title} tbody`).html(data.datatable);
                     $(modalFormulario).modal('hide');
                     showToastr(data.message, 'success');
         
                  } else {
                     showAlertSimple('Error', 'Hubo un problema al eliminar el registro', 'error');
                  }

               } catch (error) {
                  console.error('Error al eliminar el registro:', error);
                  showAlertSimple('Error', 'No se pudo completar la operación', 'error');
               }
            }
         } catch (error) {
            console.error('Error al mostrar la alerta:', error);
         }
      }
   });
  
  
   /**
    *  app:|end
    */

});