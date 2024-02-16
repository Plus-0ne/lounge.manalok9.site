<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            {{-- <a href="/"> --}}
                {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
                <img src="{{asset('/Source')}}/META_LOGO.svg" width="100" height="100">
            {{-- </a> --}}
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="columns-2">
                <div><!-- First Name -->
                    <div >
                        <x-label for="first_name" :value="__('FirstName')" />
        
                        <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus />
                    </div>
        
                    <!-- Last Name -->
                    <div class="mt-4">
                        <x-label for="last_name" :value="__('LastName')" />
        
                        <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus />
                    </div>
        
                    <!-- Complete Address -->
                    <div class="mt-4">
                        <x-label for="Address" :value="__('Address')" />
        
                        <x-input id="Address" class="block mt-1 w-full" type="text" name="Address" :value="old('Address')" required autofocus />
                    </div>
        
                    <!-- mobile number -->
                    <div class="mt-4">
                        <x-label for="Contact" :value="__('Contact')" />
        
                        <x-input id="Contact" class="block mt-1 w-full" type="text" name="Contact" :value="old('Contact')" required />
                    </div>
        
                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-label for="email" :value="__('Email')" />
        
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    </div>
        
                    <!-- Password -->
                    <div class="mt-4">
                        <x-label for="password" :value="__('Password')" />
        
                        <x-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />
                    </div>
        
                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-label for="password_confirmation" :value="__('Confirm Password')" />
        
                        <x-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required />
                    </div>
                </div>
                <div>           
                     
                    <div class="mt-4">
                        <x-label for="kennel" :value="__('kennel')" />
        
                        <x-input id="kennel" class="block mt-1 w-full" type="url" name="kennel" :value="old('kennel')" />
                    </div>
        
                    {{-- cattery --}}
                    <div class="mt-4">
                        <x-label for="cattery" :value="__('cattery')" />
        
                        <x-input id="cattery" class="block mt-1 w-full" type="url" name="cattery" :value="old('cattery')" />
                    </div>
        
                    {{-- rabbitry --}}
                    <div class="mt-4">
                        <x-label for="rabbitry" :value="__('rabbitry')" />
        
                        <x-input id="rabbitry" class="block mt-1 w-full" type="url" name="rabbitry" :value="old('rabbitry')" />
                    </div>
        
                    {{-- chickencoop --}}
                    <div class="mt-4">
                        <x-label for="chickencoop" :value="__('chickencoop')" />
        
                        <x-input id="chickencoop" class="block mt-1 w-full" type="url" name="chickencoop" :value="old('chickencoop')" />
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
        
                        <x-button class="ml-4">
                            {{ __('Register') }}
                        </x-button>
                    </div></div>
            </div>
            


        </form>
    </x-auth-card>
</x-guest-layout>
