<!-- ================= Modal de Encuesta ================= -->
<div class="modal fade" id="encuestaModal" tabindex="-1" aria-labelledby="encuestaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="encuestaModalLabel">Encuesta por Ubicación</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <form id="formEncuesta">
          <div id="preguntasEncuesta">
            <!-- Aquí se inyectan las preguntas con JS -->
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" id="guardarEncuesta" class="btn btn-primary">
          Guardar Respuestas
        </button>
      </div>

    </div>
  </div>
</div>
<!-- ================= Fin Modal ================= -->
