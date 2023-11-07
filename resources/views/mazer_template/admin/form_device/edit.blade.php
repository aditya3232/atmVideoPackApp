@extends('mazer_template.layouts.app')
@section('title', 'Update Device')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Update Device</h3>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="mb-4">
                <a href="{{ route('admin.device.index') }}" type="button" class="btn" style='border-radius:12px; background-color:#FFA500; color:white;'><i class="bi bi-arrow-return-left" style="font-size: 13px;"></i></a>
            </div>
            <form class="form" action="{{ url('admin/device/update/'.$data->id) }}" id="form-update-device" method="POST">
                @csrf
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-start">

                            </div>
                            <div class="float-end">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-clock"></i><span class="ms-2">Updated At : {{ $data->updated_at }}</span>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="tid" style="font-weight: bold">Tid <span class="text-danger">*</span></label>
                                                <div class="position-relative">
                                                    <div class="position-relative">
                                                        <input type="text" id="tid" class="form-control" placeholder="..." name="tid" value="{{ old('tid') ? old('tid') : $data->tid }}">
                                                        <div class="form-control-icon">
                                                            @include('mazer_template.layouts.icons.numeric')
                                                        </div>
                                                    </div>
                                                    @if($errors->has('tid'))
                                                        <span class="text-danger">{{ $errors->first('tid') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="ip_address" style="font-weight: bold">IP Address <span class="text-danger">*</span></label>
                                                <div class="position-relative">
                                                    <div class="position-relative">
                                                        <input type="text" id="ip_address" class="form-control" placeholder="..." name="ip_address"
                                                            value="{{ old('ip_address') ? old('ip_address') : $data->ip_address }}">
                                                        <div class="form-control-icon">
                                                            @include('mazer_template.layouts.icons.alphabet')
                                                        </div>
                                                    </div>
                                                    @if($errors->has('ip_address'))
                                                        <span class="text-danger">{{ $errors->first('ip_address') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="sn_mini_pc" style="font-weight: bold">SN Mini PC <span class="text-danger">*</span></label>
                                                <div class="position-relative">
                                                    <div class="position-relative">
                                                        <input type="text" id="sn_mini_pc" class="form-control" placeholder="..." name="sn_mini_pc"
                                                            value="{{ old('sn_mini_pc') ? old('sn_mini_pc') : $data->sn_mini_pc }}">
                                                        <div class="form-control-icon">
                                                            @include('mazer_template.layouts.icons.alphabet')
                                                        </div>
                                                    </div>
                                                    @if($errors->has('sn_mini_pc'))
                                                        <span class="text-danger">{{ $errors->first('sn_mini_pc') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="location_id" style="font-weight: bold;">Lokasi <span class="text-danger">*</span></label>
                                                <select class="form-control select2-form-device-location" id="select2-form-device-location" name="location_id">
                                                    <option value="{{ old('location_id') ? old('location_id') : $data->location_id }}" selected="selected">
                                                        {{ $location_name }}
                                                    </option>
                                                </select>
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
                </div>
            </form>
            <div class="d-grid gap-2 mt-4">
                <button class="align-items-center col-12 btn btn-lg" type="submit" style='border-radius:12px; background-color:#56B000; color:white;' id="submit-update-device" onClick="changeToLoadingFormUpdateDevice()">Update</button>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function changeToLoadingFormUpdateDevice() {
        var btn = document.getElementById('submit-update-device');
        btn.innerHTML = '<span class="spinner-border" role="status" aria-hidden="true"></span> Loading...';
        btn.disabled = true;

        // Simulating a delay of 2 seconds for demonstration purposes
        setTimeout(function () {
            // Enable the button and change the text back to "Login" after the delay
            btn.disabled = false;
            btn.innerHTML = 'Submit';

            // Submit the form
            submitFormUpdateDevice();
        }, 2000);
    }

    function submitFormUpdateDevice() {
        // Get the form element
        var form = document.getElementById('form-update-device');

        // Create a new FormData object
        var formData = new FormData(form);

        // Send the form data using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.errors) {
                    // Handle validation errors
                    var errorMessages = Object.values(response.errors).join('<br>');
                    Swal.fire({
                        title: 'Validation Error',
                        html: errorMessages, // Gunakan html untuk mengaktifkan baris baru (\n)
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                } else {
                    // Handle a successful response
                    console.log(response.message);
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('admin.device.index') }}";
                        }
                    });
                }
            } else {
                // Handle errors
                console.error(xhr.statusText);
                Swal.fire({
                    title: 'Error!',
                    text: 'Device failed to update.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        };
        xhr.onerror = function () {
            console.error(xhr.statusText);
        };
        xhr.send(formData);
    }

</script>


@endsection
