@include('templates.accessHeader')
<div class="container mt-5">
    <!-- Contenitore flessibile per h1 e pulsante -->
    <div class="d-flex align-items-center justify-content-between">
        <!-- Titolo -->
        <h1 class="mb-0">Users</h1>

        <!-- Pulsante -->
        {{--        <a href="#" class="btn btn-outline-gray-custom px-5 btn-custom-height" data-bs-toggle="modal" data-bs-target="#addModal>--}}
        {{--            <i class="fa-solid fa-plus"></i> Add--}}
        {{--        </a>--}}
        <button type="button" class="btn btn-outline-gray-custom px-5 btn-custom-height" data-bs-toggle="modal" data-bs-target="#addModal">Add</button>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col" class="w-auto">Id</th>
                <th scope="col" class="w-auto">Name</th>
                <th scope="col" class="w-auto">Surname</th>
                <th scope="col" class="w-auto">Username</th>
                <th scope="col" style="width: 120px">Born Date</th>
                <!--<th scope="col" class="w-auto">Address</th>
                <th scope="col" class="w-auto">Postcode</th>
                <th scope="col" class="w-auto">City</th>
                <th scope="col" class="w-auto">Country</th>-->
                <th scope="col" class="w-auto">Phone</th>
                <th scope="col" class="w-auto">Mail</th>
                <th scope="col" class="w-auto">Role</th>
                <th scope="col" class="w-auto">Edit</th>
                <th scope="col" class="w-auto">Delete</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->surname }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->formatted_born_date }}</td>
                    <!--
                    <td>{{ $user->address }}</td>
                    <td>{{ $user->postcode }}</td>
                    <td>{{ $user->city }}</td>
                    <td>{{ $user->country }}</td>-->

                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-outline-danger">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade hidden" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800"/>
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add a product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('templates.addProduct')
            </div>
        </div>
    </div>
</div>

<!-- Stile personalizzato -->
<style>
    .btn-outline-gray-custom {
        color: #838584; /* Colore del testo grigio */
        border-color: #838584; /* Colore del bordo grigio */
        background-color: transparent; /* Sfondo trasparente */
        transition: all 0.3s ease; /* Transizione fluida */
    }

    .btn-outline-gray-custom:hover {
        color: #fff; /* Testo bianco al passaggio del mouse */
        background-color: #838584; /* Sfondo grigio al passaggio del mouse */
        border-color: #838584; /* Colore del bordo al passaggio del mouse */
    }

    .btn-custom-height {
        padding-top: 0.25rem; /* Riduce il padding superiore */
        padding-bottom: 0.25rem; /* Riduce il padding inferiore */
    }
</style>

