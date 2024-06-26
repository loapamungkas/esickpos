<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use Session;
use App\Acces;
use App\Product;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionManageController extends Controller
{
    // Show View Transaction
    public function viewTransaction()
    {
        $id_account = Auth::id();
        $check_access = Acces::where('id_user', $id_account)
            ->first();
        if ($check_access->transaksi == 1) {
            $products = Product::all()
                ->sortBy('kode_barang');

            return view('transaction.transaction', compact('products'));
        } else {
            return back();
        }
    }

    // Take Transaction Product
    public function transactionProduct($id)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('id_user', $id_account)
            ->first();
        if ($check_access->transaksi == 1) {
            $product = Product::where('id', '=', $id)
                ->first();

            $status = 1;

            return response()->json([
                'product' => $product,
                'status' => $status
            ]);
        } else {
            return back();
        }
    }

    // Check Transaction Product
    public function transactionProductCheck($id)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('id_user', $id_account)
            ->first();
        if ($check_access->transaksi == 1) {
            $product_check = Product::where('id', '=', $id)
                ->count();

            if ($product_check != 0) {
                $product = Product::where('id', '=', $id)
                    ->first();
                $status = 1;
                $check = "tersedia";
            } else {
                $product = '';
                $status = '';
                $check = "tidak tersedia";
            }

            return response()->json([
                'product' => $product,
                'status' => $status,
                'check' => $check
            ]);
        } else {
            return back();
        }
    }

    // Transaction Process
    public function transactionProcess(Request $req)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('id_user', $id_account)
            ->first();
        if ($check_access->transaksi == 1) {
            $jml_barang = count($req->id_barang);
            for ($i = 0; $i < $jml_barang; $i++) {
                $transaction = new Transaction;
                $transaction->kode_transaksi = $req->kode_transaksi;

                $transaction->id_barang = $req->id_barang[$i];

                $transaction->jumlah = $req->jumlah_barang[$i];
                $transaction->total_barang = $req->total_barang[$i];
                $transaction->subtotal = $req->subtotal;
                $transaction->diskon = $req->diskon;
                $transaction->total = $req->total;
                $transaction->bayar = $req->bayar;
                $transaction->kembali = $req->bayar - $req->total;
                $transaction->id_user = Auth::id();
                $transaction->save();
            }

            for ($j = 0; $j < $jml_barang; $j++) {
                $product = Product::where('id', '=', $req->id_barang[$j])
                    ->first();
                $product->stok = $product->stok - $req->jumlah_barang[$j];
                $product->save();
                $product_status = Product::where('id', '=', $req->id_barang[$j])
                    ->first();
                if ($product_status->stok == 0) {
                    $product_status->keterangan = 'Habis';
                    $product_status->save();
                }
            }
            Session::flash('transaction_success', $req->kode_transaksi);

            return back();
        } else {
            return back();
        }
    }

    // Transaction Receipt
    public function receiptTransaction($id)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('id_user', $id_account)
            ->first();
        if ($check_access->transaksi == 1) {
            $transaction = Transaction::join('users', 'transaksi.id_user', '=', 'users.id')
                ->where('transaksi.kode_transaksi', '=', $id)
                ->select('transaksi.*', 'users.*')
                ->first();
            $transactions = Transaction::where('transaksi.kode_transaksi', '=', $id)
                ->join('produk', 'transaksi.id_barang', '=', 'produk.id')
                ->select('transaksi.*', 'produk.*')
                ->get();
            $diskon = $transaction->subtotal * $transaction->diskon / 100;

            $customPaper = array(0, 0, 400.00, 283.80);
            $pdf = PDF::loadview('transaction.receipt_transaction', compact('transaction', 'transactions', 'diskon'))->setPaper($customPaper, 'landscape');
            return $pdf->stream();
        } else {
            return back();
        }
    }
}
