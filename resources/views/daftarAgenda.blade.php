@extends('app')
@section('title', 'Agenda BAPPEDA')

@section('nav')
   @include('nav')
@endsection

@section('breadcrumb')
   <ol class="breadcrumb pull-right">
      <li><a href="http://sakatoplan.sumbarprov.go.id/bappeda/">Dashboard</a></li>
      <li><a href="{{ route('index') }}">Agenda</a></li>
      <li class="active">Daftar Agenda</li>
   </ol>
@endsection

@section('panel')
   <div class="row">
        {{-- begin col-12 --}}
        <div class="col-md-12 ui-sortable">
            <div class="panel panel-inverse">
                <div class="panel-heading" style="background-image: linear-gradient(to right, rgb(245,156,26) 50%, rgb(195,8,1));">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Agenda BAPPEDA</h4>
                </div>
                <div class="panel-body">
                    
                    <div class="col-md-12">
                        <a href="/add"><button type="button" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Agenda</button></a>
                        <div class="px-1 py-2 flex justify-center">
                            <div class="table-responsive">
                                <table id="dataAgenda" class="table table-hover table-bordered table-responsive">
                                    <thead class="thead-light">
                                        <tr class="border">
                                            <th class="text-center p-2 ">No.</th>
                                            <th class="text-center p-2 ">Perihal</th>
                                            <th class="text-center p-2 ">Peserta</th>
                                            <th class="text-center p-2 ">Tanggal</th>
                                            <th class="text-center p-2 ">Jam</th>
                                            <th class="text-center p-2 ">Ruangan</th>
                                            <th class="text-center p-2 " width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($agenda as $i => $agenda)
                                            <tr class="border-b hover:bg-gray-100 table-light">
                                                <td class="text-center p-2 ">{{ ++$i }}</td>
                                                <td class="p-2 ">{{ $agenda->perihal }}</td>
                                                <td class="p-2 "><?php echo $agenda->peserta ?></td>
                                                <?php
                                                $tm = Carbon\Carbon::parse($agenda->tgl_mulai);
                                                $ts = Carbon\Carbon::parse($agenda->tgl_selesai);
                                                $jm = Carbon\Carbon::parse($agenda->jam_mulai);
                                                $js = Carbon\Carbon::parse($agenda->jam_selesai);
                                                $tgl_m = $tm->isoFormat('D MMMM Y');
                                                $tgl_s = $ts->isoFormat('D MMMM Y');
                                                $jam_m = $jm->format('H:i');
                                                $jam_s = $js->format('H:i');

                                                if ($tgl_m == $tgl_s){
                                                    $tgl = $tgl_m;
                                                }else{
                                                    $tgl_mulai = $tm->isoFormat('D');
                                                    $tgl_selesai  = $ts->isoFormat('D');
                                                    $bln_mulai = $tm->isoFormat('MMMM');
                                                    $thn_mulai  = $tm->isoFormat('Y');
                                                    $bln_selesai = $ts->isoFormat('MMMM');
                                                    $thn_selesai  = $ts->isoFormat('Y');

                                                    if($bln_mulai == $bln_selesai && $thn_mulai == $thn_selesai){
                                                        $tgl = $tgl_mulai.' - '.$tgl_selesai.' '.$bln_mulai.' '.$thn_mulai; 
                                                    }else if ($bln_mulai != $bln_selesai && $thn_mulai == $thn_selesai){
                                                        $tgl = $tgl_mulai.' '.$bln_mulai.' - '.$tgl_selesai.' '.$bln_selesai.' '.$thn_mulai;
                                                    }else {
                                                        $tgl = $tgl_m.' - '.$tgl_s;
                                                    }
                                                }
                                                ?>
                                                <td class="text-center p-2 ">{{ $tgl }}</td>
                                                <?php 
                                                    if($agenda->jam_selesai == null){
                                                        $k = 'selesai';
                                                    }
                                                    else{
                                                        $k = $jam_s;
                                                    }
                                                ?>
                                                <td class="text-center p-2 ">{{ $jam_m }} - {{ $k }}</td>
                                                <td class="p-2 ">{{ $agenda->nama_lokasi }}</td>
                                                <td class="text-center p-2">
                                                    <a href="/detail/{{ $agenda->id }}"><button type="button" class="btn btn-sm btn-primary"><i class="fa-regular fa-eye"></i></button></a>
                                                    <a href="/edit/{{ $agenda->id }}"><button type="button" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen"></i></button></a>
                                                    <a href="/delete/{{ $agenda->id }}"><button type="button" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus agenda ini?');"><i class="fa-solid fa-trash"></i></button></a>
                                                </td>
                                            </tr>
                                        @empty
                                        <tr class="border-b hover:bg-gray-100">
                                            <td colspan="7"><center><p class="text-sm text-gray-500">Tidak Ada Data Agenda</p></center></td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>
@endsection

@section('js')
    <!-- data tables  -->
    <script>
        $(document).ready(function() {
            $('#dataAgenda').DataTable();
        } );
    </script>
    <!-- sweetalert tambah agenda-->
    <script src="js/sweetalert/sweetalert2.all.min.js"></script>
        @if(Session::has('success'))
        <script>
            Swal.fire({
            icon: 'success',
            title: 'Agenda Berhasil Ditambahkan',
            showConfirmButton: false,
            timer: 1500
            })
        </script>
        @elseif(Session::has('error'))
        <script>
            Swal.fire({
            icon: 'error',
            title: 'Agenda Gagal Ditambahkan',
            showConfirmButton: false,
            timer: 1500
            })
        </script>
        @endif
        @if(Session::has('dsuccess'))
        <script>
            Swal.fire({
            icon: 'success',
            title: 'Agenda Berhasil Dihapus',
            showConfirmButton: false,
            timer: 1500
            })
        </script>
        <!-- sweetalert hapus agenda -->
        @elseif(Session::has('derror'))
        <script>
            Swal.fire({
            icon: 'error',
            title: 'Agenda Gagal Dihapus',
            showConfirmButton: false,
            timer: 1500
            })
        </script>
        @endif
        @if(Session::has('esuccess'))
        <script>
            Swal.fire({
            icon: 'success',
            title: 'Agenda Berhasil Diedit',
            showConfirmButton: false,
            timer: 1500
            })
        </script>
        <!-- sweetalert hapus agenda -->
        @elseif(Session::has('eerror'))
        <script>
            Swal.fire({
            icon: 'error',
            title: 'Agenda Gagal Diedit',
            showConfirmButton: false,
            timer: 1500
            })
        </script>
        @endif
@endsection