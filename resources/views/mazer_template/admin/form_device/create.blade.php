@extends('mazer_template.layouts.app')
@section('title', 'Tambah Device')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tambah Device</h3>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="mb-4">
                <a href="{{ route('admin.device.index') }}" type="button" class="btn" style='border-radius:12px; background-color:#FFA500; color:white;'><i class="bi bi-arrow-return-left" style="font-size: 13px;"></i></a>
            </div>
            <form class="form" action="{{ route('admin.device.store') }}" id="form-create-device" method="POST">
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
                                            <label for="tid" style="font-weight: bold">TID</label>
                                            <div class="position-relative">
                                                <input oninput="this.value=this.value.replace(/[^0-9]/g,'');" type="number" id="tid" class="form-control" placeholder="..." name="tid"
                                                    value="{{ old('tid') ? old('tid') : '' }}">
                                                <div class="form-control-icon">
                                                    @include('mazer_template.layouts.icons.numeric')
                                                </div>
                                            </div>

                                            @if($errors->has('tid'))
                                                <span class="text-danger">{{ $errors->first('tid') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group has-icon-left">
                                            <label for="text" style="font-weight: bold;">IP Address <span class="text-danger">*</span></label>
                                            <div class="position-relative">
                                                <input type="text" id="ip_address" class="form-control" placeholder="..." name="ip_address"
                                                    value="{{ old('ip_address') ? old('ip_address') : '' }}">
                                                <div class="form-control-icon">
                                                    @include('mazer_template.layouts.icons.alphabet')
                                                </div>
                                            </div>
                                            @if($errors->has('ip_address'))
                                                <span class="text-danger">{{ $errors->first('ip_address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group has-icon-left">
                                            <label for="text" style="font-weight: bold;">SN Mini PC <span class="text-danger">*</span></label>
                                            <div class="position-relative">
                                                <input type="text" id="sn_mini_pc" class="form-control" placeholder="..." name="sn_mini_pc"
                                                    value="{{ old('sn_mini_pc') ? old('sn_mini_pc') : '' }}">
                                                <div class="form-control-icon">
                                                    @include('mazer_template.layouts.icons.alphabet')
                                                </div>
                                            </div>
                                            @if($errors->has('sn_mini_pc'))
                                                <span class="text-danger">{{ $errors->first('sn_mini_pc') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="location_id" style="font-weight: bold;">Lokasi <span class="text-danger">*</span></label>
                                            <select class="form-control select2-form-device-location" name="location_id">
                                                @if(old('location_id')  != null)
                                                    <option value="{{ old('location_id') }}" selected="selected">
                                                        {{ old('item_select2_location') }}
                                                    </option>
                                                @endif
                                            </select>
                                            <input type="hidden" id="item_select2_location" name="item_select2_location" value="{{ old('item_select2_location') }}" />
                                            @if($errors->has('location_id'))
                                                <span class="text-danger">{{ $errors->first('location_id') }}</span>
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
                <button class="align-items-center col-12 btn btn-lg" type="submit" style='border-radius:12px; background-color:#56B000; color:white;' id="submit-create-device" onClick="changeToLoadingFormCreateDevice()">Create</button>
            </div>
        </div>
    </section>
</div>

<script>
    function changeToLoadingFormCreateDevice() {
        var btn = document.getElementById('submit-create-device');
        btn.innerHTML = '<span class="spinner-border" role="status" aria-hidden="true"></span> Loading...';
        btn.disabled = true;

        // Simulating a delay of 2 seconds for demonstration purposes
        setTimeout(function () {
            // Enable the button and change the text back to "Login" after the delay
            btn.disabled = false;
            btn.innerHTML = 'Submit';

            // Submit the form
            submitFormCreateDevice();
        }, 2000);
    }

    function submitFormCreateDevice() {
        // Get the form element
        var form = document.getElementById('form-create-device');

        // Submit the form
        form.submit();
    }

</script>

@endsection
