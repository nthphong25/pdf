<?php
// dd($data);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Laravel 7 PDF Example</title>
    {{-- <style>
        .chart-container {
            display: flex;
            /* Sử dụng flexbox layout để sắp xếp theo hàng ngang */
            justify-content: center;
            /* Cách đều hai biểu đồ */
            width: 100%;


        }

        .custom-table {
            font-family: Arial, sans-serif;
            border-collapse: collapse;
            width: 1400px;
            margin-left: 100px;

            text-align: center;
        }

        .custom-table th,
        .custom-table td {
            border: 1px solid #ddd;
        }

        .custom-table th {
            background-color: #f2f2f2;
        }

        .custom-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }


        .myChartDiv {
            align-items: center;
        }

        .total {
            background-color: aqua;
        }
    </style> --}}
</head>

<body>
    <script src="{{ asset('js/app.js') }}" type="text/js"></script>
    <script>
        const imageCollection = [];
    </script>

    <div class="justify-center items-center text-center mt-8">

        @if (isset($allDataByDayAndDept))
            @foreach ($allDataByDayAndDept as $day => $datas)
                @php
                    $day = str_replace('-', '_', $day);
                @endphp


                <table class=" border border-black mx-auto" style="" id="customers_{{ $day }}">

                    <tr>
                        <th class="w-10 bg-gray-400 px-4 py-2 border-r border-black">#NO</th>
                        <th class="w-16 bg-gray-400 px-4 py-2 border-r border-black">INSPECTED DATE</th>
                        <th class="w-32 bg-gray-400 px-4 py-2 border-r border-black">HOURS</th>
                        <th class="w-16 bg-gray-400 px-4 py-2 border-r border-black">BRAND</th>
                        <th class="w-16 bg-gray-400 px-4 py-2 border-r border-black">LINE NAME</th>
                        <th class="w-16 bg-gray-400 px-4 py-2 border-r border-black">TQC NAME</th>
                        <th class="w-16 bg-gray-400 px-4 py-2 border-r border-black">INSPECTED QTY</th>
                        <th class="w-16 bg-gray-400 px-4 py-2 border-r border-black">PASSED QTY</th>
                        <th class="w-16 bg-gray-400 px-4 py-2 border-r border-black">TQC1 DEFECT QTY</th>
                        <th class="w-16 bg-gray-400 px-4 py-2 border-r border-black">TQC2 DEFECT QTY</th>
                        <th class="w-16 bg-gray-400 px-4 py-2 border-r border-black">TQC3 DEFECT QTY</th>
                        <th class="w-24 bg-gray-400 px-4 py-2 border-r border-black">TQC1 DEFECT RATE %</th>
                        <th class="w-24 bg-gray-400 px-4 py-2 border-r border-black">TQC2 DEFECT RATE %</th>
                        <th class="w-24 bg-gray-400 px-4 py-2 border-r border-black">TQC3 DEFECT RATE %</th>
                    </tr>
                    @php
                        $totalTotal = 0;
                        $totalLogValue = 0;
                        $totalDefectQtyATQC20 = 0;
                        $totalDefectQtyATQC30 = 0;
                        $totalDefectQtyATQC40 = 0;
                        $totalPercentATQC20 = 0;
                        $totalPercentATQC30 = 0;
                        $totalPercentATQC40 = 0;
                        $timeline = ['07:00-08:00', '08:00-09:00', '09:00-10:00', '10:00-11:00', '11:00-12:00', '12:00-13:00', '13:00-14:00', '14:00-15:00', '15:00-16:00', '16:00-17:00', '17:00-18:00', '18:00-19:00'];
                        $count = count($timeline);
                    @endphp
                    @foreach ($datas as $index => $item)
                        <tr class="border border-black">
                            <td class="px-4 py-2 border-r border-black">{{ $index }}</td>
                            <td class="px-4 py-2 border-r border-black">{{ date('j-M', strtotime($item->qip_date)) }}
                            </td>
                            @if (isset($timeline[$index]))
                                <td class="px-4 py-2 border-r border-black">{{ $timeline[$index] }}</td>
                            @else
                                <td class="px-4 py-2 border-r border-black"></td>
                                <!-- Hoặc bạn có thể đặt giá trị mặc định khác cho trường hợp này -->
                            @endif
                            <td class="px-4 py-2 border-r border-black">{{ $item->custbrand_id }}</td>
                            <td class="px-4 py-2 border-r border-black">{{ $item->qc_dept_code }}</td>
                            <td class="px-4 py-2 border-r border-black">{{ $item->qc_dept_code }}</td>
                            @php

                                $logData = json_decode($item->FRQC10_log, true);
                                $logValue = $logData['log'][$timeline[$index]] ?? null;
                                $maxDefect = max($item->defect_qty_ATQC20, $item->defect_qty_ATQC30, $item->defect_qty_ATQC40);
                                $total = $maxDefect != 0 ? $logValue + $maxDefect : 0;

                                // Tính phần trăm chỉ khi $total khác 0
                                $percentATQC20 = round($total != 0 ? ($item->defect_qty_ATQC20 / $total) * 100 : 0);
                                $percentATQC30 = round($total != 0 ? ($item->defect_qty_ATQC30 / $total) * 100 : 0);
                                $percentATQC40 = round($total != 0 ? ($item->defect_qty_ATQC40 / $total) * 100 : 0);
                            @endphp
                            <td class="px-4 py-2 border-r border-black">{{ $total }}</td>
                            <td class="px-4 py-2 border-r border-black"> {{ $logValue }} </td>
                            <td class="px-4 py-2 border-r border-black">{{ $item->defect_qty_ATQC20 }}</td>
                            <td class="px-4 py-2 border-r border-black">{{ $item->defect_qty_ATQC30 }}</td>
                            <td class="px-4 py-2 border-r border-black">{{ $item->defect_qty_ATQC40 }}</td>
                            <td class="px-4 py-2 border-r border-black"> {{ $percentATQC20 }}%</td>
                            <td class="px-4 py-2 border-r border-black">{{ $percentATQC30 }}%</td>
                            <td class="px-4 py-2 border-r border-black"> {{ $percentATQC40 }}%</td>

                        </tr>
                        @php
                            // Tính tổng cho các biến
                            $totalTotal += $total;
                            $totalLogValue += $logValue;
                            $totalDefectQtyATQC20 += $item->defect_qty_ATQC20;
                            $totalDefectQtyATQC30 += $item->defect_qty_ATQC30;
                            $totalDefectQtyATQC40 += $item->defect_qty_ATQC40;
                            $totalPercentATQC20 += $percentATQC20;
                            $totalPercentATQC30 += $percentATQC30;
                            $totalPercentATQC40 += $percentATQC40;
                        @endphp
                    @endforeach
                    @for ($index = count($datas); $index < $count; $index++)
                        <tr class="border border-black">
                            <td class="px-4 py-2 border-r border-black"></td>
                            <td class="px-4 py-2 border-r border-black"></td>
                            <td class="px-4 py-2 border-r border-black">{{ $timeline[$index] }}</td>
                            <td class="px-4 py-2 border-r border-black"></td>
                            <td class="px-4 py-2 border-r border-black"></td>
                            <td class="px-4 py-2 border-r border-black"></td>
                            <td class="px-4 py-2 border-r border-black"></td>
                            <td class="px-4 py-2 border-r border-black"></td>
                            <td class="px-4 py-2 border-r border-black"></td>
                            <td class="px-4 py-2 border-r border-black"></td>
                            <td class="px-4 py-2 border-r border-black"></td>
                            <td class="px-4 py-2 border-r border-black"></td>
                            <td class="px-4 py-2 border-r border-black"></td>
                            <td class="px-4 py-2 border-r border-black"></td>
                            <!-- Đặt giá trị trống cho các cột khác nếu cần -->
                        </tr>
                    @endfor







                    <tr class="border border-black">
                        <td class="px-4 py-2 border-r border-black">Total</td>
                        <td class="px-4 py-2 border-r border-black">{{ date('j-M', strtotime($item->qip_date)) }}</td>
                        <td class="px-4 py-2 border-r border-black"></td>
                        <td class="px-4 py-2 border-r border-black"></td>
                        <td class="px-4 py-2 border-r border-black"></td>
                        <td class="px-4 py-2 border-r border-black"></td>
                        <td class="px-4 py-2 border-r border-black">{{ $totalTotal }}</td>
                        <td class="px-4 py-2 border-r border-black">{{ $totalLogValue }}</td>
                        <td class="px-4 py-2 border-r border-black">{{ $totalDefectQtyATQC20 }}</td>
                        <td class="px-4 py-2 border-r border-black">{{ $totalDefectQtyATQC30 }}</td>
                        <td class="px-4 py-2 border-r border-black">{{ $totalDefectQtyATQC40 }}</td>
                        <td class="px-4 py-2 border-r border-black">{{ $totalPercentATQC20 }}%</td>
                        <td class="px-4 py-2 border-r border-black">{{ $totalPercentATQC30 }}%</td>
                        <td class="px-4 py-2 border-r border-black">{{ $totalPercentATQC40 }}%</td>
                    </tr>
                </table>
                <div class="text-center mt-8 ">
                    <div id="chart-{{ $day }}" class="flex justify-center items-center">
                        <div class="mx-4">
                            <canvas class="w-[800px]" id="total_{{ $day }}"></canvas>
                        </div>
                        <div class="mx-4">
                            <canvas class="w-[600px]" id="myChart_{{ $day }}"></canvas>
                        </div>
                    </div>
                </div>

                <br>
                <br>

                <script>
                    // Khai báo biến chart TOTAL
                    const table_{{ $day }} = document.getElementById('customers_{{ $day }}');
                    const labels1_{{ $day }} = [];

                    const totalTQC1_{{ $day }} = [];
                    const totalTQC2_{{ $day }} = [];
                    const totalTQC3_{{ $day }} = [];
                    const date_{{ $day }} = [];
                    const numFooterRows_{{ $day }} = 1; // Số hàng ở phần cuối
                    const totalRows_{{ $day }} = table_{{ $day }}.rows.length;
                    const startIndex_{{ $day }} = totalRows_{{ $day }} - numFooterRows_{{ $day }};

                    // Khai báo biến chart1 với tên duy nhất dựa trên $day
                    const labels_{{ $day }} = [];
                    const dataTQC1_{{ $day }} = [];
                    const dataTQC2_{{ $day }} = [];
                    const dataTQC3_{{ $day }} = [];
                    const dataTarget_{{ $day }} = [];


                    // Lấy dữ liệu cho biểu đồ 1
                    for (let i = 1; i < (table_{{ $day }}.rows.length - 1); i++) {
                        const row = table_{{ $day }}.rows[i];
                        labels_{{ $day }}.push(row.cells[2].textContent);
                        dataTQC1_{{ $day }}.push(parseInt(row.cells[11].textContent));
                        dataTQC2_{{ $day }}.push(parseInt(row.cells[12].textContent));
                        dataTQC3_{{ $day }}.push(parseInt(row.cells[13].textContent));
                        dataTarget_{{ $day }}.push(1);
                    }

                    // Lấy dữ liệu cho biểu đồ TOTAL
                    for (let i = startIndex_{{ $day }}; i < totalRows_{{ $day }}; i++) {
                        const row = table_{{ $day }}.rows[i];
                        labels1_{{ $day }}.push(row.cells[1].textContent);
                        totalTQC1_{{ $day }}.push(parseInt(row.cells[11].textContent));
                        totalTQC2_{{ $day }}.push(parseInt(row.cells[12].textContent));
                        totalTQC3_{{ $day }}.push(parseInt(row.cells[13].textContent));

                    }

                    // Vẽ biểu đồ TOTAL
                    const ctx1_{{ $day }} = document.getElementById('myChart_{{ $day }}');
                    const myChart1_{{ $day }} = new Chart(ctx1_{{ $day }}, {
                        type: 'bar',
                        data: {
                            labels: labels1_{{ $day }},
                            datasets: [{
                                    type: 'bar',
                                    label: 'TQC1',
                                    data: totalTQC1_{{ $day }},
                                    borderColor: 'rgb(255, 99, 132)',
                                    backgroundColor: 'rgba(68, 114, 196, 0.7)'
                                },
                                {
                                    type: 'bar',
                                    label: 'TQC2',
                                    data: totalTQC2_{{ $day }},
                                    borderColor: 'rgb(255, 99, 132)',
                                    backgroundColor: 'rgba(237, 125, 49, 0.7)'
                                },
                                {
                                    type: 'bar',
                                    label: 'TQC3',
                                    data: totalTQC3_{{ $day }},
                                    borderColor: 'rgba(165, 165, 165, 0.7)',
                                }
                            ]
                        },
                        options: {
                            responsive: false,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                        }
                    });

                    // Vẽ biểu đồ 1
                    const ctx_{{ $day }} = document.getElementById('total_{{ $day }}');
                    const myChart_{{ $day }} = new Chart(ctx_{{ $day }}, {
                        type: 'bar',
                        data: {
                            labels: labels_{{ $day }},
                            datasets: [{
                                    type: 'bar',
                                    label: 'TQC1',
                                    data: dataTQC1_{{ $day }},
                                    borderColor: 'rgb(255, 99, 132)',
                                    backgroundColor: 'rgba(68, 114, 196, 0.7)',
                                },
                                {
                                    type: 'bar',
                                    label: 'TQC2',
                                    data: dataTQC2_{{ $day }},
                                    borderColor: 'rgb(255, 99, 132)',
                                    backgroundColor: 'rgba(237, 125, 49, 0.7)',
                                },
                                {
                                    type: 'bar',
                                    label: 'TQC3',
                                    data: dataTQC3_{{ $day }},
                                    borderColor: 'rgb(255, 99, 132)',
                                    backgroundColor: 'rgba(165, 165, 165, 0.7)',
                                },
                                {
                                    type: 'line',
                                    label: 'Target',
                                    data: dataTarget_{{ $day }},
                                    fill: false,
                                    backgroundColor: 'rgba(240, 5, 5)',
                                    borderColor: 'rgba(240, 5, 5)',
                                },
                            ],
                        },
                        options: {
                            responsive: false,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                },
                            },
                        },
                    });
                </script>


            @endforeach
        @endif
    </div>


</body>

</html>
