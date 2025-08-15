<div class="card theme-wizard" id="wizard">
    <div class="bg-body-tertiary">
        <ul class="nav justify-content-between nav-wizard">
            <li class="nav-item"><a class="nav-link active fw-semi-bold" href="#bootstrap-wizard-tab1" data-bs-toggle="tab"
                    data-wizard-step="1"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span
                                class="fas fa-user"></span></span></span><span
                        class="d-none d-md-block mt-1 fs-10">Personal</span></a></li>
            <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab2" data-bs-toggle="tab"
                    data-wizard-step="2"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span
                                class="fas fa-map-marker-alt"></span></span></span><span
                        class="d-none d-md-block mt-1 fs-10">Ubicación</span></a></li>

            <li class="nav-item"><a class="nav-link fw-semi-bold" href="#bootstrap-wizard-tab3" data-bs-toggle="tab"
                    data-wizard-step="3"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span
                                class="fas fa-thumbs-up"></span></span></span><span
                        class="d-none d-md-block mt-1 fs-10">Fin</span></a></li>
        </ul>
    </div>
    <div class="card-body py-1" id="wizard-controller">
        <div class="tab-content">
            <div class="tab-pane active px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-tab1"
                id="bootstrap-wizard-tab1">
                <form class="personal-data-validation" novalidate="novalidate" data-wizard-form="2"
                    id="personal-data-form">
                    <input type="hidden" name="parent_id" id="parent_id" value="{{ $referidor->id ?? null }}">
                    <input type="hidden" name="fuente" id="fuente" value="{{ $fuente ?? 'web' }}">
                    <input type="hidden" name="medio" id="medio" value="{{ $medio ?? 'web' }}">
                    <input type="hidden" name="referencia_id" id="referencia_id" value="{{ $referencia_id ?? null }}">
                    <div class="container text-center">
                        <h3>Datos personales</h3>
                        <p class="text-muted">Ingresa tus datos personales para que sepamos de ti.</p>

                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="bootstrap-wizard-name">Nombre*</label>
                                <input class="form-control" type="text" name="name" placeholder="Juan"
                                    id="name" required />
                                <div class="invalid-feedback">
                                    Este campo es obligatorio.
                                </div>
                            </div>

                            <!-- Apellido -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="bootstrap-wizard-last-name">Apellido*</label>
                                <input class="form-control" type="text" name="surname" placeholder="Gonzales"
                                    id="surname" required />
                                <div class="invalid-feedback">
                                    Este campo es obligatorio.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Tipo de documento -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="bootstrap-wizard-id_type">Tipo de
                                    documento*</label>
                                <select class="form-select" name="tipo_documento" id="tipo_documento" >
                                    <option selected disabled value="">Seleccione tipo de documento
                                    </option>
                                    <option value="cc">Cedula</option>
                                    <option value="ce">Cedula de extranjeria</option>
                                    <option value="nit">Nit</option>
                                    <option value="rut">Rut</option>
                                </select>
                                <div class="invalid-feedback">
                                    Este campo es obligatorio.
                                </div>
                            </div>

                            <!-- Numero de documento -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="bootstrap-wizard-num_doc">Numero de
                                    documento*</label>
                                <input class="form-control" type="number" name="cedula" placeholder="0123456789"
                                    id="cedula" required />
                                <div class="invalid-feedback">
                                    Este campo es obligatorio.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Teléfono -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="bootstrap-wizard-phone">Correo electronico*</label>
                                <input class="form-control" type="email" name="email"
                                    placeholder="name@example.com" id="email"  />
                               
                            </div>
                        </div>

                        <div class="row">
                            <!-- Teléfono -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="bootstrap-wizard-phone">Telefono</label>
                                <input class="form-control" type="tel" name="telefono"
                                    data-input-mask='{"mask":"+57 (999) 999-9999"}' placeholder="(XXX) XXX-XXXX"
                                    id="telephoneInputmask"  />
                               
                            </div>
                        </div>




                    </div>
                </form>
            </div>
            <div class="tab-pane text-center px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-tab2"
                id="bootstrap-wizard-tab2">
                <form class="needs-validation" id="navigation" novalidate="novalidate" data-wizard-form="2">
                    <div class="container text-center">
                        <h3>Datos de ubicacion</h3>
                        <p class="text-muted">Donde te encuentras.</p>

                        <div class="mb-3">
                            <label class="form-label" for="bootstrap-wizard-country">Pais</label>
                            <select class="form-select " name="pais" id="pais" >
                                <option disabled selected value="">Seleccione un país</option>
                                <option value="3686110">Colombia</option>
                            </select>
                           
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="bootstrap-wizard-state">Departamento/Estado</label>
                            <select class="form-select " name="departamento" id="departamento" disabled >
                                <option selected disabled value="">Seleccione un estado</option>
                            </select>
                            
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="bootstrap-wizard-city">Ciudad</label>
                            <select class="form-select " name="ciudad" id="ciudad" disabled >
                                <option selected disabled value="">Seleccione una ciudad</option>
                            </select>
                        </div>
                    
                          <div class="mb-3">
                                <label class="form-label" for="bootstrap-wizard-id_type">Dirección</label>
                                <input class="form-control" id="direccion" name="direccion" type="text"
                                    placeholder="Digite su dirección"  />
                               
                            </div>


                        <div class="row">
                            <!-- Numero de documento -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="bootstrap-wizard-num_doc">Barrio</label>
                                <input class="form-control" id="barrio" name="barrio" type="text"
                                    placeholder="Centro"  />
                            </div>

                             <div class="col-md-6 mb-3">
                                <label class="form-label" for="bootstrap-wizard-id_type">Comuna/Localidad</label>
                                <input class="form-control" id="comuna" name="comuna" type="text"
                                    placeholder="Comuna 18/Chapinero"  />
                            </div>
                        </div>
                    </div>
                </form>
            </div>




            <div class="tab-pane text-center px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-tab3"
                id="bootstrap-wizard-tab3">
                <div class="wizard-lottie-wrapper">
                    <div class="lottie wizard-lottie mx-auto my-3" id="exito" hidden
                        data-options='{"path":"../falcon/public/assets/img/animated-icons/celebration.json"}'>
                    </div>
                </div>
                <h4 class="mb-1">¡Tu cuenta está lista!</h4>
                <p>Revisa tu correo para poder iniciar sesion <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">términos y condiciones</a></p>
                
                <a class="btn btn-primary px-5 my-3" id="login-link"
                    href="{{ route('login') }}">Iniciar</a>
            </div>
        </div>
    </div>
    <div class="card-footer bg-body-tertiary">
        <div class="px-sm-3 px-md-5">
            <ul class="pager wizard list-inline mb-0">
                <li class="previous">
                    <button class="btn btn-link ps-0" type="button"><span class="fas fa-chevron-left me-2"
                            data-fa-transform="shrink-3"></span>Atras</button>
                </li>
                <li class="next">
                    <button class="btn btn-primary px-5 px-sm-6" type="button" id="wizard-submit">
                        <span id="wizard-submit-text">Siguiente</span>
                        <span class="fas fa-chevron-right ms-2" data-fa-transform="shrink-3"></span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px">
        <div class="modal-content position-relative p-5">
            <div class="d-flex align-items-center">
                <div class="lottie me-3"
                    data-options='{"path":"../falcon/public/assets/img/animated-icons/warning-light.json"}'></div>
                <div class="flex-1">
                    <button class="btn btn-link text-danger position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal"><span class="fas fa-times"></span></button>
                    <p class="mb-0">No tienes acceso al enlace, por favor inicia.</p>
                </div>
            </div>
        </div>
    </div>
</div>


@section('scripts')
    {!! Html::script('falcon/public/vendors/flatpickr/flatpickr.min.js') !!}
    {!! Html::script('falcon/public/vendors/dropzone/dropzone-min.js') !!}
    {!! Html::script('falcon/public/vendors/lottie/lottie.min.js') !!}
    {!! Html::script('falcon/public/vendors/validator/validator.min.js') !!}
    {!! Html::script('falcon/public/vendors/jquery/jquery.min.js') !!}
    {!! Html::script('falcon/public/vendors/inputmask/inputmask.min.js') !!}
    @include('admin.form.scripts._profile_user')
@endsection
