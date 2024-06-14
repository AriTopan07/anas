@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>{{ NavHelper::name_menu(Session::get('menu_active'))->name_menu }}</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-body table-responsive">
                    <h5>Filter range</h5>
                    <div class="col-md-6 d-flex">
                        <div>
                            <small for="">Date start</small>
                            <input type="date" name="date_start" id="date_start" class="form-control">
                        </div>
                        <div class="ms-2">
                            <small for="">Date end</small>
                            <input type="date" name="date_end" id="date_end" class="form-control">
                        </div>
                    </div>
                    <!-- Default Table -->
                    <table class="table table-hover table-vcenter mt-4" id="">
                        <thead>
                            <tr>
                                <th width="100px">No.</th>
                                <th>Data Type</th>
                                <th width="400px">Exports Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Goods Receives</td>
                                <td>
                                    <button class="btn btn-success" onclick="export_excel('receives')">
                                        Download Excel
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Goods Pickings</td>
                                <td>
                                    <button class="btn btn-success" onclick="export_excel('pickings')">
                                        Download Excel
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Goods Quantity</td>
                                <td>
                                    <button class="btn btn-success" onclick="export_excel('goods')">
                                        Download Excel
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script>
        function export_excel(params) {
            let date_start = $('#date_start').val();
            let date_end = $('#date_end').val();

            if (date_start == null || date_start == "") {
                message("The start date has not been entered!", false);
                return;
            }
            if (date_end == null || date_end == "") {
                message("The end date has not been entered!", false);
                return;
            }

            let url;

            if (params === 'receives') {
                url = "{{ route('reports.excel', ['receives', ':date_start', ':date_end']) }}";
            } else if (params === 'pickings') {
                url = "{{ route('reports.excel', ['pickings', ':date_start', ':date_end']) }}";
            } else if (params === 'goods') {
                url = "{{ route('reports.excel', ['goods', ':date_start', ':date_end']) }}";
            }

            url = url.replace(':date_start', date_start);
            url = url.replace(':date_end', date_end);

            window.open(url);
            console.log(url);
        }
    </script>
@endpush
