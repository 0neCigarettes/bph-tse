@extends('layouts.main')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">


        @include('toast.toast')
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="btn btn-outline-primary rounded" data-bs-toggle="modal" data-bs-target="#modalImport">
                            <i class='bx bx-import me-1'></i>Import Excel</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.downloadTemplate') }}" class="btn btn-outline-success rounded">
                            <i class='bx bxs-down-arrow-circle me-1'></i>Download Template Excel</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">Data Laporan</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr class="text-nowrap">
                                    <th>Tanggal</th>
                                    <th>Pelapor</th>
                                    <th>nomor hp pelapor</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Teknisi</th>
                                    <th>nomor hp teknisi</th>
                                    <th>Solusi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $x)
                                    <tr>
                                        <td>{{ date('h:i d M Y', strtotime($x->created_at)) }}</td>
                                        <td>{{ $x->user->name ?? '-' }}</td>
                                        <td><span class="badge bg-primary">{{ $x->user->phone ?? '-' }}</span></td>
                                        <td>{{ $x->report_title }}</td>
                                        <td>
                                            @if ($x->report_status == 0)
                                                <span class="badge bg-danger">Belum mendapat teknisi</span>
                                            @elseif($x->report_status == 1)
                                                <span class="badge bg-warning">Dalam proses</span>
                                            @elseif($x->report_status == 2)
                                                <span class="badge bg-success">Selesai</span>
                                            @endif
                                        </td>
                                        <td>{{ $x->tech->name ?? '-' }}</td>
                                        <td><span class="badge bg-primary">{{ $x->tech->phone ?? '-' }}</span></td>
                                        <td>{{ $x->solving_description ?? '-' }}</td>
                                        <td>
                                            @if ($x->report_status == 0)
                                                <a href="javascript:void(0);" class="btn btn-sm btn-danger"
                                                    onclick="assignTech({{ $x->id }})" data-bs-toggle="modal"
                                                    data-bs-target="#modalCenter">Assign
                                                    Teknisi</a>
                                            @else
                                                <a href="javascript:void(0);" class="btn btn-sm btn-success"><i
                                                        class='bx bx-check'></i></a>
                                            @endif
                                        </td>
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

    <!-- Modal -->
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Assign Teknisi</h5>
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="tech_id" class="form-label">Judul Laporan</label>
                                <select name="tech_id" id="tech_id" class="form-select" required>
                                    <option value="">Pilih Teknisi</option>
                                    @foreach ($techs as $x)
                                        <option value="{{ $x->id }}">{{ $x->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if (count($techs) == 0)
                            <span class="badge bg-danger">Tidak ada teknisi idle</span>
                        @endif
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalImport" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Import file excel</h5>
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.importExcel') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="file" class="form-label">Pilih file</label>
                                <input type="file" name="file" id="file" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function assignTech(id) {
            let form = $('#updateForm');
            form.attr('action', "{{ route('admin.assignTech', ':id') }}".replace(':id', id));
        }
    </script>
@endsection
