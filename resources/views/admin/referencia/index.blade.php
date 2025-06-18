@extends('layouts.admin')
@section('styles')
@endsection
@section('options')
@endsection
@section('preference')
@endsection
@section('content')
    {!! Html::style('/falcon/public/assets/css/vis-network.css') !!}
    {!! Html::style('/falcon/public/vendors/jquery/jquery.min.js') !!}
    {!! Html::style('/falcon/public/vendors/datatables.net/dataTables.min.js') !!}
    {!! Html::style('/falcon/public/vendors/datatables.net-bs5/dataTables.bootstrap5.min.js') !!}
    {!! Html::style('/falcon/public/vendors/datatables.net-fixedcolumns/dataTables.fixedColumns.min.js') !!}

    <style>
        #qrCode img {
            margin: 0 auto;
            border: 1px solid #eee;
            padding: 10px;
            border-radius: 8px;
            background: white;
        }

        .input-group-text {
            cursor: pointer;
            transition: all 0.3s;
        }

        .input-group-text:hover {
            background-color: #e9ecef;
        }

        #qrCodeContainer {
            display: inline-block;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background: white;
        }

        #qrCodeContainer img {
            display: block;
            margin: 0 auto;
        }

        .list-group-item {
            padding: 0.75rem 1.25rem;
        }

        .list-group-item span:last-child {
            text-align: right;
        }

        #referenceLinkInput {
            color: #000;
            background-color: #d3d5d6;
        }
    </style>

    <div class="container mt-5">
        <div class="page-header d-flex justify-content-between">
            <h3 class="page-title">
                Mis Campañas
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="/home">Panel principal</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Campañas</li>
                </ol>
            </nav>
        </div>

        <div class="d-flex justify-content-between">
            <h4 class="card-title">lista de campañas</h4>
            <div class="btn-group">
                <a href="{{ route('referencias.create') }}" class="btn btn-primary me-1 mb-1" type="button">
                    <span class="fas fa-plus ms-1" data-fa-transform="shrink-3"></span>
                    Crear enlace de campaña</a>
            </div>
        </div>

        @if ($referencias->isEmpty())
            <div class="alert alert-info">Aún no has generado ninguna campañas.</div>
        @else
            @include('alert.message')
            <div class="table-responsive  pt-3">
                <table id="order-listing" class="table mb-0 table-striped data-table fs-10">
                    <thead>
                        <tr>
                            <th>Campaña</th>
                            <th>Objetivo</th>
                            <th>Fuente</th>
                            <th>Medio</th>
                            <th style="width: 100px;">Creado</th>
                            <th style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($referencias as $ref)
                            <tr>
                                <td>{{ $ref->campaña->name }}</td>
                                <td>{{ $ref->objetivo }}</td>
                                <td>{{ $ref->fuente }}</td>
                                <td>{{ $ref->medio }}</td>
                                <td style="width: 100px;">{{ $ref->created_at->diffForHumans() }}</td>

                                <td style="width: 160px;">
                                    {!! Form::open([
                                        'route' => ['referencias.destroy', $ref],
                                        'method' => 'DELETE',
                                        'id' => 'delete-form-' . $ref->id,
                                    ]) !!}

                                    <a class="btn btn-outline-info me-1 mb-1 show-reference-btn btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#referenceModal"
                                        data-reference-id="{{ $ref->id }}" data-campaign="{{ $ref->campaña->name }}"
                                        data-objective="{{ $ref->objetivo }}" data-source="{{ $ref->fuente }}"
                                        data-medium="{{ $ref->medio }}"
                                        data-created="{{ $ref->created_at->format('d/m/Y H:i') }}"
                                        data-referral-url="{{ route('referidos.registro', [
                                            'usr' => auth()->id(),
                                            'fuente' => $ref->fuente,
                                            'medio' => $ref->medio,
                                            'ref_id' => $ref->id,
                                        ]) }}"
                                        title="Ver enlace de campaña">
                                        <span class="fas fa-link ms-1" data-fa-transform="shrink-3"></span>
                                    </a>

                                    <a class="btn btn-outline-success me-1 mb-1 btn-sm"
                                        href="{{ route('referencias.edit', $ref) }}" type="button" title="Editar">
                                        <span class="fas fa-pen ms-1" data-fa-transform="shrink-3"></span>
                                    </a>

                                    <button class="btn btn-outline-danger me-1 mb-1 delete-confirm btn-sm" type="submit"
                                        title="Eliminar" onclick="return confirmDelete()">
                                        <span class="fas fa-trash ms-1" data-fa-transform="shrink-3"></span>
                                    </button>
                                    {!! Form::close() !!}

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @include('admin.referencia.__modal_exito')

    @include('admin.referencia.__modal_referencia')

@endsection
@section('scripts')
    {!! Html::script('melody/js/data-table.js') !!}
    <!-- Librería QR Code -->
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

    @if (session('show_modal'))
        <script>
            var toastEl = document.getElementById('liveToast');
        var toast = new bootstrap.Toast(toastEl);
            document.addEventListener('DOMContentLoaded', function() {
                // Configuración del modal
                const modalConfig = {
                    title: "{{ session('modal_config.title') }}",
                    message: "{{ session('modal_config.message') }}",
                    formUrl: generateReferralLink()
                };

                // Generar el enlace con parámetros GET
                function generateReferralLink() {
                    const baseUrl = "{{ route('referidos.registro') }}";
                    const params = new URLSearchParams({
                        usr: "{{ session('modal_config.usr') }}",
                        fuente: "{{ session('modal_config.fuente', null) }}",
                        medio: "{{ session('modal_config.medio') }}",
                        ref_id: "{{ session('modal_config.ref_id', null) }}",
                    });
                    return `${baseUrl}?${params.toString()}`;
                }

                // Mostrar modal
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));

                // Asignar datos al modal
                document.getElementById('referralLink').value = modalConfig.formUrl;

                // Generar QR
                new QRCode(document.getElementById("qrCode"), {
                    text: modalConfig.formUrl,
                    width: 150,
                    height: 150,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });

                // Mostrar modal
                successModal.show();

                // Copiar al portapapeles
                window.copyToClipboard = function() {
                    const copyText = document.getElementById("referralLink");
                    copyText.select();
                    document.execCommand("copy");
                    toast.show();
                };

                // Compartir en WhatsApp
                window.shareOnWhatsApp = function() {
                    const message = `Únete a nuestra plataforma usando este enlace: ${modalConfig.formUrl}`;
                    window.open(`https://wa.me/?text=${encodeURIComponent(message)}`, '_blank');
                };

                // Compartir por Email
                window.shareOnEmail = function() {
                    const subject = "Invitación a unirse a nuestra plataforma";
                    const body =
                        `Hola,\n\nTe invito a registrarte en nuestra plataforma usando este enlace:\n${modalConfig.formUrl}\n\nSaludos`;
                    window.location.href =
                        `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
                };
            });
        </script>
    @endif



    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
        <div class="toast fade" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-primary text-white"><strong class="me-auto">RedCivica</strong><small>11 mins
                    ago</small>
                <div data-bs-theme="dark">
                    <button class="btn-close" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <div class="toast-body">Enlace copiado al portapapeles. Puedes compartirlo manualmente.</div>
        </div>
    </div>

    <script>
        var toastEl = document.getElementById('liveToast');
        var toast = new bootstrap.Toast(toastEl);
        document.addEventListener('DOMContentLoaded', function() {
            // Variables para almacenar datos
            let currentReferenceUrl = '';
            let qrCodeInstance = null;

            // Evento cuando se muestra el modal
            document.querySelectorAll('.show-reference-btn').forEach(button => {
                button.addEventListener('click', function() {
                    // Obtener datos de los atributos data
                    const referenceId = this.getAttribute('data-reference-id');
                    const campaign = this.getAttribute('data-campaign');
                    const objective = this.getAttribute('data-objective');
                    const source = this.getAttribute('data-source');
                    const medium = this.getAttribute('data-medium');
                    const created = this.getAttribute('data-created');
                    currentReferenceUrl = this.getAttribute('data-referral-url');

                    // Actualizar contenido del modal
                    document.getElementById('modalCampaign').textContent = campaign;
                    document.getElementById('modalObjective').textContent = objective;
                    document.getElementById('modalSource').textContent = source;
                    document.getElementById('modalMedium').textContent = medium;
                    document.getElementById('modalCreated').textContent = created;
                    document.getElementById('referenceLinkInput').value = currentReferenceUrl;

                    // Generar o actualizar QR
                    if (qrCodeInstance) {
                        qrCodeInstance.clear();
                        qrCodeInstance.makeCode(currentReferenceUrl);
                    } else {
                        qrCodeInstance = new QRCode(document.getElementById("qrCodeContainer"), {
                            text: currentReferenceUrl,
                            width: 150,
                            height: 150,
                            colorDark: "#000000",
                            colorLight: "#ffffff",
                            correctLevel: QRCode.CorrectLevel.H
                        });
                    }
                });
            });

            // Función para copiar el enlace
            window.copyReferenceLink = function() {
                const copyText = document.getElementById("referenceLinkInput");
                copyText.select();
                document.execCommand("copy");

                // Mostrar notificación
                const originalText = copyText.nextElementSibling.innerHTML;
                copyText.nextElementSibling.innerHTML = '<i class="fas fa-check"></i> Copiado';

                setTimeout(() => {
                    copyText.nextElementSibling.innerHTML = originalText;
                }, 2000);
            };

            // Función para abrir el formulario
            window.openReferralForm = function() {
                window.open(currentReferenceUrl, '_blank');
            };

            // Función para compartir
            window.shareReference = function() {
                if (navigator.share) {
                    navigator.share({
                        title: 'Únete a nuestra campaña',
                        text: 'Por favor regístrate usando este enlace de campaña',
                        url: currentReferenceUrl
                    }).catch(err => {
                        console.log('Error al compartir:', err);
                    });
                } else {
                    // Fallback para navegadores que no soportan Web Share API
                    copyReferenceLink();
                    toast.show();
                  
                }
            };
        });
    </script>
@endsection
