@extends('mazer_template.layouts.app')
@section('title', 'Tambah Location')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Location</h3>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="mb-4">
                <a href="{{ route('admin.location.index') }}" type="button" class="btn" style='border-radius:12px; background-color:#FFA500; color:white;'><i class="bi bi-arrow-return-left"
                        style="font-size: 13px;"></i></a>
            </div>
            <form class="form" action="{{ route('admin.location.store') }}" id="form-create-location" method="POST">
                @csrf
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-content">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="regional_office_id" style="font-weight: bold;">Regional Office <span class="text-danger">*</span></label>
                                            <select class="form-control select2-form-location-regional-office" name="regional_office_id">
                                                @if(old('regional_office_id')  != null)
                                                    <option value="{{ old('regional_office_id') }}" selected="selected">
                                                        {{ old('item_select2_regional_office') }}
                                                    </option>
                                                @endif
                                            </select>
                                            <input type="hidden" id="item_select2_regional_office" name="item_select2_regional_office" value="{{ old('item_select2_regional_office') }}" />
                                            @if($errors->has('regional_office_id'))
                                                <span class="text-danger">{{ $errors->first('regional_office_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="kc_supervisi_id" style="font-weight: bold;">Branch <span class="text-danger">*</span></label>
                                            <select class="form-control select2-form-location-kc-supervisi" name="kc_supervisi_id">
                                                @if(old('kc_supervisi_id')  != null)
                                                    <option value="{{ old('kc_supervisi_id') }}" selected="selected">
                                                        {{ old('item_select2_kc_supervisi') }}
                                                    </option>
                                                @endif
                                            </select>
                                            <input type="hidden" id="item_select2_kc_supervisi" name="item_select2_kc_supervisi" value="{{ old('item_select2_kc_supervisi') }}" />
                                            @if($errors->has('kc_supervisi_id'))
                                                <span class="text-danger">{{ $errors->first('kc_supervisi_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="branch_id" style="font-weight: bold;">Lokasi <span class="text-danger">*</span></label>
                                            <select class="form-control select2-form-location-branch" name="branch_id">
                                                @if(old('branch_id')  != null)
                                                    <option value="{{ old('branch_id') }}" selected="selected">
                                                        {{ old('item_select2_branch') }}
                                                    </option>
                                                @endif
                                            </select>
                                            <input type="hidden" id="item_select2_branch" name="item_select2_branch" value="{{ old('item_select2_branch') }}" />
                                            @if($errors->has('branch_id'))
                                                <span class="text-danger">{{ $errors->first('branch_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group has-icon-left">
                                            <label for="address" style="font-weight: bold">Alamat Kantor</label>
                                            <div class="position-relative">
                                                <textarea name="address" id="address" cols="24" class="form-control" placeholder="..."
                                                    rows="3">{{ old('address') ? old('address') : '' }}</textarea>
                                                <div class="form-control-icon">
                                                    @include('mazer_template.layouts.icons.alphabet')
                                                </div>
                                            </div>
                                            @if($errors->has('address'))
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group has-icon-left">
                                            <label for="postal_code" style="font-weight: bold">Kode Pos</label>
                                            <div class="position-relative">
                                                <input oninput="this.value=this.value.replace(/[^0-9]/g,'');" type="number" id="postal_code" class="form-control" placeholder="..." name="postal_code"
                                                    value="{{ old('postal_code') ? old('postal_code') : '' }}">
                                                <div class="form-control-icon">
                                                    @include('mazer_template.layouts.icons.numeric')
                                                </div>
                                            </div>
                                            @if($errors->has('postal_code'))
                                                <span class="text-danger">{{ $errors->first('postal_code') }}</span>
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
                <button class="align-items-center col-12 btn btn-lg" type="submit" style='border-radius:12px; background-color:#56B000; color:white;' id="submit-create-location" onClick="changeToLoadingFormCreateLocation()">Create</button>
            </div>
        </div>
    </section>
</div>

<script>
    function changeToLoadingFormCreateLocation() {
        var btn = document.getElementById('submit-create-location');
        btn.innerHTML = '<span class="spinner-border" role="status" aria-hidden="true"></span> Loading...';
        btn.disabled = true;

        // Simulating a delay of 2 seconds for demonstration purposes
        setTimeout(function () {
            // Enable the button and change the text back to "Login" after the delay
            btn.disabled = false;
            btn.innerHTML = 'Submit';

            // Submit the form
            submitFormCreateLocation();
        }, 2000);
    }

    function submitFormCreateLocation() {
        // Get the form element
        var form = document.getElementById('form-create-location');

        // Submit the form
        form.submit();
    }

</script>

@endsection
