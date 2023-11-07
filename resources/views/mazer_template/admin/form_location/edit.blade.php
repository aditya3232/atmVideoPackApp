@extends('mazer_template.layouts.app')
@section('title', 'Update Location')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Update Location</h3>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="mb-4">
                <a href="{{ route('admin.location.index') }}" type="button" class="btn" style='border-radius:12px; background-color:#FFA500; color:white;'><i class="bi bi-arrow-return-left"
                        style="font-size: 13px;"></i></a>
            </div>
            <form class="form" action="{{ url('admin/location/update/'.$data->id) }}" id="form-update-location" method="POST" onsubmit="return false;">
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
                                            <div class="form-group">
                                                <label for="regional_office_id" style="font-weight: bold;">Regional Office <span class="text-danger">*</span></label>
                                                <select class="form-control select2-form-location-regional-office" id="select2-form-location-regional-office" name="regional_office_id">
                                                    <option value="{{ old('regional_office_id') ? old('regional_office_id') : $data->regional_office_id }}" selected="selected">
                                                        {{ $regional_office_name }}
                                                    </option>
                                                </select>
                                                @if($errors->has('regional_office_id'))
                                                    <span class="text-danger">{{ $errors->first('regional_office_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="kc_supervisi_id" style="font-weight: bold;">KC Supervisi <span class="text-danger">*</span></label>
                                                <select class="form-control select2-form-location-kc-supervisi" id="select2-form-location-kc-supervisi" name="kc_supervisi_id">
                                                    <option value="{{ old('kc_supervisi_id') ? old('kc_supervisi_id') : $data->kc_supervisi_id }}" selected="selected">
                                                        {{ $kc_supervisi_name }}
                                                    </option>
                                                </select>
                                                @if($errors->has('kc_supervisi_id'))
                                                    <span class="text-danger">{{ $errors->first('kc_supervisi_id') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="branch_id" style="font-weight: bold;">Branch <span class="text-danger">*</span></label>
                                                <select class="form-control select2-form-location-branch" id="select2-form-location-branch" name="branch_id">
                                                    <option value="{{ old('branch_id') ? old('branch_id') : $data->branch_id }}" selected="selected">
                                                        {{ $kc_supervisi_name }}
                                                    </option>
                                                </select>
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
                                                        rows="3">{{ old('address') ? old('address') : $data->address }}</textarea>
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
                                                        value="{{ old('postal_code') ? old('postal_code') : $data->postal_code }}">
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
                </div>
            </form>
            <div class="d-grid gap-2 mt-4">
                <button class="align-items-center col-12 btn btn-lg" type="submit" style='border-radius:12px; background-color:#56B000; color:white;' id="submit-update-location" onClick="changeToLoadingFormUpdateLocation()">Update</button>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function changeToLoadingFormUpdateLocation() {
        var btn = document.getElementById('submit-update-location');
        btn.innerHTML = '<span class="spinner-border" role="status" aria-hidden="true"></span> Loading...';
        btn.disabled = true;

        // Simulating a delay of 2 seconds for demonstration purposes
        setTimeout(function () {
            // Enable the button and change the text back to "Login" after the delay
            btn.disabled = false;
            btn.innerHTML = 'Submit';

            // Submit the form
            submitFormUpdateLocation();
        }, 2000);
    }

    function submitFormUpdateLocation() {
        // Get the form element
        var form = document.getElementById('form-update-location');

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
                            window.location.href = "{{ route('admin.location.index') }}";
                        }
                    });
                }
            } else {
                // Handle errors
                console.error(xhr.statusText);
                Swal.fire({
                    title: 'Error!',
                    text: 'Location failed to update.',
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

{{-- mencegah enter form --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var form = document.getElementById("form-update-location");

        form.addEventListener("keydown", function (event) {
            if (event.key === "Enter" && !event.shiftKey) {
                event.preventDefault();
                // Mencegah pengguna menekan Enter tanpa klik tombol submit
            }
        });
    });

</script>


@endsection
