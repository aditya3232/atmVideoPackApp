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

