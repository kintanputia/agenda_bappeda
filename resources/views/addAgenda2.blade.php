@extends('app')
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- trix editor -->
    <link rel="stylesheet" type="text/css" href="/css/trix.css">
    <script type="text/javascript" src="/js/trix.js"></script>

</head>
<body>
    @section('panel')
        <form name="frm_add" id="frm_add" class="form-horizontal" action="{{route('simpanagenda')}}" method="POST" enctype="multipart/form-data" onsubmit="submitForm()">
                @csrf
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
                                <div class="col-lg-10 mb-3"><input id="timepicker2" name="jam_selesai"></div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
    @endsection
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
                dynamic: true,
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
                dynamic: true,
                dropdown: true,
                scrollbar: true
            });
    </script>
</body>
</html>