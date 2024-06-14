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
                            @if (NavHelper::cekAkses(Auth::user()->id, 'Goods Receives', 'add') == true)
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
                                            <th>Goods Name</th>
                                            <th>Date</th>
                                            <th>Qty</th>
                                            <th>Image</th>
                                            <th>Description</th>
                                            <th>Created By</th>
                                            <th>Verified</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['new'] as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->date }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td><img src="{{ asset('storage/' . $item->image) }}" alt="Image"
                                                        height="90px"></td>
                                                <td>{{ $item->description }}</td>
                                                <td>{{ $item->user_name }}</td>
                                                <td>
                                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Goods Receives', 'verif') == true)
                                                        <button onclick="return accept({{ $item->id }})" type="button"
                                                            class="btn btn-success btn-sm">Accept</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="request" role="tabpanel" aria-labelledby="profile-tab">
                            <h5 class="mb-5 mt-3">Displays a list accepted </h5>
                            <div class="table-responsive">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Goods Name</th>
                                            <th>Date</th>
                                            <th>Qty In</th>
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
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->date }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>{{ $item->created_by_name }}</td>
                                                <td>{{ $item->updated_by_name }}</td>
                                                <td>
                                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Goods Receives', 'edit') == true)
                                                        <button value="{{ $item->id }}" id="edit" type="button"
                                                            class="btn btn-primary btn-sm edit" data-bs-toggle="modal"
                                                            data-bs-target="#modal_edit" title="Edit"><i
                                                                class="bi bi-pencil"></i></button>
                                                    @endif
                                                    @if (NavHelper::cekAkses(Auth::user()->id, 'Goods Receives', 'delete') == true)
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

    <div class="modal fade text-left" id="modal_edit" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Goods Receives</h4>
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
                <form action="" id="groupFormEdit" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="row">
                            <label>Goods Name</label>
                            <div class="form-group">
                                <select class="form-control" name="edit_goods" id="edit_goods">
                                    <option value="">Select Goods</option>
                                    @foreach ($data['goods'] as $goods)
                                        <option value="{{ $goods->id }}">{{ $goods->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label>Date</label>
                            <div class="form-group">
                                <input class="form-control" type="date" name="edit_date" id="edit_date">
                            </div>
                            <label>Quantity</label>
                            <div class="form-group">
                                <input class="form-control" type="number" name="edit_qty" id="edit_qty">
                            </div>
                            <label>Description</label>
                            <div class="form-group">
                                <textarea class="form-control" type="text" name="edit_description" id="edit_description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary btn-tutup" data-bs-dismiss="modal">
                            <span class="">Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1 btn-simpan">
                            <span class="">Update</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="modal_add" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Create Goods Receives</h4>
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
                <form action="{{ route('goods-receives.create') }}" id="groupForm" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <label>Goods Name</label>
                            <div class="form-group">
                                <select class="form-control" name="goods_id" id="goods_id">
                                    <option value="">Select Goods</option>
                                    @foreach ($data['goods'] as $goods)
                                        <option value="{{ $goods->id }}">{{ $goods->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label>Date</label>
                            <div class="form-group">
                                <input class="form-control" type="date" name="date" id="date" required>
                            </div>
                            <label>Quantity</label>
                            <div class="form-group">
                                <input class="form-control" type="number" name="qty" id="qty" required>
                            </div>
                            <label>Image</label>
                            <div class="form-group">
                                <input class="form-control" type="file" name="image" id="image"
                                    accept="image/*" capture="camera" required>
                            </div>
                            <label>Description</label>
                            <div class="form-group">
                                <textarea class="form-control" type="text" name="description" id="description" required></textarea>
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
                    url: 'goods-receives/' + id,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        if (response.status && response.data.length > 0) {
                            let data = response.data[0];
                            $('#id').val(data.id);
                            $('#edit_goods').val(data.goods_id);
                            $('#edit_date').val(data.date);
                            $('#edit_qty').val(data.qty);
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
                let url = '{{ route('goods-receives.update', 'ID') }}';
                let newUrl = url.replace('ID', id);
                let formData = {
                    '_token': csrfToken,
                    'edit_goods': $('#edit_goods').val(),
                    'edit_date': $('#edit_date').val(),
                    'edit_qty': $('#edit_qty').val(),
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

        function accept(id) {
            let url = '{{ route('goods-receives.accept', ':id') }}';
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

        function deletes(id) {
            let url = '{{ route('goods-receives.delete', 'ID') }}';
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
    </script>
@endpush
