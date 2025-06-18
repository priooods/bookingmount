@extends('landingpage.main')
@section('main')
    <div class="py-9">
        <h2 class="font-bold text-2xl uppercase text-center mb-10">Berita Hari Ini</h2>
        <div class="grid grid-cols-2 gap-10 mt-8">
            @isset($news)
                @foreach ($news as $item)
                <div class="flex justify-start gap-4 max-h-60">
                    <img src="{{ asset('storage/'.$item->file_path) }}" alt="news-{{$item->id}}" class="w-60 h-60 object-cover">
                    <div class="h-full">
                        <p class="font-semibold text-2xl">{{ $item->title }}</p>
                        <p class="mt-6 text-sm line-clamp-6">{{$item->description}}</p>
                    </div>
                </div>
            @endforeach
            @endisset
        </div>
    </div>
@endsection