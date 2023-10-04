<script>
    $(document).ready(function () {
        $('#table1').DataTable();
    });

</script>

<script>
    $(document).ready(function () {
        $('#permissions').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.permissions.datatable') }}",
                dataType: "json",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Do something here
                    console.log(Error);
                }
            },
            columns: [{
                    data: null,
                    "sortable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    width: "50px"
                },
                {
                    data: "name"
                },
                {
                    data: "options",
                    "sortable": false,
                    width: "120px"
                }
            ],
            order: [
                [1, 'desc']
            ],
            language: {
                paginate: {
                    previous: '&laquo;',
                    next: '&raquo;'
                },
                info: "_START_ to _END_ of _TOTAL_ results",
                lengthMenu: "show _MENU_ per page" // Change "entries" to "per page"
            },

        });
        // search change form input more rounded
        $('.dataTables_filter input[type="search"]').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',

            'background-image': 'url("{{ asset('assets/images/samples/search-png.png') }}")',
            'background-repeat': 'no-repeat',
            'background-position': 'right',
            'background-size': '25px',

        });

        // select show with border radius
        $('.dataTables_length select').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',
            // add more wide select
            'width': '80px',
            // text arial
            'font-family': 'Arial',
        });

        // border radius for table
        // $('.dataTables_wrapper').css({
        //     'border-radius': '15px',
        //     'border': '3px solid #ebebeb',
        //     'padding-left': '20px',
        //     'padding-right': '20px',
        //     'padding-top': '5px',
        //     'padding-bottom': '5px',
        //     'margin-bottom': '10px',
        //     'margin-top': '10px',
        //     'color': 'black',
        //     'width': '100%'
        // });

        $('.dataTables_wrapper').css({
            'color': 'black',
        });

        $('.dataTables_wrapper').find('tr').css({
            'color': 'black',
        });

        // change template pagination
        $('#permissions').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%', // Make it circular
            });
        });
    });

</script>

<script>
    $(document).ready(function () {
        $('#roles').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.roles.datatable') }}",
                dataType: "json",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Do something here
                    console.log(Error);
                }
            },
            columns: [{
                    data: null,
                    "sortable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    width: "50px"
                },
                {
                    data: "name"
                },
                {
                    data: "options",
                    "sortable": false,
                    width: "100px"
                }
            ],
            order: [
                [0, 'desc']
            ],
            language: {
                paginate: {
                    previous: '&laquo;',
                    next: '&raquo;'
                },
                info: "_START_ to _END_ of _TOTAL_ results",
                lengthMenu: "show _MENU_ per page"
            },

        });
        $('.dataTables_filter input[type="search"]').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',

            'background-image': 'url("{{ asset('assets/images/samples/search-png.png') }}")',
            'background-repeat': 'no-repeat',
            'background-position': 'right',
            'background-size': '25px',

        });

        $('.dataTables_length select').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',
            'width': '80px',
            'font-family': 'Arial',
        });

        $('.dataTables_wrapper').css({
            'color': 'black',
        });

        $('.dataTables_wrapper').find('tr').css({
            'color': 'black',
        });

        $('#roles').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%',
            });
        });
    });

</script>

<script>
    $(document).ready(function () {
        $('#users').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.users.datatable') }}",
                dataType: "json",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Do something here
                    console.log(Error);
                }
            },
            columns: [{
                    data: null,
                    "sortable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    width: "50px"
                },
                {
                    data: "name"
                },
                {
                    data: "username",
                },
                {
                    data: "role"
                },
                {
                    data: "options",
                    sortable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        if (row.authId === row.id) {
                            return "";
                        } else {
                            return data;
                        }
                    },
                    width: "100px"
                }
            ],
            order: [
                [3, 'desc']
            ],
            language: {
                paginate: {
                    previous: '&laquo;',
                    next: '&raquo;'
                },
                info: "_START_ to _END_ of _TOTAL_ results",
                lengthMenu: "show _MENU_ per page"
            },

        });
        $('.dataTables_filter input[type="search"]').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',

            'background-image': 'url("{{ asset('assets/images/samples/search-png.png') }}")',
            'background-repeat': 'no-repeat',
            'background-position': 'right',
            'background-size': '25px',

        });

        $('.dataTables_length select').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',
            'width': '80px',
            'font-family': 'Arial',
        });

        $('.dataTables_wrapper').css({
            'color': 'black',
        });

        $('.dataTables_wrapper').find('tr').css({
            'color': 'black',
        });

        $('#users').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%',
            });
        });
    });

</script>

<script>
    var table_form_log_accepted;
    $(document).ready(function () {
        table_form_log_accepted = $('#form_log_accepted').DataTable({
            searching: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.log.datatableaccepted') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                type: "POST",
                data: function (data) {
                    // ambil value text dari filter select2
                    var filter_username_card = $('#select2-username-mcu-in-log-accepted').find('option:selected').text();
                    var filter_no_card = $('#select2-entry-in-log-accepted').find('option:selected').text();
                    var filter_door_token = $('#select2-door-token-in-log-accepted').find('option:selected').text();
                    var filter_log_status = $('#select2-log-status-in-log-accepted').find('option:selected').val();
                    var filter_log_status_text = $('#select2-log-status-in-log-accepted').find('option:selected').text();
                    var filter_location_access = $('#select2-office-in-log-accepted').find('option:selected').text();

                    // var filter_start_date_time = find datetime-local
                    var filter_start_date_time = $('#input-start-date-time-in-log-accepted').val();
                    filter_start_date_time = filter_start_date_time.replace("T", " ");


                    var filter_end_date_time = $('#input-end-date-time-in-log-accepted').val();
                    filter_end_date_time = filter_end_date_time.replace("T", " ");

                    // set datanya ke controller agar bisa difilter
                    data.username_card = filter_username_card; // data.sekian disesuaikan dengan form request nya
                    data.no_card = filter_no_card;
                    data.door_token = filter_door_token;
                    data.office_name = filter_location_access;
                    data.log_status = filter_log_status;
                    data.start_date_time = filter_start_date_time;
                    data.end_date_time = filter_end_date_time;

                    // set ke last filternya
                    $('#last_fitler_username_card').text(filter_username_card);
                    $('#last_filter_no_card').text(filter_no_card);
                    $('#last_filter_door_token').text(filter_door_token);
                    $('#last_filter_location_access').text(filter_location_access);
                    $('#last_filter_log_status').text(filter_log_status_text);

                    // time
                    $('#last_filter_start_date_time').text(filter_start_date_time);
                    $('#last_filter_end_date_time').text(filter_end_date_time);
                },

                error: function (jqXHR, textStatus, errorThrown) {
                    // Do something here
                    console.log(Error);
                }
            },
            columns: [{
                    data: null,
                    "sortable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    width: "50px"
                },
                {
                    data: "username_card"
                },
                {
                    data: "no_card"
                },
                {
                    data: "door_token"
                },
                {
                    data: "office_name"
                },
                {
                    data: "log_status"
                },
                {
                    data: "created_at",
                    render: function (data) {
                        if (!data) return '';
                        const date = new Date(data);
                        const options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: 'numeric',
                            minute: 'numeric',
                            second: 'numeric'
                        };
                        return new Intl.DateTimeFormat('en-US', options).format(date);
                    },
                    width: "250px"
                },
            ],
            order: [
                [6, 'desc']
            ],
            language: {
                paginate: {
                    previous: '&laquo;',
                    next: '&raquo;'
                },
                info: "_START_ to _END_ of _TOTAL_ results",
                lengthMenu: "show _MENU_ per page"
            },

        });
        $('.dataTables_filter input[type="search"]').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',

            'background-image': 'url("{{ asset('assets/images/samples/search-png.png') }}")',
            'background-repeat': 'no-repeat',
            'background-position': 'right',
            'background-size': '25px',

        });

        $('.dataTables_length select').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',
            'width': '80px',
            'font-family': 'Arial',
        });

        $('.dataTables_wrapper').css({
            'color': 'black',
        });

        $('.dataTables_wrapper').find('tr').css({
            'color': 'black',
        });

        $('#form_log_accepted').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%',
            });
        });

        // filter
        $('#btn-filter-log-accepted').click(function () { //button filter event click
            table_form_log_accepted.ajax.reload(); //just reload table
        });

        // reset filter
        $('#btn-reset-filter-log-accepted').click(function () { //button reset event click
            $('#form-filter-log-accepted')[0].reset();
            $("#select2-username-mcu-in-log-accepted").val(null).trigger("change"); // reset select2
            $("#select2-entry-in-log-accepted").val(null).trigger("change"); // reset select2
            $("#select2-door-token-in-log-accepted").val(null).trigger("change"); // reset select2
            $("#select2-office-in-log-accepted").val(null).trigger("change"); // reset select2
            $("#input-start-date-time-in-log-accepted").val(null).trigger("change"); // reset select2
            $("#input-end-date-time-in-log-accepted").val(null).trigger("change"); // reset select2
            $("#select2-log-status-in-log-accepted").val(null).trigger("change"); // reset select2
            table_form_log_accepted.ajax.reload(); //just reload table
        });

    });

</script>

<script>
    $(document).ready(function () {
        $('#form_user_mcu').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('admin.usermcu.datatable') }}",
                dataType: "json",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Do something here
                    console.log(Error);
                }
            },
            columns: [{
                    data: null,
                    "sortable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    width: "50px"
                },
                {
                    data: "username_card"
                },
                {
                    data: "nama_lengkap"
                },
                {
                    data: "nik"
                },
                {
                    data: "jabatan"
                },
                {
                    data: "office_name"
                },
                {
                    data: "created_at",
                    render: function (data) {
                        if (!data) return '';
                        const date = new Date(data);
                        const options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: 'numeric',
                            minute: 'numeric',
                            second: 'numeric'
                        };
                        return new Intl.DateTimeFormat('en-US', options).format(date);
                    },
                    width: "250px"
                },
                {
                    data: "options",
                    "sortable": false,
                    width: "150px"
                }
            ],
            order: [
                [6, 'desc']
            ],
            language: {
                paginate: {
                    previous: '&laquo;',
                    next: '&raquo;'
                },
                info: "_START_ to _END_ of _TOTAL_ results",
                lengthMenu: "show _MENU_ per page"
            },

        });
        $('.dataTables_filter input[type="search"]').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',

            'background-image': 'url("{{ asset('assets/images/samples/search-png.png') }}")',
            'background-repeat': 'no-repeat',
            'background-position': 'right',
            'background-size': '25px',

        });

        $('.dataTables_length select').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',
            'width': '80px',
            'font-family': 'Arial',
        });

        $('.dataTables_wrapper').css({
            'color': 'black',
        });

        $('.dataTables_wrapper').find('tr').css({
            'color': 'black',
        });

        $('#form_user_mcu').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%',
            });
        });

    });

</script>

<script>
    $(document).ready(function () {
        $('#form_office').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.office.datatable') }}",
                dataType: "json",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Do something here
                    console.log(Error);
                }
            },
            columns: [{
                    data: null,
                    "sortable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    width: "50px"
                },
                {
                    data: "office_name"
                },
                {
                    data: "address_office",
                    width: "500px"
                },
                {
                    data: "kode_pos"
                },
                {
                    data: "created_at",
                    render: function (data) {
                        if (!data) return '';
                        const date = new Date(data);
                        const options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: 'numeric',
                            minute: 'numeric',
                            second: 'numeric'
                        };
                        return new Intl.DateTimeFormat('en-US', options).format(date);
                    },
                    width: "250px"
                },
                {
                    data: "options",
                    "sortable": false,
                    width: "150px"
                }
            ],
            order: [
                [3, 'desc']
            ],
            language: {
                paginate: {
                    previous: '&laquo;',
                    next: '&raquo;'
                },
                info: "_START_ to _END_ of _TOTAL_ results",
                lengthMenu: "show _MENU_ per page"
            },
        });

        $('.dataTables_filter input[type="search"]').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',

            'background-image': 'url("{{ asset('assets/images/samples/search-png.png') }}")',
            'background-repeat': 'no-repeat',
            'background-position': 'right',
            'background-size': '25px',

        });

        $('.dataTables_length select').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',
            'width': '80px',
            'font-family': 'Arial',
        });

        $('.dataTables_wrapper').css({
            'color': 'black',
        });

        $('.dataTables_wrapper').find('tr').css({
            'color': 'black',
        });

        $('#form_office').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%',
            });
        });

    });

</script>

<script>
    var table_form_setting_user;
    $(document).ready(function () {
        table_form_setting_user = $('#form_setting_user').DataTable({
            searching: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.settinguser.datatable') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                type: "POST",
                data: function (data) {
                    // ambil value text dari filter select2
                    var fitler_no_card = $('#select2-entry-in-setting-user').find('option:selected').text();
                    var filter_username = $('#select2-username-card-in-setting-user').find('option:selected').text();
                    var filter_status_pekerja = $('#select2-status-pekerja-in-setting-user').find('option:selected').text();
                    var filter_status_user = $('#select2-status-user-in-setting-user').find('option:selected').val();
                    var filter_status_user_text = $('#select2-status-user-in-setting-user').find('option:selected').text();
                    var filter_lokasi_kantor_user = $('#select2-office-in-setting-user').find('option:selected').text();
                    var filter_lokasi_kantor_yang_dikunjungi = $('#select2-office-dikunjungi-in-setting-user').find('option:selected').text();

                    // set datanya ke controller agar bisa difilter
                    data.no_card = fitler_no_card; // data.sekian disesuaikan dengan form request nya
                    data.username_card = filter_username;
                    data.status_pekerja = filter_status_pekerja;
                    data.status_user = filter_status_user;
                    data.office_name = filter_lokasi_kantor_user;
                    data.lokasi_kantor_yg_dikunjungi = filter_lokasi_kantor_yang_dikunjungi;

                    // set ke last filternya
                    $('#last_fitler_no_card').text(fitler_no_card);
                    $('#last_filter_username').text(filter_username);
                    $('#last_filter_status_pekerja').text(filter_status_pekerja);
                    $('#last_filter_status_user').text(filter_status_user_text);
                    $('#last_filter_lokasi_kantor_user').text(filter_lokasi_kantor_user);
                    $('#last_filter_lokasi_kantor_yang_dikunjungi').text(filter_lokasi_kantor_yang_dikunjungi);
                },

                error: function (jqXHR, textStatus, errorThrown) {
                    // Do something here
                    console.log(Error);
                }
            },
            columns: [{
                    data: null,
                    "sortable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    width: "50px" // Adjust the width as needed
                },
                {
                    data: "no_card"
                },
                {
                    data: "username_card"
                },
                {
                    data: "status_pekerja"
                },
                {
                    data: "status_user"
                },
                {
                    data: "office_name"
                },
                {
                    data: "lokasi_kantor_yg_dikunjungi"
                },
                {
                    data: "options",
                    "sortable": false,
                }
            ],
            order: [
                [5, 'desc']
            ],
            // dom: '<"top"lf>rt<"bottom"ip><"clear">',
            // pagingType: "full_numbers",
            language: {
                paginate: {
                    previous: '&laquo;',
                    next: '&raquo;'
                },
                info: "_START_ to _END_ of _TOTAL_ results",
                lengthMenu: "show _MENU_ per page" // Change "entries" to "per page"
            },
        });

        // search change form input more rounded
        $('.dataTables_filter input[type="search"]').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',

            'background-image': 'url("{{ asset('assets/images/samples/search-png.png') }}")',
            'background-repeat': 'no-repeat',
            'background-position': 'right',
            'background-size': '25px',

        });

        // select show with border radius
        $('.dataTables_length select').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',
            // add more wide select
            'width': '80px',
            // text arial
            'font-family': 'Arial',
        });

        $('.dataTables_wrapper').css({
            'color': 'black',
        });

        $('.dataTables_wrapper').find('tr').css({
            'color': 'black',
        });

        // change template pagination
        $('#form_setting_user').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%', // Make it circular
            });
        });

        // filter
        $('#btn-filter-setting-user-mcu').click(function () { //button filter event click
            table_form_setting_user.ajax.reload(); //just reload table
        });

        // reset filter
        $('#btn-reset-filter-setting-user-mcu').click(function () { //button reset event click
            $('#form-filter-setting-user-mcu')[0].reset();
            $("#select2-entry-in-setting-user").val(null).trigger("change"); // reset select2
            $("#select2-username-card-in-setting-user").val(null).trigger("change"); // reset select2
            $("#select2-status-pekerja-in-setting-user").val(null).trigger("change"); // reset select2
            $("#select2-status-user-in-setting-user").val(null).trigger("change"); // reset select2
            $("#select2-office-in-setting-user").val(null).trigger("change"); // reset select2
            $("#select2-office-dikunjungi-in-setting-user").val(null).trigger("change"); // reset select2
            table_form_setting_user.ajax.reload(); //just reload table
        });

    });

</script>

<script>
    $(document).ready(function () {
        $('#form_card').DataTable({

            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.card.datatable') }}",
                dataType: "json",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Do something here
                    console.log(Error);
                }
            },
            columns: [{
                    data: null,
                    "sortable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    width: "50px" // Adjust the width as needed
                },
                {
                    data: "no_card"
                },
                {
                    data: "office_name"
                },
                {
                    data: "created_at",
                    render: function (data) {
                        if (!data) return '';
                        const date = new Date(data);
                        const options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: 'numeric',
                            minute: 'numeric',
                            second: 'numeric'
                        };
                        return new Intl.DateTimeFormat('en-US', options).format(date);
                    }
                },
                {
                    data: "options",
                    "sortable": false,
                    width: "100px"
                }
            ],
            order: [
                [3, 'desc']
            ],
            language: {
                paginate: {
                    previous: '&laquo;',
                    next: '&raquo;'
                },
                info: "_START_ to _END_ of _TOTAL_ results",
                lengthMenu: "show _MENU_ per page"
            },
        });

        $('.dataTables_filter input[type="search"]').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',

            'background-image': 'url("{{ asset('assets/images/samples/search-png.png') }}")',
            'background-repeat': 'no-repeat',
            'background-position': 'right',
            'background-size': '25px',

        });

        $('.dataTables_length select').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',
            'width': '80px',
            'font-family': 'Arial',
        });

        $('.dataTables_wrapper').css({
            'color': 'black',
        });

        $('.dataTables_wrapper').find('tr').css({
            'color': 'black',
        });

        $('#form_card').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%',
            });
        });

    });

</script>

<script>
    $(document).ready(function () {
        $('#form_mcu').DataTable({

            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.mcu.datatable') }}",
                dataType: "json",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Do something here
                    console.log(Error);
                }
            },
            columns: [{
                    data: null,
                    "sortable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    width: "50px" // Adjust the width as needed
                },
                {
                    data: "door_token"
                },
                {
                    data: "door_name_mcu"
                },
                {
                    data: "type_mcu"
                },
                {
                    data: "keypad_password"
                },
                {
                    data: "delay"
                },
                {
                    data: "office_name"
                },
                {
                    data: "created_at",
                    render: function (data) {
                        if (!data) return '';
                        const date = new Date(data);
                        const options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: 'numeric',
                            minute: 'numeric',
                            second: 'numeric'
                        };
                        return new Intl.DateTimeFormat('en-US', options).format(date);
                    },
                    width: "250px"
                },
                {
                    data: "options",
                    "sortable": false,
                    width: "100px"
                }
            ],
            order: [
                [3, 'desc']
            ],
            language: {
                paginate: {
                    previous: '&laquo;',
                    next: '&raquo;'
                },
                info: "_START_ to _END_ of _TOTAL_ results",
                lengthMenu: "show _MENU_ per page"
            },
        });

        $('.dataTables_filter input[type="search"]').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',

            // add icon in my input search in right
            'background-image': 'url("{{ asset('assets/images/samples/search-png.png') }}")',
            'background-repeat': 'no-repeat',
            'background-position': 'right',
            'background-size': '25px',
        });

        // add search icon in input search
        // $('.dataTables_filter input[type="search"]').attr('placeholder', 'Search');

        $('.dataTables_length select').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',
            'width': '80px',
            'font-family': 'Arial',
        });

        $('.dataTables_wrapper').css({
            'color': 'black',
        });

        // tr color
        $('.dataTables_wrapper').find('tr').css({
            'color': 'black',
        });

        $('#form_mcu').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%',
            });
        });

    });

</script>

<script>
    $(document).ready(function () {
        $('#total_card_mcu').DataTable({
            // disable search
            searching: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.datatabletotalcardmcu') }}",
                dataType: "json",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Do something here
                    console.log(Error);
                }
            },
            columns: [{
                    data: null,
                    "sortable": false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    width: "50px" // Adjust the width as needed
                },
                {
                    data: "office_name"
                },
                {
                    data: "total_card"
                },
                {
                    data: "total_mcu"
                },
            ],
            order: [
                [1, 'asc']
            ],
            language: {
                paginate: {
                    previous: '&laquo;',
                    next: '&raquo;'
                },
                info: "_START_ to _END_ of _TOTAL_ results",
                lengthMenu: "show _MENU_ per page"
            },
        });

        $('.dataTables_filter input[type="search"]').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',

            // add icon in my input search in right
            'background-image': 'url("{{ asset('assets/images/samples/search-png.png') }}")',
            'background-repeat': 'no-repeat',
            'background-position': 'right',
            'background-size': '25px',
        });

        // add search icon in input search
        // $('.dataTables_filter input[type="search"]').attr('placeholder', 'Search');

        $('.dataTables_length select').css({
            'border-radius': '15px',
            'border': '1px solid #ebebeb',
            'padding-left': '20px',
            'padding-right': '20px',
            'padding-top': '5px',
            'padding-bottom': '5px',
            'margin-bottom': '10px',
            'margin-top': '10px',
            'width': '80px',
            'font-family': 'Arial',
        });

        $('.dataTables_wrapper').css({
            'color': 'black',
        });

        // tr color
        $('.dataTables_wrapper').find('tr').css({
            'color': 'black',
        });

        $('#total_card_mcu').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%',
            });
        });

    });

</script>
