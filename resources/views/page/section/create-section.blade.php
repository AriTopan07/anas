@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Create Section and Menu</h3>
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
                                <th>No.</th>
                                <th>Nama Section</th>
                                <th>Urutan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name_section }}</td>
                                    <td>{{ $item->order }}</td>
                                    <td>
                                        <a href="/section/edit/{{ $item->id }}" type="button"
                                            class="btn btn-warning btn-sm">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    {{-- Modal Tambah Section --}}
    <div class="modal fade text-left modal-lg" id="modal_add" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Tambah Section</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="/section/store" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label>Nama Section</label>
                        <div class="form-group">
                            <input type="text" placeholder="Nama Section" class="form-control" id="name_section"
                                name="name_section" required>
                        </div>
                        <div id="form-icon"></div>
                        <div class="form-group">
                            <i id="selected-icon"></i>
                            <a href="#" onclick="modalIcon()" class="btn btn-secondary btn-sm">Pilih Icon</a>
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

        const modalAddSection = () => {
            $('#modal-section').modal('show')
        }
    </script>
@endpush
