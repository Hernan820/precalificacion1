<div class="modal fade" id="modal-crear-seminario" data-preserve-input="{{ $errors->any() ? 'true' : 'false' }}" tabindex="-1" role="dialog"
    aria-labelledby="modalCrearSeminarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content small">
            <div class="modal-header py-2">
                <h5 class="modal-title" id="modalCrearSeminarioLabel">
                    <i class="fas fa-calendar-plus mr-2" aria-hidden="true"></i>Crear seminario
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form-crear-seminario" method="POST" action="{{ route('seminarios.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-3">
                    <p class="text-muted mb-3">Completa la información que se mostrará a los participantes.</p>

                    <h6 class="text-primary border-bottom border-primary pb-1 mb-2">Información general</h6>
                    <div class="form-row">
                        <div class="form-group col-md-8 mb-2">
                            <label for="seminario-titulo">Título <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('titulo') is-invalid @enderror @error('slug') is-invalid @enderror" id="seminario-titulo" name="titulo" value="{{ old('titulo') }}"
                                maxlength="255" >
                                @error('titulo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('slug')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group col-md-4 mb-2">
                            <label for="seminario-estatus">Estatus <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm @error('estatus') is-invalid @enderror" id="seminario-estatus" name="estatus">
                                <option value="borrador" {{ old('estatus', 'borrador') === 'borrador' ? 'selected' : '' }}>Borrador</option>
                                <option value="publicado" {{ old('estatus') === 'publicado' ? 'selected' : '' }}>Publicado</option>
                                {{-- <option value="finalizado">Finalizado</option>
                                <option value="cancelado">Cancelado</option> --}}
                            </select>
                            @error('estatus')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="form-group mb-2">
                        <label for="seminario-slug">Slug <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm @error('slug') is-invalid @enderror" id="seminario-slug" name="slug" value="{{ old('slug') }}"
                            maxlength="255" placeholder="ejemplo-seminario" >
                        @error('slug')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">Identificador usado en la URL. Usa minúsculas y guiones.</small>
                    </div> --}}

                    <div class="form-group mb-2 d-none">
                        <label for="seminario-resumen">Resumen</label>
                        <textarea class="form-control form-control-sm @error('resumen') is-invalid @enderror" id="seminario-resumen" name="resumen" rows="2"
                            maxlength="500">{{ old('resumen') }}</textarea>
                        @error('resumen')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="seminario-descripcion">Descripción</label>
                        <textarea class="form-control form-control-sm @error('descripcion') is-invalid @enderror" id="seminario-descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <h6 class="text-primary border-bottom border-primary pb-1 mb-2 mt-3">Fecha y horario</h6>
                    <div class="form-row">
                        <div class="form-group col-md-4 mb-2">
                            <label for="seminario-fecha">Fecha <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm @error('fecha') is-invalid @enderror" id="seminario-fecha" name="fecha" value="{{ old('fecha') }}" >
                                @error('fecha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group col-md-4 mb-2">
                            <label for="seminario-hora-inicio">Hora de inicio <span class="text-danger">*</span></label>
                            <input type="time" class="form-control form-control-sm @error('hora_inicio') is-invalid @enderror" id="seminario-hora-inicio" name="hora_inicio" value="{{ old('hora_inicio') }}" >
                                @error('hora_inicio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group col-md-4 mb-2">
                            <label for="seminario-hora-fin">Hora de finalización <span class="text-danger">*</span></label>
                            <input type="time" class="form-control form-control-sm @error('hora_fin') is-invalid @enderror" id="seminario-hora-fin" name="hora_fin" value="{{ old('hora_fin') }}" >
                                @error('hora_fin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="seminario-registro-hasta">Registro disponible hasta <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control form-control-sm @error('registro_hasta') is-invalid @enderror" id="seminario-registro-hasta"
                            name="registro_hasta" value="{{ old('registro_hasta') }}" >
                            @error('registro_hasta')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>

                    <h6 class="text-primary border-bottom border-primary pb-1 mb-2 mt-3">Ubicación y modalidad</h6>
                    <div class="form-row">
                        <div class="form-group col-md-8 mb-2">
                            <label for="seminario-lugar">Lugar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('lugar') is-invalid @enderror" id="seminario-lugar" name="lugar" value="{{ old('lugar') }}"
                                maxlength="255" >
                            @error('lugar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4 mb-2">
                            <label for="seminario-modalidad">Modalidad <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm @error('modalidad') is-invalid @enderror" id="seminario-modalidad" name="modalidad">
                                <option value="presencial" {{ old('modalidad', 'presencial') === 'presencial' ? 'selected' : '' }}>Presencial</option>
                                <option value="virtual" {{ old('modalidad') === 'virtual' ? 'selected' : '' }}>Virtual</option>
                                <option value="hibrida" {{ old('modalidad') === 'hibrida' ? 'selected' : '' }}>Híbrida</option>
                            </select>
                            @error('modalidad')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="seminario-direccion">Dirección <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm @error('direccion') is-invalid @enderror" id="seminario-direccion" name="direccion" maxlength="500" value="{{ old('direccion') }}" >
                            @error('direccion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 mb-2">
                            <label for="seminario-ciudad">Ciudad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('ciudad') is-invalid @enderror" id="seminario-ciudad" name="ciudad" maxlength="150" value="{{ old('ciudad') }}" >
                            @error('ciudad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="seminario-estado">Estado <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('estado') is-invalid @enderror" id="seminario-estado" name="estado" maxlength="150" value="{{ old('estado') }}" >
                            @error('estado')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="seminario-mapa-url">URL de Google Maps <span class="text-danger">*</span></label>
                        <input type="url" class="form-control form-control-sm @error('mapa_url') is-invalid @enderror" id="seminario-mapa-url" name="mapa_url" maxlength="500" value="{{ old('mapa_url') }}">
                        @error('mapa_url')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <h6 class="text-primary border-bottom border-primary pb-1 mb-2 mt-3">Registro y recursos</h6>
                    <div class="form-row">
                        <div class="form-group col-md-6 mb-2">
                            <label for="seminario-cupos">Cupos <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-sm @error('cupos') is-invalid @enderror" id="seminario-cupos" name="cupos"
                                min="1" step="1" value="{{ old('cupos') }}" >
                                @error('cupos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        {{-- <div class="form-group col-md-4 mb-2">
                            <label for="seminario-tipo-registro">Tipo de registro <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm" id="seminario-tipo-registro" name="tipo_registro" >
                                <option value="ambos" selected>Ambos</option>
                                <option value="cliente">Cliente</option>
                                <option value="codeudor">Codeudor</option>
                            </select>
                        </div> --}}
                        <div class="form-group col-md-6 mb-2">
                            <label for="seminario-telefono">Teléfono call center <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-sm @error('telefono') is-invalid @enderror" id="seminario-telefono" name="telefono" maxlength="30" value="{{ old('telefono') }}" >
                                @error('telefono')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>

                    {{-- <div class="form-group mb-2 d-none">
                        <label for="seminario-imagen">Imagen del seminario</label>
                        <input type="file" class="form-control-file" id="seminario-imagen" name="imagen"
                            accept="image/*">
                        <small class="form-text text-muted">Formatos de imagen permitidos.</small>
                    </div> --}}

                    <div class="custom-control custom-checkbox mt-3">
                        <input type="hidden" name="activo" value="0">
                        <input type="checkbox" class="custom-control-input" id="seminario-activo" name="activo" value="1"
                            {{ old('activo', '1') == '1' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="seminario-activo">Seminario activo</label>
                    </div>
                </div>

                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-save mr-1" aria-hidden="true"></i>Guardar seminario
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var $modal = window.jQuery('#modal-crear-seminario');
            var preserveInput = $modal.data('preserve-input') === true;

            $modal.on('show.bs.modal', function () {
                if (preserveInput) {
                    preserveInput = false;
                    return;
                }

                var form = this.querySelector('form');
                form.reset();
                form.querySelectorAll('input:not([type="hidden"]):not([type="checkbox"]):not([type="submit"]):not([type="button"]), textarea').forEach(function (field) {
                    field.value = '';
                });
                form.querySelectorAll('select').forEach(function (select) {
                    select.selectedIndex = 0;
                });
                form.querySelector('#seminario-activo').checked = true;
                form.querySelectorAll('.is-invalid').forEach(function (field) {
                    field.classList.remove('is-invalid');
                });
                form.querySelectorAll('.invalid-feedback').forEach(function (feedback) {
                    feedback.remove();
                });
            });

            if (preserveInput) {
                $modal.modal('show');
            }
        });
    </script>
</div>
