<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ $tanggal }}_PENJUALAN</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <style type="text/css" media="screen">
            html {
                font-family: sans-serif;
                line-height: 1.15;
                margin: 0;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                font-weight: 400;
                line-height: 1.5;
                color: #212529;
                text-align: left;
                background-color: #fff;
                font-size: 10px;
                margin: 36pt;
            }

            h4 {
                margin-top: 0;
                margin-bottom: 0.5rem;
            }

            p {
                margin-top: 0;
                margin-bottom: 1rem;
            }

            strong {
                font-weight: bolder;
            }

            img {
                vertical-align: middle;
                border-style: none;
            }

            table {
                border-collapse: collapse;
            }

            th {
                text-align: inherit;
            }

            h4, .h4 {
                margin-bottom: 0.5rem;
                font-weight: 500;
                line-height: 1.2;
            }

            h4, .h4 {
                font-size: 1.5rem;
            }

            .table {
                width: 100%;
                margin-bottom: 1rem;
                color: #212529;
            }

            .table th,
            .table td {
                padding: 0.75rem;
                vertical-align: top;
            }

            .table.table-items td {
                border-top: 1px solid #dee2e6;
            }

            .table thead th {
                vertical-align: bottom;
                border-bottom: 2px solid #dee2e6;
            }

            .mt-5 {
                margin-top: 3rem !important;
            }

            .pr-0,
            .px-0 {
                padding-right: 0 !important;
            }

            .pl-0,
            .px-0 {
                padding-left: 0 !important;
            }

            .text-right {
                text-align: right !important;
            }

            .text-center {
                text-align: center !important;
            }

            .text-uppercase {
                text-transform: uppercase !important;
            }
            * {
                font-family: "DejaVu Sans";
            }
            body, h1, h2, h3, h4, h5, h6, table, th, tr, td, p, div {
                line-height: 1.1;
            }
            .party-header {
                font-size: 1.5rem;
                font-weight: 400;
            }
            .total-amount {
                font-size: 12px;
                font-weight: 700;
            }
            .border-0 {
                border: none !important;
            }
            .cool-gray {
                color: #6B7280;
            }
        </style>
    </head>

    <body>
        {{-- Header --}}
        <h1>Apotek Berkah</h1>

        <h2>Penjualan {{ $tanggal }}</h2>

        {{-- Table --}}
        <table class="table table-items">
            <thead>
                <tr>
                    <th scope="col" class="border-0 pl-0">ID</th>
                    <th scope="col" class="text-center border-0">No Faktur</th>
                    <th scope="col" class="text-right border-0">Tanggal</th>
                    <th scope="col" class="text-right border-0">Sub total</th>
                    <th scope="col" class="text-right border-0">Tipe</th>
                </tr>
            </thead>
            <tbody>
                {{-- Items --}}
                @foreach($penjualan as $index => $item)
                <tr>
                    <td class="pl-0">
                        {{ $item['penjualan_id'] }}
                    </td>
                    <td class="text-center">{{ $item['no_faktur'] }}</td>
                    <td class="text-right">{{ $item['tanggal'] }}</td>
                    <td class="text-right">
                        Rp. {{ number_format($item['jumlah']) }}
                    </td>
                    <td class="text-right">
                        @if ($item['tipe'] == 'Resep')
                            <p>Resep</p>
                            <p>Nama Dokter: {{ $item['nama_dokter'] ?? '' }}</p>
                            <p>Nama Pelanggan: {{ $item['nama_pelanggan'] ?? '' }}</p>
                        @else
                            <p>Non Resep</p>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Total : Rp. {{ number_format($penjualan->sum('jumlah')) }}</h2>
    </body>
</html>