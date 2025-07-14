@extends('landingpage.main')
@section('main')
    <div class="py-9 max-w-4/6">
        <h2 class="font-bold text-2xl uppercase text-start mb-10">{{$news->title}}</h2>
        <img src="{{ asset('storage/'.$news->file_path) }}" alt="news-{{$news->id}}" class="w-auto h-auto max-w-[50rem] max-h-[50rem] object-cover">
        <p class="mt-6 text-sm w-full">{{$news->description}}</p>
        {{-- <div class="grid grid-cols-2 gap-10 mt-8">
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
        </div> --}}
    </div>
@endsection