<script>
    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

</script>

<script>
    $(document).ready(function () {
        $('.select2').select2();
    });

</script>

<script>
    $(document).ready(function () {

        var urlPath = window.location.pathname;
        var segments = urlPath.split('/');
        var role_id = segments[segments.length - 1];

        $(".select2-permissions").select2({
            ajax: {
                url: "{{ route('admin.roles.select2permissions', '') }}" + '/' + role_id,
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });

</script>

<script>
    $(document).ready(function () {
        $(".select2-role").select2({
            ajax: {
                url: "{{ route('admin.users.select2roles') }}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });

</script>

<script>
    $(document).ready(function () {
        $(".select2-mcu-in-edit-office").select2({
            ajax: {
                url: "{{ route('admin.office.select2mcuineditoffice') }}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });

</script>

<script>
    $(document).ready(function () {
        $(".select2-entry-in-setting-user").select2({
            ajax: {
                url: "{{ route('admin.settinguser.select2entryinsettinguser') }}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });

</script>

<script>
    $(document).ready(function () {
        $(".select2-username-card-in-setting-user").select2({
            ajax: {
                url: "{{ route('admin.settinguser.select2usernamecardinsettinguser') }}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });

</script>

<script>
    $(document).ready(function () {
        $('.select2-status-pekerja-in-setting-user').select2();
    });

</script>

<script>
    $(document).ready(function () {
        $('.select2-status-user-in-setting-user').select2();
    });

</script>

<script>
    $(document).ready(function () {
        $(".select2-office-in-setting-user").select2({
            ajax: {
                url: "{{ route('admin.settinguser.select2kantorinsettinguser') }}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });

</script>

<script>
    $(document).ready(function () {
        var urlPath = window.location.pathname;
        var segments = urlPath.split('/');
        var office_id = segments[segments.length - 1];

        var officeId = $('#office_id').val();
        var cardId = $('#card_id').val();

        $(".select2-mcu").select2({
            ajax: {
                url: "{{ route('admin.card.select2mcu', ['','']) }}" + '/' + officeId + '/' + cardId,
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });

</script>

<script>
    $(document).ready(function () {
        $(".select2-office").select2({
            ajax: {
                url: "{{ route('admin.usermcu.select2office') }}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
        $('.select2-office').on('change', function (e) {
            var title = $(this).select2('data')[0].text;
            $('#item_select2_office').val(title);
        });
    });

</script>

<script>
    $(document).ready(function () {

        // Initialize Select2 based on the initial status_pekerja value
        initializeSelect2EntryInSetting();

        // Event listener for the "Visitor" radio button
        $('#visitor').on('click', function () {
            // Check if the "Visitor" radio button is checked
            if ($(this).is(':checked')) {
                // Set the selected value to null
                setSelectedDefaultValue();
                // Reload the Select2 when "Visitor" is selected
                initializeSelect2EntryInSetting();
            }
        });
        $('#vip').on('click', function () {
            if ($(this).is(':checked')) {
                setSelectedDefaultValue();
                initializeSelect2EntryInSetting();

            }
        });
        $('#keamanan').on('click', function () {
            if ($(this).is(':checked')) {
                setSelectedDefaultValue();
                initializeSelect2EntryInSetting();
            }
        });
        $('#karyawan_kantor').on('click', function () {
            if ($(this).is(':checked')) {
                setSelectedDefaultValue();
                initializeSelect2EntryInSetting();
            }
        });
        $('#reset_kartu').on('click', function () {
            if ($(this).is(':checked')) {
                setSelectedDefaultValue();
                initializeSelect2EntryInSetting();
            } else {
                setSelectedValue();
                initializeSelect2EntryInSetting();
            }
        });

        function initializeSelect2EntryInSetting() {
            var status_pekerja = $("input[name='status_pekerja']:checked").val();
            if (status_pekerja == 'Visitor') {

                var officeId = $('#office_id').val();

                $(".select2-entry").select2({
                    ajax: {
                        url: "{{ route('admin.settinguser.select2entryvisitor', '') }}" + '/' + officeId,
                        type: "post",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                _token: CSRF_TOKEN,
                                search: params.term // search term
                            };
                        },
                        processResults: function (response) {
                            return {
                                results: response
                            };
                        },
                        cache: true
                    }
                });
                $('.select2-entry').on('change', function (e) {
                    var title = $(this).select2('data')[0].text;
                    $('#item_select2_entry').val(title);
                });


            } else {
                var officeId = $('#office_id').val();

                $(".select2-entry").select2({
                    ajax: {
                        url: "{{ route('admin.settinguser.select2entry', '') }}" + '/' + officeId,
                        type: "post",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                _token: CSRF_TOKEN,
                                search: params.term // search term
                            };
                        },
                        processResults: function (response) {
                            return {
                                results: response
                            };
                        },
                        cache: true
                    }
                });
                $('.select2-entry').on('change', function (e) {
                    var title = $(this).select2('data')[0].text;
                    $('#item_select2_entry').val(title);
                });


            }
        }

        // function set to default selected default value
        function setSelectedDefaultValue() {
            $("#selected-disabled-value-setting-user").prop("selected", true);
        }

        function setSelectedValue() {
            $("#selected-disabled-value-setting-user").prop("selected", false);
        }



    });

</script>

<script>
    $(document).ready(function () {
        $(".select2-entry-in-log-accepted").select2({
            ajax: {
                url: "{{ route('admin.log.select2entryinlogaccepted') }}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });

</script>

<script>
    $(document).ready(function () {
        $(".select2-username-mcu-in-log-accepted").select2({
            ajax: {
                url: "{{ route('admin.log.select2usernamemcuinlogaccepted') }}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });

</script>

<script>
    $(document).ready(function () {
        $(".select2-office-in-log-accepted").select2({
            ajax: {
                url: "{{ route('admin.log.select2officeinlogaccepted') }}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });

</script>

<script>
    $(document).ready(function () {
        $(".select2-door-token-in-log-accepted").select2({
            ajax: {
                url: "{{ route('admin.log.select2doortokeninlogaccepted') }}",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });

</script>

<script>
    $(document).ready(function () {
        $('.select2-log-status-in-log-accepted').select2();
    });

</script>
