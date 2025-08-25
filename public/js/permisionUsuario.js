
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

  let td  = e.target.closest('td'); 
  let tr  = e.target.closest('tr'); 
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

