<div class="modal fade" id="modal-crear-seminario" tabindex="-1" role="dialog"
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

                    <h6 class="text-primary border-bottom pb-1 mb-2">Información general</h6>
                    <div class="form-row">
                        <div class="form-group col-md-8 mb-2">
                            <label for="seminario-titulo">Título <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="seminario-titulo" name="titulo"
                                maxlength="255" required>
                        </div>
                        <div class="form-group col-md-4 mb-2">
                            <label for="seminario-estatus">Estatus <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm" id="seminario-estatus" name="estatus" required>
                                <option value="borrador" selected>Borrador</option>
                                <option value="publicado">Publicado</option>
                                <option value="finalizado">Finalizado</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="seminario-slug">Slug <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="seminario-slug" name="slug"
                            maxlength="255" placeholder="ejemplo-seminario" required>
                        <small class="form-text text-muted">Identificador usado en la URL. Usa minúsculas y guiones.</small>
                    </div>

                    <div class="form-group mb-2">
                        <label for="seminario-resumen">Resumen</label>
                        <textarea class="form-control form-control-sm" id="seminario-resumen" name="resumen" rows="2"
                            maxlength="500"></textarea>
                    </div>

                    <div class="form-group mb-2">
                        <label for="seminario-descripcion">Descripción</label>
                        <textarea class="form-control form-control-sm" id="seminario-descripcion" name="descripcion" rows="3"></textarea>
                    </div>

                    <h6 class="text-primary border-bottom pb-1 mb-2 mt-3">Fecha y horario</h6>
                    <div class="form-row">
                        <div class="form-group col-md-4 mb-2">
                            <label for="seminario-fecha">Fecha <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm" id="seminario-fecha" name="fecha" required>
                        </div>
                        <div class="form-group col-md-4 mb-2">
                            <label for="seminario-hora-inicio">Hora de inicio <span class="text-danger">*</span></label>
                            <input type="time" class="form-control form-control-sm" id="seminario-hora-inicio" name="hora_inicio" required>
                        </div>
                        <div class="form-group col-md-4 mb-2">
                            <label for="seminario-hora-fin">Hora de finalización</label>
                            <input type="time" class="form-control form-control-sm" id="seminario-hora-fin" name="hora_fin">
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="seminario-registro-hasta">Registro disponible hasta</label>
                        <input type="datetime-local" class="form-control form-control-sm" id="seminario-registro-hasta"
                            name="registro_hasta">
                    </div>

                    <h6 class="text-primary border-bottom pb-1 mb-2 mt-3">Ubicación y modalidad</h6>
                    <div class="form-row">
                        <div class="form-group col-md-8 mb-2">
                            <label for="seminario-lugar">Lugar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="seminario-lugar" name="lugar"
                                maxlength="255" required>
                        </div>
                        <div class="form-group col-md-4 mb-2">
                            <label for="seminario-modalidad">Modalidad <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm" id="seminario-modalidad" name="modalidad" required>
                                <option value="presencial" selected>Presencial</option>
                                <option value="virtual">Virtual</option>
                                <option value="hibrida">Híbrida</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="seminario-direccion">Dirección</label>
                        <input type="text" class="form-control form-control-sm" id="seminario-direccion" name="direccion" maxlength="500">
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 mb-2">
                            <label for="seminario-ciudad">Ciudad</label>
                            <input type="text" class="form-control form-control-sm" id="seminario-ciudad" name="ciudad" maxlength="150">
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="seminario-estado">Estado</label>
                            <input type="text" class="form-control form-control-sm" id="seminario-estado" name="estado" maxlength="150">
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="seminario-mapa-url">URL de Google Maps</label>
                        <input type="url" class="form-control form-control-sm" id="seminario-mapa-url" name="mapa_url" maxlength="500">
                    </div>

                    <h6 class="text-primary border-bottom pb-1 mb-2 mt-3">Registro y recursos</h6>
                    <div class="form-row">
                        <div class="form-group col-md-4 mb-2">
                            <label for="seminario-cupos">Cupos</label>
                            <input type="number" class="form-control form-control-sm" id="seminario-cupos" name="cupos"
                                min="1" step="1">
                        </div>
                        <div class="form-group col-md-4 mb-2">
                            <label for="seminario-tipo-registro">Tipo de registro <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm" id="seminario-tipo-registro" name="tipo_registro" required>
                                <option value="ambos" selected>Ambos</option>
                                <option value="cliente">Cliente</option>
                                <option value="codeudor">Codeudor</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 mb-2">
                            <label for="seminario-telefono">Teléfono call center</label>
                            <input type="tel" class="form-control form-control-sm" id="seminario-telefono" name="telefono" maxlength="30">
                        </div>
                    </div>

                    <div class="form-group mb-2">
                        <label for="seminario-imagen">Imagen del seminario</label>
                        <input type="file" class="form-control-file" id="seminario-imagen" name="imagen"
                            accept="image/*">
                        <small class="form-text text-muted">Formatos de imagen permitidos.</small>
                    </div>

                    <div class="custom-control custom-checkbox mt-3">
                        <input type="checkbox" class="custom-control-input" id="seminario-activo" name="activo" value="1" checked>
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
</div>
