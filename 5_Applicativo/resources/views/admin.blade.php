@include('templates.header')

<div class="container mt-5">
    <b><h1 style="font-size: 25px">Users</h1></b>

    <!-- Search Bar -->
    <div class="mb-4">
        <form class="d-flex">
            <input class="form-control me-2 rounded-2 m-3" id="searchUser" type="search" placeholder="Search User" aria-label="Search">
        </form>
    </div>

    <br><br>

    @if(!$searchTerm || !$users->isEmpty())
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th scope="col" class="w-auto">Id</th>
                    <th scope="col" class="w-auto">Name</th>
                    <th scope="col" class="w-auto">Surname</th>
                    <th scope="col" class="w-auto">Username</th>
                    <th scope="col" style="width: 120px">Born Date</th>
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
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                            <a href="{{ route('admin.edit', $user) }}" class="btn btn-sm btn-outline-primary">
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
    @endif

    @if($searchTerm && $users->isEmpty())
        <div class="flex items-center justify-center min-h-[60vh]">
            <div class="text-center max-w-md mx-auto p-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M15 12a3 3 0 10-6 0 3 3 0 006 0zM4 20v-1a4 4 0 014-4h8a4 4 0 014 4v1M17.5 8.5l3 3m0-3l-3 3" />
                </svg>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">No users found</h3>
                <p class="text-gray-500 mb-6">We couldn't find any results for "<span class="font-medium">{{ $searchTerm }}</span>"</p>
                <div class="space-y-3">
                    <a href="{{ route('admin') }}" class="inline-block px-6 py-2 bg-purple-600 hover:bg-purple-700 text-gray-700 rounded-lg transition-colors">
                        Browse all users
                    </a>
                    <p class="text-sm text-gray-400">or try a different search term</p>
                </div>
            </div>
        </div>
    @endif
</div>

@include('modals.delete')

<!-- Custom styles -->
<style>
    .btn-outline-gray-custom {
        color: #838584;
        border-color: #838584;
        background-color: transparent;
        transition: all 0.3s ease;
    }

    .btn-outline-gray-custom:hover {
        color: #fff;
        background-color: #838584;
        border-color: #838584;
    }

    .btn-custom-height {
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
    }
</style>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var searchTimer;

        $('#searchUser').on('keyup', function() {
            clearTimeout(searchTimer);
            var keyword = $(this).val().trim();

            searchTimer = setTimeout(function() {
                redirectToCatalog(keyword);
            }, 800);
        });

        $('#searchUser').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                var keyword = $(this).val().trim();
                if (keyword.length > 0) {
                    redirectToCatalog(keyword);
                }
            }
        });

        function redirectToCatalog(keyword) {
            var url = '{{ route("admin") }}?searchUser=' + encodeURIComponent(keyword);
            window.location.href = url;
        }
    });
</script>
