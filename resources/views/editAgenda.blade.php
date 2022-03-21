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
            <form name="frm_edit" id="frm_edit" class="form-horizontal" action="{{route('edit_process')}}" method="POST" enctype="multipart/form-data" onsubmit="setLokasi()">
            @csrf
                    <input type="hidden" name="id" value="{{ $detail->id }}">
                    <div class="mb-3 p-5">
                        <label for="perihal" class="form-label">Perihal</label>
                        <input type="text" name="perihal" value="{{ $detail->perihal }}" class="form-control" required>
                    </div>
                    <div class="mb-3 p-5">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <br><textarea class="form-control" name="deskripsi">{{ $detail->deskripsi }}</textarea>
                    </div>
                    <div class="mb-3 p-5">
                        <label for="peserta" class="form-label">Peserta</label>
                        <input id="peserta" type="hidden" name="peserta" value="{{ $detail->peserta }}">
                        <trix-editor input="peserta"></trix-editor>
                    </div>
                    <div class="mb-3 p-5 col-lg-10">
                        <label for="lokasi" class="form-label">Lokasi</label>
                            <div class="form-check p-1">
                                <input type="radio" class="form-check-input" id="dalam" name="optradio" value="dalam" onclick="text(1)" checked>Gedung BAPPEDA
                                <label class="form-check-label" for="dalam"></label>
                            </div>
                            <!-- pilih ruangan dalam gedung-->
                            <div class="form-group col-lg-10">
                                <div class="col-lg-5" id="internal1">
                                    <select class="form-control default-select" id="internal" name="lokasi1">
                                    <!-- <option value="" selected>---- Pilih Ruangan ----</option> -->
                                        @foreach ($ruangan as $r)
                                            <?php 
                                            if ($r->id_lokasi == $detail->id_lokasi){?>
                                                <option value="{{ $detail->id_lokasi }}" selected>{{ $detail->nama_lokasi }}</option>
                                            <?php } 
                                            else { ?>
                                                <option value="{{ $r->id_lokasi }}">{{ $r->nama_lokasi }}</option>
                                            <?php } ?>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                                <div class="form-check p-1 col-lg-10">
                                    <input type="radio" class="form-check-input" id="luar" name="optradio" value="luar" onclick="text(0)">Luar Gedung BAPPEDA
                                    <label class="form-check-label" for="luar"></label>
                                </div>
                                <!-- input lokasi luar gedung -->
                                <div class="col-lg-12" id="eksternal1">
                                    <div class="col-lg-5 p-1">
                                        <select class="form-control default-select2" id="eksternal" name="lokasi2">
                                        <!-- <option value="" selected>---- Pilih Ruangan ----</option> -->
                                            @foreach ($lokasi as $l)
                                                <?php 
                                                if ($l->id_lokasi == $detail->id_lokasi){?>
                                                    <option value="{{ $detail->id_lokasi }}" selected>{{ $detail->nama_lokasi }}</option>
                                                <?php } 
                                                else { ?>
                                                    <option value="{{ $l->id_lokasi }}">{{ $l->nama_lokasi }}</option>
                                                <?php } ?>
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

                                <!-- hidden input untuk menampung kategori lokasi terpilih -->
                                <input type="hidden" id="lokasi" name="lokasi" value="{{ $detail->id_lokasi }}">
                                <!-- hidden input untuk menandai lokasi dalam atau luar -->
                                <input type="hidden" id="dl" name="dl" value="" required>
                        
                    </div>
                    <div class="mb-3 p-5 col-lg-10">
                        <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" value="{{ $detail->tgl_mulai }}">
                    </div>
                    <div class="mb-3 p-5 col-lg-10">
                        <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control date_picker2" value="{{ $detail->tgl_selesai }}" required>
                    </div>
                    <div class="mb-3 p-5 col-lg-10">
                        <label for="jam_mulai" class="form-label">Waktu Mulai</label>
                        <br><input class="timepicker" name="jam_mulai" id="jam_mulai" type="text">
                    </div>
                    <div class="mb-3 p-5 col-lg-10">
                        <label for="jam_selesai" class="form-label">Waktu Selesai</label>
                        <br><input class="timepicker2" name="jam_selesai" id="jam_selesai" type="text" value="{{ $detail->jam_selesai }}">
                    </div>
                    <div class="mb-3 p-5 col-lg-10">
                        <label for="upload_file">Upload File</label>
                        <br>
                        <a href="{{ url('dokumen/' . $detail->file) }}" download>{{ $detail->file }}</a>
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
    <!-- date picker tanggal mulai -->
    <script language="javascript">
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
        $('.date_picker').attr('min',today);
    </script>
    <!-- date picker tanggal selesai -->
    <script language="javascript">
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
        $('.date_picker2').attr('min',today);
    </script>
    <!-- set value lokasi -->
    <script>
        function setLokasi(){
            var d = document.getElementById("internal");
            var l = document.getElementById("eksternal");

            if (document.getElementById("dalam").checked){
                document.frm_edit.lokasi.value= d.value;
                document.frm_edit.dl.value= "dalam";
            } else if (document.getElementById("luar").checked){
                document.frm_edit.lokasi.value= l.value;
            }
        }
    </script>

    <!-- cek radio button lokasi internal atau eksternal -->
    <script>
        var l = '{{ $detail->id_lokasi }}';
        var r = <?php echo json_encode($ruangan); ?>;

        for (let i = 0; i < r.length; i++) {
            console.log(r[i].id)
            console.log(l)
            if (r[i].id_lokasi==l){
                    document.getElementById("dalam").checked = true;
                    break;
                }else {
                    document.getElementById("luar").checked = true;
                }
        }
    </script>

    <!-- tampilan input radio button-->
    <script>
    $(document).ready(function(){
        text(1);
        tambah_lokasi(1);
    });
        function text(x){
            if (x==0 || document.getElementById("luar").checked){
                document.getElementById("eksternal1").style.display="block";
                document.getElementById("internal1").style.display="none";
                }
            else if (x==1 || document.getElementById("dalam").checked) {
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
                maxTime: '22:00',
                defaultTime: '{{ $detail->jam_mulai }}',
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
                defaultTime: '{{ $detail->jam_selesai }}',
                startTime: '08:30',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
    </script>
    <!-- select2 -->
    <script>
        $(".default-select").select2({ placeholder: "Pilih Ruangan" });
        $(".default-select2").select2({ placeholder: "Pilih Lokasi" });;
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
                    else if(dataResult.statusCode==201){
                        alert("Data Lokasi Tidak Berhasil Ditambahkab");
                    }
                    
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
                    url: "/getStatusEdit/{{ $detail->id }}",
                    success: function(response){
                        var ts = document.getElementById("tgl_selesai");
                        var js = document.getElementById("jam_selesai");
                        var tm = document.getElementById("tgl_mulai");
                        var jm = document.getElementById("jam_mulai");
                        var sub = true;

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
                                            if(cv_jm>=jm.value && cv_jm<bt){
                                                console.log("gabisa dipake4");
                                                sub = false;
                                                break;
                                            }
                                            else if (cv_js<bt && cv_js>jm.value){
                                                console.log("gabisa dipake5");
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
                                            if(cv_jm>=jm.value && cv_jm<bt){
                                                console.log("gabisa dipake9");
                                                sub = false;
                                                break;
                                            }
                                            else if (cv_js<bt && cv_js>jm.value){
                                                console.log("gabisa dipake10");
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
            var form = $("#frm_edit");
            var forms = $("#frm_edit")[0];
            var url = form.attr('action');
            var formData = new FormData(forms);

            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                url: url,
                data: formData,
                success: function(data) {
                    alert("Data Berhasil Diedit");
                    location.href = "/"
                },
                error: function (data) {
                    console.log(data.responseText);
                    var response = JSON.parse(data.responseText);
                    var errorString = '';
                        $.each( response.errors, function( key, value) {
                            errorString += value;
                        });
                    console.log(errorString);
                    alert(errorString);
                }
            });
        }
    </script>
    <script>
        function validasi(){
            let a = document.forms["frm_edit"]["perihal"].value;
            let b = document.forms["frm_edit"]["peserta"].value;
            let c = document.forms["frm_edit"]["lokasi"].value;
            let d = document.forms["frm_edit"]["tgl_mulai"].value;
            let e = document.forms["frm_edit"]["tgl_selesai"].value;
            let f = document.forms["frm_edit"]["jam_mulai"].value;

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
            else {
                submitForm();
            }
        }
    </script>
@endsection
