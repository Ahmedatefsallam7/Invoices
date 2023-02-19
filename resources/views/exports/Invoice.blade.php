<table>
    <thead>
        <tr class="head">
            <th style="background-color: yellow; text-align: center">رقم الفاتوره</th>
            <th style="background-color: yellow; text-align: center">اسم المستخدم</th>
            <th style="background-color: yellow; text-align: center">تاريخ الفاتوره</th>
            <th style="background-color: yellow; text-align: center">تاريخ الاستحقاق</th>
            <th style="background-color: yellow ; text-align: center"> المنتج</th>
            <th style="background-color: yellow; text-align: center"> القسم</th>
            <th style="background-color: yellow; text-align: center"> الخصم</th>
            <th style="background-color: yellow; text-align: center"> نسبة الضريبه</th>
            <th style="background-color: yellow ; text-align: center"> قيمة الضريبه</th>
            <th style="background-color: yellow; text-align: center"> الاجمالي</th>
            <th style="background-color: yellow; text-align: center"> الملاحظات</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($invoices as $invoice)
            <tr class="body">
                <td style="text-align: center">{{ $invoice->invoice_number }}</td>
                <td style="text-align: center">{{ Auth()->user()->name }}</td>
                <td style="text-align: center">{{ $invoice->invoice_date }}</td>
                <td style="text-align: center">{{ $invoice->due_date }}</td>
                <td style="text-align: center">{{ $invoice->product }}</td>
                <td style="text-align: center">{{ $invoice->section->section_name }}</td>
                <td style="text-align: center">{{ $invoice->Discount }}</td>
                <td style="text-align: center">{{ $invoice->Rate_Vat }}</td>
                <td style="text-align: center">{{ $invoice->Value_Vat }}</td>
                <td style="text-align: center">{{ $invoice->Total }}</td>
                <td style="text-align: center">{{ $invoice->note }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
