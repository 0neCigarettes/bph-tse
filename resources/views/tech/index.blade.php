@extends('layouts.main')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">


        @include('toast.toast')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">Penugasan anda</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr class="text-nowrap">
                                    <th>Tanggal</th>
                                    <th>Pelapor</th>
                                    <th>nomor hp pelapor</th>
                                    <th>Judul</th>
                                    <th>Status</th>
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
                                        <td>{{ $x->solving_description ?? '-' }}</td>
                                        <td>
                                            @if ($x->report_status == 1)
                                                <a href="javascript:void(0);" class="btn btn-sm btn-warning"
                                                    onclick="finishReport({{ $x->id }})" data-bs-toggle="modal"
                                                    data-bs-target="#modalCenter">Selesaikan
                                                    tugas</a>
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

    <!-- Create report Modal -->
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Selesaikan tugas</h5>
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="solving_desc" class="form-label">Solusi</label>
                                <textarea name="solving_description" class="form-control" id="solving_desc" rows="3"
                                    placeholder="Harap deskripsikan solusi" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-primary">Selesaikan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function finishReport(id) {
            let form = $('#updateForm');
            form.attr('action', "{{ route('tech.solve', ':id') }}".replace(':id', id));
        }
    </script>
