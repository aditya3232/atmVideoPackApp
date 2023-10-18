@extends('mazer_template.layouts.app')
@section('title', 'Tambah Branch')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Branch</h3>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="mb-4">
                <a href="{{ route('admin.branch.index') }}" type="button" class="btn" style='border-radius:12px; background-color:#FFA500; color:white;'><i class="bi bi-arrow-return-left" style="font-size: 13px;"></i></a>
            </div>
            <form class="form" action="{{ route('admin.branch.store') }}" id="form-create-branch" method="POST">
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
                                            <label for="branch_name" style="font-weight: bold;">Nama Branch <span class="text-danger">*</span></label>
                                            <div class="position-relative">
                                                <input type="text" id="branch_name" class="form-control" placeholder="..." name="branch_name"
                                                    value="{{ old('branch_name') ? old('branch_name') : '' }}">
                                                <div class="form-control-icon">
                                                    @include('mazer_template.layouts.icons.alphabet')
                                                </div>
                                            </div>
                                            @if($errors->has('branch_name'))
                                                <span class="text-danger">{{ $errors->first('branch_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group has-icon-left">
                                            <label for="text" style="font-weight: bold;">Kode Branch <span class="text-danger">*</span></label>
                                            <div class="position-relative">
                                                <input oninput="this.value=this.value.replace(/[^0-9]/g,'');" type="number" id="branch_code" class="form-control" placeholder="..." name="branch_code"
                                                    value="{{ old('branch_code') ? old('branch_code') : '' }}">
                                                <div class="form-control-icon">
                                                    @include('mazer_template.layouts.icons.numeric')
                                                </div>
                                            </div>
                                            @if($errors->has('branch_code'))
                                                <span class="text-danger">{{ $errors->first('branch_code') }}</span>
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
                <button class="align-items-center col-12 btn btn-lg" type="submit" style='border-radius:12px; background-color:#56B000; color:white;' id="submit-create-branch" onClick="changeToLoadingFormCreateBranch()">Create</button>
            </div>
        </div>
    </section>
</div>

<script>
    function changeToLoadingFormCreateBranch() {
        var btn = document.getElementById('submit-create-branch');
        btn.innerHTML = '<span class="spinner-border" role="status" aria-hidden="true"></span> Loading...';
        btn.disabled = true;

        // Simulating a delay of 2 seconds for demonstration purposes
        setTimeout(function () {
            // Enable the button and change the text back to "Login" after the delay
            btn.disabled = false;
            btn.innerHTML = 'Submit';

            // Submit the form
            submitFormCreateBranch();
        }, 2000);
    }

    function submitFormCreateBranch() {
        // Get the form element
        var form = document.getElementById('form-create-branch');

        // Submit the form
        form.submit();
    }

</script>

@endsection
