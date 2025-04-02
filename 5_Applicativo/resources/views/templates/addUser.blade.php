@include('templates.header')
<div class="container-lg p-5">
    <form method="POST" action="{{route('admin.save')}}" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- Riga 1: Name e Surname -->
            <div class="col-md-6 mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="col-md-6 mb-4">
                <x-input-label for="surname" :value="__('Surname')" />
                <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')" required />
                <x-input-error :messages="$errors->get('surname')" class="mt-2" />
            </div>
        </div>

        <div class="row">
            <!-- Riga 2: Username e Born Date -->
            <div class="col-md-6 mb-4">
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <div class="col-md-3 mb-4">
                <x-input-label for="role" :value="__('Role')" />

                <x-input-error :messages="$errors->get('born_date')" class="mt-2" />
            </div>

            <div class="col-md-3 mb-4">
                <x-input-label for="born_date" :value="__('Born Date')" />
                <x-text-input id="born_date" class="block mt-1 w-full" type="date" name="born_date" :value="old('born_date')" required />
                <x-input-error :messages="$errors->get('born_date')" class="mt-2" />
            </div>
        </div>

        <!-- Continua con lo stesso pattern per gli altri campi... -->
        <div class="row">
            <!-- Riga: Postcode, City, Country -->
            <div class="col-md-4 mb-4">
                <x-input-label for="address" :value="__('Address')" />
                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')"/>
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <div class="col-md-2 mb-4">
                <x-input-label for="postcode" :value="__('Postcode')" />
                <x-text-input id="postcode" class="block mt-1 w-full" type="number" name="postcode" :value="old('postcode')"/>
                <x-input-error :messages="$errors->get('postcode')" class="mt-2" />
            </div>

            <div class="col-md-3 mb-4">
                <x-input-label for="city" :value="__('City')" />
                <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')"/>
                <x-input-error :messages="$errors->get('city')" class="mt-2" />
            </div>

            <div class="col-md-3 mb-4">
                <x-input-label for="country" :value="__('Country')" />
                <x-text-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country')"/>
                <x-input-error :messages="$errors->get('country')" class="mt-2" />
            </div>
        </div>

        <div class="row">
            <!-- Riga: Phone e Email -->
            <div class="col-md-6 mb-4">
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <div class="col-md-6 mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <div class="row">
            <!-- Riga: Password e Conferma -->
            <div class="col-md-6 mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" :value="old('password')" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="col-md-6 mb-4">
                <x-input-label for="confirm" :value="__('Repeat Password')" />
                <x-text-input id="confirm" class="block mt-1 w-full" type="password" name="confirm" :value="old('confirm')" required />
                <x-input-error :messages="$errors->get('confirm')" class="mt-2" />
            </div>
        </div>

        <!-- Pulsante di invio -->
        <div class="flex items-center justify-end mt-6">
            <x-primary-button>
                {{ __('Add user') }}
            </x-primary-button>
        </div>
    </form>
</div>
