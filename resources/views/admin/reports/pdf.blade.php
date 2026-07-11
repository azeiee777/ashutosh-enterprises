<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ ucwords(str_replace('_', ' ', $type)) }} Report</title>
    <style>
        @page { margin: 40px 40px 60px 40px; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; margin: 0; padding: 0; color: #334155; }
        
        .header-table {
            width: 100%;
            border-bottom: 3px solid #1e3a8a;
            padding-bottom: 15px;
            margin-bottom: 25px;
            border-collapse: collapse;
        }
        .header-table td {
            border: none;
            padding: 0;
            background: transparent;
        }
        .company-name {
            font-size: 24px;
            font-weight: 800;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .report-title {
            font-size: 14px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .report-meta {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 5px;
            text-align: right;
        }
        
        footer { 
            position: fixed; 
            bottom: -40px; 
            left: 0px; 
            right: 0px; 
            height: 30px; 
            text-align: center; 
            border-top: 1px solid #e2e8f0; 
            font-size: 10px; 
            color: #94a3b8; 
            padding-top: 15px;
        }
        
        .watermark {
            position: fixed;
            top: 40%;
            left: 10%;
            width: 80%;
            text-align: center;
            font-size: 60px;
            font-weight: 800;
            color: rgba(30, 58, 138, 0.04);
            transform: rotate(-30deg);
            z-index: -1000;
        }
        
        .data-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        .data-table th { 
            background-color: #1e3a8a; 
            color: #ffffff; 
            font-weight: 600; 
            text-transform: uppercase; 
            font-size: 10px;
            letter-spacing: 0.5px;
            padding: 12px 10px; 
            text-align: left; 
            border: none;
        }
        .data-table td { 
            border-bottom: 1px solid #e2e8f0; 
            padding: 10px 10px; 
            text-align: left; 
            color: #475569;
            border-top: none;
            border-left: none;
            border-right: none;
        }
        .data-table tbody tr:nth-child(even) { 
            background-color: #f8fafc; 
        }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; color: #1e293b; }
        
        .data-table .bg-gray td { 
            background-color: #059669; 
            color: #ffffff; 
            font-weight: bold;
            border: none;
            padding: 12px 10px;
        }
        .data-table .bg-gray td.font-bold {
            color: #ffffff;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td style="width: 60%; vertical-align: top;">
                <div class="company-name">Ashutosh Enterprises</div>
                <div class="report-title">{{ ucwords(str_replace('_', ' ', $type)) }} Report</div>
            </td>
            <td style="width: 40%; vertical-align: bottom;">
                <div class="report-meta">
                    <strong>Generated On:</strong><br>
                    {{ now()->format('d M Y, h:i A') }}
                </div>
            </td>
        </tr>
    </table>

    <footer>
        Ashutosh Enterprises &copy; {{ date('Y') }} - System Generated Report
    </footer>

    <div class="watermark">
        ASHUTOSH ENTERPRISES
    </div>

    <main>
        <table class="data-table">
            @if($type == 'daily_labour')
                <thead>
                    <tr><th>Date</th><th>Client</th><th>Site</th><th class="text-center">S</th><th class="text-center">SS</th><th class="text-center">US</th><th class="text-center">Total</th></tr>
                </thead>
                <tbody>
                    @php $s=0; $ss=0; $us=0; $t=0; @endphp
                    @foreach($data as $row)
                        @php $s+=$row->skilled_count; $ss+=$row->semi_skilled_count; $us+=$row->unskilled_count; $t+=$row->total_count; @endphp
                        <tr>
                            <td>{{ $row->date->format('d M Y') }}</td>
                            <td>{{ $row->client?->company_name ?? '-' }}</td>
                            <td>{{ $row->site?->site_name ?? '-' }}</td>
                            <td class="text-center">{{ $row->skilled_count }}</td>
                            <td class="text-center">{{ $row->semi_skilled_count }}</td>
                            <td class="text-center">{{ $row->unskilled_count }}</td>
                            <td class="text-center font-bold">{{ $row->total_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray font-bold">
                        <td colspan="3" class="text-right">GRAND TOTALS</td>
                        <td class="text-center">{{ $s }}</td><td class="text-center">{{ $ss }}</td><td class="text-center">{{ $us }}</td><td class="text-center">{{ $t }}</td>
                    </tr>
                </tfoot>
            @elseif($type == 'monthly_labour')
                <thead>
                    <tr><th>Month</th><th>Client</th><th class="text-center">Total S</th><th class="text-center">Total SS</th><th class="text-center">Total US</th><th class="text-center">Grand Total</th></tr>
                </thead>
                <tbody>
                    @php $s=0; $ss=0; $us=0; $t=0; @endphp
                    @foreach($data as $row)
                        @php $s+=$row->total_skilled; $ss+=$row->total_semi_skilled; $us+=$row->total_unskilled; $t+=$row->grand_total; @endphp
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($row->month.'-01')->format('M Y') }}</td>
                            <td>{{ $row->client?->company_name ?? '-' }}</td>
                            <td class="text-center">{{ $row->total_skilled }}</td>
                            <td class="text-center">{{ $row->total_semi_skilled }}</td>
                            <td class="text-center">{{ $row->total_unskilled }}</td>
                            <td class="text-center font-bold">{{ $row->grand_total }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray font-bold">
                        <td colspan="2" class="text-right">GRAND TOTALS</td>
                        <td class="text-center">{{ $s }}</td><td class="text-center">{{ $ss }}</td><td class="text-center">{{ $us }}</td><td class="text-center">{{ $t }}</td>
                    </tr>
                </tfoot>
            @elseif($type == 'client_wise_labour')
                <thead>
                    <tr><th>Client</th><th class="text-center">Total Days</th><th class="text-center">Total S</th><th class="text-center">Total SS</th><th class="text-center">Total US</th><th class="text-center">Grand Total</th></tr>
                </thead>
                <tbody>
                    @php $d=0; $s=0; $ss=0; $us=0; $t=0; @endphp
                    @foreach($data as $row)
                        @php $d+=$row->total_days; $s+=$row->total_skilled; $ss+=$row->total_semi_skilled; $us+=$row->total_unskilled; $t+=$row->grand_total; @endphp
                        <tr>
                            <td>{{ $row->client?->company_name ?? '-' }}</td>
                            <td class="text-center">{{ $row->total_days }}</td>
                            <td class="text-center">{{ $row->total_skilled }}</td>
                            <td class="text-center">{{ $row->total_semi_skilled }}</td>
                            <td class="text-center">{{ $row->total_unskilled }}</td>
                            <td class="text-center font-bold">{{ $row->grand_total }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray font-bold">
                        <td class="text-right">GRAND TOTALS</td>
                        <td class="text-center">{{ $d }}</td><td class="text-center">{{ $s }}</td><td class="text-center">{{ $ss }}</td><td class="text-center">{{ $us }}</td><td class="text-center">{{ $t }}</td>
                    </tr>
                </tfoot>
            @elseif($type == 'site_wise_labour')
                <thead>
                    <tr><th>Site</th><th>Client</th><th class="text-center">Total Days</th><th class="text-center">Grand Total</th></tr>
                </thead>
                <tbody>
                    @php $d=0; $t=0; @endphp
                    @foreach($data as $row)
                        @php $d+=$row->total_days; $t+=$row->grand_total; @endphp
                        <tr>
                            <td>{{ $row->site?->site_name ?? '-' }}</td>
                            <td>{{ $row->client?->company_name ?? '-' }}</td>
                            <td class="text-center">{{ $row->total_days }}</td>
                            <td class="text-center font-bold">{{ $row->grand_total }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray font-bold">
                        <td colspan="2" class="text-right">GRAND TOTALS</td>
                        <td class="text-center">{{ $d }}</td><td class="text-center">{{ $t }}</td>
                    </tr>
                </tfoot>
            @elseif($type == 'payment')
                <thead>
                    <tr><th>Date</th><th>Client</th><th>Payment Head</th><th class="text-right">Amount</th><th>Method</th></tr>
                </thead>
                <tbody>
                    @php $t=0; @endphp
                    @foreach($data as $row)
                        @php $t+=$row->amount; @endphp
                        <tr>
                            <td>{{ $row->date->format('d M Y') }}</td>
                            <td>{{ $row->client?->company_name ?? '-' }}</td>
                            <td>{{ $row->payment_head->label() }}</td>
                            <td class="text-right">₹{{ number_format($row->amount, 2) }}</td>
                            <td>{{ $row->payment_method->label() }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray font-bold">
                        <td colspan="3" class="text-right">GRAND TOTAL</td>
                        <td class="text-right">₹{{ number_format($t, 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            @elseif($type == 'expense')
                <thead>
                    <tr><th>Date</th><th>Category</th><th>Vendor</th><th>Description</th><th class="text-right">Amount</th></tr>
                </thead>
                <tbody>
                    @php $t=0; @endphp
                    @foreach($data as $row)
                        @php $t+=$row->amount; @endphp
                        <tr>
                            <td>{{ $row->date->format('d M Y') }}</td>
                            <td>{{ $row->category->label() }}</td>
                            <td>{{ $row->vendor ?? '-' }}</td>
                            <td>{{ $row->description ?? '-' }}</td>
                            <td class="text-right">₹{{ number_format($row->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-gray font-bold">
                        <td colspan="4" class="text-right">GRAND TOTAL</td>
                        <td class="text-right">₹{{ number_format($t, 2) }}</td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </main>

</body>
</html>
