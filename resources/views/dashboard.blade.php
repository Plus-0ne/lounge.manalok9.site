<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col p-8">
                
               
                
                @if(Auth::user()->first_name or Auth::user()->last_name)
                    <div class="text-2xl" style="margin: auto; ">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</div>
                @endif

                @if(Auth::user()->email)
                <div class="text-xl" style="margin: auto; "><a href="mailto:{{Auth::user()->email}}">{{Auth::user()->email}}</a></div>
                @endif

                @if(Auth::user()->Address)
                <div class="text-2xl" style="margin: auto; ">{{Auth::user()->Address}}</div>
                @endif

                @if(Auth::user()->Contact)
                <div class="text-2xl" style="margin: auto; ">{{Auth::user()->Contact}}</div>
                @endif
                
            </div>

            
        </div>
    </div>
    @if(Auth::user()->kennel)
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col p-8">
                <div class="MX-AUTO"><h2>ICGD</h2></div>
                <iframe src="{{ Auth::user()->kennel }}" height="500px" width="100%" title="Iframe Example" style="border: solid #000000;"></iframe>
            </div>

            
        </div>
    </div>
    @endif
    @if(Auth::user()->cattery)
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col p-8">
                <div><h2>IFGD</h2></div>
                <iframe src="{{ Auth::user()->cattery }}" height="500px" width="100%" title="Iframe Example" style="border: solid #000000;"></iframe>
            </div>
        </div>
    </div>
    @endif
    @if(Auth::user()->rabbitry)
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col p-8">
                <div><h2>IRGD</h2></div>
                <iframe src="{{ Auth::user()->rabbitry }}" height="500px" width="100%" title="Iframe Example" style="border: solid #000000;"></iframe>
            </div>
        </div>
    </div>
    @endif
    @if(Auth::user()->chicken_coop)
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col p-8">
                <div><h2>IBGD</h2></div>
                <iframe src="{{ Auth::user()->chicken_coop }}" height="500px" width="100%" title="Iframe Example" style="border: solid #000000;"></iframe>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
