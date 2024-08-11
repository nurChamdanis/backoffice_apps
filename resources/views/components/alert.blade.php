@if (session('sukses'))

<div class="example-alert mb-3">
    <div class="alert alert-fill alert-success alert-icon">
        <em class="icon ni ni-check-circle"></em> 
        {{ session('sukses') }}
    </div>
</div>

@elseif(session('error'))

<div class="example-alert mb-3">
    <div class="alert alert-fill alert-danger alert-dismissible alert-icon">
        <em class="icon ni ni-cross-circle"></em> 
        {{ session('error') }}
        <button class="close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

@foreach ($errors->all() as $error)
<div class="example-alert mb-3">
    <div class="alert alert-fill alert-danger alert-dismissible alert-icon">
        <em class="icon ni ni-cross-circle"></em> 
        {{ $error }}
        <button class="close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endforeach
