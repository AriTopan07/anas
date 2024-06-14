@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="row">
            @if ($group_id == 1)
                <!-- Jika user adalah admin -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex">
                                    <div class="stats-icon purple mb-2">
                                        <i class="bi-box-fill"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Transaksi barang masuk</h6>
                                    <a href="{{ route('goods-receives.index') }}">
                                        <h6 class="font-light mb-0">Kunjungi</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex">
                                    <div class="stats-icon red mb-2">
                                        <i class="bi-box-fill"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Transaksi barang keluar</h6>
                                    <a href="{{ route('goods-picking.index') }}">
                                        <h6 class="font-light mb-0">Kunjungi</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Jika user bukan admin -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex">
                                    <div class="stats-icon green mb-2">
                                        <i class="bi-box-fill"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Barang Masuk</h6>
                                    <a href="{{ route('goods-receives.index') }}" class="btn btn-primary">
                                        <h6 class="text-light mb-0">Tambah barang masuk</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex">
                                    <div class="stats-icon green mb-2">
                                        <i class="bi-box-fill"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Barang Keluar</h6>
                                    <a href="{{ route('goods-picking.index') }}" class="btn btn-primary">
                                        <h6 class="text-light mb-0">Tambah barang keluar</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </div>
@endsection
