<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\User;
use App\Acces;
use App\Supply;
use App\Product;
use App\Kategori;
use App\Transaction;
use Illuminate\Http\Request;

class SearchManageController extends Controller
{
	// Search Page Feature
	public function searchPage($word)
	{
		$access = Acces::join('users', 'users.id', '=', 'akses.id_user')
			->select('akses.*', 'users.*')
			->get();
		$transactions = Transaction::all();
		$kode_transaksi_distinct = Transaction::select('kode_transaksi')
			->distinct()
			->get();
		$products = Product::join('kategori', 'produk.id_kategori', '=', 'kategori.id')->select('produk.*', 'kategori.nama_kategori')->get();
		$supplies = Supply::all();
		$kategoris = Kategori::all();
		$accounts = User::all();
		$kode_transaksi_dis = Transaction::select('kode_transaksi')
			->distinct()
			->get();
		$kode_transaksi_dis_daily = Transaction::whereDate('created_at', Carbon::now())
			->select('kode_transaksi')
			->distinct()
			->get();
		$all_incomes = 0;
		$incomes_daily = 0;
		foreach ($kode_transaksi_dis as $kode) {
			$transaksi = Transaction::where('kode_transaksi', $kode->kode_transaksi)->first();
			$all_incomes += $transaksi->total;
		}
		foreach ($kode_transaksi_dis_daily as $kode) {
			$transaksi_daily = Transaction::where('kode_transaksi', $kode->kode_transaksi)->first();
			$incomes_daily += $transaksi_daily->total;
		}
		$customers_daily = count($kode_transaksi_dis_daily);
		$min_date = Transaction::min('created_at');
		$max_date = Transaction::max('created_at');
		$kd_transaction = Transaction::select('kode_transaksi')
			->latest()
			->distinct()
			->take(5)
			->get();
		$transactions = Transaction::all();
		$array = array();
		foreach ($transactions as $no => $transaction) {
			array_push($array, $transactions[$no]->created_at->toDateString());
		}
		$dates = array_unique($array);
		rsort($dates);

		$arr_ammount = count($dates);
		$incomes_data = array();
		if ($arr_ammount > 7) {
			for ($i = 0; $i < 7; $i++) {
				array_push($incomes_data, $dates[$i]);
			}
		} elseif ($arr_ammount > 0) {
			for ($i = 0; $i < $arr_ammount; $i++) {
				array_push($incomes_data, $dates[$i]);
			}
		}
		$incomes = array_reverse($incomes_data);

		// Dashboard Content
		$dashboard_content = 'Dashboard => Pendapatan Harian : Rp. ' . number_format($incomes_daily, 2, ',', '.') . ', Pelanggan Harian : ' . $customers_daily . ' Orang, Total Pemasukan : Rp. ' . number_format($all_incomes, 2, ',', '.') . ' (' . date('d M, Y', strtotime($min_date)) . ' - ' . date('d M, Y', strtotime($max_date)) . ') ';
		// foreach ($kd_transaction as $kode) {
		// 	$ket_transaksi = Transaction::join('users', 'transaksi.id_user', '=', 'users.id')->where('kode_transaksi', $kode->kode_transaksi)
		// 		->first();
		// 	$dashboard_content .= 'Riwayat Transaksi Terbaru : (Kode Transaksi : ' . $kode->kode_transaksi . ', Total : ' . number_format($ket_transaksi->total, 2, ',', '.') . ', Kasir : ' . $ket_transaksi->nama . ', Waktu : ' . Carbon::parse($ket_transaksi->created_at)->diffForHumans() . ') ';
		// }
		// Account Content
		$account_content = 'Daftar Akun => ';
		foreach ($accounts as $account) {
			$account_content .= ' (Nama : ' . $account->nama . ', Email : ' . $account->email . ', Posisi : ' . $account->role . ')';
		}
		// New Account
		$new_account_content = 'Daftar Akun | Akun Baru : Foto Profil, Nama, Email, Username, Password, dan Posisi';
		$access_content = 'Hak Akses => ';
		foreach ($access as $acces) {
			$access_content .= ' (Nama : ' . $acces->nama . ', Kelola Akun : ' . $acces->kelola_akun . ', Kelola Barang : ' . $acces->kelola_barang . ', Transaksi : ' . $acces->transaksi . ', Kelola Laporan : ' . $acces->kelola_laporan . ')';
		}
		// Kategori
		$kategori_content = 'Daftar Kategori => kategori : ';
		foreach ($kategoris as $kategori) {
			$kategori_content .= ' (Id Kategori : ' . $kategori->id . ', Nama Barang : ' . $kategori->nama_kategori . ')';
		}
		// New Kategori
		$new_kategori_content = 'Daftar Kategori | Kategori Baru : Nama kategori';
		// Product
		$product_content = 'Daftar Barang => Barang : ';
		foreach ($products as $product) {
			$product_content .= ' (Kode Barang : ' . $product->kode_barang . ', Kategori : ' . $product->nama_kategori . ', Nama Barang : ' . $product->nama_barang . ', Stok : ' . $product->stok . ', Harga : Rp. ' . number_format($product->harga, 2, ',', '.') . ', Keterangan : ' . $product->keterangan . ')';
		}
		// New Product
		$new_prpduct_content = 'Daftar Barang | Barang Baru : Kode Barang, Nama Barang, Jenis Barang, Berat Barang, Merek Barang, Stok Barang, Harga Barang';
		// Supply
		$supply_content = 'Riwayat Pasok => ';
		foreach ($supplies as $supply) {
			$supply_content .= ' (Tanggal : ' . $supply->created_at . ')';
		}
		// New Supply
		$new_supply_content = 'Riwayat Pasok | Pasok Barang : Kode Barang, Jumlah Barang,Harga Satuan, dan Total';
		// Transaksi
		$transaksi_content = 'Transaksi => Daftar Pesanan, Tanggal Transaksi, Waktu, Kasir, Subtotal, Diskon, Total, Nominal Bayar dan Kembali';
		// Laporan Transaksi
		$laporan_transaksi_content = 'Laporan | Laporan Transaksi => Statistik Pemasukan : Rp. ' . number_format($transactions->sum('total'), 2, ',', '.') . ' ->';
		foreach ($kode_transaksi_distinct as $transaksi) {
			$transaksi_data = Transaction::where('kode_transaksi', $transaksi->kode_transaksi)->first();
			$laporan_transaksi_content .= ' (Kode Transaksi : ' . $transaksi_data->kode_transaksi . ', Total : Rp. ' . number_format($transaksi_data->total, 2, ',', '.') . ', Bayar : Rp. ' . number_format($transaksi_data->bayar, 2, ',', '.') . ', Kembali : Rp. ' . number_format($transaksi_data->kembali, 2, ',', '.') . ')';
		}
		// Laporan Pegawai
		$laporan_pegawai_content = 'Laporan | Laporan Pegawai => ';
		foreach ($accounts as $account) {
			$transaction_activity = Transaction::where('id_user', $account->id)->select('kode_transaksi')->distinct()->get();
			$supply_activity = Supply::where('id_user', $account->id)->count();
			$laporan_pegawai_content .= ' (Aktivitas Pasok : ' . $supply_activity . ', Aktivitas Transaksi : ' . $transaction_activity->count() . ')';
		}

		$page_array = array();
		$access = Acces::where('id_user', Auth::id())
			->first();
		$number_array = 0;
		$page_array[$number_array] = array(
			'page_name' => 'Dashboard',
			'page_url' => 'dashboard',
			'page_title' => 'Dashboard',
			'page_content' => $dashboard_content
		);
		$number_array += 1;
		if ($access->kelola_akun == true) {
			$page_array[$number_array] = array(
				'page_name' => 'Daftar Akun',
				'page_url' => 'account',
				'page_title' => 'Daftar Akun',
				'page_content' => $account_content
			);
			$number_array += 1;
			$page_array[$number_array] = array(
				'page_name' => 'Akun Baru',
				'page_url' => 'account/new',
				'page_title' => 'Daftar Akun > Akun Baru',
				'page_content' => $new_account_content
			);
			$number_array += 1;
			$page_array[$number_array] = array(
				'page_name' => 'Hak Akses',
				'page_url' => 'access',
				'page_title' => 'Hak Akses',
				'page_content' => $access_content
			);
			$number_array += 1;
		}
		if ($access->kelola_barang == true) {
			$page_array[$number_array] = array(
				'page_name' => 'Daftar Kategori',
				'page_url' => 'kategori',
				'page_title' => 'Daftar Kategori',
				'page_content' => $kategori_content
			);
			$number_array += 1;
			$page_array[$number_array] = array(
				'page_name' => 'Kategori Baru',
				'page_url' => 'kategori/new',
				'page_title' => 'Daftar Kategori > Kategori Baru',
				'page_content' => $new_kategori_content
			);
			$number_array += 1;
			$page_array[$number_array] = array(
				'page_name' => 'Daftar Barang',
				'page_url' => 'product',
				'page_title' => 'Daftar Barang',
				'page_content' => $product_content
			);
			$number_array += 1;
			$page_array[$number_array] = array(
				'page_name' => 'Barang Baru',
				'page_url' => 'product/new',
				'page_title' => 'Daftar Barang > Barang Baru',
				'page_content' => $new_prpduct_content
			);
			$number_array += 1;
			$page_array[$number_array] = array(
				'page_name' => 'Riwayat Pasok',
				'page_url' => 'supply',
				'page_title' => 'Riwayat Pasok',
				'page_content' => $supply_content
			);
			$number_array += 1;
			$page_array[$number_array] = array(
				'page_name' => 'Pasok Barang',
				'page_url' => 'supply/new',
				'page_title' => 'Riwayat Pasok > Pasok Barang',
				'page_content' => $new_supply_content
			);
			$number_array += 1;
		}
		if ($access->transaksi == true) {
			$page_array[$number_array] = array(
				'page_name' => 'Transaksi',
				'page_url' => 'transaction',
				'page_title' => 'Transaksi',
				'page_content' => $transaksi_content
			);
			$number_array += 1;
		}
		if ($access->kelola_laporan == true) {
			$page_array[$number_array] = array(
				'page_name' => 'Laporan Transaksi',
				'page_url' => 'report/transaction',
				'page_title' => 'Laporan Transaksi',
				'page_content' => $laporan_transaksi_content
			);
			$number_array += 1;
			$page_array[$number_array] = array(
				'page_name' => 'Laporan Pegawai',
				'page_url' => 'report/workers',
				'page_title' => 'Laporan Pegawai',
				'page_content' => $laporan_pegawai_content
			);
			$number_array += 1;
		}

		$data_trash = array();
		$data_result = array();
		$number = 0;
		for ($i = 0; $i < count($page_array); $i++) {
			if (stripos($page_array[$i]['page_content'], $word) === FALSE) {
				$data_trash[$number] = array(
					'page_name' => $page_array[$i]['page_name'],
					'page_url' => $page_array[$i]['page_url'],
					'page_title' => $page_array[$i]['page_title'],
					'page_content' => $page_array[$i]['page_content']
				);
			} else {
				$data_result[$number] = array(
					'page_name' => $page_array[$i]['page_name'],
					'page_url' => $page_array[$i]['page_url'],
					'page_title' => $page_array[$i]['page_title'],
					'page_content' => $page_array[$i]['page_content']
				);
				$number += 1;
			}
		}

		return response()->json($data_result);
	}
}
