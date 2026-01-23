@extends('layouts.admin')

@section('title', 'Configuración General')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Configuración General del Sistema</h5>
            </div>
            <div class="card-body">
                <form action="#" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Configuración del Sitio</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="site_name" class="form-label">Nombre del Sitio</label>
                                        <input type="text" class="form-control" id="site_name" value="Sistema de Candidatos">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="site_description" class="form-label">Descripción</label>
                                        <textarea class="form-control" id="site_description" rows="3">Sistema de gestión de campañas políticas</textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="site_email" class="form-label">Email de Contacto</label>
                                        <input type="email" class="form-control" id="site_email" value="info@sistema-candidatos.com">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Configuración de Visualización</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="candidatos_por_pagina" class="form-label">Candidatos por página</label>
                                        <input type="number" class="form-control" id="candidatos_por_pagina" value="10" min="5" max="50">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="propuestas_por_pagina" class="form-label">Propuestas por página</label>
                                        <input type="number" class="form-control" id="propuestas_por_pagina" value="10" min="5" max="50">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="default_color" class="form-label">Color principal por defecto</label>
                                        <input type="color" class="form-control form-control-color" id="default_color" value="#007bff">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Configuración de Seguridad</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="require_verification" checked>
                                                <label class="form-check-label" for="require_verification">
                                                    Requerir verificación de email
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="enable_2fa" checked>
                                                <label class="form-check-label" for="enable_2fa">
                                                    Habilitar autenticación de dos factores
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="log_activities" checked>
                                                <label class="form-check-label" for="log_activities">
                                                    Registrar actividades del sistema
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="auto_backup" checked>
                                                <label class="form-check-label" for="auto_backup">
                                                    Backup automático diario
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2">
                                    <i class="fas fa-times me-2"></i> Cancelar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Guardar Configuración
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection