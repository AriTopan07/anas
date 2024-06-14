@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>User</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    {!! NavHelper::action('header') !!}
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Tgl. Dibuat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>********</td>
                                    <td>{{ date('Y-m-d', strtotime($item->created_at)) }}</td>
                                    <td>
                                        <span class="">{{ Str::ucfirst($item->status) }}</span>
                                    </td>
                                    <td>
                                        {!! NavHelper::action('table', $item->id) !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <div class="modal fade text-left" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33"> Edit User </h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                    <form action="{{ route('users.update', ['id' => $item->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id">
                        <div class="modal-body">
                            <div class="row">
                                <label>Nama</label>
                                <div class="form-group">
                                    <input readonly type="text" placeholder="Nama" class="form-control" name="name"
                                        id="name" required value="{{ old('name') }}">
                                </div>
                                <label>Username</label>
                                <div class="form-group">
                                    <input readonly type="text" placeholder="Username" class="form-control"
                                        name="username" id="username" required value="{{ old('username') }}">
                                </div>
                                <label>Password</label>
                                <div class="form-group">
                                    <input type="text" placeholder="password" class="form-control" name="password"
                                        id="password" required value="{{ old('password') }}">
                                </div>
                                <label>Confirm Password</label>
                                <div class="form-group">
                                    <input type="text" placeholder="password" class="form-control" name="repassword"
                                        id="repassword" required value="{{ old('repassword') }}">
                                </div>
                                <label>Status</label>
                                <div class="form-group">
                                    <select class="form-control" name="status" id="status" class="form-control choices"
                                        required value="{{ old('status') }}">
                                        <option value="active">active</option>
                                        <option value="nonactive">nonactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary ml-1 btn-simpan">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Tutup</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade text-left" id="modal_add" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Tambah Data </h4>
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
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <label>Nama</label>
                            <div class="form-group">
                                <input type="text" placeholder="Nama" class="form-control" name="name_create"
                                    id="name" required value="{{ old('name') }}">
                            </div>
                            <label>Username</label>
                            <div class="form-group">
                                <input type="text" placeholder="Username" class="form-control" name="username_create"
                                    id="username" required value="{{ old('username') }}">
                            </div>
                            <label>Password</label>
                            <div class="form-group">
                                <input type="text" placeholder="password" class="form-control" name="password_create"
                                    id="password" required value="{{ old('password') }}">
                            </div>
                            <label>Confirm Password</label>
                            <div class="form-group">
                                <input type="text" placeholder="password" class="form-control"
                                    name="repassword_create" id="repassword" required value="{{ old('repassword') }}">
                            </div>
                            <label>Status</label>
                            <div class="form-group">
                                <select class="form-control" name="status_create" id="status"
                                    class="form-control choices" required value="{{ old('status') }}">
                                    <option value="active">active</option>
                                    <option value="nonactive">nonactive</option>
                                </select>
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
        $(".btn-simpan").click(function(e) {

            e.preventDefault();

            var name = $("input[name=name_create]").val();
            var username = $("input[name=username_create]").val();
            var password = $("input[name=password_create]").val();
            var repassword = $("input[name=repassword_create]").val();
            var status = $('select[name=status_create] option').filter(':selected').val();
            let token = $('input[name="_token"]').val();

            if (password !== repassword) {
                message('Password tidak sama!', false);
                return;
            }

            let fd = new FormData();
            fd.append('_token', token);
            fd.append('name', name);
            fd.append('username', username);
            fd.append('password', password);
            fd.append('repassword', repassword);
            fd.append('status', status);

            $.ajax({
                type: 'POST',
                url: "{{ route('users.store') }}",
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: fd,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function() {
                    $('.btn-simpan').prop('disabled', true);
                    $('.btn-simpan').html('')
                    $('.btn-simpan').append(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...'
                    )
                },
                success: async function(data) {
                    message(data.message, data.success);
                    window.location.href = '{{ route('users.index') }}';
                },
                complete: function() {
                    $('.btn-simpan').prop('disabled', false);
                    $('.btn-simpan').html('')
                    $('.btn-simpan').append('Simpan');
                    $("input[name=sku]").val("");
                },
                error: function(params) {
                    let txt = params.responseJSON;
                    $.each(txt.errors, function(k, v) {
                        message(v, false);
                    });
                }
            });
        });

        function detail(id) {
            $('#modal_update').modal('show')

            $.ajax({
                type: 'get',
                data: {},
                url: "{{ url('users') }}/" + id,
                success: function(data) {
                    console.log(data);
                    $('#name').val(data.data.name);
                    $('#username').val(data.data.username);
                    $('#password').val(data.data.password);
                    $('#status').val(data.data.status);
                    $('#id').val(data.data.id);
                    let detail = data.data.detail
                    $.each(detail, function(i, item) {
                        console.log(item);
                    });
                },
                complete: function() {}
            })
        }

        $('body').on('click', '#button-save', function() {
            var users_id = $('#id').val();
            var name = $('#name').val();
            var username = $('#username').val();
            var password = $('#password').val();
            var repassword = $('#repassword').val();
            var status = $('select[name=status] option').filter(':selected').val();
            var token = "{{ csrf_token() }}"

            if (password !== repassword) {
                message('Password tidak sama!', false);
                return;
            }

            Swal.fire({
                title: 'Apakah Kamu Yakin',
                text: "mengubah data user?",
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, UBAH!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var fd = new FormData();
                    fd.append('_token', token);
                    fd.append('name', name);
                    fd.append('username', username);
                    fd.append('password', password);
                    fd.append('status', status);

                    $.ajax({
                        url: `/users/update/${users_id}`,
                        type: "POST",
                        cache: false,
                        processData: false,
                        contentType: false,
                        data: fd,
                        success: function(response) {
                            setTimeout(function() {
                                window.location = window.location;
                            }, 1220);
                            //show success message
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    });
                }
            })
        });

        //status
        $(document).ready(function() {
            var currentStatus = $('select[name=status]').val();

            $('select[name=status] option').each(function() {
                if ($(this).val() == currentStatus) {
                    $(this).prop('disabled', true);
                }
            });

            $('select[name=status]').on('change', function() {
                var currentStatus = $(this).val();

                $('select[name=status] option').each(function() {
                    if ($(this).val() == currentStatus) {
                        $(this).prop('disabled', true);
                    } else {
                        $(this).prop('disabled', false);
                    }
                });
            });

            $('select[name=status]').on('click', function() {
                var currentStatus = $(this).val();

                $('select[name=status] option').each(function() {
                    if ($(this).val() == currentStatus) {
                        $(this).prop('disabled', true);
                    } else {
                        $(this).prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endpush
