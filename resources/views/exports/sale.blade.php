<body>
    <table>
        <tr>
            @if ($startDate && $endDate)
            <td colspan="5">Laporan penjualan {{ $startDate->locale('id')->isoFormat('dddd, Do MMMM YYYY') }} hingga {{
                $endDate->locale('id')->isoFormat('dddd, Do MMMM YYYY')}}</td>
            @else
            <td colspan="5">seluruh Laporan penjualan </td>
            @endif
        </tr>
        <tr>
            <td colspan="5">Daftar Transaksi :</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th scope="col" class="px-6 py-3">
                    #
                </th>
                <th scope="col" class="px-6 py-3">
                    total transaksi
                </th>
                <th scope="col" class="px-6 py-3">
                    total barang
                </th>
                <th scope="col" class="px-6 py-3">
                    tanggal transaksi
                </th>

            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $data)
            <tr>
                <th scope="row">
                    {{ $loop->index +1 }}
                </th>
                <td class="px-6 py-4">
                    {{ Number::currency($data->grand_total, 'IDR', 'id') }}
                </td>
                <td class="px-6 py-4">
                    @php
                    $total = 0;
                    foreach($data->saleDetails as $detail){
                    $total += $detail->quantity;
                    }
                    @endphp

                    {{ $total }}
                </td>
                <td class="px-6 py-4">
                    {{ $data->created_at->locale('id')->isoFormat('dddd, Do MMMM YYYY, h:mm') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <table>
        <tr>
            <td colspan="5">Daftar produk terjual :</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th scope="col">
                    #
                </th>
                <th scope="col">
                    nama produk
                </th>
                <th scope="col">
                    unit terjual
                </th>
                <th scope="col">
                    unit terjual
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)

            <tr>
                <th scope="row">
                    {{ $loop->index + 1 }}
                </th>
                <td>
                    {{ $product['name'] }}
                </td>
                <td>
                    {{ $product['quantity'] }}
                </td>
                <td>
                    {{ $product['quantity'] * $product['price'] }}
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>


    <table>
        <tr>
            <td colspan="2">jumlah penjualan</td>
            <td colspan="2">{{ $sales->count() }}</td>
        </tr>
        <tr>
            <td colspan="2">produk terjual </td>
            <td colspan="2">{{ Number::format($products->sum('quantity'), 0, 0, 'id-ID') }}</td>

        </tr>
        <tr>
            <td colspan="2">Total Pendapatan </td>
            <td colspan="2">{{ Number::currency($sales->sum('grand_total'),
                'IDR',
                'id')
                }} </td>
        </tr>
    </table>


</body>

</html>