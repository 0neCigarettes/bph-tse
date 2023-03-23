@extends('layouts.main')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('toast.toast')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">Data Pengguna</h5>
                    <div class="flex-column flex-md-row mb-3">
                        <form>
                            <div class="row mt-3">
                                <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                                    <select name="role" id="role" class="form-select">
                                        <option value="all" selected>Semua</option>
                                        @foreach ($roles as $r)
                                            <option value="{{ $r['id'] }}"
                                                {{ isset($query['role']) ? ((string) $query['role'] === (string) $r['id'] ? 'selected' : '') : '' }}>
                                                {{ $r['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                                    <input type="text" class="form-control" name="name"
                                        value="{{ $query['name'] ?? '' }}" placeholder="cari nama pegawai..">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
                                    <button class="btn btn-outline-primary rounded" type="submit">
                                        <i class='bx bx-search-alt-2'></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr class="text-nowrap">
                                    <th>nama</th>
                                    <th>email</th>
                                    <th>nomor hp</th>
                                    <th>role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $x)
                                    <tr>
                                        <td>{{ $x->name ?? '-' }}</td>
                                        <td>{{ $x->email ?? '-' }}</td>
                                        <td>{{ $x->phone ?? '-' }}</td>
                                        <td>
                                            @if ($x->role == 1)
                                                <span class="badge bg-warning">Pelapor</span>
                                            @elseif($x->role == 2)
                                                <span class="badge bg-success">Teknisi</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-danger"
                                                onclick="return confirmDelete()">Hapus</a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
                <div class="mt-3">
                    {{ $users->appends($query)->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function confirmDelete(msg = 'Apakah Anda Yakin Menghapus Data ?') {
            var pilihan = confirm(msg);
            if (pilihan) {
                return true
            } else {
                alert("Proses Di Batalkan")
                return false
            }
        }
    </script>
@endsection
