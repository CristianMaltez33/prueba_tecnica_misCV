@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container-fluid px-4">
            <form action="{{ route('cv.index') }}" id="formBuscar" class="mb-4" method="GET">
                @csrf
                @method('GET')
                <div class="row g-3">

                    <div class="col-md-2">
                        <label for="nivelAcademico" class="form-label">Nivel académico</label>
                        <select name="facademica_estado" id="nivelAcademico" class="form-select">
                            <option value="">-- Seleccione --</option>
                            @foreach ($nivelAcademico as $nivel)
                                <option value="{{ $nivel->estado }}"
                                    {{ old('facademica_estado', request('facademica_estado')) == $nivel->estado ? 'selected' : '' }}>
                                    {{ $nivel->estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="especialidad" class="form-label">Especialidad</label>
                        <input id="especialidad" name="facademica_especialidad" class="form-control"
                            placeholder="Administración de Empresas"
                            value="{{ old('facademica_especialidad', request('facademica_especialidad')) }}">
                    </div>

                    <div class="col-md-2">
                        <label for="departamento" class="form-label">Departamento</label>
                        <select name="departamento" id="departamento" class="form-select">
                            <option value="">-- Seleccione --</option>
                            @foreach ($departamentos as $departamento)
                                <option value="{{ $departamento->nombre }}"
                                    {{ old('departamento', request('departamento')) == $departamento->nombre ? 'selected' : '' }}>
                                    {{ $departamento->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label for="licencia" class="form-label">Licencia</label>
                        <select name="licencia" id="licencia" class="form-select">
                            <option value="">--</option>
                            <option value="SI" {{ old('licencia', request('licencia')) == 'SI' ? 'selected' : '' }}>Sí
                            </option>
                            <option value="NO" {{ old('licencia', request('licencia')) == 'NO' ? 'selected' : '' }}>No
                            </option>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label for="vehiculo" class="form-label">Vehículo</label>
                        <select name="vehiculo" id="vehiculo" class="form-select">
                            <option value="">--</option>
                            <option value="SI" {{ old('vehiculo', request('vehiculo')) == 'SI' ? 'selected' : '' }}>Sí
                            </option>
                            <option value="NO" {{ old('vehiculo', request('vehiculo')) == 'NO' ? 'selected' : '' }}>No
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="salario" class="form-label">Salario máximo</label>
                        <input name="salario" id="salario" type="number" class="form-control" min="0"
                            value="{{ old('salario', request('salario')) }}">
                    </div>

                    <div class="col-md-2">
                        <div style="height: 30px"></div>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </form>
            <div class="mb-3">
                <a href="{{ route('cv.export.csv', request()->all()) }}" class="btn btn-success">Exportar CSV</a>
                <a href="{{ route('cv.export.json', request()->all()) }}" class="btn btn-primary">Exportar JSON</a>
            </div>


            @if (isset($resultados) && $resultados->count())
                <div class="table-responsive">
                    <table id="cvTable" class="table table-bordered mt-4">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Departamento</th>
                                <th>Vehículo</th>
                                <th>Licencia</th>
                                <th>Salario más alto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resultados as $cv)
                                <tr>
                                    <td>{{ $cv->nombre_completo }}</td>
                                    <td>{{ $cv->correo }}</td>
                                    <td>{{ $cv->telefono }}</td>
                                    <td>{{ strtoupper($cv->departamento) }}</td>
                                    <td>{{ $cv->vehiculo }}</td>
                                    <td>{{ $cv->licencia }}</td>
                                    <td>
                                        @php
                                            $salarios = collect($cv->exlaboral)
                                                ->pluck('salario')
                                                ->map(fn($s) => (int) $s);
                                            $salarioMax = $salarios->max();
                                        @endphp
                                        ${{ $salarioMax }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="mt-4">No se encontraron resultados.</p>
            @endif

        </div>
    </div>

    <script>
        const input = document.getElementById('especialidad');
        input.addEventListener('blur', () => input.value = input.value.trim());
        document.querySelector('#formBuscar').addEventListener('submit', () => input.value = input.value.trim());

        $(document).ready(function() {
            $('#cvTable').DataTable({
                "order": [
                    [0, "asc"]
                ],
                "paging": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "language": {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron resultados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": activar para ordenar ascendente",
                        "sortDescending": ": activar para ordenar descendente"
                    }
                }
            });
        });
    </script>
@endsection
