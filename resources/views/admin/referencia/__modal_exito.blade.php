<!-- Modal de Éxito -->
    <div class="modal fade" id="successModal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-lg mt-6" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="rounded-top-3 bg-body-tertiary py-3 ps-4 pe-6">
                        <h4 class="mb-1" id="staticBackdropLabel">¡Referencia creada con éxito!</h4>
                        <p class="fs-11 mb-0">Comparte este enlace</p>
                    </div>
                    <div class="p-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <!-- Código QR -->
                                <div class="text-center mb-4">
                                    <div id="qrCode" class="mb-3"></div>
                                    <small class="text-muted">Escanea para compartir</small>
                                </div>

                                <!-- Enlace de registro -->
                                <div class="mb-4">
                                    <label class="form-label">Enlace de registro:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="referralLink" readonly>
                                        <button class="btn btn-primary" onclick="copyToClipboard()">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Botones de compartir -->
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-primary flex-fill" onclick="shareOnWhatsApp()">
                                        <i class="fab fa-whatsapp me-2"></i> WhatsApp
                                    </button>
                                    <button class="btn btn-outline-info flex-fill" onclick="shareOnEmail()">
                                        <i class="fas fa-envelope me-2"></i> Email
                                    </button>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="d-flex"><span class="fa-stack ms-n1 me-3"><i
                                            class="fas fa-circle fa-stack-2x text-200"></i><i
                                            class="fa-inverse fa-stack-1x text-primary fas fa-link"
                                            data-fa-transform="shrink-2"></i></span>
                                    <div class="flex-1">
                                        <h5 class="mb-2 fs-9">Instrucciones</h5>
                                        <ul class="fs-10">
                                            <li class="mb-2">Comparte este enlace con tus contactos</li>
                                            <li class="mb-2">Al registrarse, quedarán vinculados a tu red</li>
                                            <li class="mb-2">Puedes hacer seguimiento en tu panel</li>
                                        </ul>
                                        <hr class="my-4" />
                                        <a :href="modalConfig.formUrl" class="btn btn-success w-100">
                                            <i class="fas fa-external-link-alt me-2"></i> Ir al formulario
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>