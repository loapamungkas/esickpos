@foreach($products as $product)
<tr>
  <td>
    <span class="kd-barang-field">{{ $product->kode_barang }}</span>
  </td>
  <td>
    <span class="nama-barang-field">{{ $product->nama_barang }}</span>
  </td>
  <td>{{ $product->nama_kategori }}</td>
  <td>{{$product->stok }}</td>
  {{-- <span class="ammount-box bg-secondary"><i class="mdi mdi-cube-outline"></i></span> --}}
  {{-- <span class="ammount-box bg-green"><i class="mdi mdi-coin"></i></span> --}}
  <td>Rp. {{
    number_format($product->harga,2,',','.') }}</td>
  <td>
    @if($product->keterangan == 'Tersedia')
    <span class="btn tersedia-span">{{ $product->keterangan }}</span>
    @else
    <span class="btn habis-span">{{ $product->keterangan }}</span>
    @endif
  </td>
  <td>
    <button type="button" class="btn btn-edit btn-icons btn-rounded btn-secondary" data-toggle="modal"
      data-target="#editModal" data-edit="{{ $product->id }}">
      <i class="mdi mdi-pencil"></i>
    </button>
    <button type="button" class="btn btn-icons btn-rounded btn-secondary ml-1 btn-delete"
      data-delete="{{ $product->id }}">
      <i class="mdi mdi-close"></i>
    </button>
  </td>
</tr>
@endforeach