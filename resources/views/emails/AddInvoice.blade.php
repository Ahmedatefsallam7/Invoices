<x-mail::message>
اهلا بك {{ auth()->user()->name }}

 تم   فاتوره جديده لك

<x-mail::button :url="$url" >
عرض الفاتورة
</x-mail::button>
 
شكراََ لك<br>
{{ config('app.name') }}
</x-mail::message>
