<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<x-navbar>Employee</x-navbar>

<body class="py-5">
    <div class="container-fluid">
        <div class="header mt-5">
            <div class="d-flex align-items-center">
                <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">Add Employee</button>
                <form action="{{ route('employee.search') }}" method="post" class="d-flex">
                    @csrf
                    <input type="number" name="age" class="form-control me-2" placeholder="Enter age">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
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
                    <th scope="col">Name</th>
                    <th scope="col">Location</th>
                    <th scope="col">Birth Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->location_code }}</td>
                        <td>{{ $employee->birth_date }}</td>
                        <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editModal" data-id="{{ $employee->id }}"
                                data-name="{{ $employee->name }}" data-location-code="{{ $employee->location_code }}"
                                data-birth-date="{{ $employee->birth_date }}">
                                Edit
                            </button>

                            <form action="{{ route('employee.destroy', $employee->id) }}" method="post"
                                id="delete-form-{{ $employee->id }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-delete"
                                    data-form-id="delete-form-{{ $employee->id }}">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Employee</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('employee.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nameLabel" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="locationCodeLabel" class="form-label">Location</label>
                            <select class="form-select" aria-label="Location" name="location_code">
                                @foreach ($locations as $location)
                                    <option value="{{ $location->code }}">{{ $location->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="birth_date" class="form-label">Birth Date</label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date">
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

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Employee</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editName" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="editLocationCode" class="form-label">Location</label>
                            <select class="form-select" id="editLocationCode" name="location_code">
                                @foreach ($locations as $location)
                                    <option value="{{ $location->code }}">{{ $location->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editBirthDate" class="form-label">Birth Date</label>
                            <input type="date" class="form-control" id="editBirthDate" name="birth_date">
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
                const name = button.getAttribute('data-name');
                const locationCode = button.getAttribute('data-location-code');
                const birthDate = button.getAttribute('data-birth-date');

                const form = editModal.querySelector('form');
                form.action = `/employee/${id}`;

                editModal.querySelector('#editName').value = name;
                editModal.querySelector('#editLocationCode').value = locationCode;
                editModal.querySelector('#editBirthDate').value = birthDate;
            });

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
