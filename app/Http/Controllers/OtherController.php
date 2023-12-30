<?php

namespace App\Http\Controllers;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\JenisSurat;
use App\Models\Instansi;
use App\Models\MasterASN;
use App\Models\FileTte;
use Illuminate\Http\Request;
use Auth;
class OtherController extends Controller
{
	public function getProvinsi(Request $request)
	{
		$data = Provinsi::all();
		return response()->json($data);
	}

	public function getKabupaten(Request $request)
	{
		// return $request->all();
		$data = Kabupaten::where('provinsi_id', $request->id)->get();
		return response()->json($data);
	}

	public function getKecamatan(Request $request)
	{
		// return $request->all();
		$data = Kecamatan::where('kabupaten_id', $request->id)->get();
		return response()->json($data);
	}

	public function getDesa(Request $request)
	{
		// return $request->all();
		$data = Desa::where('kecamatan_id', $request->id)->get();
		return response()->json($data);
	}
	public function getInstansi(Request $request)
	{
		// return $request->all();
		$data = Instansi::where('kode_instansi', $request->id)->get();
		return response()->json($data);
	}
	public function getInstansiById(Request $request)
	{
		// return $request->all();
		$data = Instansi::findOrFail($request->id);
		return response()->json($data);
	}
	public function getJenisSurat(Request $request)
	{
		// return $request->all();
		$data = JenisSurat::where('kode_jenis_surat', $request->id)->first();
		return response()->json($data);
	}
	public function getJenisSuratById(Request $request)
	{
		// return $request->all();
		$data = JenisSurat::findOrFail($request->id);
		return response()->json($data);
	}
	public function getAsnByKategori(Request $request)
	{
		$data = MasterASN::where('jabatan',$request->id)->get();
		return response()->json($data);
	}
	public function getAsnByName(Request $request)
	{
		$key = $request->id;
		$data = MasterASN::where('nama_asn','like',"%$key%")->orWhere('nip','like',"%$key%")->get();
		return response()->json($data);
	}
	public function getAsnByLevel(Request $request)
	{
		$data = MasterASN::with('users')->whereRelation('users','level_user',$request->id)->get();
		return response()->json($data);
	}
	// public function getInstansiByName(Request $request)
	// {
	// 	$key = $request->id;
	// 	$data = Instansi::where('kode_instansi','like',"%$key%")
    //                     ->orWhere('nama_instansi','like',"%$key%")
    //                     ->get();
	// 	return response()->json($data);
	// }
    public function getInstansiByName(Request $request)
    {
        $key = $request->id;
        $data = Instansi::whereRaw('LOWER(kode_instansi) LIKE ? OR LOWER(nama_instansi) LIKE ?', ["%".strtolower($key)."%", "%".strtolower($key)."%"])->get();
        return response()->json($data);
    }

	public function test(Request $request)
	{
		$pdf_base64 = $request->pdfData;
		$pdf_name = $request->pdfName;
        // return $request->case;
        if($request->case=="watermark"){
			// return 'non';
            $pdfData = file_put_contents(public_path().'\storage/surat-tte/'.date("H i s").'-'.$pdf_name, base64_decode($pdf_base64));

            return $store = FileTte::create([
                'nama_surat'        => $pdf_name,
                'tanggal_surat'     => date('Y-m-d'),
                'penanda_tangan_id' => Auth::user()->id,
                'file_surat'		=> date("H i s").'-'.$pdf_name,
                'file_surat_salinan'=> date("H i s").'-'.$pdf_name,
            ]);
        }else{
			// return 'water';
            return $pdfData = file_put_contents(public_path().'\storage/surat-tte-salinan/'.date("H i s").'-'.$pdf_name, base64_decode($pdf_base64));
        }
		// return $pdfData = file_put_contents(public_path().'\storage/surat-tte-salinan/'.date("H i s").'-'.$pdf_name, base64_decode($pdf_base64));

		// $pdfData = file_put_contents(public_path().'\storage/surat-tte/'.date("H i s").'-'.$pdf_name, base64_decode($pdf_base64));
		// $pdfData = file_put_contents(public_path().'\storage/surat-tte-salinan/'.date("H i s").'-'.$pdf_name, base64_decode($pdf_base64));
		// $store = FileTte::create([
		// 	'nama_surat'        => $pdf_name,
		// 	'tanggal_surat'     => date('Y-m-d'),
		// 	'penanda_tangan_id' => Auth::user()->id,
		// 	'file_surat'		=> date("H i s").'-'.$pdf_name,
		// 	'file_surat_salinan'=> date("H i s").'-'.$pdf_name,
		// ]);
		//decode untuk ekstrak string base64 menjadi file

		// dd(base64_decode($pdf_base64));storeAs('public/surat-masuk/',$filename);
		// Storage::disk('local')->put($pdf_name,content'public/surat-masuk/');
		// dd(['nama_surat' => $request->all()]);
	}
}
