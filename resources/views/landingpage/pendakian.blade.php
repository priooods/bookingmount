@extends('landingpage.main')
@section('main')
    <div class="py-9">
        <h2 class="font-bold text-2xl uppercase text-center mb-10">Informasi Pendakian Terbaru</h2>
        <div class="flex justify-end mb-4 px-6">
          <div class="mr-auto">
            <p>Kuota Tersedia</p>
            <p>Tgl {{ \Carbon\Carbon::parse($kuota->start_dates)->format('d F Y') }} - {{ \Carbon\Carbon::parse($kuota->end_dates)->format('d F Y') }}</p>
            <p>Kuota {{ $kuota->kuota }}</p>
          </div>
          <form method="GET" action="{{ route('pendakian.index') }}" class="flex items-center space-x-2">
              <input
                  type="text"
                  name="search"
                  value="{{ request('search') }}"
                  placeholder="Cari nama pendaki..."
                  class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
              >
              <button
                  type="submit"
                  class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition"
              >
                  Cari
              </button>
          </form>
        </div>
        @isset($pendakian)
          <div class="p-6">
              <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="min-w-full table-auto border border-gray-200">
                  <thead class="bg-gradient-to-r from-purple-500 to-pink-500 text-white">
                    <tr>
                      <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Nama</th>
                      <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Berangkat</th>
                      <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Pulang</th>
                      <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Jumlah Teman</th>
                    </tr>
                  </thead>
                  <tbody class="text-gray-700">
                      @foreach ($pendakian as $item)
                          <tr class="hover:bg-gray-50">
                              <td class="px-6 py-4">{{$item->realname}}</td>
                              <td class="px-6 py-4">{{\Carbon\Carbon::parse($item->start_climb)->format('d M Y')}}</td>
                              <td class="px-6 py-4">{{\Carbon\Carbon::parse($item->end_climb)->format('d M Y')}}</td>
                              <td class="px-6 py-4">{{$item->count_friend}}</td>
                          </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            
        @endisset
    </div>
@endsection