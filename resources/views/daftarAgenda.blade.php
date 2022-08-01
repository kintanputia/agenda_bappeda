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
                        <button type="button" id="btn_cek_ruangan" class="btn btn-info" data-toggle="modal" data-target="#cek" >Cek Pemakaian Ruangan</button>
                        <!-- Start Modal -->
                        <div class="modal fade" id="cek" tabindex="-1" role="dialog" aria-labelledby="modalSayaLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="modalSayaLabel">Cek Pemakaian Ruangan</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <label for="ruangan" class="form-label">Ruangan</label>
                                <select class="form-control default-select2" id="ruangan" name="ruangan" data-size="5">
                                    <option value="" selected>---- Pilih Ruangan ----</option>
                                </select>
                                <label for="tgl" class="form-label">Tanggal</label>
                                <input id="tgl" type="date" name="tgl" class="form-control" required>
                                <div class="p-5">
                                    <button id="btn_cek_search" type="button" class="btn btn-primary">Cek</button>
                                </div>
                                <table class="table" id="hasil_cek">
                                <thead class="thead-dark">
                                    <tr>
                                    <th scope="col" class="text-center">Agenda</th>
                                    <th scope="col" class="text-center">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- hasil search -->
                                </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                            </div>
                        </div>
                        </div>
                        <!-- end modal -->
                        <div class="px-1 py-2 flex justify-center">
                            <div class="table-responsive p-5">
                                <table id="dataAgenda" class="table table-hover table-bordered table-responsive">
                                    <thead class="thead-light">
                                        <tr class="border">
                                            <th class="text-center p-2 ">No.</th>
                                            <th class="text-center p-2 ">Perihal</th>
                                            <th class="text-center p-2 " width="30%">Bidang Pelaksana</th>
                                            <th class="text-center p-2 ">Peserta</th>
                                            <th class="text-center p-2 ">Tanggal</th>
                                            <th class="text-center p-2 ">Jam</th>
                                            <th class="text-center p-2 ">Lokasi</th>
                                            <th class="text-center p-2 " width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($agenda as $i => $agenda)
                                            <tr class="border-b hover:bg-gray-100 table-light">
                                                <td class="text-center p-2 ">{{ ++$i }}</td>
                                                <td class="p-2 ">{{ $agenda->perihal }}</td>
                                                <td class="text-center p-2 ">{{ $agenda->bidang }}</td>
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
                                                @if (Session::get('username') == $agenda->nip )
                                                    <a href="/detail/{{ $agenda->id }}"><button type="button" class="btn btn-sm btn-primary"><i class="fa-regular fa-eye"></i></button></a>
                                                    <a href="/edit/{{ $agenda->id }}" ><button type="button" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen"></i></button></a>
                                                    <a href="/delete/{{ $agenda->id }}"><button type="button" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus agenda ini?');"><i class="fa-solid fa-trash"></i></button></a>
                                                @else
                                                    <a href="/detail/{{ $agenda->id }}"><button type="button" class="btn btn-sm btn-primary"><i class="fa-regular fa-eye"></i></button></a>
                                                    <button type="button" class="btn btn-sm btn-warning" disabled><i class="fa-solid fa-pen"></i></button>
                                                    <button type="button" class="btn btn-sm btn-danger"  disabled><i class="fa-solid fa-trash"></i></button>
                                                @endif
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

        <!-- ajax cek ruangan -->
        <script>
        $('#btn_cek_ruangan').on('click', function() {
            $.ajax({
                    type: "GET",
                    url: "/getRuangan",
                    success: function(response){
                        console.log(response);
                        $('#ruangan').empty();
                        $("#ruangan").append('<option value="">'+ "------- Pilih Ruangan -------" +'</option>');
                        for (var i=0;i<response.ruangan.length;i++){;
                            $('#ruangan').append('<option value="'+response.ruangan[i].id_lokasi+'">'+ response.ruangan[i].nama_lokasi +'</option>');
                        }
                    }
            });
        });
        $('#btn_cek_search').on('click', function() {
            var ruangan = $('#ruangan').val();
            var tgl = $('#tgl').val();
            console.log(ruangan, tgl);
            if (ruangan == ""){
                alert("Harap pilih ruangan");
            }
            else if (tgl == ""){
                alert("Harap pilih tanggal");
            }
            else if (ruangan != "" && tgl != ""){
                $.ajax({
                    type: "POST",
                    url: "/getKetersediaan",
                    data: {
                    _token: "{{ csrf_token() }}",
                    ruangan : ruangan,
                    tgl : tgl
                    },
                    success: function(response){
                        console.log(response);
                        $('#hasil_cek tbody').empty();
                       for (var i=0;i<response.ketersediaan.length;i++){
                            // merubah format jam
                            var jam_m = response.ketersediaan[i].jam_mulai;
                            var jam_s = response.ketersediaan[i].jam_selesai;
                            var ex_m = new Date("1970-01-01 " + jam_m);
                            var ex_s = new Date("1970-01-01 " + jam_s);
                            const timeFormatter = ('id-ID', { hour: '2-digit', minute:'2-digit' }); //format jam
                            var jm = ex_m.toLocaleTimeString(timeFormatter);
                            var js = ex_s.toLocaleTimeString(timeFormatter);
                            var cv_jm = moment(jm, 'hh:mm:ss A').format('HH:mm');
                            var cv_js = moment(js, 'hh:mm:ss A').format('HH:mm');
                            $('#hasil_cek tbody').append('<tr><td class="text-center">'+ response.ketersediaan[i].perihal +'</td><td class="text-center">'+ cv_jm +'-'+ cv_js +'</td></tr>')
                       }
                       if (response.ketersediaan.length == 0){
                            $('#hasil_cek tbody').append('<tr><td colspan="2" class="text-center">'+ 'Ruangan Tersedia' +'</td></tr>')
                       }
                    },
                    error: function (data) {
                    var response = JSON.parse(data.responseText);
                    var errorString = '';
                        $.each( response.errors, function( key, value) {
                            errorString += value;
                        });
                    console.log(data);
                    alert(errorString);
                    }
                });
            }
            
        });
        </script>
@endsection