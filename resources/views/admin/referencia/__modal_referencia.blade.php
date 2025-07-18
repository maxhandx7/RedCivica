   <!-- Modal para Mostrar Referencia -->
   <div class="modal fade" id="referenceModal" tabindex="-1" aria-labelledby="referenceModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <div class="modal-header bg-primary text-white">
                   <h5 class="modal-title" id="referenceModalLabel">Enlace de Referencia</h5>
                   <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                       aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <div class="row">
                       <!-- Información de la Referencia -->
                       <div class="col-md-6">
                           <div class="mb-4">
                               <h5 class="text-primary fw-bold mb-3">
                                   <i class="fas fa-info-circle me-2"></i>Detalles de la Referencia
                               </h5>
                               <ul class="list-group shadow-sm rounded overflow-hidden">
                                   <li class="list-group-item d-flex justify-content-between align-items-center">
                                       <span class="fw-semibold">📌 Campaña:</span>
                                       <span id="modalCampaign"></span>
                                   </li>
                                   <li class="list-group-item d-flex justify-content-between align-items-center">
                                       <span class="fw-semibold">🎯 Objetivo:</span>
                                       <span id="modalObjective"></span>
                                   </li>
                                   <li class="list-group-item d-flex justify-content-between align-items-center">
                                       <span class="fw-semibold">🌐 Fuente:</span>
                                       <span id="modalSource"></span>
                                   </li>
                                   <li class="list-group-item d-flex justify-content-between align-items-center">
                                       <span class="fw-semibold">📣 Medio:</span>
                                       <span id="modalMedium"></span>
                                   </li>
                                   <li class="list-group-item d-flex justify-content-between align-items-center">
                                       <span class="fw-semibold">📅 Creado:</span>
                                       <span id="modalCreated"></span>
                                   </li>
                               </ul>
                           </div>

                           <div class="bg-light p-3 rounded shadow-sm">
                               <h5 class="text-success fw-bold mb-3">
                                   <i class="fas fa-bullhorn me-2"></i>¡Activa tu red!
                               </h5>
                               <ul class="fs-10 text-dark ps-1">
                                   <li class="mb-2"><i class="fas fa-share me-2 text-success"></i>Comparte el enlace
                                       con tus contactos.</li>
                                   <li class="mb-2"><i class="fas fa-user-friends me-2 text-success"></i>Ellos se
                                       registran y se suman a tu red.</li>
                                   <li class="mb-2"><i class="fas fa-chart-line me-2 text-success"></i>Monitorea su
                                       progreso desde tu panel.</li>
                               </ul>
                           </div>

                           <hr class="my-4" />
                       </div>


                       <!-- Enlace y QR -->
                       <div class="col-md-6">
                           <div class="d-flex flex-column align-items-center mb-4">
                               <div id="qrCodeContainer" class="mb-3"></div>
                               <small class="text-muted">Escanea para compartir</small>

                           </div>

                           <div class="mb-3">
                               <label class="form-label">Enlace de referencia:</label>
                               <div class="input-group">
                                   <input type="text" class="form-control" id="referenceLinkInput" readonly>
                                   <button class="btn btn-primary" onclick="copyReferenceLink()">
                                       <i class="fas fa-copy"></i> Copiar
                                   </button>
                               </div>
                           </div>

                           <div class="d-flex gap-2 mt-3">
                               <button class="btn btn-success flex-fill" onclick="openReferralForm()">
                                   <i class="fas fa-external-link-alt me-2"></i> Abrir Formulario
                               </button>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                   <button type="button" class="btn btn-primary" onclick="shareReference()">
                       <i class="fas fa-share-alt me-2"></i> Compartir
                   </button>
               </div>
           </div>
       </div>
   </div>
