@extends('mazer_template.layouts.app')
@section('title', 'Tambah Regional Office')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Regional Office</h3>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="mb-4">
                <a href="{{ route('admin.regionaloffice.index') }}" type="button" class="btn" style='border-radius:12px; background-color:#FFA500; color:white;'><i class="bi bi-arrow-return-left" style="font-size: 13px;"></i></a>
            </div>
            <form class="form" action="{{ route('admin.regionaloffice.store') }}" id="form-create-regionaloffice" method="POST">
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
                                            <label for="regional_office_name" style="font-weight: bold;">Nama Regional Office <span class="text-danger">*</span></label>
                                            <div class="position-relative">
                                                <input type="text" id="regional_office_name" class="form-control" placeholder="..." name="regional_office_name"
                                                    value="{{ old('regional_office_name') ? old('regional_office_name') : '' }}">
                                                <div class="form-control-icon">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            </div>
                                            @if($errors->has('regional_office_name'))
                                                <span class="text-danger">{{ $errors->first('regional_office_name') }}</span>
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
                <button class="align-items-center col-12 btn btn-lg" type="submit" style='border-radius:12px; background-color:#56B000; color:white;' id="submit-create-regionaloffice" onClick="changeToLoadingFormCreateRegionalOffice()">Create</button>
            </div>
        </div>
    </section>
</div>

<script>
    function changeToLoadingFormCreateRegionalOffice() {
        var btn = document.getElementById('submit-create-regionaloffice');
        btn.innerHTML = '<span class="spinner-border" role="status" aria-hidden="true"></span> Loading...';
        btn.disabled = true;

        // Simulating a delay of 2 seconds for demonstration purposes
        setTimeout(function () {
            // Enable the button and change the text back to "Login" after the delay
            btn.disabled = false;
            btn.innerHTML = 'Submit';

            // Submit the form
            submitFormCreateRegionalOffice();
        }, 2000);
    }

    function submitFormCreateRegionalOffice() {
        // Get the form element
        var form = document.getElementById('form-create-regionaloffice');

        // Submit the form
        form.submit();
    }

</script>

@endsection
