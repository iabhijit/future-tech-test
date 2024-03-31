
@extends('layout')
@section('title', 'CRUD Application')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center mt-3">
        @if($errors->any() || session('success'))
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Add New Entry</div>

                <div class="card-body">


                    <form action="{{ route('post.crudapp') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header">Entries List</div>

                <div class="card-body overflow-auto" style="max-height: calc(100vh - 120px);">
                    <form action="{{ route('show') }}" method="GET">
                        <div class="mb-3">
                            <label for="sort_by" class="form-label">Sort by:</label>
                            <select class="form-select" name="sort_by" id="sort_by">
                                <option value="id" {{ $sortBy == 'id' ? 'selected' : '' }}>ID</option>
                                <option value="name" {{ $sortBy == 'name' ? 'selected' : '' }}>Name</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Sort</button>
                    </form>
                    <table class="table mt-3">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Address</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item_data)
                                <tr>
                                    <th scope="row">{{$item_data->id}}</th>
                                    <td>{{$item_data->name}}</td>
                                    <td><img src="{{asset('storage/'.$item_data->image)}}" width="100px" height="100px" /></td>
                                    <td>{{$item_data->address}}</td>
                                    <td>{{$item_data->gender}}</td>
                                    <td>
                                        <a class="btn btn-primary editDataBtn" data-id="{{ $item_data->id }}" data-name="{{ $item_data->name }}" data-image="{{ $item_data->image }}" data-address="{{ $item_data->address }}" data-gender="{{ $item_data->gender }}">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <form action="{{ route('crudapp.destroy', $item_data->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fa fa-trash-alt"></i> <!-- Font Awesome delete icon -->
                                            </button>
                                        </form>
                                        <a class="btn btn-success viewDataBtn" data-id="{{ $item_data->id }}" data-name="{{ $item_data->name }}" data-image="{{ $item_data->image }}" data-address="{{ $item_data->address }}" data-gender="{{ $item_data->gender }}">
                                            <i class="fa fa-eye"></i> <!-- Font Awesome view icon -->
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- View Data Modal -->
    <div class="modal fade" id="viewDataModal" tabindex="-1" aria-labelledby="viewDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDataModalLabel">View Data</h5>

                </div>
                <form>
                    @csrf
                <div class="modal-body">
                    <p><img id="viewImage" width="100%" /></p>

                    <p><strong>Name:</strong> <span id="viewName"></span></p>
                    <p><strong>Address:</strong> <span id="viewAddress"></span></p>
                    <p><strong>Gender:</strong> <span id="viewGender"></span></p>
                </div></form>
            </div>
        </div>
    </div>

    <!-- Edit Data Modal -->
    <div class="modal fade" id="editDataModal" tabindex="-1" role="dialog" aria-labelledby="editDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataModalLabel">Edit Data</h5>

                </div>
                <div class="modal-body">

                    <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="editName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editName" name="name">
                        </div>


                        <div class="mb-3">
                            <label for="editImage" class="form-label">Image</label>
                            <img id="editImage" src="" width="100%" />
                            <input type="file" class="form-control" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="editAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="editAddress" name="address">
                        </div>
                        <div class="mb-3">
                            <label for="editGender" class="form-label">Gender</label>
                            <select class="form-select" id="editGender" name="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
