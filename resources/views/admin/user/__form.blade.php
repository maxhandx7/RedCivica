@include('alert.message')
{!! Form::open(['route' => 'users.store', 'method' => 'POST', 'files' => true]) !!}
@csrf

<div class="mb-3">
    <label class="form-label" for="name">Nombres</label>
    <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name"
        value="{{ old('name') }}" required autocomplete="given-name" autofocus>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="surname">Apellidos</label>
    <input class="form-control @error('surname') is-invalid @enderror" id="surname" type="text" name="surname"
        value="{{ old('surname') }}" required autocomplete="family-name">
    @error('surname')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row g-2 mb-3">
    <div class="col-sm-6">
        <label class="form-label" for="cedula">Cédula</label>
        <input class="form-control @error('cedula') is-invalid @enderror" id="cedula" type="text" name="cedula"
            value="{{ old('cedula') }}" required pattern="[0-9]{6,10}"
            title="Ingresa un número de cédula válido (6-10 dígitos)">
        @error('cedula')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="telefono">Teléfono</label>
        <input class="form-control @error('telefono') is-invalid @enderror" id="telefono" type="tel"
            name="telefono" value="{{ old('telefono') }}" pattern="[0-9]{10,15}"
            title="Ingresa un número de teléfono válido">
        @error('telefono')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label" for="email">Correo Electrónico</label>
    <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email"
        value="{{ old('email') }}" required autocomplete="email">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="direccion">Dirección</label>
    <input class="form-control @error('direccion') is-invalid @enderror" id="direccion" type="text" name="direccion"
        value="{{ old('direccion') }}">
    @error('direccion')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row g-2 mb-3">
    <div class="col-sm-6">
        <label class="form-label" for="barrio">Barrio</label>
        <input class="form-control @error('barrio') is-invalid @enderror" id="barrio" type="text" name="barrio"
            value="{{ old('barrio') }}">
        @error('barrio')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="ciudad">Ciudad</label>
        <input class="form-control @error('ciudad') is-invalid @enderror" id="ciudad" type="text" name="ciudad"
            value="{{ old('ciudad') }}">
        @error('ciudad')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label" for="mesa">Mesa de Votación</label>
    <input class="form-control @error('mesa') is-invalid @enderror" id="mesa" type="text" name="mesa"
        value="{{ old('mesa') }}" placeholder="Ej: A12, B05">
    @error('mesa')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="card card-borderless shadow-sm mb-4">
    <div class="card-header bg-primary">
        <h5 class="card-header-title">Configuración Adicional</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label" for="password">Contraseña</label>
                <input class="form-control @error('password') is-invalid @enderror" id="password" type="password"
                    name="password" autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label" for="password_confirmation">Confirmar Contraseña</label>
                <input class="form-control" id="password_confirmation" type="password" name="password_confirmation"
                    autocomplete="new-password">
            </div>

            <div class="col-12 mb-3">
                <label class="form-label">Rol de usuario</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="role_admin" value="admin"
                        >
                    <label class="form-check-label" for="role_admin">
                        <span class="fas fa-user-shield me-2"></span>Administrador
                    </label>
                </div>
                <div class="form-check ">
                    <input class="form-check-input" type="radio" name="role" id="role_cliente"
                        value="cliente" checked>
                    <label class="form-check-label" for="role_cliente">
                        <span class="fas fa-user me-2"></span>Usuario común
                    </label>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-check form-switch form-check-lg">
                    <input class="form-check-input" type="checkbox" name="estado" id="estado" checked>
                    <label class="form-check-label" for="estado">
                        Usuario activo
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    <button class="btn btn-primary d-block w-100 mt-3" type="submit">
        <i class="fas fa-user-plus me-2"></i> Registrar
    </button>
</div>
</form>
