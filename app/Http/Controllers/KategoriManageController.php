<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Acces;
use App\Kategori;
use Illuminate\Http\Request;

class KategoriManageController extends Controller
{
    // View Kategori
    public function viewKategori()
    {
        $id_account = Auth::id();
        $check_access = Acces::where('id_user', $id_account)
            ->first();
        if ($check_access->kelola_barang == 1) {
            $kategoris = Kategori::all();

            return view('manage_product.kategori', compact('kategoris'));
        } else {
            return back();
        }
    }

    // Create Kategori
    public function createKategori(Request $req)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('id_user', $id_account)
            ->first();
        if ($check_access->kelola_barang == 1) {

            $check_kategori = Kategori::where('nama_kategori', $req->nama_kategori)
                ->count();

            if ($check_kategori == 0) {
                $kategori = new Kategori;
                $kategori->nama_kategori = $req->nama_kategori;
                $kategori->save();

                Session::flash('create_success', 'Kategori baru berhasil ditambahkan');

                return redirect('/kategori');
            } else {
                Session::flash('create_failed', 'Kategori telah digunakan');

                return back();
            }
        } else {
            return back();
        }
    }


    // Edit Kategori
    public function editKategori($id)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('id_user', $id_account)
            ->first();
        if ($check_access->kelola_barang == 1) {
            $kategori = Kategori::find($id);

            return response()->json(['kategori' => $kategori]);
        } else {
            return back();
        }
    }

    // Update Kategori
    public function updateKategori(Request $req)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('id_user', $id_account)
            ->first();
        if ($check_access->kelola_barang == 1) {
            $kategori = Kategori::find($req->id);
            $kategori->nama_kategori = $req->nama_kategori_edit;
            $kategori->save();
            Session::flash('update_success', 'Data kategori berhasil diubah');

            return redirect('/kategori');
        } else {
            return back();
        }
    }

    // Delete Kategori
    public function deleteKategori($id)
    {
        $id_account = Auth::id();
        $check_access = Acces::where('id_user', $id_account)
            ->first();
        if ($check_access->kelola_barang == 1) {
            Kategori::destroy($id);

            Session::flash('delete_success', 'Barang berhasil dihapus');

            return back();
        } else {
            return back();
        }
    }
}
