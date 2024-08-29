<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Location Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</head>

<x-navbar>Location</x-navbar>

<body class="py-5">
    <div class="container-fluid">
        <div class="header mt-5">
            <div class="d-flex align-items-center">
                <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModalLocation">Add
                    Location</button>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-info mt-3" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($locations as $location)
                    <tr>
                        <td>{{ $location['code'] }}</td>
                        <td>{{ $location['name'] }}</td>
                        <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editModal" data-id="{{ $location->id }}"
                                data-name="{{ $location->name }}" data-code="{{ $location->code }}">
                                Edit
                            </button>

                            <form action="{{ route('location.destroy', $location->id) }}" method="post"
                                id="delete-form-{{ $location->id }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-delete"
                                    data-form-id="delete-form-{{ $location->id }}">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="addModalLocation" tabindex="-1" aria-labelledby="addModalLocation" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Location</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('location.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="codeLabel" class="form-label">Code</label>
                            <input type="text" class="form-control" id="code" name="code">
                        </div>
                        <div class="mb-3">
                            <label for="nameLabel" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Location</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="{{ route('location.update', $location->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editCode" class="form-label">Code</label>
                            <input type="text" class="form-control" id="editCode" name="code">
                        </div>
                        <div class="mb-3">
                            <label for="editName" class="form-label">Birth Date</label>
                            <input type="text" class="form-control" id="editName" name="name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const code = button.getAttribute('data-code');
                const name = button.getAttribute('data-name');

                const form = editModal.querySelector('form');
                form.action = `/location/${id}`;

                editModal.querySelector('#editCode').value = code;
                editModal.querySelector('#editName').value = name;
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Are you sure you want to delete this item?')) {
                        document.getElementById(button.dataset.formId).submit();
                    }
                });
            });
        });
    </script>
</body>

</html>
