{{--
    Partial: admin/partials/empty-state.blade.php
    Uso: @include('admin.partials.empty-state', ['title' => '...', 'message' => '...'])
--}}
<div class="text-center py-5 px-4">
    <img class="img-fluid mb-3"
         src="{{ asset('/falcon/public/assets/img/gallery/noData.svg') }}"
         alt="Sin datos"
         style="max-width: 180px;">
    <h5 class="mb-1">{{ $title ?? 'Sin datos' }}</h5>
    <p class="text-muted mb-0">{{ $message ?? 'No hay información disponible todavía.' }}</p>
</div>