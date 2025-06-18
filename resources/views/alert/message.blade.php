@if(session('success'))
<div id="success-message" class="alert alert-success border-0 d-flex align-items-center" role="alert">
  <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-6"></span></div>
  <p class="mb-0 flex-1">{{ session('success') }}</p>
  <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@elseif(session('error'))
<div id="success-message" class="alert alert-danger border-0 d-flex align-items-center" role="alert">
  <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-6"></span></div>
  <p class="mb-0 flex-1">{{ session('error') }}</p>
  <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@elseif(session('warning'))
<div id="success-message" class="alert alert-warning">
    {{ session('warning') }}
</div>
@elseif(session('info'))
<div id="success-message" class="alert alert-info">
    {{ session('info') }}
</div>
@endif