
function toX(chip){
  const btn = chip.querySelector('.chip-action, .chip-x, .chip-add');
  btn.classList.remove('chip-add'); btn.classList.add('chip-action','chip-x');
  btn.setAttribute('aria-label', 'Eliminar ' + chip.querySelector('.chip-label').textContent);
  btn.innerHTML = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>';
  chip.classList.remove('chip_verde'); chip.classList.add('chip_azul');
}

function toPlus(chip){
  const btn = chip.querySelector('.chip-action, .chip-x, .chip-add');
  btn.classList.remove('chip-x'); btn.classList.add('chip-action','chip-add');
  btn.setAttribute('aria-label', 'Agregar ' + chip.querySelector('.chip-label').textContent);
  btn.innerHTML = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>';
  chip.classList.remove('chip_azul'); chip.classList.add('chip_verde');
}


document.addEventListener('click', (e) => {
  const addBtn = e.target.closest('.chip-add');
  const delBtn = e.target.closest('.chip-x');
  if (!addBtn && !delBtn) return;

  let td  = e.target.closest('td'); // <- CELDA ACTUAL
  let tr  = e.target.closest('tr'); // fila del usuario
  let chip = (addBtn || delBtn).closest('.chip');
  let id = chip?.dataset.id;
  let id_usuario = chip?.dataset.idusuario;

    if (delBtn) {
        const targetTd = td.nextElementSibling || tr.querySelector('.td-disponibles');
        const targetList = targetTd?.querySelector('.chips');

        axios.post(`${principalUrl}usuarios/permisos/quitar/${id}/${id_usuario}` )
        .then((respuesta) => {
            toPlus(chip);
            targetList?.appendChild(chip);
        })
        .catch((error) => {
            if (error.response) {
                console.log(error.response.data);
            }
        });
    }

    if (addBtn) {
        const targetTd = td.previousElementSibling || tr.querySelector('.td-asignados');
        const targetList = targetTd?.querySelector('.chips');

        axios.post(`${principalUrl}usuarios/permisos/agregar/${id}/${id_usuario}`)
        .then((respuesta) => {
            toX(chip);
            targetList?.appendChild(chip);
        })
        .catch((error) => {
            if (error.response) {
                console.log(error.response.data);
            }
        });
    }
});

function modalPermisoUsuarios() {
    $("#modal-permiso-usuarios").modal("show");
}


function opcionesPermisosUsuarios(selectPermisos, id) {
    var opt = $(selectPermisos).val();

    switch (opt) {
        case "1":   
            quitaPermisosUsuarios(selectPermisos, id);
            break;
        case "2":
            agregarPermisoUsuario(selectPermisos , id, "2"); // Agregar permiso creador de clientes
            break;
        case "3":
            agregarPermisoUsuario(selectPermisos , id, "3"); // Agregar permiso gestionar clientes
            break;
        default:
            console.log("Opción no válida");
    }
    $(selectPermisos).prop("selectedIndex", 0);
}


function quitaPermisosUsuarios(selectThis ,id) {
    Swal.fire({
        title: "¿Estas seguro de quitar los permisos a este usuario?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, quitar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {

            axios.post(principalUrl + "usuarios/permisos/"+id )
            .then((respuesta) => {
                Swal.fire({
                    title: "¡Éxito!",
                    text: "Permisos eliminados con éxito.",
                    icon: "success",
                    confirmButtonText: "Aceptar"
                }).then(() => {
                    $(selectThis).closest('tr').remove(); 
                    $("#selectUsuariosAsignado").append(`<option value="${respuesta.data.id}">${respuesta.data.name}</option>`);
                });
            })
            .catch((error) => {
                if (error.response) {
                    console.log(error.response.data);
                }
            });
            
        } else if (result.isDenied) {
            Swal.fire("Changes are not saved", "", "info");
        }
    });
}


function agregarPermisoUsuario(selectThis, id, permiso) {

    axios.post(principalUrl + "usuarios/permisos/"+id+"/editar", {
        permiso: permiso
    }) 
    .then((respuesta) => {
        Swal.fire({
            title: "¡Éxito!",
            text: "Se ha agregado nuevo permiso a usuario.",
            icon: "success",
            confirmButtonText: "Aceptar"
        }).then(() => {
            if (permiso === "2") {
                $(selectThis).closest('tr').find('td').eq(2)
                    .html('✅');
            } else if (permiso === "3") {
                $(selectThis).closest('tr').find('td').eq(1)
                    .html('✅');
            }
        });
    })
    .catch((error) => {
        if (error.response) {
            console.log(error.response.data);
        }
    });
}


