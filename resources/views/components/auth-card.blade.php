<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 custom-back" style="background-image: url('{{ asset('img/SDN BANNER 2.png') }}')">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>

</div>
