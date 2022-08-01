<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda BAPPEDA</title>
    <link href="{{asset('css/table.css')}}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="view" style="background-image: url('https://sumbarprov.go.id/images/2020/07/slider/MASJID_RAYA_SUMBAR.png'); background-repeat: no-repeat; background-size: cover;">
    <!-- <div class="p-3 mb-2 text-white text-center gradient" style="font-size:40px">Agenda BAPPEDA</div> -->
    <!-- <nav class="navbar navbar-light"> -->
        <!-- <div class="container-fluid text-white gradient p-3" style="font-size:40px">
        <div class="d-flex">
                <img src="{{asset('assets/img/logo_sumbar.png')}}" alt="" width="70">
                <p class="text-center">AgendaBAPPEDA<p>
            </div>
        </div> -->
    <!-- </nav> -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top gradient">
        <div class="container">
            <a class="navbar-brand" href="#">
            <img src="{{asset('assets/img/logo_sumbar.png')}}" alt="..." height="60">
            </a>
            <!-- <h1 class="text-white">Agenda BAPPEDA</h1> -->
            <div class="text-white text-center" style="font-size:40px">Agenda BAPPEDA</div>
            <img src="http://sakatoplan.sumbarprov.go.id/bappeda/logobaru.png" alt="" height="20">
        </div>
    </nav>

        <div id="contain">
        <table class="styled-table">
                <thead>
                    <tr>      
                        <th>No.</th>
                        <th>Perihal</th>
                        <th>Bidang Pelaksana</th>
                        <th>Peserta</th>
                        <th>Tanggal</th>                                    
                        <th>Jam</th>                                    
                        <th>Lokasi</th>                                                                        
                    </tr>
                </thead>
                <tbody>
                @forelse ($agenda as $i => $agenda)
                <tr>
                <td style="text-align: center; vertical-align: middle;">{{ ++$i }}</td>
                <td>{{ $agenda->perihal }}</td>
                <td width="20%">{{ $agenda->bidang }}</td>
                <td><?php echo $agenda->peserta ?></td>
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
                        $k = $jam_s;                                    }
                ?>
                <td style="text-align: center; vertical-align: middle;">{{ $jam_m }} - {{ $k }}</td>
                <td style="text-align: center; vertical-align: middle;">{{ $agenda->nama_lokasi }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6"><center><p>Tidak Ada Data Agenda</p></center></td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script>
        $(document).ready(function() {
        pageScroll();
        setInterval(fetchdata,1000);

        $("#contain").mouseover(function() {
            clearTimeout(my_time);
        }).mouseout(function() {
            pageScroll();
        });
        
        getWidthHeader('table_fixed','table_scroll');
        
        });

        var my_time;
        function pageScroll() {
            var objDiv = document.getElementById("contain");
        objDiv.scrollTop = objDiv.scrollTop + 1;  
        if ((Math.round(objDiv.scrollTop) + 505) == objDiv.scrollHeight) {
            objDiv.scrollTop = 0;
        }
        my_time = setTimeout('pageScroll()', 50);
        }

        function getWidthHeader(id_header, id_scroll) {
        var colCount = 0;
        $('#' + id_scroll + ' tr:nth-child(1) td').each(function () {
            if ($(this).attr('colspan')) {
            colCount += +$(this).attr('colspan');
            } else {
            colCount++;
            }
        });
        
        for(var i = 1; i <= colCount; i++) {
            var th_width = $('#' + id_scroll + ' > tbody > tr:first-child > td:nth-child(' + i + ')').width();
            $('#' + id_header + ' > thead th:nth-child(' + i + ')').css('width',th_width + 'px');
        }
        }
    </script>
    <!-- fetchdata -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
    <script>
        function fetchdata(){
            $.ajax({
                type: "GET",
                url: "/tv/fetchdata",
                success: function(response){
                   if(response){
                       console.log(response.agenda.length);
                       $('tbody').empty();
                       for (var i=0;i<response.agenda.length;i++){
                           var tm = new Date(response.agenda[i].tgl_mulai);
                           var ts = new Date(response.agenda[i].tgl_selesai);
                           var jam_m = response.agenda[i].jam_mulai;
                           var jam_s = response.agenda[i].jam_selesai;

                        //    merubah jam agar menjadi tgl
                           var ex_m = new Date("1970-01-01 " + jam_m);
                           var ex_s = new Date("1970-01-01 " + jam_s);
                        //    format tgl dan jam
                           const dateFormatter = new Intl.DateTimeFormat('id', { day: 'numeric', month: 'long', year: "numeric" }); //format tgl lengkap
                           const timeFormatter = ('id-ID', { hour: '2-digit', minute:'2-digit' }); //format jam
                           const d = new Intl.DateTimeFormat('id', { day: 'numeric' }); //format tgl
                           const m = new Intl.DateTimeFormat('id', { month: 'long' }); //format bulan
                           const y = new Intl.DateTimeFormat('id', { year: "numeric" }); //format tahun
                        //    konvert tgl jam
                           var tgl_m = dateFormatter.format(tm);
                           var tgl_s = dateFormatter.format(ts);
                           var tgl_mulai = d.format(tm);
                           var bln_mulai = m.format(tm);
                           var thn_mulai = y.format(tm);
                           var tgl_selesai = d.format(ts);
                           var bln_selesai = m.format(ts);
                           var thn_selesai = y.format(ts);
                           var jm = ex_m.toLocaleTimeString(timeFormatter);
                           var js = ex_s.toLocaleTimeString(timeFormatter);
                           var cv_jm = moment(jm, 'hh:mm:ss A').format('HH:mm');
                           var cv_js = moment(js, 'hh:mm:ss A').format('HH:mm');

                            if(tgl_m == tgl_s){
                                var t = tgl_m;
                            }else {
                                if(bln_mulai == bln_selesai && thn_mulai == thn_selesai){
                                    var t = tgl_mulai+' - '+tgl_selesai+' '+bln_mulai+' '+thn_mulai; 
                                }else if (bln_mulai != bln_selesai && thn_mulai == thn_selesai){
                                    var t = tgl_mulai+' '+bln_mulai+' - '+tgl_selesai+' '+bln_selesai+' '+thn_mulai;
                                }else {
                                    var t = tgl_m+' - '+tgl_s;
                                }
                            }

                            if(response.agenda[i].jam_selesai == null){
                                var k = 'selesai';
                            }
                            else{
                                var k = cv_js;
                            }
                        var x = i+1; 
                        $('tbody').append('<tr><td class="text-center">'+ x +'</td><td>'+ response.agenda[i].perihal +'</td><td class="text-center" width="20%">'+ response.agenda[i].bidang +'</td><td>'+ response.agenda[i].peserta +'</td><td class="text-center">'+ t +'</td><td class="text-center">'+ cv_jm +' - '+ k +'</td><td class="text-center">'+ response.agenda[i].nama_lokasi +'</td></tr>')
                       }
                   }
                }
            });
            }
    </script>
</body>
</html>