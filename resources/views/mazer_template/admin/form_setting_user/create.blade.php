@extends('mazer_template.layouts.app')
@section('title', 'Office Create')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><i class="bi bi-gear-fill"></i> Office <small class="text-muted">Create</small></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.office.index') }}">Office List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Office Create</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="mb-4">
                <a href="{{ route('admin.office.index') }}" type="button" class="btn" style='border-radius:12px; background-color:#FFA500; color:white;'><i class="bi bi-arrow-return-left" style="font-size: 13px;"></i></a>
            </div>
            <form class="form" action="{{ route('admin.office.store') }}" id="form-create-office" method="POST">
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
                                            <label for="office_name" style="font-weight: bold">Nama Kantor</label>
                                            <input type="text" id="office_name" class="form-control" placeholder="..." name="office_name"
                                                value="{{ old('office_name') ? old('office_name') : '' }}">
                                            @if($errors->has('office_name'))
                                                <span class="text-danger">{{ $errors->first('office_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="address_office" style="font-weight: bold">Alamat Kantor</label>
                                            <textarea name="address_office" id="address_office" cols="24" class="form-control" placeholder="..."
                                                rows="3">{{ old('address_office') ? old('address_office') : '' }}</textarea>
                                            @if($errors->has('address_office'))
                                                <span class="text-danger">{{ $errors->first('address_office') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="kode_pos" style="font-weight: bold">Kode Pos</label>
                                            <input oninput="this.value=this.value.replace(/[^0-9]/g,'');" type="number" id="kode_pos" class="form-control" placeholder="..." name="kode_pos"
                                                value="{{ old('kode_pos') ? old('kode_pos') : '' }}">
                                            @if($errors->has('kode_pos'))
                                                <span class="text-danger">{{ $errors->first('kode_pos') }}</span>
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
                <button class="btn btn-primary btn-lg" type="submit" id="submit-create-office" onClick="changeToLoadingFormTambahOffice()">Submit</button>
            </div>
        </div>
    </section>
</div>

<script>
    function changeToLoadingFormTambahOffice() {
        var btn = document.getElementById('submit-create-office');
        btn.innerHTML = '<span class="spinner-border" role="status" aria-hidden="true"></span> Loading...';
        btn.disabled = true;

        setTimeout(function () {
            btn.disabled = false;
            btn.innerHTML = 'Submit';

            submitFormOffice();
        }, 2000);
    }

    function submitFormOffice() {
        var form = document.getElementById('form-create-office');

        form.submit();
    }

</script>

@endsection
