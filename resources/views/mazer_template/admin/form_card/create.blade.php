@extends('mazer_template.layouts.app')
@section('title', 'Tambah Card')
@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><i class="bi bi-gear-fill"></i> Card <small class="text-muted">Create</small></h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.card.index') }}">Card List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Card Create</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="mb-4">
                <a href="{{ route('admin.card.index') }}" type="button" class="btn" style='border-radius:12px; background-color:#FFA500; color:white;'><i class="bi bi-arrow-return-left" style="font-size: 13px;"></i></a>
            </div>
            <form class="form" action="{{ route('admin.card.store') }}" id="form-create-card" method="POST">
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
                                            <label for="no_card" style="font-weight: bold">No Card <span class="text-danger">*</span></label>
                                            <input type="text" id="no_card" class="form-control" placeholder="..." name="no_card"
                                                value="{{ old('no_card') ? old('no_card') : '' }}">
                                            @if($errors->has('no_card'))
                                                <span class="text-danger">{{ $errors->first('no_card') }}</span>
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
                <button class="align-items-center col-12 btn btn-lg" type="submit" style='border-radius:12px; background-color:#56B000; color:white;' id="submit-create-card" onClick="changeToLoadingFormCard()">Create</button>
            </div>
        </div>
    </section>
</div>

<script>
    function changeToLoadingFormCard() {
        var btn = document.getElementById('submit-create-card');
        btn.innerHTML = '<span class="spinner-border" role="status" aria-hidden="true"></span> Loading...';
        btn.disabled = true;

        setTimeout(function () {
            btn.disabled = false;
            btn.innerHTML = 'Create';

            submitFormCard();
        }, 2000);
    }

    function submitFormCard() {
        var form = document.getElementById('form-create-card');

        form.submit();
    }

</script>

@endsection
