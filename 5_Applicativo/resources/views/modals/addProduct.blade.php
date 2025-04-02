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
