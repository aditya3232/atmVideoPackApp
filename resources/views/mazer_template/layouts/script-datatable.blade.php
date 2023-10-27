<script>
    $(document).ready(function () {
        $('#table1').DataTable();
    });

</script>

<script>
    $(document).ready(function () {
        $('#table_client_side').DataTable({
            processing: true,
            serverSide: false,
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
        $('#table_client_side').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%', // Make it circular
            });
        });
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

{{-- master data branch --}}
<script>
    $(document).ready(function () {
        $('#form_branch').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('admin.branch.datatable') }}",
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
                    data: "branch_name"
                },
                {
                    data: "branch_code"
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
                [2, 'desc']
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

        $('#form_branch').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%',
            });
        });

    });

</script>

{{-- master kc supervisi --}}
<script>
    $(document).ready(function () {
        $('#form_kc_supervisi').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('admin.kcsupervisi.datatable') }}",
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
                    data: "kc_supervisi_name"
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
                [1, 'desc']
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

        $('#form_kc_supervisi').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%',
            });
        });

    });

</script>

{{-- master regional office --}}
<script>
    $(document).ready(function () {
        $('#form_regional_office').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('admin.regionaloffice.datatable') }}",
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
                    data: "regional_office_name"
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
                [1, 'desc']
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

        $('#form_regional_office').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%',
            });
        });

    });

</script>

{{-- master location --}}
<script>
    $(document).ready(function () {
        $('#form_location').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('admin.location.datatable') }}",
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
                    data: "regional_office_name"
                },
                {
                    data: "kc_supervisi_name"
                },
                {
                    data: "branch_name"
                },
                {
                    data: "address"
                },
                {
                    data: "postal_code"
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
                [1, 'desc']
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

        $('#form_location').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%',
            });
        });

    });

</script>

{{-- master data tid / device --}}
<script>
    $(document).ready(function () {
        $('#form_device').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('admin.device.datatable') }}",
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
                    data: "tid"
                },
                {
                    data: "sn_mini_pc"
                },
                {
                    data: "regional_office_name"
                },
                {
                    data: "kc_supervisi_name"
                },
                {
                    data: "branch_name"
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
                [5, 'desc']
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

        $('#form_device').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%',
            });
        });

    });

</script>

{{-- human detection --}}
<script>
    $(document).ready(function () {
        $('#form_human_detection').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('admin.humandetection.datatable') }}",
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
                    data: "file_name_capture_human_detection"
                },
                {
                    data: "tid"
                },
                {
                    data: "regional_office_name"
                },
                {
                    data: "kc_supervisi_name"
                },
                {
                    data: "branch_name"
                },
                {
                    data: "person"
                },
                {
                    data: "date_time",
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

        $('#form_human_detection').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%',
            });
        });

    });

</script>
<script>
    $(document).ready(function () {
        $('#form_human_detection_client_side').DataTable({
            processing: true,
            serverSide: false,
            searching: false,
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

    });

</script>

{{-- vandal detection --}}
<script>
    $(document).ready(function () {
        $('#form_vandal_detection').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('admin.vandaldetection.datatable') }}",
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
                    data: "file_name_capture_vandal_detection"
                },
                {
                    data: "tid"
                },
                {
                    data: "regional_office_name"
                },
                {
                    data: "kc_supervisi_name"
                },
                {
                    data: "branch_name"
                },
                {
                    data: "person"
                },
                {
                    data: "date_time",
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

        $('#form_vandal_detection').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%',
            });
        });

    });

</script>
<script>
    $(document).ready(function () {
        $('#form_vandal_detection_client_side').DataTable({
            processing: true,
            serverSide: false,
            searching: false,
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

    });

</script>

{{-- streaming cctv --}}
<script>
    $(document).ready(function () {
        $('#form_streaming_cctv').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('admin.streamingcctv.datatable') }}",
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
                    data: "tid"
                },
                {
                    data: "regional_office_name"
                },
                {
                    data: "kc_supervisi_name"
                },
                {
                    data: "branch_name"
                },
                {
                    data: "options",
                    "sortable": false,
                    width: "150px"
                }
            ],
            order: [
                [4, 'desc']
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

        $('#form_streaming_cctv').DataTable().on('draw.dt', function () {
            $('.dataTables_paginate > .pagination > li > a').css({
                'border-radius': '100%',
            });
        });

    });

</script>

{{-- download playback --}}
<script>
    $(document).ready(function () {
        $('#form_download_playback_client_side').DataTable({
            processing: true,
            serverSide: false,
            searching: false,
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

    });

</script>
