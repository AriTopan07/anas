    @extends('layouts.master')

    @section('content')
        <div class="page-heading">
            <h3>Edit Section and Menu</h3>
        </div>
        <div class="page-content">
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <a href="/create-section">Back</a>
                        <h4>Section {{ $data->name_section }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="/section/update/{{ $data->id }}" method="post">
                            @csrf
                            <label>Nama Section</label>
                            <div class="form-group">
                                <input type="text" placeholder="Nama Section" class="form-control" name="name_section"
                                    required value="{{ $data->name_section }}">
                            </div>
                            <div id="form-icon"></div>
                            <div class="form-group">
                                <i id="selected-icon" class="bi bi-{{ $data->icons }}"></i>
                                <a href="#" onclick="modalIcon()" class="btn btn-secondary btn-sm ms-2">Pilih Icon</a>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="status" value="active" role="switch"
                                    id="status" {{ $data->status === 'active' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">Status</label>
                            </div>
                            <button type="submit" class="btn btn-primary mb-4">Simpan</button>
                        </form>

                        <button class="btn btn-primary btn-sm mb-4" onclick="addModal()">Tambah Menu</button>
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Section</th>
                                    <th>Urutan</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menu as $key => $m)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $m->name_menu }}</td>
                                        <td>{{ $m->order }}</td>
                                        <td>{{ $m->status }}</td>
                                        <td>
                                            {!! NavHelper::action('tabel', $m->id) !!}
                                            {{-- <button class="btn btn-warning btn-sm" onclick="detail({{ $m->id }})">Edit</button> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>

        {{-- Modal Icon --}}
        <div class="modal fade text-left modal-lg" id="modal-icon" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Pilih Icon</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        @foreach ($icons as $icon)
                            <a href="#" onclick="modalIcon('{{ substr($icon->getFilename(), 0, -4) }}')">
                                <i class="bi bi-{{ substr($icon->getFilename(), 0, -4) }}"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Edit --}}
        <div class="modal fade text-left modal-lg" id="modal-edit" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Edit Menu</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form id="formEditMenu" method="post">
                        <div class="modal-body">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label>Nama Menu</label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Nama Menu" class="form-control" id="name_menu"
                                            name="name_menu" required>
                                    </div>
                                    <label>Url</label>
                                    <div class="form-group">
                                        <input type="text" placeholder="URL" class="form-control" id="url"
                                            name="url" required>
                                    </div>
                                    <label for="">Section</label>
                                    <div class="form-group">
                                        <select class="form-select" name="section_id" id="section_id">
                                            @foreach ($section as $item)
                                                <option {{ $item->id === $data->id ? 'selected' : '' }}
                                                    value="{{ $item->id }}">{{ $item->name_section }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="">Parent</label>
                                    <div class="form-group">
                                        <select class="form-select" name="parent_id" id="parent_id">
                                            <option value="0">Tidak Memiliki Parent</option>
                                            @foreach ($listMenu as $item)
                                                <option value="{{ $item->id }}">{{ $item->name_menu }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="status" value="active"
                                            role="switch" id="status-act">
                                        <label class="form-check-label" for="status">Status</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Tutup</span>
                            </button>
                            <button type="submit" class="btn btn-primary ml-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Add --}}
        <div class="modal fade text-left modal-lg" id="modal-add" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Tambah Menu</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form action="/menu/store" method="post">
                        <div class="modal-body">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label>Nama Menu</label>
                                    <div class="form-group">
                                        <input type="text" placeholder="Nama Menu" class="form-control"
                                            id="name_menu" name="name_menu" required>
                                    </div>
                                    <label>Url</label>
                                    <div class="form-group">
                                        <input type="text" placeholder="URL" class="form-control" id="url"
                                            name="url" required>
                                    </div>
                                    <input type="hidden" name="section_id" value="{{ $data->id }}">
                                    <label for="">Parent</label>
                                    <div class="form-group">
                                        <select class="form-select" name="parent_id" id="parent_id">
                                            <option value="0">Tidak Memiliki Parent</option>
                                            @foreach ($listMenu as $item)
                                                <option value="{{ $item->id }}">{{ $item->name_menu }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Tutup</span>
                            </button>
                            <button type="submit" class="btn btn-primary ml-1">
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
            const modalIcon = (icon) => {
                if (icon != undefined) {
                    $('#modal-icon').modal('toggle')
                    $('#selected-icon').attr('class', `bi bi-${icon}`)
                    $('#form-icon').html(`<input type="hidden" name="icons" value="${icon}">`)
                } else {
                    $('#modal-icon').modal('show')
                }
            }

            const detail = async (id) => {
                $('#modal-edit').modal('show')
                const response = await fetch(`/menu/api/${id}`)
                const data = await response.json()

                const token = $('input[name="_token"]').val()
                const name_menu = $('input[name="name_menu"]')
                const url = $('input[name="url"]')
                const parent_id = $('#parent_id')
                const status = $(`#status-act`)
                const formEditMenu = $('#formEditMenu')

                name_menu.val(data.payload.name_menu)
                url.val(data.payload.url)
                parent_id.val(data.payload.parent_id)
                if (data.payload.status === 'active') {
                    status.attr('checked', true)
                } else if (data.payload.status === 'inactive') {
                    status.attr('checked', false)
                }
                formEditMenu.attr('action', `/menu/update/${id}`)
            }

            const addModal = () => {
                $('#modal-add').modal('show')
            }
        </script>
    @endpush
