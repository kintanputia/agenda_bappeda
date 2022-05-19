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
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><b>Perihal<b></td>
                            <td>{{ $detail->perihal }}</td>
                        </tr>
                        <tr>
                            <td><b>Bidang Pelaksana<b></td>
                            <td>{{ $detail->bidang }}</td>
                        </tr>
                        <tr>
                            <td><b>Deskripsi<b></td>
                            <td>{{ $detail->deskripsi }}</td>
                        </tr>
                        <tr>
                            <td><b>Peserta<b></td>
                            <td><?php echo $detail->peserta ?></td>
                        </tr>
                        <tr>
                            <td><b>Lokasi<b></td>
                            <td>{{ $detail->nama_lokasi }}</td>
                        </tr>
                        <tr>
                            <?php
                            $tm = Carbon\Carbon::parse($detail->tgl_mulai);
                            $ts = Carbon\Carbon::parse($detail->tgl_selesai);
                            $jm = Carbon\Carbon::parse($detail->jam_mulai);
                            $js = Carbon\Carbon::parse($detail->jam_selesai);
                            $tgl_m = $tm->isoFormat('D MMMM Y');
                            $tgl_s = $ts->isoFormat('D MMMM Y');
                            $jam_m = $jm->format('H:i');
                            $jam_s = $js->format('H:i');
                            ?>
                            <td><b>Tanggal Mulai<b></td>
                            <td>{{ $tgl_m }}</td>
                        </tr>
                        <tr>
                            <td><b>Tanggal Selesai<b></td>
                            <td>{{ $tgl_s }}</td>
                        </tr>
                        <tr>
                            <td><b>Waktu Mulai<b></td>
                            <td>{{ $jam_m }}</td>
                        </tr>
                        <tr>
                        <?php 
                            if($detail->jam_selesai == null){
                                $k = 'selesai';
                            }
                            else{
                                $k = $jam_s;
                            }
                            ?>
                            <td><b>Waktu Selesai<b></td>
                            <td>{{ $k }}</td>
                        </tr>
                        <tr>
                            <td><b>Dokumen<b></td>
                            <td><a href="{{ url('dokumen/' . $detail->file) }}" download>{{ $detail->file }}</a></td>
                        </tr>
                    </tbody>
                    </table>
            </div>
        </div>
   </div>
@endsection