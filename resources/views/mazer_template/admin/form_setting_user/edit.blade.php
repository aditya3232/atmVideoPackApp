@extends('mazer_template.layouts.app')
@section('title', 'User Mcu Settings')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><i class="bi bi-stack"></i> User Mcu <small class="text-muted">Settings</small></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.usermcu.index') }}">User Mcu List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Mcu Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="mb-4">
                <a href="{{ route('admin.settinguser.index') }}" type="button" class="btn" style='border-radius:12px; background-color:#FFA500; color:white;'><i class="bi bi-arrow-return-left"
                        style="font-size: 13px;"></i></a>
            </div>

            {{-- officeId --}}
            <input type="hidden" id="office_id" name="office_id" value="{{ $data->tb_office_id }}" />

            <form class="form" action="{{ url('admin/settinguser/update/'.$data->id) }}" id="form-update-settinguser" method="POST">
                @csrf
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">

                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="status_pekerja" style="font-weight: bold;">Status Pekerja <span class="text-danger">*</span></label>
                                            <br>
                                            <div class="border p-2 rounded">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status_pekerja" value="Karyawan Kantor"
                                                        {{ old('status_pekerja') == "Karyawan Kantor" || $data->status_pekerja == 'Karyawan Kantor' ? 'checked' : '' }}
                                                        id="karyawan_kantor">
                                                    <label class="form-check-label" for="karyawan_kantor">
                                                        Karyawan Kantor
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status_pekerja" value="Keamanan"
                                                        {{ old('status_pekerja') == "Keamanan" || $data->status_pekerja == 'Keamanan' ? 'checked' : '' }}
                                                        id="keamanan">
                                                    <label class="form-check-label" for="keamanan">
                                                        Keamanan
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status_pekerja" value="VIP"
                                                        {{ old('status_pekerja') == "VIP" || $data->status_pekerja == 'VIP' ? 'checked' : '' }}
                                                        id="vip">
                                                    <label class="form-check-label" for="vip">
                                                        VIP
                                                    </label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="status_pekerja" value="Visitor"
                                                        {{ old('status_pekerja') == "Visitor" || $data->status_pekerja == 'Visitor' ? 'checked' : '' }}
                                                        id="visitor">
                                                    <label class="form-check-label" for="visitor">
                                                        Visitor
                                                    </label>
                                                </div>




                                            </div>
                                            @if($errors->has('status_pekerja'))
                                                <span class="text-danger">{{ $errors->first('status_pekerja') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- ada kondisi jika visitor dan bukan di select2 nya --}}
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="tb_entry_id" style="font-weight: bold;">Pilih Kartu </label>

                                            {{-- make switch bootstrap to run setSelectedDefaultValue(); --}}
                                            <div class="float-start">

                                            </div>
                                            <div class="float-end">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="reset_kartu">
                                                    <label class="form-check-label" for="reset_kartu">Reset Kartu </label>
                                                </div>
                                            </div>

                                            <select class="form-control select2-entry" name="tb_entry_id">
                                                <option id="selected-disabled-value-setting-user" selected disabled value="">Pilih salah satu kartu...</option>
                                                @if(old('tb_entry_id')  != null && old('item_select2_entry') != null)
                                                    <option value="{{ old('tb_entry_id') }}" selected>
                                                        {{ old('item_select2_entry') }}
                                                    </option>
                                                @elseif($data->tb_entry_id != null)
                                                    <option value="{{ $data->tb_entry_id }}" selected>
                                                        {{ $data->no_card }}
                                                    </option>
                                                @endif
                                            </select>

                                            <input type="hidden" id="item_select2_entry" name="item_select2_entry" value="{{ old('item_select2_entry') }}" />
                                            @if($errors->has('tb_entry_id'))
                                                <span class="text-danger">{{ $errors->first('tb_entry_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="keperluan" style="font-weight: bold;">Keperluan <span class="text-danger">*</span></label>
                                            <textarea name="keperluan" id="keperluan" cols="24" class="form-control" placeholder="..."
                                                rows="3">{{ old('keperluan') ? old('keperluan') : $data->keperluan }}</textarea>
                                            @if($errors->has('keperluan'))
                                                <span class="text-danger">{{ $errors->first('keperluan') }}</span>
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
                <button class="align-items-center col-12 btn btn-lg" type="submit" style='border-radius:12px; background-color:#56B000; color:white;' id="submit-update-settinguser"
                    onClick="changeToLoadingFormUpdateSettingUser()">Update</button>
            </div>
        </div>
    </section>
</div>

<script>
    function changeToLoadingFormUpdateSettingUser() {
        var btn = document.getElementById('submit-update-settinguser');
        btn.innerHTML = '<span class="spinner-border" role="status" aria-hidden="true"></span> Loading...';
        btn.disabled = true;

        setTimeout(function () {
            btn.disabled = false;
            btn.innerHTML = 'Update';

            submitFormUpdateSettingUser();
        }, 2000);
    }

    function submitFormUpdateSettingUser() {
        var form = document.getElementById('form-update-settinguser');

        form.submit();
    }

</script>

@endsection
