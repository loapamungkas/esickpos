<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use Session;
use Carbon\Carbon;
use App\Acces;
use App\Supply;
use App\Product;
use Illuminate\Http\Request;

class SupplyManageController extends Controller
{
    // Show View Supply
    public function viewSupply()
    {
        $id_account = Auth::id();
        $check_access = Acces::where('id_user', $id_account)
            ->first();
        if ($check_access->kelola_barang == 1) {
            $supplies = Supply::all();
            // $supplies = Supply::select('pasok.*')->latest()->take(5)->get();
            $array = array();
            foreach ($supplies as $no => $supply) {
                array_push($array, $supplies[$no]->created_at->toDateString());
            }
            $dates = array_unique($array);
            rsort($dates);

            return view('manage_product.supply_product.supply', compact('dates'));
        } else {
            return back();
        }
    }


    // Show View New Supply
    public function viewNewSupply()
    {
        $id_account = Auth::id();
        $check_access = Acces::where('id_user', $id_account)
            ->first();
        if ($check_access->kelola_barang == 1) {
            $products = Product::all()
                ->sortBy('kode_barang');

            return view('manage_product.supply_product.new_supply', compact('products'));
        } else {
            return back();
        }
    }

    // Check Supply Data
    public function checkSupplyCheck($id)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('id_user', $id_account)
            ->first();
        if ($check_access->kelola_barang == 1) {
            $check_product = Product::where('id', $id)
                ->count();

            if ($check_product != 0) {
                echo "sukses";
            } else {
                echo "gagal";
            }
        } else {
            return back();
        }
    }

    // Take Supply Data
    public function checkSupplyData($id)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('id_user', $id_account)
            ->first();

        if ($check_access->kelola_barang == 1) {
            $product = Product::where('id', $id)
                ->first();

            return response()->json(['product' => $product]);
        } else {
            return back();
        }
    }

    // Create New Supply
    public function createSupply(Request $req)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('id_user', $id_account)
            ->first();
        if ($check_access->kelola_barang == 1) {
            $jumlah_data = 0;
            foreach ($req->kode_barang_supply as $no => $id_barang) {
                $product_status = Product::where('id', $id_barang)
                    ->first();
                if ($product_status->stok == 0) {
                    $product_status->keterangan = 'Tersedia';
                    $product_status->save();
                }

                $supply = new Supply;
                $supply->id_barang = $id_barang;
                $supply->jumlah = $req->jumlah_supply[$no];
                $supply->id_user = Auth::id();
                $supply->save();
                $jumlah_data += 1;
            }
            Session::flash('create_success', 'Barang berhasil dipasok');

            return redirect('/supply');
        } else {
            return back();
        }
    }


    // Export Supply Report
    public function exportSupply(Request $req)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('id_user', $id_account)
            ->first();
        if ($check_access->kelola_barang == 1) {
            $jenis_laporan = $req->jns_laporan;
            $current_time = Carbon::now()->isoFormat('Y-MM-DD') . ' 23:59:59';
            if ($jenis_laporan == 'period') {
                if ($req->period == 'minggu') {
                    $last_time = Carbon::now()->subWeeks($req->time)->isoFormat('Y-MM-DD') . ' 00:00:00';
                    $supplies = Supply::select('pasok.*')
                        ->whereBetween('created_at', array($last_time, $current_time))
                        ->get();
                    $array = array();
                    foreach ($supplies as $no => $supply) {
                        array_push($array, $supplies[$no]->created_at->toDateString());
                    }
                    $dates = array_unique($array);
                    rsort($dates);
                    $tgl_awal = $last_time;
                    $tgl_akhir = $current_time;
                } elseif ($req->period == 'bulan') {
                    $last_time = Carbon::now()->subMonths($req->time)->isoFormat('Y-MM-DD') . ' 00:00:00';
                    $supplies = Supply::select('pasok.*')
                        ->whereBetween('created_at', array($last_time, $current_time))
                        ->get();
                    $array = array();
                    foreach ($supplies as $no => $supply) {
                        array_push($array, $supplies[$no]->created_at->toDateString());
                    }
                    $dates = array_unique($array);
                    rsort($dates);
                    $tgl_awal = $last_time;
                    $tgl_akhir = $current_time;
                } elseif ($req->period == 'tahun') {
                    $last_time = Carbon::now()->subYears($req->time)->isoFormat('Y-MM-DD') . ' 00:00:00';
                    $supplies = Supply::select('pasok.*')
                        ->whereBetween('created_at', array($last_time, $current_time))
                        ->get();
                    $array = array();
                    foreach ($supplies as $no => $supply) {
                        array_push($array, $supplies[$no]->created_at->toDateString());
                    }
                    $dates = array_unique($array);
                    rsort($dates);
                    $tgl_awal = $last_time;
                    $tgl_akhir = $current_time;
                }
            } else {
                $start_date = $req->tgl_awal_export;
                $end_date = $req->tgl_akhir_export;
                $start_date2 = $start_date[6] . $start_date[7] . $start_date[8] . $start_date[9] . '-' . $start_date[3] . $start_date[4] . '-' . $start_date[0] . $start_date[1] . ' 00:00:00';
                $end_date2 = $end_date[6] . $end_date[7] . $end_date[8] . $end_date[9] . '-' . $end_date[3] . $end_date[4] . '-' . $end_date[0] . $end_date[1] . ' 23:59:59';
                $supplies = Supply::select('pasok.*')
                    ->whereBetween('created_at', array($start_date2, $end_date2))
                    ->get();
                $array = array();
                foreach ($supplies as $no => $supply) {
                    array_push($array, $supplies[$no]->created_at->toDateString());
                }
                $dates = array_unique($array);
                rsort($dates);
                $tgl_awal = $start_date2;
                $tgl_akhir = $end_date2;
            }
            return view('manage_product.supply_product.export_report_supply', compact('dates', 'tgl_awal', 'tgl_akhir'));
        } else {
            return back();
        }
    }
}
