@extends('layouts.app')

@section('content')
<main>

<div class="projects-create">

    <div class="container">

        <div class="card mx-auto my-5" style="max-width: 900px;">
            <div class="card-body">
                <h3 class="card-title" style="text-align:center;">Inserisci un nuovo progetto!</h5>

                <form action="{{ route('projects.store') }}" method="POST">
                    {{-- controllo csrf  --}}
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Titolo:</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title') }}">
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type-id" class="form-label">Tipologia:</label>
                        <select class="form-select @error('type_id') is-invalid @enderror" name="type_id" id="type-id" value="{{ old('type_id') }}">
                            <option value="" selected>Seleziona tipologia</option>
                            @foreach($types as $type)
                                <option @selected( old('type_id') == $type->id ) value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        
                        @error('type_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descrizione:</label>
                        <textarea type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description">
                            {{ old('description') }}
                        </textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="client_name" class="form-label">Cliente:</label>
                        <input type="text" class="form-control @error('client_name') is-invalid @enderror" name="client_name" id="client_name" value="{{ old('client_name') }}">
                        @error('client_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="client_tel" class="form-label">Telefono cliente:</label>
                        <input type="text" class="form-control @error('client_tel') is-invalid @enderror" name="client_tel" id="client_tel" value="{{ old('client_tel') }}">
                        @error('client_tel')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="btn-parent d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary mx-auto">Salva</button>
                    </div>
                
                </form>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>

    </div>

</div>

</main>
@endsection
