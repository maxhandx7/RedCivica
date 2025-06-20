@extends('layouts.admin')
@section('title', 'Gestión de empresa')
@section('styles')
@endsection
@section('options')
@endsection
@section('preference')
@endsection
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">Gestión de empresa</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('alert.message')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="fs-0 mb-1"><span class="fas fa-file-signature mr-2"></span>Nombre</h6>
                                    <p class="text-800">{{ $business->name }}</p>
                                </div>
                                <hr class="my-3">

                                <div class="mb-4">
                                    <h6 class="fs-0 mb-1"><span class="fab fa-adn mr-2"></span>Titulo del encabezado</h6>
                                    <p class="text-800">{!! $business->configurations['thead'] ?? 'sin titulo' !!}</p>
                                </div>
                                <hr class="my-3">

                                <div class="mb-4">
                                    <h6 class="fs-0 mb-1"><span class="fas fa-align-left mr-2"></span>Descripción</h6>
                                    <p class="text-800">{{ $business->description }}</p>
                                </div>
                                <hr class="my-3">

                                <div class="mb-4">
                                    <h6 class="fs-0 mb-1"><span class="fas fa-map-marked-alt mr-2"></span>Dirección</h6>
                                    <p class="text-800">{{ $business->address }}</p>
                                </div>
                                <hr class="my-3">

                                <div class="mb-4">
                                    <h6 class="fs-0 mb-1"><span class="fas fa-mobile-alt mr-2"></span>Teléfono</h6>
                                    <p class="text-800">{{ $business->phone }}</p>
                                </div>
                                <hr class="my-3">

                                <div class="mb-4">
                                    <h6 class="fs-0 mb-1"><span class="fas fa-align-left mr-2"></span>Misión</h6>
                                    <p class="text-800">{{ $business->mision }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="fs-0 mb-1"><span class="far fa-address-card mr-2"></span>NIT</h6>
                                    <p class="text-800">{{ $business->nit }}</p>
                                </div>
                                <hr class="my-3">

                                <div class="mb-4">
                                    <h6 class="fs-0 mb-1"><span class="far fa-envelope mr-2"></span>Correo electrónico</h6>
                                    <p class="text-800">{{ $business->mail }}</p>
                                </div>
                                <hr class="my-3">

                                <div class="mb-4">
                                    <h6 class="fs-0 mb-1"><span class="far fa-calendar-check mr-2"></span>Fecha de alta</h6>
                                    <p class="text-800">{{ $business->created_at }}</p>
                                </div>
                                <hr class="my-3">

                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="fs-0 mb-1"><span class="fas fa-exclamation-circle mr-2"></span>Logo</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <img style="width:50px; height:50px;" src="{{ asset('image/' . $business->logo) }}" class="rounded" alt="logo">
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-3">

                                <div class="mb-4">
                                    <h6 class="fs-0 mb-1"><span class="fas fa-align-left mr-2"></span>Visión</h6>
                                    <p class="text-800">{{ $business->vision }}</p>
                                </div>
                                <hr class="my-3">

                                <div class="mb-4">
                                    <h6 class="fs-0 mb-1"><span class="fab fa-facebook mr-2"></span>Facebook</h6>
                                    <p class="text-800">{{ $business->configurations['facebook'] ?? 'sin datos' }}</p>
                                </div>
                                <hr class="my-3">

                                <div class="mb-4">
                                    <h6 class="fs-0 mb-1"><span class="fab fa-twitter mr-2"></span>Twitter</h6>
                                    <p class="text-800">{{ $business->configurations['twitter'] ?? 'sin datos' }}</p>
                                </div>
                                <hr class="my-3">

                                <div class="mb-4">
                                    <h6 class="fs-0 mb-1"><span class="fab fa-instagram mr-2"></span>Instagram</h6>
                                    <p class="text-800">{{ $business->configurations['instagram'] ?? 'sin datos' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <button class="btn btn-primary btn-sm float-right" type="button" data-bs-toggle="modal" data-bs-target="#updateBusinessModal">
                            Actualizar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="updateBusinessModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar datos de empresa</h5>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fas fa-times fs--1"></span>
                    </button>
                </div>
                {!! Form::model($business, ['route' => ['business.update', $business], 'method' => 'PUT', 'files' => true]) !!}
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="name">Nombre</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ $business->name }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="nit">NIT</label>
                        <input class="form-control" type="text" name="nit" id="nit" value="{{ $business->nit }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="description">Descripción</label>
                        <textarea class="form-control" name="description" id="description" rows="3">{{ $business->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="mision">Misión</label>
                        <textarea class="form-control" name="mision" id="mision" rows="3">{{ $business->mision }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="vision">Visión</label>
                        <textarea class="form-control" name="vision" id="vision" rows="3">{{ $business->vision }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="mail">Correo electrónico</label>
                        <input class="form-control" type="email" name="mail" id="mail" value="{{ $business->mail }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="address">Dirección</label>
                        <input class="form-control" type="text" name="address" id="address" value="{{ $business->address }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="phone">Teléfono</label>
                        <input class="form-control" type="text" name="phone" id="phone" value="{{ $business->phone }}">
                    </div>

                    <hr class="my-3">

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" name="show_letter" id="show_letter" type="checkbox" 
                            {{ isset($business->configurations['show_letter']) && $business->configurations['show_letter'] ? 'checked' : '' }}>
                        <label class="form-check-label" for="show_letter">Mostrar titulo del encabezado</label>
                    </div>

                    <div class="mb-3" id="theadCheck">
                        <label class="form-label" for="thead">Titulo de encabezado</label>
                        <input class="form-control" type="text" name="thead" id="thead" 
                            value="{{ $business->configurations['thead'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="facebook">Facebook</label>
                        <input class="form-control" type="url" name="facebook" id="facebook" 
                            value="{{ $business->configurations['facebook'] ?? '' }}" placeholder="https://facebook.com/pagina">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="twitter">Twitter</label>
                        <input class="form-control" type="url" name="twitter" id="twitter" 
                            value="{{ $business->configurations['twitter'] ?? '' }}" placeholder="https://twitter.com/pagina">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="instagram">Instagram</label>
                        <input class="form-control" type="url" name="instagram" id="instagram" 
                            value="{{ $business->configurations['instagram'] ?? '' }}" placeholder="https://instagram.com/pagina">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Logo</label>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <img style="width:50px; height:50px;" src="{{ asset('image/' . $business->logo) }}" class="rounded" alt="logo">
                            </div>
                            <div class="flex-1">
                                <input class="form-control" type="file" name="picture" id="picture">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Actualizar</button>
                    <button class="btn btn-outline-primary" type="button" data-bs-dismiss="modal">Cancelar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#show_letter").on("change", function() {
                if ($(this).prop("checked")) {
                    $("#theadCheck").show();
                } else {
                    $("#theadCheck").hide();
                }
            });
        });
    </script>
@endsection