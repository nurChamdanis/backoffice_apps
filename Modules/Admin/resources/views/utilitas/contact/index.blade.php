@extends('layouts.app')

@section('template_title')
    Contact Settings
@endsection

@section('style')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="nk-block-head">
    <div class="nk-block-head-content">
        <h4 class="title nk-block-title">Setting Kontak</h4>
        <div class="nk-block-des">
            <p>Berikan nilai yang sesuai dengan nama kolom yang tersedia</p>
        </div>
    </div>
</div>
<div class="col-md-4 card">
    <div class="card-body">
        <form action="{{ route('kontak.store') }}" class="form-validate is-alter" method="POST">
            @method('POST')
            @csrf
            <div class="form-control-wrap">
                <div class="form-group">
                    <label class="form-label mt-3">Nomor Whatsapp</label>
                    <div class="form-control-wrap">
                        <input type="number" name="whatsapp" value="{{ isset($value) ? $value->whatsapp : null }}" data-msg="Tidak boleh kosong"
                            class="form-control" required>
                        <span class="text-danger subtitle font-italic fs-10px">
                            Input dengan kode negara <b>(62)</b> contoh : 628123456789
                        </span>
                    </div>
                </div>
            </div>
    
            <div class="form-control-wrap">
                <div class="form-group">
                    <label class="form-label mt-3">Nomor Telegram</label>
                    <div class="form-control-wrap">
                        <input type="number" name="telegram" value="{{ isset($value) ? $value->telegram : null }}" data-msg="Tidak boleh kosong"
                            class="form-control" required>
                        <span class="text-danger subtitle font-italic fs-10px">
                            Input dengan kode negara <b>(62)</b> contoh : 628123456789
                        </span>
                    </div>
                </div>
            </div>
    
            <div class="form-control-wrap">
                <div class="form-group">
                    <label class="form-label mt-3">Link Profile Facebook</label>
                    <div class="form-control-wrap">
                        <input type="text" name="facebook" value="{{ isset($value) ? $value->facebook : null }}" data-msg="Tidak boleh kosong"
                            class="form-control">
                    </div>
                </div>
            </div>
    
            <div class="form-control-wrap">
                <div class="form-group">
                    <label class="form-label mt-3">Link Profile Instagram</label>
                    <div class="form-control-wrap">
                        <input type="text" name="instagram" value="{{ isset($value) ? $value->instagram : null }}" data-msg="Tidak boleh kosong"
                            class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-control-wrap">
                <div class="form-group">
                    <label class="form-label mt-3">Link Profile Tiktok</label>
                    <div class="form-control-wrap">
                        <input type="text" name="tiktok" value="{{ isset($value) ? $value->tiktok : null }}" data-msg="Tidak boleh kosong"
                            class="form-control">
                    </div>
                </div>
            </div>
    
            <div class="form-control-wrap">
                <div class="form-group">
                    <label class="form-label mt-3">Link Profile Tweeter</label>
                    <div class="form-control-wrap">
                        <input type="text" name="tweeter" value="{{ isset($value) ? $value->tweeter : null }}" data-msg="Tidak boleh kosong"
                            class="form-control">
                    </div>
                </div>
            </div>
    
            <div class="form-control-wrap">
                <div class="form-group">
                    <label class="form-label mt-3">Alamat Email</label>
                    <div class="form-control-wrap">
                        <input type="email" name="email" value="{{ isset($value) ? $value->email : null }}" data-msg="Tidak boleh kosong"
                            class="form-control">
                    </div>
                </div>
            </div>
    
            <div class="form-control-wrap">
                <div class="form-group">
                    <label class="form-label mt-3">Alamat Perusahaan</label>
                    <div class="form-control-wrap">
                        <textarea name="alamat" class="form-control" id="" rows="5">
                                {{ isset($value) ? $value->alamat : null }}
                            </textarea>
                    </div>
                </div>
            </div>
    
            <div class="form-control-wrap">
                <div class="form-group">
                    <label class="form-label mt-3">Telepon Kantor</label>
                    <div class="form-control-wrap">
                        <input type="text" name="telepon" value="{{ isset($value) ? $value->telepon : null }}" data-msg="Tidak boleh kosong"
                            class="form-control">
                    </div>
                </div>
            </div>
    
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-md btn-primary">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>  
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script type="text/javascript">
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
</script>
@endsection
