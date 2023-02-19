@extends('layouts.master')
@section('title')
    طباعة الفاتوره
@endsection
@section('css')
    <style>
        @media print {
            #print_btn {
                display: none;
            }
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    طباعة الفاتوره</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice" id="print">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title">فاتورة تحصيل</h1>
                            <div class="billed-from">
                                <h5>اسم الشركه :</h5>
                                <h6>العنوان :</h6>
                                <h6> التليفون :</h6>
                                <h6>الايميل : <a style="text-decoration-line: underline"
                                        href="ahmedatefsallam7@gmail.com">ahmedatefsallam7@gmail.com</a> </h6>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">

                            <div class="col-md">

                                <label class="tx-gray-600">معلومات الفاتوره</label>
                                <p class="invoice-info-row"><span>رقم الفاتوره</span>
                                    <span>{{ $invoices->invoice_number }}</span>
                                </p>
                                <p class="invoice-info-row"><span>تاريخ الاصدار</span>
                                    <span>{{ $invoices->invoice_date }}</span>
                                </p>
                                <p class="invoice-info-row"><span>تاريخ الاستحقاق</span>
                                    <span>{{ $invoices->due_date }}</span>
                                </p>
                                <p class="invoice-info-row"><span>القسم</span>
                                    <span>{{ $invoices->section->section_name }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="wd-20p">#</th>
                                        <th class="wd-40p">المنتج</th>
                                        <th class="tx-center">مبلغ التحصيل</th>
                                        <th class="tx-right">مبلغ العموله</th>
                                        <th class="tx-right">الاجمالي</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        $count = 0;
                                    @endphp

                                    @php
                                        $count++;
                                    @endphp
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td class="tx-12">{{ $invoices->product }}</td>
                                        <td class="tx-center">${{ number_format($invoices->Amount_Collection) }}</td>
                                        <td class="tx-right">${{ number_format($invoices->Amount_Commission) }}</td>
                                        <td class="tx-right">
                                            ${{ number_format($invoices->Amount_Collection + $invoices->Amount_Commission) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="valign-middle" colspan="2" rowspan="4">
                                            <div class="invoice-notes">
                                                <label class="main-content-label tx-13">الملاحظات :</label><br>
                                                <span>{{ $invoices->note }}</span>
                                            </div><!-- invoice-notes -->
                                        </td>
                                        <td class="tx-right">الاجمالي</td>
                                        <td class="tx-right" colspan="2">
                                            ${{ number_format($invoices->Amount_Collection + $invoices->Amount_Commission) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">نسبة الضريبه (ْ{{ $invoices->Rate_Vat }})</td>
                                        <td class="tx-right" colspan="2">${{ number_format($invoices->Value_Vat) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">فيمة الخصم</td>
                                        <td class="tx-right" colspan="2">${{ number_format($invoices->Discount) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right tx-uppercase tx-bold tx-inverse">الاجمالي شامل الضريبه</td>
                                        <td class="tx-right" colspan="2">
                                            <h4 class="tx-primary tx-bold">$ {{ number_format($invoices->Total) }}</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mg-b-40">

                        <a class="btn btn-danger float-left mt-3 mr-2" id="print_btn" onclick="printDiv()">
                            <i class="mdi mdi-printer ml-1"></i>طباعة
                        </a>

                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
{{-- print invoice button --}}
    <script>
        function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@endsection
