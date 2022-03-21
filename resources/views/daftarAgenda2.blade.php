<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda BAPPEDA</title>
    <!-- timepicker -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- trix editor -->
    <link rel="stylesheet" type="text/css" href="/css/trix.css">
    <script type="text/javascript" src="/js/trix.js"></script>
</head>
<body>

<div class="view" style="background-image: url('https://sumbarprov.go.id/images/2020/07/slider/MASJID_RAYA_SUMBAR.png'); background-repeat: no-repeat; background-size: cover;">
    <section>
            <div class="container bg-light p-4">
            <div class="p-3 mb-4 bg-info text-white text-center font-weight-bold" style="font-size:40px">Agenda BAPPEDA</div>
            <a href="/add"><button class="btn btn-outline-success btn-flat mb-3 btn-sm"><i class="fa fa-plus"></i> Tambah Agenda</button></a>
            <div class="row">
                <div class="col-md-12">
                    <div class="px-1 py-2 flex justify-center">
                    <table id="dataAgenda" class="table table-hover table-bordered">
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
                                    <td class="text-center p-2 ">
                                    @if($agenda->tgl_mulai == $agenda->tgl_selesai)
                                        {{ $agenda->tgl_mulai }}
                                    @else
                                        {{ $agenda->tgl_mulai }} - {{ $agenda->tgl_selesai }}
                                    @endif
                                    </td>
                                    <?php 
                                        if($agenda->jam_selesai == null){
                                            $k = 'selesai';
                                        }
                                        else{
                                            $k = $agenda->jam_selesai;
                                        }
                                    ?>
                                    <td class="text-center p-2 ">{{ $agenda->jam_mulai }} - {{ $k }}</td>
                                    <td class="p-2 ">{{ $agenda->lokasi }}</td>
                                    <td class="text-center p-2">
                                        <a href="/detail/{{ $agenda->id }}"><button type="button" class="btn btn-sm btn-primary"><i class="fa-regular fa-eye"></i></button></a>
                                        <button type="button" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen"></i></button>
                                        <a href="/delete/{{ $agenda->id }}"><button type="button" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button></a>
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
        <!-- modal add data-->
        <div class="modal inmodal fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xs">
                <form name="frm_add" id="frm_add" class="form-horizontal" action="{{route('simpanagenda')}}" method="POST" enctype="multipart/form-data" onsubmit="submitForm()">
                @csrf
                    <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h4 class="modal-title">Tambah Agenda</h4>
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group"><b><label class="col-lg-5 control-label">Perihal</label></b>
                                <div class="col-lg-10 mb-3"><input type="text" name="perihal" placeholder="Masukkan perihal rapat" class="form-control" required></div>
                                <div class="form-group"><b><label class="col-lg-5 control-label">Deskripsi (opsional)</label></b>
                                <div class="col-lg-10 mb-3"><textarea rows="5" cols="55" name="deskripsi" placeholder="Masukkan deskripsi rapat"></textarea></div>
                                <div class="form-group"><b><label class="col-lg-5 control-label">Peserta</label></b>
                                    <input id="peserta" type="hidden" name="peserta">
                                    <trix-editor input="peserta"></trix-editor>
                                </div>
                                <div class="col-lg-10">
                                    <b><label for="position-option">Lokasi</label></b>
                                    <div class="col-lg-10 mb-3">
                                        <div class="form-check p-1">
                                            <input type="radio" class="form-check-input" id="dalam" name="optradio" value="dalam" onclick="text(1)" checked>Gedung BAPPEDA
                                            <label class="form-check-label" for="dalam"></label>
                                            </div>
                                            <!-- pilih ruangan dalam gedung-->
                                            <div class="form-group">
                                                <select class="form-control" id="internal" name="lokasi1">
                                                <option value="" selected>---- Pilih Ruangan ----</option>
                                                @foreach ($ruangan as $r)
                                                    <option value="{{ $r->nama_ruangan }}">{{ $r->nama_ruangan }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                            <div class="form-check p-1">
                                            <input type="radio" class="form-check-input" id="luar" name="optradio" value="luar" onclick="text(0)">Luar Gedung BAPPEDA
                                            <label class="form-check-label" for="luar"></label>
                                        </div>
                                        <!-- input lokasi luar gedung -->
                                        <input type="text" name="lokasi2" id="eksternal" placeholder="Masukkan lokasi agenda" class="form-control">

                                        <!-- hidden input untuk menampung kategori lokasi terpilih -->
                                        <input type="hidden" id="lokasi" name="lokasi" value="">
                                    </div>
                                </div>
                                <div class="form-group"><b><label class="col-lg-5 control-label">Tanggal Mulai</label></b>
                                <div class="col-lg-10 mb-3"><input id="date_picker" type="date" name="tgl_mulai" class="form-control" required></div>
                                <div class="form-group"><b><label class="col-lg-5 control-label">Tanggal Selesai</label></b>
                                <div class="col-lg-10 mb-3"><input id="date_picker2" type="date" name="tgl_selesai" class="form-control" required></div>
                                <div class="form-group"><b><label class="col-lg-5 control-label">Jam Mulai</label></b>
                                <div class="col-lg-10 mb-3">
                                    <input id="timepicker" name="jam_mulai" type="text">
                                </div>
                                <div class="form-group"><b><label class="col-lg-8 control-label">Jam Selesai (opsional)</label></b>
                                <div class="col-lg-10 mb-3"><input id="timepicker2" name="jam_selesai" class="form-control"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
        <!-- end add modal -->
        
        <!-- modal detail -->
        @foreach($agenda2 as $data)
            <div class="modal fade" id="menungguModal-{{ $data->id }}" tabindex="-1" aria-labelledby="menungguModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content">
                           <div class="modal-header bg-light">
                              <h5 class="modal-title text-black" id="menungguModallLabel">Data Janji Tamu Detail</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <div class="modal-body">
                              <table class="table table-borderless">
                                 <tr>
                                    <td>Nama Tamu</td>
                                    <td>{{ $data->perihal }}</td>
                                 </tr>
                              </table>
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                           </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
        <!-- end modal detail -->
    <!-- js bootstrap -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    </script>
    <!-- date picker tanggal mulai -->
    <script language="javascript">
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
        $('#date_picker').attr('min',today);
    </script>
    <!-- date picker tanggal selesai -->
    <script language="javascript">
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
        $('#date_picker2').attr('min',today);
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
    <!-- radio button lokasi -->
    <script>
    $(document).ready(function(){
        text(1);
    });
        function text(x){
            if (x==0){
                document.getElementById("eksternal").style.display="block";
                document.getElementById("internal").style.display="none";
                }
            else if (x==1) {
                document.getElementById("eksternal").style.display="none";
                document.getElementById("internal").style.display="block";
            }
            return;
        }
    </script>
    <!-- set value lokasi -->
    <script>
        function submitForm(){
            var d = document.getElementById("internal");
            var l = document.getElementById("eksternal");

            if (document.getElementById("dalam").checked){
                document.frm_add.lokasi.value= d.value;
            } else if (document.getElementById("luar").checked){
                document.frm_add.lokasi.value= l.value;
            }
        }
    </script>
    
    <!-- timepicker -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script>
            $('#timepicker').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                minTime: '07:00',
                maxTime: '16:00',
                defaultTime: '08:00',
                startTime: '09:00',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
            $('#timepicker2').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                minTime: '08:00',
                maxTime: '16:00',
                defaultTime: '08:30',
                startTime: '08:00',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
    </script>
</body>
</html>