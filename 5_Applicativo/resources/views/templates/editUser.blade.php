@include('templates.header')
<div class="container-lg p-5">
    <b><h1 style="font-size: 25px">Edit {{$user->name}} {{$user->surname}}</h1></b>
    <br>
    <br>
    <form method="POST" action="{{route('admin.save', $user)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Riga 1: Name e Surname -->
            <div class="col-md-6 mb-4">
                <x-input-label for="name" :value="__('Name*')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{$user->name}}" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="col-md-6 mb-4">
                <x-input-label for="surname" :value="__('Surname*')" />
                <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname" value="{{$user->surname}}" required />
                <x-input-error :messages="$errors->get('surname')" class="mt-2" />
            </div>
        </div>

        <div class="row">
            <!-- Riga 2: Username, Born Date e Ruolo-->
            <div class="col-md-6 mb-4">
                <x-input-label for="username" :value="__('Username*')" />
                <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" value="{{$user->username}}" required />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <div class="col-md-3 mb-4">
                <x-input-label for="role" :value="__('Role*')" />
                <select name="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 rounded-md shadow-sm" required>
                    <option value="{{$user->role->name}}" selected>{{$user->role->name}}</option>
                    @foreach($roles as $role)
                        <option value="{{$role}}">{{$role}}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="col-md-3 mb-4">
                <x-input-label for="born_date" :value="__('Born Date*')" />
                <x-text-input id="born_date" class="block mt-1 w-full" type="date" name="born_date" value="{{$user->formatted_born_date_for_form}}" required />
                <x-input-error :messages="$errors->get('born_date')" class="mt-2" />
            </div>
        </div>

        <!-- Continua con lo stesso pattern per gli altri campi... -->
        <div class="row">
            <!-- Riga: Postcode, City, Country -->
            <div class="col-md-4 mb-4">
                <x-input-label for="address" :value="__('Address')" />
                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" value="{{$user->address}}"/>
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <div class="col-md-2 mb-4">
                <x-input-label for="postcode" :value="__('Postcode')" />
                <x-text-input id="postcode" class="block mt-1 w-full" type="number" name="postcode" value="{{$user->postcode}}"/>
                <x-input-error :messages="$errors->get('postcode')" class="mt-2" />
            </div>

            <div class="col-md-3 mb-4">
                <x-input-label for="city" :value="__('City')" />
                <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" value="{{$user->city}}"/>
                <x-input-error :messages="$errors->get('city')" class="mt-2" />
            </div>

            <div class="col-md-3 mb-4">
                <x-input-label for="country" :value="__('Country')" />
                <x-text-input id="country" class="block mt-1 w-full" type="text" name="country" value="{{$user->country}}"/>
                <x-input-error :messages="$errors->get('country')" class="mt-2" />
            </div>
        </div>

        <div class="row">
            <!-- Riga: Phone e Email -->
            <div class="col-md-6 mb-4">
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" value="{{$user->phone}}" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <div class="col-md-6 mb-4">
                <x-input-label for="email" :value="__('Email*')" />
                <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" value="{{$user->email}}" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button>
                {{ __('Edit') }}
            </x-primary-button>
        </div>
    </form>
</div>
