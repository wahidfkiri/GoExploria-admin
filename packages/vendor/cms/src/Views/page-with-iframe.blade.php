@extends('cms::layouts.app')
@section('content')
    
    <!-- Conteneur principal avec padding -->
        <div class="row">
            
            <!-- Colonne droite - iframe (8 colonnes) -->
            <div class="col-12" style="padding: 0; height: 100vh;">
                <iframe 
                    src="{{ route('theme.iframe', ['etablissementId' => $etablissement->id, 'slug' => 'home']) }}" 
                    style="width: 100%; height: 100%; border: none;"
                    title="Theme Preview">
                </iframe>
            </div>
        </div>
@endsection