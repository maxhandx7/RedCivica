@extends('layouts.admin')

@section('title', 'RedCivica – Dashboard')

@section('content')
    <div class="container py-4">


        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 border-end-lg border-bottom border-bottom-lg-0 pb-3 pb-lg-0">
                        <div class="d-flex flex-between-center mb-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-item icon-item-sm bg-primary-subtle shadow-none me-2 bg-primary-subtle">
                                    <span class="fs-11 fas fa-users text-primary"></span>
                                </div>
                                <h6 class="mb-0">Referidos Totales</h6>
                            </div>
                            <div class="dropdown font-sans-serif btn-reveal-trigger">
                                <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal"
                                    type="button" id="dropdown-new-contact" data-bs-toggle="dropdown"
                                    data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span
                                        class="fas fa-ellipsis-h fs-11"></span></button>
                                <div class="dropdown-menu dropdown-menu-end border py-2"
                                    aria-labelledby="dropdown-new-contact"><a class="dropdown-item" href="">Ver</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="d-flex">
                                <p class="font-sans-serif lh-1 mb-1 fs-5 pe-2">{{ $referidosTotales ?? 0 }}</p>
                                <div class="d-flex flex-column">
                                    <span
                                        class="me-1 fas fa-caret-{{ $referidosTotales > 0 ? 'up text-primary' : 'down text-danger' }}"></span>
                                    <p class="fs-11 mb-0 text-nowrap">Personas que se han registrado en tu red.</p>
                                </div>
                            </div>
                            {{--  <div class="echart-crm-statistics w-100 ms-2" data-echart-responsive="true"
                                data-echarts='{"tooltip":{"trigger":"axis"},"xAxis":{"type":"category","data":["June 01","June 02","June 03","June 04","June 05","June 06","June 07"]},"series":[{"type":"line","data":[220,230,150,175,200,170,70,160],"color":"#01FE91","areaStyle":{"color":{"colorStops":[{"offset":0,"color":"#01FE913A"},{"offset":1,"color":"#01FE910A"}]}}}],"grid":{"bottom":"-10px"}}'>
                            </div> --}}
                        </div>
                    </div>

                    <div class="col-lg-4 border-end-lg border-bottom border-bottom-lg-0 pb-3 pb-lg-0">
                        <div class="d-flex flex-between-center mb-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-item icon-item-sm bg-primary-subtle shadow-none me-2 bg-primary-subtle">
                                    <span class="fs-11 fas fas fa-vote-yea text-primary"></span>
                                </div>
                                <h6 class="mb-0">Probabilidad de votación</h6>
                            </div>
                            <div class="dropdown font-sans-serif btn-reveal-trigger">
                                <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal"
                                    type="button" id="dropdown-new-contact" data-bs-toggle="dropdown"
                                    data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span
                                        class="fas fa-ellipsis-h fs-11"></span></button>
                                <div class="dropdown-menu dropdown-menu-end border py-2"
                                    aria-labelledby="dropdown-new-contact"><a class="dropdown-item" href="">Ver</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="d-flex">
                                <p class="font-sans-serif lh-1 mb-1 fs-5 pe-2">{{ $probabilidadVoto . '%' ?? '80%' }}</p>
                                <div class="d-flex flex-column">
                                    <span
                                        class="me-1 fas fa-caret-{{ $probabilidadVoto > 0 ? 'up text-primary' : 'down text-danger' }}"></span>
                                    <p class="fs-11 mb-0 text-nowrap">Estimado de participación en tu red.</p>
                                </div>
                            </div>
                            {{--  <div class="echart-crm-statistics w-100 ms-2" data-echart-responsive="true"
                                data-echarts='{"tooltip":{"trigger":"axis"},"xAxis":{"type":"category","data":["June 01","June 02","June 03","June 04","June 05","June 06","June 07"]},"series":[{"type":"line","data":[220,230,150,175,200,170,70,160],"color":"#01FE91","areaStyle":{"color":{"colorStops":[{"offset":0,"color":"#01FE913A"},{"offset":1,"color":"#01FE910A"}]}}}],"grid":{"bottom":"-10px"}}'>
                            </div> --}}
                        </div>
                    </div>

                    <div class="col-lg-4 border-end-lg border-bottom border-bottom-lg-0 pb-3 pb-lg-0">
                        <div class="d-flex flex-between-center mb-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-item icon-item-sm bg-primary-subtle shadow-none me-2 bg-primary-subtle">
                                    <span class="fs-11 fas fa-hands-helping text-primary"></span>
                                </div>
                                <h6 class="mb-0">Partidarios activos</h6>
                            </div>
                            <div class="dropdown font-sans-serif btn-reveal-trigger">
                                <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal"
                                    type="button" id="dropdown-new-contact" data-bs-toggle="dropdown"
                                    data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span
                                        class="fas fa-ellipsis-h fs-11"></span></button>
                                <div class="dropdown-menu dropdown-menu-end border py-2"
                                    aria-labelledby="dropdown-new-contact"><a class="dropdown-item" href="">Ver</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="d-flex">
                                <p class="font-sans-serif lh-1 mb-1 fs-5 pe-2">{{ $partidariosActivos ?? 0 }}</p>
                                <div class="d-flex flex-column">
                                    <span
                                        class="me-1 fas fa-caret-{{ $partidariosActivos > 0 ? 'up text-primary' : 'down text-danger' }}"></span>
                                    <p class="fs-11 mb-0 text-nowrap">Usuarios con al menos 1 referido.</p>
                                </div>
                            </div>
                            {{--  <div class="echart-crm-statistics w-100 ms-2" data-echart-responsive="true"
                                data-echarts='{"tooltip":{"trigger":"axis"},"xAxis":{"type":"category","data":["June 01","June 02","June 03","June 04","June 05","June 06","June 07"]},"series":[{"type":"line","data":[220,230,150,175,200,170,70,160],"color":"#01FE91","areaStyle":{"color":{"colorStops":[{"offset":0,"color":"#01FE913A"},{"offset":1,"color":"#01FE910A"}]}}}],"grid":{"bottom":"-10px"}}'>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Formulario para crear enlaces --}}
        <div class="card mb-4">
            <div class="card-header">Crear Enlace de Referencia</div>
            <div class="card-body">
                <form method="POST" action="{{ route('referencias.store') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col">
                            <label for="campaña_id">Campaña</label>
                            <select name="campaña_id" id="campaña_id" class="form-select">
                                <option value="" disabled>Seleccione una campaña...</option>
                                @foreach ($campañas as $campaña)
                                    <option value="{{ $campaña->id }}"
                                        {{ old('campaña_id') == $campaña->id ? 'selected' : '' }}>
                                        {{ $campaña->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label>Objetivo</label>
                            <textarea name="objetivo" class="form-control"
                                placeholder="Ej: Inscripción votantes"  rows="3"></textarea>
                           
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label>Fuente</label>
                            <input type="text" name="fuente" class="form-control"
                                placeholder="facebook, whatsapp, etc">
                        </div>
                        <div class="col">
                            <label>Medio</label>
                            <input type="text" name="medio" class="form-control" placeholder="Redes, Impreso, etc">
                        </div>
                    </div>
                    <button class="btn btn-primary w-100">Generar Enlace</button>
                </form>
            </div>
        </div>
    @endsection
