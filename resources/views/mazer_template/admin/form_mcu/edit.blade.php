@extends('mazer_template.layouts.app')
@section('title', 'Door Access Update')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><i class="bi bi-gear-fill"></i> Door Access <small class="text-muted">Update</small></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.mcu.index') }}">Door Access List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Door Access Update</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="mb-4">
                <a href="{{ route('admin.mcu.index') }}" type="button" class="btn" style='border-radius:12px; background-color:#FFA500; color:white;'><i class="bi bi-arrow-return-left" style="font-size: 13px;"></i></a>
            </div>
            <form class="form" action="{{ url('admin/mcu/update/'.$data->id) }}" id="form-update-mcu" method="POST">
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
                                            <label for="door_token" style="font-weight: bold">Door Token <span class="text-danger">*</span></label>
                                            <input type="text" id="door_token" class="form-control" placeholder="..." name="door_token"
                                                value="{{ old('door_token') ? old('door_token') : $data->door_token }}">
                                            @if($errors->has('door_token'))
                                                <span class="text-danger">{{ $errors->first('door_token') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="door_name_mcu" style="font-weight: bold">Door Name <span class="text-danger">*</span></label>
                                            <input type="text" id="door_name_mcu" class="form-control" placeholder="..." name="door_name_mcu"
                                                value="{{ old('door_name_mcu') ? old('door_name_mcu') : $data->door_name_mcu }}">
                                            @if($errors->has('door_name_mcu'))
                                                <span class="text-danger">{{ $errors->first('door_name_mcu') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="type_mcu" style="font-weight: bold">Type Door Access <span class="text-danger">*</span></label>
                                            <input type="text" id="type_mcu" class="form-control" placeholder="..." name="type_mcu"
                                                value="{{ old('type_mcu') ? old('type_mcu') : $data->type_mcu }}">
                                            @if($errors->has('type_mcu'))
                                                <span class="text-danger">{{ $errors->first('type_mcu') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="keypad_password" style="font-weight: bold">Keypad Password <span class="text-danger">*</span></label>
                                            <input type="text" id="keypad_password" class="form-control" placeholder="..." name="keypad_password"
                                                value="{{ old('keypad_password') ? old('keypad_password') : $data->keypad_password }}">
                                            @if($errors->has('keypad_password'))
                                                <span class="text-danger">{{ $errors->first('keypad_password') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="delay" style="font-weight: bold">Delay <span class="text-danger">*</span></label>
                                            <input oninput="this.value=this.value.replace(/[^0-9]/g,'');" type="number" id="delay" class="form-control" placeholder="..." name="delay"
                                                value="{{ old('delay') ? old('delay') : $data->delay }}">
                                            @if($errors->has('delay'))
                                                <span class="text-danger">{{ $errors->first('delay') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="tb_office_id" style="font-weight: bold;">Lokasi Kantor <span class="text-danger">*</span></label>
                                            <select class="form-control select2-office" name="tb_office_id">
                                                @if(old('tb_office_id')  != null)
                                                    <option value="{{ old('tb_office_id') }}" selected="selected">
                                                        {{ old('item_select2_office') }}
                                                    </option>
                                                @else
                                                    <option value="{{ $data->tb_office_id }}" selected="selected">
                                                        {{ $data->office_name }}
                                                    </option>
                                                @endif
                                            </select>
                                            <input type="hidden" id="item_select2_office" name="item_select2_office" value="{{ old('item_select2_office') }}" />
                                            @if($errors->has('tb_office_id'))
                                                <span class="text-danger">{{ $errors->first('tb_office_id') }}</span>
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
                <button class="align-items-center col-12 btn btn-lg" type="submit" style='border-radius:12px; background-color:#56B000; color:white;' id="submit-update-mcu" onClick="changeToLoadingFormUpdateMcu()">Update</button>
            </div>
        </div>
    </section>
</div>

<script>
    function changeToLoadingFormUpdateMcu() {
        var btn = document.getElementById('submit-update-mcu');
        btn.innerHTML = '<span class="spinner-border" role="status" aria-hidden="true"></span> Loading...';
        btn.disabled = true;

        // Simulating a delay of 2 seconds for demonstration purposes
        setTimeout(function () {
            // Enable the button and change the text back to "Login" after the delay
            btn.disabled = false;
            btn.innerHTML = 'Update';

            // Submit the form
            submitFormUpdateMcu();
        }, 2000);
    }

    function submitFormUpdateMcu() {
        // Get the form element
        var form = document.getElementById('form-update-mcu');

        // Submit the form
        form.submit();
    }

</script>

@endsection
