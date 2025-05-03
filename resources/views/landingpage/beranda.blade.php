@extends('landingpage.main')
@section('main')
    <div class="py-3">
        <div class="bg-gray-300 p-8 rounded-sm">
            <p class="text-4xl font-semibold mb-10">Selamat Datang di Pendakian <br> Gunung Aseupan</p>
            <a href="pengguna" class="rounded-lg bg-green-800 px-4 py-2 text-white font-semibold text-sm">Booking Now</a>
        </div>
        <div class="mt-16">
            <h2 class="font-bold text-lg uppercase">Berita Hari Ini</h2>
            <div class="grid grid-cols-2 gap-10 mt-8">
                @foreach ($news as $item)
                    <div class="flex justify-start gap-4 max-h-60">
                        <img src="{{ asset('storage/'.$item->file_path) }}" alt="news-{{$item->id}}" class="w-60 h-60 object-cover">
                        <div class="h-full">
                            <p class="font-semibold text-2xl">{{ $item->title }}</p>
                            <p class="mt-6 text-sm line-clamp-6">{{$item->description}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection