@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>User Group</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#modal_add"><i class="bi bi-plus"></i> Tambah</button>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>
                                        <button value="{{ $item->id }}" type="button"
                                            class="btn btn-primary btn-sm groupEdit" data-bs-toggle="modal"
                                            data-bs-target="#modal_edit" title="Edit"><i
                                                class="bi bi-pencil"></i></button>
                                        <a href="{{ route('permission.data-akses', ['id' => $item->id]) }}"
                                            class="btn btn-warning btn-sm" title="Atur Akses"><i class="bi bi-gear"></i></a>
                                        @if (NavHelper::cekAkses(Auth::user()->id, 'Group', 'delete') == true)
                                            <button onclick="deletes({{ $item->id }})" type="button"
                                                class="btn btn-danger btn-sm"><i class="bi bi-trash3"
                                                    title="Hapus"></i></button>
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
                    <h4 class="modal-title" id="myModalLabel33">Tambah Group Baru</h4>
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
                            <label>Nama</label>
                            <div class="form-group">
                                <input type="text" placeholder="Nama" class="form-control" name="name" id="name">
                            </div>
                            <label>Deskripsi</label>
                            <div class="form-group">
                                <input type="text" placeholder="Deskripsi" class="form-control" name="description"
                                    id="description">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary btn-tutup" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tutup</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1 btn-simpan">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
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
                    <h4 class="modal-title" id="myModalLabel33">Tambah Group Baru</h4>
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
                <form action="" id="groupForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <label>Nama</label>
                            <div class="form-group">
                                <input type="text" placeholder="Nama" class="form-control" name="name"
                                    id="name" required value="{{ old('name') }}">
                            </div>
                            <label>Deskripsi</label>
                            <div class="form-group">
                                <input type="text" placeholder="Deskripsi" class="form-control" name="description"
                                    id="deskripsi" required value="{{ old('deskripsi') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary btn-tutup" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tutup</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1 btn-simpan">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function deleteGroup(id) {
            let url = 'group/' + id;
            let csrfToken = $('input[name="_token"]').val();

            Swal.fire({
                title: 'Yakin hapus data ini?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(data) {
                            if (data.status) {
                                message(data.message, data.success);
                                window.location.href = "{{ route('group.index') }}";
                            } else {
                                message('Gagal menghapus data Group: ' + data.message);
                            }
                        }
                    });
                }
            });
        }

        $(document).ready(function() {
            $('#groupForm').submit(function(event) {
                event.preventDefault();

                let csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('group.store') }}',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: async function(data) {
                        message(data.message, data.success);
                        $('#groupForm')[0].reset();
                        window.location.href = '{{ route('group.index') }}';
                    },
                    error: function(error) {
                        alert('Terjadi kesalahan saat menyimpan data Group.');
                    }
                });
            });

            // Edit Group
            $(document).on('click', '.groupEdit', function() {
                let id = $(this).val();
                $('#modal_edit').modal('show');

                $.ajax({
                    url: 'group/' + id,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            $('#id').val(response.data.id);
                            $('#name').val(response.data.name);
                            $('#description').val(response.data.description);
                        }
                    }
                });
            });

            $('#groupFormEdit').submit(function(event) {
                event.preventDefault();

                let token = $('input[name="_token"]').val();
                var id = $('#id').val();
                var formData = {
                    '_token': token,
                    'id': id,
                    'name': $('#name').val(),
                    'description': $('#description').val()
                };

                $.ajax({
                    type: 'PUT',
                    url: 'group/' + id,
                    data: formData,
                    dataType: 'json',
                    success: async function(data) {
                        if (data.success) {
                            message(data.message, data.success);
                            $('#modal_edit').modal('hide');

                            window.location.href = '{{ route('group.index') }}';
                        } else {
                            alert(data.message);
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat mengupdate data Group.');
                    }
                });

            });
        });
    </script>
@endpush
