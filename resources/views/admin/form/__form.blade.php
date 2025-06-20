
{!! Form::open(['route' => 'users.form', 'method' => 'POST', 'files' => true]) !!}
                        @csrf

                        <!-- Campos ocultos para tracking -->
                        <input type="hidden" name="parent_id" value="{{ $referidor->id ??  null}}">
                        <input type="hidden" name="fuente" value="{{ $fuente ?? 'web' }}">
                        <input type="hidden" name="medio" value="{{ $medio ?? 'web' }}">
                        <input type="hidden" name="referencia_id" value="{{ $referencia_id ?? null }}">

                        <div class="mb-3">
                            <label class="form-label" for="name">Nombres</label>
                            <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" 
                                   name="name" value="{{ old('name') }}" required autocomplete="given-name" autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="surname">Apellidos</label>
                            <input class="form-control @error('surname') is-invalid @enderror" id="surname" type="text" 
                                   name="surname" value="{{ old('surname') }}" required autocomplete="family-name">
                            @error('surname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="cedula">Cédula</label>
                                <input class="form-control @error('cedula') is-invalid @enderror" id="cedula" type="text" 
                                       name="cedula" value="{{ old('cedula') }}" required 
                                       pattern="[0-9]{6,10}" title="Ingresa un número de cédula válido (6-10 dígitos)">
                                @error('cedula')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="telefono">Teléfono</label>
                                <input class="form-control @error('telefono') is-invalid @enderror" id="telefono" type="tel" 
                                       name="telefono" value="{{ old('telefono') }}" 
                                       pattern="[0-9]{10,15}" title="Ingresa un número de teléfono válido">
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="email">Correo Electrónico</label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="direccion">Dirección</label>
                            <input class="form-control @error('direccion') is-invalid @enderror" id="direccion" type="text" 
                                   name="direccion" value="{{ old('direccion') }}">
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="barrio">Barrio</label>
                                <input class="form-control @error('barrio') is-invalid @enderror" id="barrio" type="text" 
                                       name="barrio" value="{{ old('barrio') }}">
                                @error('barrio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="ciudad">Ciudad</label>
                                <input class="form-control @error('ciudad') is-invalid @enderror" id="ciudad" type="text" 
                                       name="ciudad" value="{{ old('ciudad') }}">
                                @error('ciudad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="mesa">Mesa de Votación</label>
                            <input class="form-control @error('mesa') is-invalid @enderror" id="mesa" type="text" 
                                   name="mesa" value="{{ old('mesa') }}" placeholder="Ej: A12, B05">
                            @error('mesa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                            <label class="form-check-label" for="terms">
                                Acepto los <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">términos y condiciones</a>
                            </label>
                            @error('terms')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary d-block w-100 mt-3" type="submit">
                                <i class="fas fa-user-plus me-2"></i> Registrar
                            </button>
                        </div>
                    </form>