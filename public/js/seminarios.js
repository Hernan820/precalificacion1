
document.addEventListener('DOMContentLoaded', function () {
    var $modal = window.jQuery('#modal-crear-seminario');
    var preserveInput = $modal.data('preserve-input') === true;
    var phoneInput = document.getElementById('seminario-telefono');
    var form = document.getElementById('form-crear-seminario');
    var pendingSeminario = null;
    var title = document.getElementById('modalCrearSeminarioLabel');
    var submitButton = form.querySelector('[type="submit"]');
    var completePhonePattern = /^\+1 \(\d{3}\) \d{3}-\d{4}$/;

    function setFieldValue(name, value) {
        var field = name === 'activo'
            ? form.querySelector('#seminario-activo')
            : form.elements[name];
        if (!field) {
            return;
        }

        if (field.type === 'checkbox') {
            field.checked = Boolean(value);
        } else {
            field.value = value == null ? '' : value;
        }
    }

    function clearValidation() {
        form.querySelectorAll('.is-invalid').forEach(function (field) {
            field.classList.remove('is-invalid');
        });
        form.querySelectorAll('.invalid-feedback').forEach(function (feedback) {
            feedback.remove();
        });
        phoneInput.setCustomValidity('');
    }

    function resetForm() {
        form.reset();
        form.querySelectorAll('input:not([type="hidden"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]), textarea').forEach(function (field) {
            field.value = '';
        });
        form.querySelectorAll('select').forEach(function (select) {
            select.selectedIndex = 0;
        });
        setFieldValue('seminario_id', '');
        setFieldValue('activo', true);

        var methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) {
            methodInput.remove();
        }

        form.action = form.dataset.storeUrl;
        title.lastChild.textContent = 'Crear seminario';
        submitButton.innerHTML = '<i class="fas fa-save mr-1" aria-hidden="true"></i>Guardar seminario';
        clearValidation();
        maskPhoneNumber();
    }

    function fillForm(seminario, updateUrl) {
        resetForm();
        Object.keys(seminario).forEach(function (name) {
            setFieldValue(name, seminario[name]);
        });
        form.action = updateUrl;
        setFieldValue('seminario_id', seminario.id);

        var methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);

        title.lastChild.textContent = 'Editar seminario';
        submitButton.innerHTML = '<i class="fas fa-save mr-1" aria-hidden="true"></i>Guardar cambios';
        maskPhoneNumber();
    }

    function maskPhoneNumber() {
        var value = phoneInput.value;
        var cursor = phoneInput.selectionStart || value.length;
        var digits = value.replace(/\D/g, '');
        var startsWithCountryCode = /^\s*\+1/.test(value)
            || (digits.length === 11 && digits.charAt(0) === '1');
        var digitsBeforeCursor = value.slice(0, cursor).replace(/\D/g, '').length;

        if (startsWithCountryCode) {
            digits = digits.slice(1);
            digitsBeforeCursor = Math.max(0, digitsBeforeCursor - 1);
        } else if (digits.length === 11 && digits.charAt(0) === '1') {
            digits = digits.slice(1);
        }

        digits = digits.slice(0, 10);
        var formatted = value.length ? '+1 (' + digits.slice(0, 3) : '';

        if (digits.length >= 3) {
            formatted += ')';
        }
        if (digits.length > 3) {
            formatted += ' ' + digits.slice(3, 6);
        }
        if (digits.length >= 6) {
            formatted += '-';
        }
        if (digits.length > 6) {
            formatted += digits.slice(6);
        }

        phoneInput.value = formatted;
        if (document.activeElement === phoneInput) {
            var nationalDigitsBeforeCursor = Math.min(digitsBeforeCursor, digits.length);
            var caret = formatted.indexOf('(') + 1;
            var seenDigits = 0;

            for (var index = caret; index < formatted.length; index++) {
                if (/\d/.test(formatted.charAt(index))) {
                    seenDigits++;
                    if (seenDigits === nationalDigitsBeforeCursor) {
                        caret = index + 1;
                        break;
                    }
                }
            }

            phoneInput.setSelectionRange(caret, caret);
        }

        phoneInput.setCustomValidity(
            phoneInput.value && !completePhonePattern.test(phoneInput.value)
                ? 'Ingresa los 10 dígitos del teléfono con el formato +1 (123) 456-7890.'
                : ''
        );
    }

    phoneInput.addEventListener('input', maskPhoneNumber);
    maskPhoneNumber();

    document.querySelectorAll('.seminarios-edit-button').forEach(function (button) {
        button.addEventListener('click', function () {
            pendingSeminario = {
                data: JSON.parse(button.dataset.seminario),
                updateUrl: button.dataset.updateUrl,
            };
            $modal.modal('show');
        });
    });

    $modal.on('show.bs.modal', function () {
        if (preserveInput) {
            preserveInput = false;
            return;
        }

        var seminarioToEdit = pendingSeminario;
        pendingSeminario = null;
        if (seminarioToEdit) {
            fillForm(seminarioToEdit.data, seminarioToEdit.updateUrl);
        } else {
            resetForm();
        }
    });

    if (preserveInput) {
        $modal.modal('show');
    }
});


document.addEventListener('DOMContentLoaded', function () {
    var searchInput = document.getElementById('buscar-seminarios');
    var rows = Array.prototype.slice.call(document.querySelectorAll('.seminarios-data-row'));
    var countLabel = document.getElementById('seminarios-count');
    var noMatches = document.getElementById('seminarios-sin-coincidencias');

    rows.forEach(function (row) {
        var detailRow = row.nextElementSibling;
        if (!detailRow || !detailRow.classList.contains('seminarios-detail-row')) {
            return;
        }

        var clearHoverTimeout;
        [row, detailRow].forEach(function (pairedRow) {
            pairedRow.addEventListener('mouseenter', function () {
                window.clearTimeout(clearHoverTimeout);
                row.classList.add('is-related-hover');
                detailRow.classList.add('is-related-hover');
            });
            pairedRow.addEventListener('mouseleave', function () {
                clearHoverTimeout = window.setTimeout(function () {
                    if (!row.matches(':hover') && !detailRow.matches(':hover')) {
                        row.classList.remove('is-related-hover');
                        detailRow.classList.remove('is-related-hover');
                    }
                }, 0);
            });
        });
    });

    document.querySelectorAll('.seminarios-description-toggle').forEach(function (button) {
        button.addEventListener('click', function () {
            var shouldExpand = button.getAttribute('aria-expanded') !== 'true';
            document.getElementById(button.dataset.preview).hidden = shouldExpand;
            document.getElementById(button.dataset.full).hidden = !shouldExpand;
            button.setAttribute('aria-expanded', String(shouldExpand));
            button.textContent = shouldExpand ? 'Leer menos...' : 'Leer más...';
        });
    });

    var $deleteModal = window.jQuery('#modal-eliminar-seminario');
    var deleteForm = document.getElementById('form-eliminar-seminario');
    var reasonInput = document.getElementById('justificacion-eliminacion');
    var deleteTitle = document.getElementById('modalEliminarSeminarioLabel');

    document.querySelectorAll('.seminarios-delete-button').forEach(function (button) {
        button.addEventListener('click', function () {
            deleteForm.action = button.dataset.deleteUrl;
            deleteForm.elements.eliminacion_seminario_id.value = button.dataset.seminarioId;
            reasonInput.value = '';
            deleteTitle.textContent = 'Eliminar seminario: ' + button.dataset.seminarioTitulo;
            $deleteModal.modal('show');
        });
    });

    if ($deleteModal.data('restore') === true) {
        $deleteModal.modal('show');
    }

    searchInput.addEventListener('input', function () {
        var query = searchInput.value.trim().toLocaleLowerCase();
        var visibleCount = 0;

        rows.forEach(function (row) {
            var detailButton = row.querySelector('.seminarios-toggle-details');
            var details = document.getElementById(detailButton.dataset.target);
            var matches = row.textContent.toLocaleLowerCase().indexOf(query) !== -1;
            row.hidden = !matches;
            details.hidden = true;
            detailButton.setAttribute('aria-expanded', 'false');
            if (matches) {
                visibleCount++;
            }
        });

        countLabel.textContent = visibleCount + (visibleCount === 1 ? ' seminario' : ' seminarios');
        noMatches.hidden = rows.length === 0 || visibleCount !== 0;
    });

    document.querySelectorAll('.seminarios-toggle-details').forEach(function (button) {
        button.addEventListener('click', function () {
            var details = document.getElementById(button.dataset.target);
            var shouldOpen = details.hidden;

            document.querySelectorAll('.seminarios-detail-row').forEach(function (row) {
                row.hidden = true;
            });
            document.querySelectorAll('.seminarios-toggle-details').forEach(function (toggle) {
                toggle.setAttribute('aria-expanded', 'false');
            });

            details.hidden = !shouldOpen;
            button.setAttribute('aria-expanded', String(shouldOpen));
        });
    });
});
