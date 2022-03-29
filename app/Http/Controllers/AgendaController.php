<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Agenda;
use App\Models\Lokasi;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\File;


class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $agenda = DB::table('agenda')->orderBy('agenda.id', 'asc')
                    ->join('lokasi', 'agenda.id_lokasi', '=', 'lokasi.id_lokasi')
                    ->get();
        return view('daftarAgenda', ['agenda'=>$agenda]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'perihal'=>'required',
            'deskripsi'=>'nullable',
            'peserta'=>'required',
            'tgl_mulai'=>'required',
            'tgl_selesai'=>'required',
            'jam_mulai'=>'required',
            'jam_selesai'=>'nullable',
            'lokasi'=>'required',
            'file'=>'required|mimes:pdf|max:10240'
        ],
        [
            'file.mimes' => 'Format dokumen harus berupa pdf',
            'file.max' => 'Ukuran file melebihi 10 Mb'
        ]);

        // set value jam selesai
        if ($validatedData['jam_selesai']==null){
            $js = '22:00:00';
        }
        else if ($validatedData['jam_selesai']!=null){
            $js = $validatedData['jam_selesai'];
        }

        $period = CarbonPeriod::create($validatedData['tgl_mulai'], $validatedData['tgl_selesai']);
        if ($file = $request->file('file')) {
            $destinationPath = 'dokumen/';
            $explode = explode('.', $file->getClientOriginalName());
            $originalName = $explode[0];
            $file_name = date('YmdHis') ."_". $originalName . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_name);
        }
        
        $simpan = DB::table('agenda')->insertGetId([
            'nip'=>"728127812",
            'perihal'=>$validatedData['perihal'],
            'deskripsi'=>$validatedData['deskripsi'],
            'peserta'=>$validatedData['peserta'],
            'tgl_mulai'=>$validatedData['tgl_mulai'],
            'tgl_selesai'=>$validatedData['tgl_selesai'],
            'jam_mulai'=>$validatedData['jam_mulai'],
            'jam_selesai'=>$validatedData['jam_selesai'],
            'id_lokasi'=>$validatedData['lokasi'],
            'file'=>"$file_name"
            ]);

        if($simpan){
            if ($request->dl == 'dalam'){
                foreach ($period as $date) {
                    DB::table('pemakaian')->insert([
                        'id'=>$simpan,
                        'tgl_pemakaian'=>$date->format('Y-m-d'),
                        'id_lokasi'=>$validatedData['lokasi'],
                        'jam_mulai'=>$validatedData["jam_mulai"],
                        'jam_selesai'=>$js
                        ]);
                }
            }
            return response()->json([
                'statusCode'=>200
            ]);
        }
        else{
            return response()->json([
                'statusCode'=>201
            ]);
        }
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $ruangan = DB::table('lokasi')->where('posisi', 0)->get();
        $lokasi = DB::table('lokasi')->where('posisi', 1)->get();
        return view('addAgenda', ['ruangan'=>$ruangan, 'lokasi'=>$lokasi]);
    }

    public function insert_lokasi(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required',
            'posisi' => 'required',
            'status' => 'required'
        ]);
        $add = Lokasi::create($request->all());
        $update  = DB::table('lokasi')->where('posisi', 1)
                    ->get();
        if ($add){
            return response()->json([
                'statusCode'=>200, 'lokasi'=>$update
            ]);
        }else {
            return response()->json([
                'statusCode'=>201
            ]);
        }
    }

    public function get_lokasi()
    {
        $update  = DB::table('lokasi')->where('posisi', 1)
                    ->get();
                return response()->json($update);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = DB::table('agenda')->orderBy('agenda.id', 'asc')
                    ->join('lokasi', 'agenda.id_lokasi', '=', 'lokasi.id_lokasi')
                    ->where('agenda.id', $id)
                    ->first();
        return view ('detailAgenda', ['detail'=>$detail]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $detail = DB::table('agenda')->where('id', $id)->first();
        $detail = DB::table('agenda')->orderBy('agenda.id', 'asc')
                    ->join('lokasi', 'agenda.id_lokasi', '=', 'lokasi.id_lokasi')
                    ->where('agenda.id', $id)
                    ->first();
        $ruangan = DB::table('lokasi')->where('posisi', 0)->get();
        $lokasi = DB::table('lokasi')->where('posisi', 1)->get();
        return view ('editAgenda', ['detail'=>$detail, 'ruangan'=>$ruangan, 'lokasi'=>$lokasi]);
    }

    public function edit_process(Request $data)
    {
        $validatedData = $data->validate([
            'perihal'=>'required',
            'deskripsi'=>'nullable',
            'peserta'=>'required',
            'tgl_mulai'=>'required',
            'tgl_selesai'=>'required',
            'jam_mulai'=>'required',
            'jam_selesai'=>'nullable',
            'lokasi'=>'required',
            'file'=>'mimes:pdf|max:10240'
        ],
        [
            'file.mimes' => 'Format dokumen harus berupa pdf',
            'file.max' => 'Ukuran file melebihi 10 Mb'
        ]);

        // set value jam selesai
        if ($validatedData['jam_selesai']==null){
            $js = '22:00:00';
        }
        else if ($validatedData['jam_selesai']!=null){
            $js = $validatedData['jam_selesai'];
        }

        $id = $data->id;
        $perihal = $validatedData['perihal'];
        $deskripsi = $validatedData['deskripsi'];
        $peserta = $validatedData['peserta'];
        $lokasi = $validatedData['lokasi'];
        $tgl_mulai = $validatedData['tgl_mulai'];
        $tgl_selesai = $validatedData['tgl_selesai'];
        $jam_mulai = $validatedData['jam_mulai'];
        $jam_selesai = $validatedData['jam_selesai'];
        $edit1 = false;
        $edit2 = false;

  
        if ($file = $data->file('file')) {
            $destinationPath = 'dokumen/';
            $explode = explode('.', $file->getClientOriginalName());
            $originalName = $explode[0];
            $file_name = date('YmdHis') ."_". $originalName . "." . $file->getClientOriginalExtension();
            $file->move($destinationPath, $file_name);
            
            $edit1 = DB::table('agenda')->where('id', $id)
                ->update([
                    'perihal'=>$perihal, 
                    'deskripsi'=>$deskripsi,
                    'peserta'=>$peserta, 
                    'id_lokasi'=>$lokasi, 
                    'tgl_mulai'=>$tgl_mulai,
                    'tgl_selesai'=>$tgl_selesai, 
                    'jam_mulai'=>$jam_mulai, 
                    'jam_selesai'=>$jam_selesai,
                    'file'=>"$file_name"]);
        }else{
            // $file_name = $validatedData['file'];
            $edit2 = DB::table('agenda')->where('id', $id)
                ->update([
                    'perihal'=>$perihal, 
                    'deskripsi'=>$deskripsi,
                    'peserta'=>$peserta, 
                    'id_lokasi'=>$lokasi, 
                    'tgl_mulai'=>$tgl_mulai,
                    'tgl_selesai'=>$tgl_selesai, 
                    'jam_mulai'=>$jam_mulai, 
                    'jam_selesai'=>$jam_selesai]);
        }

        if($edit1 || $edit2){
            $period = CarbonPeriod::create($tgl_mulai, $tgl_selesai);
            DB::table('pemakaian')->where('id', $id)
                            ->delete();
                    if ($data->dl == 'dalam'){
                        foreach ($period as $date) {
                            DB::table('pemakaian')->insert([
                                'id'=>$id,
                                'tgl_pemakaian'=>$date->format('Y-m-d'),
                                'id_lokasi'=>$lokasi,
                                'jam_mulai'=>$jam_mulai,
                                'jam_selesai'=>$js
                                ]);
                        }
                }
            return redirect()->action([AgendaController::class, 'index'])->with('esuccess', 'Agenda Berhasil Ditambahkan');
        }
        else{
            return redirect()->action([AgendaController::class, 'index'])->with('eerror', 'Agenda Gagal Ditambahkan');
        }
    }

    public function tampilan_tv()
    {
        $agenda = DB::table('agenda')->orderBy('agenda.tgl_mulai', 'asc')
                    ->join('lokasi', 'agenda.id_lokasi', '=', 'lokasi.id_lokasi')
                    ->whereDate('tgl_selesai', '>=', Carbon::now())
                    ->get();
        return view('tv', ['agenda'=>$agenda]);
    }

    public function fetchdata()
    {
        $agenda = DB::table('agenda')->orderBy('agenda.tgl_mulai', 'asc')
                    ->join('lokasi', 'agenda.id_lokasi', '=', 'lokasi.id_lokasi')
                    ->whereDate('tgl_selesai', '>=', Carbon::now())
                    ->get();

        return response()->json([
            'agenda'=>$agenda,
        ]);
    }

    public function get_status()
    {
        $agenda = DB::table('pemakaian')
                    ->join('lokasi', 'pemakaian.id_lokasi', '=', 'lokasi.id_lokasi')
                    ->where('lokasi.posisi', '=', 0)
                    ->get();
        return response()->json([
            'status'=>$agenda
        ]);
    }
    public function get_status_edit($id)
    {
        $agenda = DB::table('pemakaian')
                    ->join('lokasi', 'pemakaian.id_lokasi', '=', 'lokasi.id_lokasi')
                    ->where('lokasi.posisi', '=', 0)
                    ->where('pemakaian.id', '!=', $id)
                    ->get();
        return response()->json([
            'status'=>$agenda
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapus = DB::table('agenda')->where('id', $id)
                            ->delete();
        if($hapus){
            return redirect()->back()->with('dsuccess', 'Agenda Berhasil Dihapus');
        }
        else{
            return redirect()->back()->with('derror', 'Agenda Gagal Dihapus');
        }
    }
}
