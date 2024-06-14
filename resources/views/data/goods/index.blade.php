@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>{{ NavHelper::name_menu(Session::get('menu_active'))->name_menu }}</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                {{-- <div class="card-header">
                    @if (NavHelper::cekAkses(Auth::user()->id, 'Categories', 'add') == true)
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                            data-bs-target="#modal_add">Create</button>
                    @endif
                </div> --}}
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="home-tab" data-bs-toggle="tab" href="#list" role="tab"
                                aria-controls="home" aria-selected="true">Request Data <span
                                    class="badge rounded-pill text-danger bg-light-danger">{{ $data['count'] }}</span></a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#request" role="tab"
                                aria-controls="profile" aria-selected="false">List Data</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="home-tab">
                            @if (NavHelper::cekAkses(Auth::user()->id, 'Goods', 'add') == true)
                                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                                    data-bs-target="#modal_add">Create</button>
                            @endif
                            {{-- @if (NavHelper::cekAkses(Auth::user()->id, 'Goods', 'verif') == true)
                                <button type="button" class="btn btn-success me-2 float-end">Accept All</button>
                            @endif --}}
                            <h5 class="mb-5 mt-3">Displays a list of item requests</h5>
                            <div class="table-responsive">
                                <table class="table table-striped" id="datatables1">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Category</th>
                                            <th>Goods Name</th>
                                            <th>Brand</th>
                                            <th>Created By</th>
                                            <th>Verified</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['new'] as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->categories_name }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->brand }}</td>
                                                <td>{{ $item->user_name }}</td>
                                                <td>
                                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Goods', 'verif') == true)
                                                        <button onclick="return accept({{ $item->id }})" type="button"
                                                            class="btn btn-success btn-sm">Accept</button>
                                                    @endif
                                                    {{-- @if (NavHelper::cekAkses(Auth::user()->id, 'Goods', 'verif') == true)
                                                        <button onclick="return reject({{ $item->id }})" type="button"
                                                            class="btn btn-danger btn-sm">Reject</button>
                                                    @endif --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="request" role="tabpanel" aria-labelledby="profile-tab">
                            <button class="btn btn-secondary float-end" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Filter
                            </button>
                            <h5 class="mb-5 mt-3">Displays a list of items in stock</h5>
                            <div class="collapse" id="collapseExample">
                                <div class="card">
                                    <form action="{{ route('goods.index') }}">
                                        <div class="row mb-4">
                                            <div class="col-md-8"></div>
                                            <div class="col-md-4 d-flex justify-content-end align-items-center">
                                                <select class="form-control" name="category_id" id="category_id">
                                                    <option value="">By Category</option>
                                                    @foreach ($data['category'] as $item)
                                                        <option value="{{ $item->id }}">{{ $item->categories_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-primary ms-2">Apply</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Category</th>
                                            <th>Units</th>
                                            <th>Supplier</th>
                                            <th>Goods Name</th>
                                            <th>Brand</th>
                                            <th>Stock</th>
                                            <th>Description</th>
                                            <th>Created By</th>
                                            <th>Updated By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['verified'] as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->categories_name }}</td>
                                                <td>{{ $item->units_name }}</td>
                                                <td>{{ $item->suppliers_name }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->brand }}</td>
                                                <td>
                                                    @if ($item->stock <= 0)
                                                        <div class="badge bg-danger">
                                                            Stock is empty
                                                        </div>
                                                    @else
                                                        {{ $item->stock }}
                                                    @endif
                                                </td>
                                                <td>{{ $item->description }}</td>
                                                <td>{{ $item->created_by_name }}</td>
                                                <td>{{ $item->updated_by_name }}</td>
                                                <td>
                                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Goods', 'edit') == true)
                                                        <button value="{{ $item->id }}" id="edit" type="button"
                                                            class="btn btn-primary btn-sm edit" data-bs-toggle="modal"
                                                            data-bs-target="#modal_edit" title="Edit"><i
                                                                class="bi bi-pencil"></i></button>
                                                    @endif
                                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Goods', 'delete') == true)
                                                        <button onclick="deletes({{ $item->id }})" type="button"
                                                            class="btn btn-danger btn-sm"><i class="bi bi-trash3"
                                                                title="Delete"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>

    <div class="modal modal-lg fade text-left" id="modal_edit" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Goods</h4>
                    <button type="button" class="close btn-tutup" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="" id="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Category</label>
                                <div class="form-group">
                                    <select class="form-control" name="edit_categories" id="edit_categories" required>
                                        <option value="">Select Category</option>
                                        @foreach ($data['category'] as $category)
                                            <option value="{{ $category->id }}">{{ $category->categories_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Units</label>
                                <select class="form-control" name="edit_units" id="edit_units" required>
                                    <option value="">Select Unit</option>
                                    @foreach ($data['units'] as $units)
                                        <option value="{{ $units->id }}">{{ $units->units_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Supplier</label>
                                <select class="form-control" name="edit_suppliers" id="edit_suppliers" required>
                                    <option value="">Select Supplier</option>
                                    @foreach ($data['supplier'] as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->suppliers_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Goods Name</label>
                                <input class="form-control" type="text" name="edit_name" id="edit_name" required>
                            </div>
                            <div class="col-md-6">
                                <label>Brand</label>
                                <input class="form-control" type="text" name="edit_brand" id="edit_brand" required>
                            </div>
                            <div class="col-md-12">
                                <label>Description</label>
                                <textarea class="form-control" name="edit_description" id="edit_description" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary btn-tutup" data-bs-dismiss="modal">
                            <span class="">Cancel</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1 btn-simpan">
                            <span class="">Update</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal modal-lg fade text-left" id="modal_add" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Create Goods</h4>
                    <button type="button" class="close btn-tutup" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('goods.create') }}" id="groupForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Category</label>
                                <div class="form-group">
                                    <select class="form-control" name="category_id" id="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach ($data['category'] as $category)
                                            <option value="{{ $category->id }}">{{ $category->categories_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Units</label>
                                <select class="form-control" name="units_id" id="units_id" required>
                                    <option value="">Select Unit</option>
                                    @foreach ($data['units'] as $units)
                                        <option value="{{ $units->id }}">{{ $units->units_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Supplier</label>
                                <select class="form-control" name="supplier_id" id="supplier_id" required>
                                    <option value="">Select Supplier</option>
                                    @foreach ($data['supplier'] as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->suppliers_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Goods Name</label>
                                <input class="form-control" type="text" name="name" id="name" required>
                            </div>
                            <div class="col-md-6">
                                <label>Brand</label>
                                <input class="form-control" type="text" name="brand" id="brand" required>
                            </div>
                            <div class="col-md-12">
                                <label>Description</label>
                                <textarea class="form-control" name="description" id="description" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary btn-tutup" data-bs-dismiss="modal">
                            <span class="">Cancel</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1 btn-simpan">
                            <span class="">Submit</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {

            $(document).on('click', '#edit', function() {
                let id = $(this).val();
                $('#modal_edit').modal('show');

                $.ajax({
                    url: 'goods/' + id,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        if (response.status && response.data.length > 0) {
                            let data = response.data[0];
                            $('#id').val(data.id);
                            $('#edit_categories').val(data.category_id);
                            $('#edit_units').val(data.units_id);
                            $('#edit_suppliers').val(data.supplier_id);
                            $('#edit_name').val(data.name);
                            $('#edit_brand').val(data.brand);
                            $('#edit_description').val(data.description);
                        } else {
                            console.log("No data found or error occurred.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $('#modal_edit').submit(function(event) {
                event.preventDefault();

                let csrfToken = $('input[name="_token"]').val();
                let id = $('#id').val();
                let url = '{{ route('goods.update', 'ID') }}';
                let newUrl = url.replace('ID', id);
                let formData = {
                    '_token': csrfToken,
                    'edit_category': $('#edit_categories').val(),
                    'edit_units': $('#edit_units').val(),
                    'edit_suppliers': $('#edit_suppliers').val(),
                    'edit_name': $('#edit_name').val(),
                    'edit_brand': $('#edit_brand').val(),
                    'edit_description': $('#edit_description').val(),
                };

                $.ajax({
                    type: 'POST',
                    url: newUrl,
                    data: formData,
                    dataType: 'json',
                    success: function(results) {
                        if (results.status === true) {
                            location.reload();
                        } else {
                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });

        function deletes(id) {
            let url = '{{ route('goods.delete', 'ID') }}';
            let newUrl = url.replace('ID', id);

            Swal.fire({
                title: 'Confirm delete?',
                text: "You can't restore it once deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: newUrl,
                        type: 'delete',
                        data: {},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        },
                        success: function(results) {
                            if (results.status === true) {
                                setTimeout(function() {
                                    location.reload();
                                }, 50);
                            } else {
                                setTimeout(function() {
                                    location.reload();
                                }, 50);
                            }
                        }
                    });
                }
            });
        }

        function accept(id) {
            let url = '{{ route('goods.terima', ':id') }}';
            url = url.replace(':id', id);

            Swal.fire({
                title: 'Accept request data ?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Accept'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        },
                        success: function(results) {
                            if (results.status === true) {
                                location.reload();
                            } else {
                                location.reload();
                            }
                        },
                    });
                }
            });
        }
    </script>
@endpush
