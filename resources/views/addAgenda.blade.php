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
            <form name="frm_add" id="frm_add" class="form-horizontal" action="{{route('simpanagenda')}}" method="POST" enctype="multipart/form-data" onsubmit="setLokasi();cekStatus();">
                @csrf
                <div class="mb-3 p-5">
                    <label for="perihal" class="form-label">Perihal</label>
                    <input type="text" name="perihal" id="perihal" placeholder="Masukkan perihal agenda" autocomplete="off" class="form-control" value="{{ old('perihal') }}" required>
                </div>
                <div class="mb-3 p-5">
                    <label for="deskripsi" class="form-label">Deskripsi (opsional)</label>
                    <br><textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Masukkan deskripsi agenda" autocomplete="off">{{ old('deskripsi') }}</textarea>
                </div>
                <div class="mb-3 p-5">
                    <label for="peserta" class="form-label">Peserta</label>
                    <input id="peserta" type="hidden" name="peserta" id="peserta" value="{{ old('peserta') }}" autocomplete="off">
                    <trix-editor input="peserta"></trix-editor>
                </div>
                <div class="mb-3 p-5">
                    <label for="Lokasi" class="form-label">Lokasi</label>
                    <div class="form-check p-1">
                                            <input type="radio" class="form-check-input" id="dalam" name="optradio" value="dalam" onclick="text(1)" checked>Gedung BAPPEDA
                                            <label class="form-check-label" for="dalam"></label>
                                            </div>
                                            <!-- pilih ruangan dalam gedung-->
                                            <div class="form-group col-lg-10">
                                                <div class="col-lg-5" id="internal1">
                                                    <select class="form-control default-select" id="internal" name="lokasi1" data-size="5">
                                                    <option value="" selected>---- Pilih Ruangan ----</option>
                                                    @foreach ($ruangan as $r)
                                                        <option value="{{ $r->id_lokasi }}">{{ $r->nama_lokasi }}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-check p-1 col-lg-10">
                                            <input type="radio" class="form-check-input" id="luar" name="optradio" value="luar" onclick="text(0)">Luar Gedung BAPPEDA
                                            <label class="form-check-label" for="luar"></label>
                                        </div>
                                        
                                        <!-- input lokasi luar gedung -->
                                            <div class="form-group col-lg-10">
                                                <div class="col-lg-12" id="eksternal1">
                                                    <div class="col-lg-5 p-1">
                                                        <select class="form-control default-select2" id="eksternal" name="lokasi2" data-size="5">
                                                        <option value="" selected>---- Pilih Lokasi ----</option>
                                                        @foreach ($lokasi as $l)
                                                            <option value="{{ $l->id_lokasi }}">{{ $l->nama_lokasi }}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <button type="button" class="btn btn-light btn-sm" onclick="tambah_lokasi(0)"><i class="fa-regular fa-plus"></i></button>
                                                    </div>
                                                    <div class="col-lg-4 p-1">
                                                        <input type="text" name="lokasi_baru" id="lokasi_baru" placeholder="Masukkan lokasi agenda" class="form-control">
                                                    </div>
                                                    <div class="col-lg-1">
                                                        <button type="button" id="btn_tambah_lokasi" class="btn btn-light btn-sm"><i class="fa-solid fa-check"></i></button>
                                                    </div>
                                                    <br>
                                                </div>
                                            </div>
                                            

                                        <!-- hidden input untuk menampung kategori lokasi terpilih -->
                                        <input type="hidden" id="lokasi" name="lokasi" value="" required>

                                        <!-- hidden input untuk menampung nip user -->
                                        <input type="hidden" id="nip" name="nip" value="{{ Session::get('username') }}">
                                        <!-- hidden input untuk menampung bidang user -->
                                        <input type="hidden" id="bidang" name="bidang" value="{{ Session::get('bidang') }}">

                                        <!-- hidden input untuk menandai lokasi dalam atau luar -->
                                        <input type="hidden" id="dl" name="dl" value="" required>
                </div>
                <div class="mb-3 p-5 col-lg-10">
                    <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                    <input id="tgl_mulai" type="date" name="tgl_mulai" id="tgl_mulai" class="date_picker form-control" value="{{ old('tgl_mulai') }}" required>
                </div>
                <div class="mb-3 p-5 col-lg-10">
                    <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                    <input id="tgl_selesai" type="date" name="tgl_selesai" id="tgl_selesai" class="date_picker form-control" value="{{ old('tgl_selesai') }}" required>
                </div>
                <div class="mb-3 p-5 col-lg-10">
                    <label for="jam_mulai" class="form-label">Waktu Mulai</label>
                    <br><input id="jam_mulai" class="timepicker" autocomplete="off" name="jam_mulai" id="jam_mulai" type="text" value="{{ old('jam_mulai') }}">
                </div>
                <div class="mb-3 p-5 col-lg-10">
                    <label for="jam_selesai" class="form-label">Waktu Selesai (opsional)</label>
                    <br><input id="jam_selesai" class="timepicker2" autocomplete="off" name="jam_selesai" id="jam_selesai" type="text" value="{{ old('jam_selesai') }}">
                </div>
                <div class="mb-3 p-5 col-lg-3">
                    <label for="upload_file">Upload File</label>
                    <input type="file" id="file" name="file">
                </div>
                <div class="mb-3 p-5 col-lg-10">
                    <button type="button" class="btn btn-primary" onclick="cekStatus()">Simpan</button>
                </div>
            </form>
        </div>
        </div>
   </div>
@endsection

@section('js')
</script>
    <!-- date picker tanggal mulai -->
    <script language="javascript">
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
        $('.date_picker').attr('min',today);
    </script>
    <!-- set value lokasi -->
    <script>
        function setLokasi(){
            var d = document.getElementById("internal");
            var l = document.getElementById("eksternal");

            if (document.getElementById("dalam").checked){
                document.frm_add.lokasi.value= d.value;
                document.frm_add.dl.value= "dalam";
            } else if (document.getElementById("luar").checked){
                document.frm_add.lokasi.value= l.value;
            }
        }
    </script>

    <!-- tampilan input lokasi -->
    <script>
    $(document).ready(function(){
        text(1);
        tambah_lokasi(1);
    });
        function text(x){
            if (x==0){
                document.getElementById("eksternal1").style.display="block";
                document.getElementById("internal1").style.display="none";
                }
            else if (x==1) {
                document.getElementById("eksternal1").style.display="none";
                document.getElementById("internal1").style.display="block";
            }
            return;
        }
    </script>
    <script>
        function tambah_lokasi(y){
            if (y==0){
                document.getElementById("lokasi_baru").style.visibility = "visible";
                document.getElementById("btn_tambah_lokasi").style.visibility = "visible";
            }
            else if(y==1){
                document.getElementById("lokasi_baru").style.visibility = "hidden";
                document.getElementById("btn_tambah_lokasi").style.visibility = "hidden";
            }
        }
    </script>

    <!-- timepicker -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script>
            $('.timepicker').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                minTime: '08:00',
                maxTime: '20:00',
                defaultTime: '',
                startTime: '08:00',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
            $('.timepicker2').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                minTime: '08:30',
                maxTime: '22:00',
                defaultTime: '',
                startTime: '08:30',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
            // $('.timepicker').timepicker({
            //     timeFormat: 'HH:mm',
            // });
            // $('.timepicker2').timepicker({
            //     timeFormat: 'HH:mm',
            // });
    </script>
    <!-- select2 -->
    <script>
        $(".default-select").select2({ placeholder: "Pilih Ruangan" });
        $(".default-select2").select2({ placeholder: "Pilih Lokasi" });
    </script>

    <!-- ajax insert lokasi baru -->
    <script>
        $('#btn_tambah_lokasi').on('click', function() {
        var lokasi_baru = $('#lokasi_baru').val();
        if(lokasi_baru!=""){
            $.ajax({
                url: "/addLokasi",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    nama_lokasi:lokasi_baru,
                    posisi:1,
                    status:0
                },
                cache: false,
                success: function(dataResult){
                    console.log(dataResult);
                    var div = $(this).parent();
                    if(dataResult.statusCode==200){
                        alert("Lokasi berhasil ditambahkan");
                        $('#eksternal').empty();
                        $("#eksternal").append('<option>Pilih Lokasi</option>');
                        for (var i=0;i<dataResult.lokasi.length;i++){
                            $('#eksternal').append('<option value="'+dataResult.lokasi[i].id_lokasi+'">'+ dataResult.lokasi[i].nama_lokasi +'</option>');
                        }
                    }
                },
                error:function(error){
                    alert("Data lokasi  tidak berhasil ditambahkan");
                }
            });
        }
        else{
            alert('Harap input lokasi agenda');
        }
    });
    </script>
    <!-- cek status ketersediaan ruangan -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
    <script>
        function cekStatus(){
            $.ajax({
                    type: "GET",
                    url: "/getStatus",
                    success: function(response){
                        var ts = document.getElementById("tgl_selesai");
                        var js = document.getElementById("jam_selesai");
                        var tm = document.getElementById("tgl_mulai");
                        var jm = document.getElementById("jam_mulai");
                        var sub = true;
                        let valid = true;

                        setLokasi();

                        for (var f=0;f<response.status.length;f++){
                                var jam_m = response.status[f].jam_mulai;
                                var jam_s = response.status[f].jam_selesai;
                                var bts = '16:00:00'

                                //    merubah jam agar menjadi tgl
                                var ex_m = new Date("1970-01-01 " + jam_m);
                                var ex_s = new Date("1970-01-01 " + jam_s);
                                var batas = new Date("1970-01-01 " + bts);
                                const timeFormatter = ('id-ID', { hour: '2-digit', minute:'2-digit' }); //format jam
                                var jamm = ex_m.toLocaleTimeString(timeFormatter);
                                var jams = ex_s.toLocaleTimeString(timeFormatter);
                                var cv_jm = moment(jamm, 'hh:mm:ss A').format('HH:mm');
                                var cv_js = moment(jams, 'hh:mm:ss A').format('HH:mm');
                                var bt = moment(batas, 'hh:mm:ss A').format('HH:mm');

                                if(response.status[f].id_lokasi == lokasi.value){
                                    if(response.status[f].tgl_pemakaian==tm.value || response.status[f].tgl_pemakaian==ts.value){
                                        if(js.value!=""){
                                            if (cv_jm<=jm.value && cv_js>jm.value){
                                                console.log(cv_jm);
                                                console.log(cv_js);
                                                console.log(jm.value);
                                                console.log("gabisa dipake1");
                                                sub = false;
                                                break;
                                            }
                                            else if (cv_jm<js.value && cv_js>=js.value){
                                                console.log("gabisa dipake2");
                                                sub = false;
                                                break;
                                            }
                                            else if(cv_jm>jm.value && cv_js<js.value){
                                                console.log("gabisa dipake2");
                                                sub = false;
                                                break;
                                            }
                                            else {
                                                console.log("bisa dipake");
                                            }
                                        }
                                        else if(js.value=="") {
                                            if (cv_jm<=jm.value && cv_js>jm.value){
                                                console.log(cv_jm);
                                                console.log(cv_js);
                                                console.log(jm.value);
                                                console.log("gabisa dipake1");
                                                sub = false;
                                                break;
                                            }
                                            else if (cv_jm<bts && cv_js>=bts){
                                                console.log("gabisa dipake2");
                                                sub = false;
                                                break;
                                            }
                                            else if(cv_jm>jm.value && cv_js<bts){
                                                console.log("gabisa dipake2");
                                                sub = false;
                                                break;
                                            }
                                            else {
                                                console.log("bisa dipake");
                                            }
                                        }
                                    }
                                    else if (response.status[f].tgl_pemakaian > tm.value && response.status[f].tgl_pemakaian < ts.value){
                                        if(js.value!=""){
                                            if (cv_jm<=jm.value && cv_js>jm.value){
                                                console.log("gabisa dipake6");
                                                sub = false;
                                                break;
                                            }
                                            else if (cv_jm<js.value && cv_js>=js.value){
                                                console.log("gabisa dipake7");
                                                sub = false;
                                                break;
                                            }
                                            else if(cv_jm>jm.value && cv_js<js.value){
                                                console.log("gabisa dipake8");
                                                sub = false;
                                                break;
                                            }
                                            else {
                                                console.log("bisa dipake");
                                            }
                                        }
                                        else if(js.value=="") {
                                            if (cv_jm<=jm.value && cv_js>jm.value){
                                                console.log(cv_jm);
                                                console.log(cv_js);
                                                console.log(jm.value);
                                                console.log("gabisa dipake1");
                                                sub = false;
                                                break;
                                            }
                                            else if (cv_jm<bts && cv_js>=bts){
                                                console.log("gabisa dipake2");
                                                sub = false;
                                                break;
                                            }
                                            else if(cv_jm>jm.value && cv_js<bts){
                                                console.log("gabisa dipake2");
                                                sub = false;
                                                break;
                                            }
                                            else {
                                                console.log("bisa dipake");
                                            }
                                        }
                                    }
                                    else{
                                        console.log("Ruangan dpt digunakan1");
                                    }
                                }
                                else {
                                    console.log("Ruangan dpt digunakan2");
                                }
                        } //endfor status
                    
                        if(sub==true){
                            // validasi tanggal dan jam
                            if (js.value!=""){
                                if (tm.value<=ts.value && jm.value<js.value){
                                    console.log("aman1");
                                    // submitForm();
                                    validasi();
                                }
                                else if (jm.value>=js.value){
                                    alert("Waktu Pelaksanaan Tidak Valid");
                                }
                                else if (tm.value>ts.value){
                                    alert("Tanggal Pelaksanaan Tidak Valid");
                                }
                            }
                            else if (js.value==""){
                                if (tm.value<=ts.value){
                                    console.log("aman2");
                                    // submitForm();
                                    validasi();
                                }
                                else if (tm.value>ts.value){
                                    alert("Tanggal Pelaksanaan Tidak Valid");
                                }
                            } 
                        }
                        else {
                            alert("Ruangan sudah digunakan");
                        }
                    }
            });
        }
    </script>
    <!-- submit form -->
    <script>
        function submitForm(){
            var form = $("#frm_add");
            var forms = $('#frm_add')[0];
            var url = form.attr('action');
            var formData = new FormData(forms);
            console.log(formData);
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                url: url,
                data: formData,
                success: function() {
                    alert("Data Berhasil Ditambahkan");
                    location.href = "/dashboard";
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
    </script>
    <script>
        function validasi(){
            let a = document.forms["frm_add"]["perihal"].value;
            let b = document.forms["frm_add"]["peserta"].value;
            let c = document.forms["frm_add"]["lokasi"].value;
            let d = document.forms["frm_add"]["tgl_mulai"].value;
            let e = document.forms["frm_add"]["tgl_selesai"].value;
            let f = document.forms["frm_add"]["jam_mulai"].value;
            let g = document.forms["frm_add"]["file"].value;

            if (a == "") {
                alert("Kolom Perihal harus diisi");
            }
            else if (b == ""){
                alert("Kolom Peserta harus diisi");
                valid = false;
            }
            else if (c == ""){
                alert("Kolom Lokasi harus dipilih");
                valid = false;
            }
            else if (d == ""){
                alert("Kolom Tanggal Mulai harus diisi");
                valid = false;
            }
            else if (e == ""){
                alert("Kolom Tanggal Selesai harus diisi");
                valid = false;
            }
            else if (f == ""){
                alert("Kolom Waktu Mulai harus diisi");
                valid = false;
            }
            else if (g == ""){
                alert("Harap Upload Dokumen yang Dibutuhkan");
                valid = false;
            }
            else {
                submitForm();
            }
        }
    </script>
@endsection