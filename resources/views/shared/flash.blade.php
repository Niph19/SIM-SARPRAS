@if (session('success'))
    <p role="status" class="rounded bg-green-100 p-3 text-green-900">{{ session('success') }}</p>
@endif
@if ($errors->any())
    <div role="alert" class="rounded bg-red-100 p-3 text-red-900"><ul class="list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif
