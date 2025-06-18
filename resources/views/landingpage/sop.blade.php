@extends('landingpage.main')
@section('main')
    <div class="py-9">
        <h2 class="font-bold text-2xl uppercase text-center mb-10">SOP Pendakian</h2>
        @isset($sop)
            <iframe src="{{ asset('storage/'.$sop->file_path) }}" 
                width="100%" height="700px">
        </iframe>
        @endisset
    </div>
@endsection