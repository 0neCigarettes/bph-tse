@extends('layouts.main')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">


        @include('toast.toast')
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="modal" data-bs-target="#modalCenter"><i
                                class="bx bx-message-square-add me-1"></i></a>
                    </li>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">Laporan anda</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr class="text-nowrap">
                                    <th>Tanggal</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Teknisi</th>
                                    <th>no hp teknisi</th>
                                    <th>Solusi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $x)
                                    <tr>
                                        <td>{{ date('h:i d M Y', strtotime($x->created_at)) }}</td>
                                        <td>{{ $x->report_title }}</td>
                                        <td>
                                            @if ($x->report_status == 0)
                                                <span class="badge bg-warning">Belum mendapat teknisi</span>
                                            @elseif($x->report_status == 1)
                                                <span class="badge bg-warning">Dalam proses</span>
                                            @elseif($x->report_status == 2)
                                                <span class="badge bg-success">Selesai</span>
                                            @endif
                                        </td>
                                        <td>{{ $x->tech->name ?? '-' }}</td>
                                        <td>{{ $x->tech->phone ?? '-' }}</td>
                                        <td>{{ $x->solving_description ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
                <div class="mt-3">
                    {{ $reports->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Create report Modal -->
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Buat Laporan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.add-report') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="report_title" class="form-label">Judul Laporan</label>
                                <input name="report_title" type="text" id="report_title" class="form-control"
                                    placeholder="Tuliskan laporan anda" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
