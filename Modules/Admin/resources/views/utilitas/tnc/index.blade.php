@extends('layouts.app')

@section('template_title')
    Syarat & Ketentuan
@endsection

@section('style')
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h4 class="title nk-block-title">Syarat & Ketentuan</h4>
                <div class="nk-block-des">
                    <p>Silahkan tulis Syarat & Ketentuan dibawah ini</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-inner">
                <form id="postForm" name="postForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div id="summernote">
                        @if (isset($data))
                        {!! $data !!}                            
                        @endif
                    </div>
                    <div class="col-12 mt-3 p-0">
                        <div class="form-group">
                            <button type="submit" id="savedata" class="btn btn-lg btn-primary btn-sm mb-3">
                                Simpan Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#summernote').summernote({
            placeholder: 'Silahkan tulis disini',
            tabsize: 2,
            height: 480,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'strikethrough', 'clear']],
                ['font', ['superscript', 'subscript']],
                ['color', ['color']],
                ['fontsize', ['fontsize', 'height']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');

            var fd = new FormData();
            var textareaValue = $('#summernote').summernote('code');
            fd.append('konten', textareaValue);
            fd.append('_token', CSRF_TOKEN);

            $.ajax({
                data: fd,
                url: "{{ route('tnc.store') }}",
                method: "POST",
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {

                    $('#postForm').trigger("reset");
                    $('#modalCreate').modal('hide');
                    NioApp.Toast(data[0].message, 'success', {
                        position: 'top-center'
                    });
                    $('#savedata').html('Save Post');
                },
                error: function(data) {
                    $('#savedata').html('Save Post');
                }
            });
        });
    </script>
@endsection
