@extends('landingpage.main')
@section('main')
    <div class="py-9">
        <h2 class="font-bold text-2xl uppercase text-center mb-10">Informasi Pendakian Terbaru</h2>
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
                  {{-- <tr class="hover:bg-gray-50 border-b">
                    <td class="px-6 py-4">Andi</td>
                    <td class="px-6 py-4">08:00</td>
                    <td class="px-6 py-4">17:00</td>
                    <td class="px-6 py-4">3</td>
                  </tr>
                  <tr class="hover:bg-gray-50 border-b">
                    <td class="px-6 py-4">Budi</td>
                    <td class="px-6 py-4">09:00</td>
                    <td class="px-6 py-4">16:00</td>
                    <td class="px-6 py-4">2</td>
                  </tr>
                  <tr class="hover:bg-gray-50 border-b">
                    <td class="px-6 py-4">Siti</td>
                    <td class="px-6 py-4">07:30</td>
                    <td class="px-6 py-4">15:30</td>
                    <td class="px-6 py-4">4</td>
                  </tr> --}}
                </tbody>
              </table>
            </div>
          </div>
          
        @endisset
    </div>
@endsection