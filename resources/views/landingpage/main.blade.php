<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gunung Aseupan</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="#" class="text-xl font-bold uppercase text-green-600">Gunung Aseupan</a>
                </div>
                <div class="hidden md:flex space-x-6 items-center">
                    <a href="/" class="text-gray-700 hover:text-green-600 font-semibold">Beranda</a>
                    <a href="data_pendakian" class="text-gray-700 hover:text-green-600 font-semibold">Data Pendakian</a>
                    <a href="panduan" class="text-gray-700 hover:text-green-600 font-semibold">Panduan Booking</a>
                    <a href="berita" class="text-gray-700 hover:text-green-600 font-semibold">Berita</a>
                    <a href="sop" class="text-gray-700 hover:text-green-600 font-semibold">SOP</a>
                    <a href="pengguna" class="text-white bg-green-600 px-4 py-2 rounded hover:bg-green-700 font-semibold">Login</a>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden px-4 pb-4">
            <a href="#" class="block py-2 text-gray-700 hover:text-green-600 font-semibold">Home</a>
            <a href="#" class="block py-2 text-gray-700 hover:text-green-600 font-semibold">About</a>
            <a href="#" class="block py-2 text-gray-700 hover:text-green-600 font-semibold">Services</a>
            <a href="#" class="block py-2 text-gray-700 hover:text-green-600 font-semibold">Contact</a>
            <a href="#" class="block py-2 text-white bg-green-600 text-center rounded hover:bg-green-700 font-semibold">Login</a>
        </div>
    </nav>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @yield('main')
    </div>
    <script>
        const btn = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>