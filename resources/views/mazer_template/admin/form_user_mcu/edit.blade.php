@extends('mazer_template.layouts.app')
@section('title', 'User Door Access Update')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><i class="bi bi-stack"></i> User Door Access <small class="text-muted">Update</small></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.usermcu.index') }}">User Door Access List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Door Access Update</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="mb-4">
                <a href="{{ route('admin.usermcu.index') }}" type="button" class="btn" style='border-radius:12px; background-color:#FFA500; color:white;'><i class="bi bi-arrow-return-left" style="font-size: 13px;"></i></a>
            </div>
            <form class="form" action="{{ url('admin/usermcu/update/'.$data->id) }}" id="form-update-usermcu" method="POST">
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
                                            <label for="username_card" style="font-weight: bold">Username <span class="text-danger">*</span></label>
                                            <input type="text" id="username_card" class="form-control" placeholder="..." name="username_card"
                                                value="{{ old('username_card') ? old('username_card') : $data->username_card }}">
                                            @if($errors->has('username_card'))
                                                <span class="text-danger">{{ $errors->first('username_card') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="nama_lengkap" style="font-weight: bold">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" id="nama_lengkap" class="form-control" placeholder="..." name="nama_lengkap"
                                                value="{{ old('nama_lengkap') ? old('nama_lengkap') : $data->nama_lengkap }}">
                                            @if($errors->has('nama_lengkap'))
                                                <span class="text-danger">{{ $errors->first('nama_lengkap') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="nik" style="font-weight: bold">Nik <span class="text-danger">*</span></label>
                                            <input oninput="this.value=this.value.replace(/[^0-9]/g,'');" type="number" id="nik" class="form-control" placeholder="..." name="nik"
                                                value="{{ old('nik') ? old('nik') : $data->nik }}">
                                            @if($errors->has('nik'))
                                                <span class="text-danger">{{ $errors->first('nik') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="jabatan" style="font-weight: bold">Jabatan <span class="text-danger">*</span></label>
                                            <input type="text" id="jabatan" class="form-control" placeholder="..." name="jabatan"
                                                value="{{ old('jabatan') ? old('jabatan') : $data->jabatan }}">
                                            @if($errors->has('jabatan'))
                                                <span class="text-danger">{{ $errors->first('jabatan') }}</span>
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
                <button class="align-items-center col-12 btn btn-lg" type="submit" style='border-radius:12px; background-color:#56B000; color:white;' id="submit-update-usermcu" onClick="changeToLoadingFormUpdateUserMcu()">Update</button>
            </div>
        </div>
    </section>
</div>

<script>
    function changeToLoadingFormUpdateUserMcu() {
        var btn = document.getElementById('submit-update-usermcu');
        btn.innerHTML = '<span class="spinner-border" role="status" aria-hidden="true"></span> Loading...';
        btn.disabled = true;

        setTimeout(function () {
            btn.disabled = false;
            btn.innerHTML = 'Update';

            submitFormUpdateUserMcu();
        }, 2000);
    }

    function submitFormUpdateUserMcu() {
        var form = document.getElementById('form-update-usermcu');

        form.submit();
    }

</script>

@endsection
