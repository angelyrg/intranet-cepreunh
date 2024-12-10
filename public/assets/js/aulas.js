$(document).ready(function() {
    /**
     *  app:aulas|start
     */

    const slug = "Aulas";

    // variables
    const config = {
        modalSelector: `#modal${slug}`,
        formSelector: `#form${slug}`,
        tableSelector: `#tbl${slug} tbody`,
        addButtonSelector: `.btnAdd${slug}`,
        editButtonSelector: `.btnEdit${slug}`,
        deleteButtonSelector: `.btnDelete${slug}`,
        baseUrl: `/aulas`,
    };

    // funciones
    const handleRequest = async (url, method, formData) => {
        const response = await fetch(url, {
            method,
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        });

        if (!response.ok) {
            const errorData = await response.json();
            if (response.status === 422) {
                displayErrors(errorData.errors);
            }
            throw new Error(errorData.message || "Error en la solicitud");
        }

        return response.json();
    };

    const updateTableUI = (data) => {
        $(config.tableSelector).html(data.datatable);
        $(config.modalSelector).modal("hide");
        showToastr(data.message, "success");
    };

    const clearForm = (form) => {
        form.reset();

        const hiddenIdField = form.querySelector("#id");
        if (hiddenIdField) hiddenIdField.value = "";

        form.querySelectorAll(".form-group").forEach(function (group) {
            group.classList.remove("error");
            group.classList.add("validate");
        });
        form.querySelectorAll(".help-block").forEach(function (helpBlock) {
            helpBlock.innerHTML = "";
        });
        form.querySelectorAll("input, select, textarea").forEach(function (
            field
        ) {
            field.setAttribute("aria-invalid", "false");
        });
    };

    const fillForm = (form, data) => {
      Object.keys(data).forEach((key) => {
         const input = form.querySelector(`#${key}`);
         if (input) {
               if (input.type === "checkbox") {
                  input.checked = !!data[key];
               } else if (input.type === "radio") {
                  const radio = form.querySelector(
                     `#${key}[value="${data[key]}"]`
                  );
                  if (radio) radio.checked = true;
               } else if (input.tagName === "SELECT") {
                  input.value = data[key];
                  input.dispatchEvent(new Event("change"));
               } else {
                  input.value = data[key];
               }
         }
      });
    };

    // insert|update
    const formAsignatura = document.getElementById(`form${slug}`);
    formAsignatura.addEventListener("submit", async function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        const id = document.getElementById("id").value;
        const url = id
            ? `${config.baseUrl}/${id}`
            : this.getAttribute("action");
        if (id) formData.append("_method", "PATCH");
        
        try {
            const data = await handleRequest(url, "POST", formData);            
            if (data.success) {
                updateTableUI(data);
            } else {
                console.error("Error al procesar:", data.message);
            }
        } catch (error) {
            console.error("Error:", error.message);
        }
    });

    // openNew
    const newButtonContainer = document.getElementById("btnActionGeneral");
    newButtonContainer.addEventListener("click", function (e) {
        const addButton = e.target.closest(`.btnAdd${slug}`);
        if (addButton) {
            clearForm(formAsignatura);
            $(config.modalSelector).modal("show");
        }
    });

    // openEdit|delete
    const buttonsTblAsignaturas = document.getElementById(`tbl${slug}`);
    buttonsTblAsignaturas.addEventListener("click", async function (e) {
        const editButton = e.target.closest(".btnEdit");
        if (editButton) {
            e.preventDefault();
            const id = editButton.getAttribute("data-id");
            try {
                const data = await handleRequest(
                    `${config.baseUrl}/${id}/edit`,
                    "GET"
                );
                
                fillForm($(config.formSelector)[0], data);
                $(config.modalSelector).modal("show");
            } catch (error) {
                console.error("Error al cargar datos:", error);
            }
        }

        const deleteButton = e.target.closest(`.btnDelete`);
        if (deleteButton) {
            const result = await showAlert(
                "",
                "¿Estás seguro de eliminar este registro?",
                "question"
            );
            if (result.isConfirmed) {
                e.preventDefault();
                const id = deleteButton.getAttribute("data-id");
                try {
                    const formData = new FormData();
                    formData.append("_method", "DELETE");
                    formData.append("estado", 5);
                    const data = await handleRequest(
                        `${config.baseUrl}/${id}/eliminar`,
                        "POST",
                        formData
                    );
                    if (data.success) {
                        updateTableUI(data);
                    } else {
                        showAlertSimple(
                            "Error",
                            "Hubo un problema al eliminar el registro",
                            "error"
                        );
                    }
                } catch (error) {
                    console.error("Error al eliminar:", error);
                    showToastr("No se pudo completar la operación", "warning");
                }
            }
        }
    });

    /**
     *  app:aulas|end
     */
});