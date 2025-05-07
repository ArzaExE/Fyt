@include('templates.header')
<div class="container mt-5">
    <b><h1 style="font-size: 25px">Users</h1></b>
    <!-- Search Bar (User) -->
    <div class="mb-4">
        <form class="d-flex">
            <input class="form-control me-2 rounded-2 m-3" type="search" placeholder="Search User" aria-label="Search">
        </form>
    </div>
    <br>
    <br>
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
                <th scope="col" class="w-auto">Country</th>
                <th scope="col" class="w-auto">Phone</th>-->
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
                    <td>{{ $user->country }}</td>
                    <td>{{ $user->phone }}</td>-->

                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>
                        <a href="{{route('admin.edit', $user)}}" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                    </td>
                    <td>
                        @if($user->id != Auth::user()->id)
                            <form method="POST" action="{{ route('admin.destroy', $user) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('modals.delete')

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

