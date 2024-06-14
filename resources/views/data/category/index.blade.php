@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>{{ NavHelper::name_menu(Session::get('menu_active'))->name_menu }}</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5>List {{ NavHelper::name_menu(Session::get('menu_active'))->name_menu }}</h5>
                    @if (NavHelper::cekAkses(Auth::user()->id, 'Categories', 'add') == true)
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                            data-bs-target="#modal_add">Create</button>
                    @endif
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->categories_name }}</td>
                                    <td>
                                        @if (NavHelper::cekAkses(Auth::user()->id, 'Categories', 'edit') == true)
                                            <button value="{{ $item->id }}" id="edit" type="button"
                                                class="btn btn-primary btn-sm edit" data-bs-toggle="modal"
                                                data-bs-target="#modal_edit" title="Edit"><i
                                                    class="bi bi-pencil"></i></button>
                                        @endif
                                        @if (NavHelper::cekAkses(Auth::user()->id, 'Categories', 'delete') == true)
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
        </section>
    </div>

    <div class="modal fade text-left" id="modal_edit" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Category</h4>
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
                            <label>Category Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="edit_nama" id="edit_nama">
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

    <div class="modal fade text-left" id="modal_add" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Create Category</h4>
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
                <form action="{{ route('categories.create') }}" id="groupForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <label>Category Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="categories_name" id="categories_name"
                                    required value="{{ old('categories_name') }}">
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
        function deletes(id) {
            let url = '{{ route('categories.delete', 'ID') }}';
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

        $(document).ready(function() {

            $(document).on('click', '#edit', function() {
                let id = $(this).val();
                $('#modal_edit').modal('show');

                console.log(id);

                $.ajax({
                    url: 'categories/' + id,
                    type: 'GET',
                    success: function(response) {
                        if (response.status) {
                            $('#id').val(response.data.id);
                            $('#edit_nama').val(response.data.categories_name);
                        }
                    }
                });
            });

            $('#modal_edit').submit(function(event) {
                event.preventDefault();

                let token = $('input[name="_token"]').val();
                let id = $('#id').val();
                let formData = {
                    '_token': token,
                    'id': id,
                    'edit_nama': $('#edit_nama').val(),
                };

                $.ajax({
                    type: 'PUT',
                    url: 'categories/' + id,
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === true) {
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
            });
        });
    </script>
@endpush
