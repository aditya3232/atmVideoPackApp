@extends('mazer_template.layouts.app')
@section('title', 'Detail Kantor')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Detail Kantor</h3>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="mb-4">
                <a href="{{ route('admin.office.index') }}" type="button" class="btn btn-primary"><i class="bi bi-arrow-return-left" style="font-size: 13px;"></i> Kembali</a>
                {{-- <a type="button" class="btn btn-danger" id="cetak-pdf-form-sim" onClick="cetakPdfFormSim()"><i class="bi bi-printer" style="font-size: 13px;"></i> Cetak Pdf</a> --}}
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="clearfix mb-0 mt-2 text-muted mx-5">
                        <div class="float-start">
                            <p></p>
                        </div>
                        <div class="float-end">
                            <table class="table table-bordered">
                                <tr>
                                    <td>
                                        <p class="font-weight-bold text-primary"><i class="bi bi-clock"></i> created at :
                                            {{ ''.\Carbon\Carbon::parse($data->created_at)->format('F j, Y, g:i a') }}
                                        </p>
                                        @if($data->updated_at)
                                            <p class="font-weight-bold text-primary"><i class="bi bi-clock"></i> updated at:
                                                {{ \Carbon\Carbon::parse($data->updated_at)->format('F j, Y, g:i a') }}
                                            </p>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">1. Data Kantor</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="office_name" style="font-weight: bold">Nama Kantor</label>
                                        <input type="text" id="office_name" class="form-control" placeholder="..." name="office_name"
                                            value="{{ old('office_name') ? old('office_name') : $data->office_name }}" disabled>
                                        @if($errors->has('office_name'))
                                            <span class="text-danger">{{ $errors->first('office_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="office_address" style="font-weight: bold">Alamat Kantor</label>
                                        <textarea name="office_address" id="office_address" cols="24" class="form-control" placeholder="..." rows="3"
                                            disabled>{{ old('office_address') ? old('office_address') : $data->office_address }}</textarea>
                                        @if($errors->has('office_address'))
                                            <span class="text-danger">{{ $errors->first('office_address') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="kode_pos" style="font-weight: bold">Kode Pos <span class="text-danger">*</span></label>
                                        <input oninput="this.value=this.value.replace(/[^0-9]/g,'');" type="number" id="kode_pos" class="form-control" placeholder="..." name="kode_pos"
                                            value="{{ old('kode_pos') ? old('kode_pos') : $data->kode_pos }}" disabled>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">2. Daftar MCU di Kantor: <span class='badge bg-primary mb-2'>{{ $data->office_name }}</span></h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="table-responsive mt-4 mb-4" style="width: 100%;">
                                        <table class="table table-striped table-bordered" id="form_mcu_in_this_office" style="border-collapse: collapse; width: 100%; table-layout: fixed;">
                                            <thead>
                                                <tr>
                                                    <th style="border: 1px solid #ddd; padding: 8px; width: 5%;">No</th>
                                                    <th style="border: 1px solid #ddd; padding: 8px; width: 15%;">Door Token</th>
                                                    <th style="border: 1px solid #ddd; padding: 8px; width: 15%;">Door Name MCU</th>
                                                    <th style="border: 1px solid #ddd; padding: 8px; width: 15%;">Type MCU</th>
                                                    <th style="border: 1px solid #ddd; padding: 8px; width: 15%;">Keypad Password</th>
                                                    <th style="border: 1px solid #ddd; padding: 8px; width: 15%;">Delay</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection
