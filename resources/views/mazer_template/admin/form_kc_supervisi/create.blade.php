@extends('mazer_template.layouts.app')
@section('title', 'Tambah KC Supervisi')
@section('content')


<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah KC Supervisi</h3>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="mb-4">
                <a href="{{ route('admin.kcsupervisi.index') }}" type="button" class="btn" style='border-radius:12px; background-color:#FFA500; color:white;'><i class="bi bi-arrow-return-left" style="font-size: 13px;"></i></a>
            </div>
            <form class="form" action="{{ route('admin.kcsupervisi.store') }}" id="form-create-kcsupervisi" method="POST">
                @csrf
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-content">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group has-icon-left">
                                            <label for="kc_supervisi_name" style="font-weight: bold;">Nama KC Supervisi <span class="text-danger">*</span></label>
                                            <div class="position-relative">
                                                <input type="text" id="kc_supervisi_name" class="form-control" placeholder="..." name="kc_supervisi_name"
                                                    value="{{ old('kc_supervisi_name') ? old('kc_supervisi_name') : '' }}">
                                                <div class="form-control-icon">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            </div>
                                            @if($errors->has('kc_supervisi_name'))
                                                <span class="text-danger">{{ $errors->first('kc_supervisi_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="d-grid gap-2 mt-4">
                <button class="align-items-center col-12 btn btn-lg" type="submit" style='border-radius:12px; background-color:#56B000; color:white;' id="submit-create-kcsupervisi" onClick="changeToLoadingFormCreateKcSupervisi()">Create</button>
            </div>
        </div>
    </section>
</div>

<script>
    function changeToLoadingFormCreateKcSupervisi() {
        var btn = document.getElementById('submit-create-kcsupervisi');
        btn.innerHTML = '<span class="spinner-border" role="status" aria-hidden="true"></span> Loading...';
        btn.disabled = true;

        // Simulating a delay of 2 seconds for demonstration purposes
        setTimeout(function () {
            // Enable the button and change the text back to "Login" after the delay
            btn.disabled = false;
            btn.innerHTML = 'Submit';

            // Submit the form
            submitFormCreateKcSupervisi();
        }, 2000);
    }

    function submitFormCreateKcSupervisi() {
        // Get the form element
        var form = document.getElementById('form-create-kcsupervisi');

        // Submit the form
        form.submit();
    }

</script>

@endsection
