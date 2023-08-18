<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ $tanggal }}_ORDER</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <style type="text/css" media="screen">
            html {
                font-family: sans-serif;
                font-size: 4px;
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
                vertical-align: top;
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
                font-size: 1rem;
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
            h1 {
                font-size: 4rem;
            }
            h2 {
                font-size: 2rem;
            }
        </style>
    </head>

    <body>
        {{-- <p class="text-right">{{ $name }} - {{ $now }}</p> --}}
        {{-- Header --}}
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">
                        <h1>Apotek Berkah</h1>
                        <h5>SIA: 503/0021.29/BPPT</h5>
                        <p>JL. RAYA GEGESIK - JAGAPURA<br>
                        GEGESIK - CIREBON<br>
                        HP. 0831 2087 2687</p>
                    </th>
                    <th scope="col" class="text-right">
                        <h2>Date {{ $tanggal }}</h2>
                        <br>
                        <br>
                        <br>
                        <br>
                        <p>
                            Supplier: {{ $request->orderList[0]->medicine->suppliers ?? '-' }}
                        </p>
                    </th>
                </tr>
            </thead>
        </table>

        {{-- Table --}}
        <table class="table table-items">
            <thead>
                <tr>
                    <th scope="col" class="border-0 pl-0">Nama Barang</th>
                    <th scope="col" class="text-center border-0">Jumlah</th>
                    {{-- <th scope="col" class="text-right border-0">Jenis</th>
                    <th scope="col" class="text-right border-0">Kuantitas</th>
                    <th scope="col" class="text-right border-0">Sub total</th> --}}
                </tr>
            </thead>
            <tbody>
                {{-- Items --}}
                @foreach($request->orderList as $index => $item)
                <tr>
                    <td class="pl-0">
                        {{ $item->medicine->nama_obat }}
                    </td>
                    <td class="text-center">{{ $item->kuantitas }} Box</td>
                    {{-- <td class="text-right">{{ $item->medicine->jenis }}</td>
                    <td class="text-right">{{ $item->kuantitas }}</td>
                    <td class="text-right">
                        Rp. {{ number_format($item->total) }}
                    </td> --}}
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- <h2>Total : Rp. {{ number_format($request->orderList->sum('total')) }}</h2> --}}
        <h5 style="position: absolute;
        right: 0px;  
        width: 200px;
        height: 120px">Hormat Kami,</h5><br><br><br><br>
        <h5 style="position: absolute;
         right: 0px;  
         width: 200px;
         height: 120px">apt.Fika Rohatul Maula,S.Farm</h5>
    </body>
</html>