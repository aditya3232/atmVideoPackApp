@extends('mazer_template.layouts.app')
@section('title', 'Update KC Supervisi')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Update KC Supervisi</h3>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="mb-4">
                <a href="{{ route('admin.kcsupervisi.index') }}" type="button" class="btn" style='border-radius:12px; background-color:#FFA500; color:white;'><i class="bi bi-arrow-return-left"
                        style="font-size: 13px;"></i></a>
            </div>
            <form class="form" action="{{ url('admin/kcsupervisi/update/'.$data->id) }}" id="form-update-kc-supervisi" method="POST" onsubmit="return false;">
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
                                                <label for="kc_supervisi_name" style="font-weight: bold">Nama KC Supervisi <span class="text-danger">*</span></label>
                                                <div class="position-relative">
                                                    <div class="position-relative">
                                                        <input type="text" id="kc_supervisi_name" class="form-control" placeholder="..." name="kc_supervisi_name"
                                                            value="{{ old('kc_supervisi_name') ? old('kc_supervisi_name') : $data->kc_supervisi_name }}">
                                                        <div class="form-control-icon">
                                                            @include('mazer_template.layouts.icons.alphabet')
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
                    </div>
                </div>
            </form>
            <div class="d-grid gap-2 mt-4">
                <button class="align-items-center col-12 btn btn-lg" type="submit" style='border-radius:12px; background-color:#56B000; color:white;' id="submit-update-kc-supervisi"
                    onClick="changeToLoadingFormUpdateKcSupervisi()">Update</button>
            </div>
        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function changeToLoadingFormUpdateKcSupervisi() {
        var btn = document.getElementById('submit-update-kc-supervisi');
        btn.innerHTML = '<span class="spinner-border" role="status" aria-hidden="true"></span> Loading...';
        btn.disabled = true;

        // Simulating a delay of 2 seconds for demonstration purposes
        setTimeout(function () {
            // Enable the button and change the text back to "Login" after the delay
            btn.disabled = false;
            btn.innerHTML = 'Submit';

            // Submit the form
            submitFormUpdateKcSupervisi();
        }, 2000);
    }

    function submitFormUpdateKcSupervisi() {
        // Get the form element
        var form = document.getElementById('form-update-kc-supervisi');

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
                            window.location.href = "{{ route('admin.kcsupervisi.index') }}";
                        }
                    });
                }
            } else {
                // Handle errors
                console.error(xhr.statusText);
                Swal.fire({
                    title: 'Error!',
                    text: 'KC Supervisi failed to update.',
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
        var form = document.getElementById("form-update-kc-supervisi");

        form.addEventListener("keydown", function (event) {
            if (event.key === "Enter" && !event.shiftKey) {
                event.preventDefault();
                // Mencegah pengguna menekan Enter tanpa klik tombol submit
            }
        });
    });

</script>


@endsection
