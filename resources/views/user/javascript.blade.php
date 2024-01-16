@push('after-script')
    <script type="text/javascript">
        var table = ".data-table";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#role_id').select2({
        dropdownParent: "#modalUser",
        placeholder: "Select",
        allowClear: true,
        ajax: {
            url: "{{ route('user.getRoles') }}",
            dataType: 'json',
            data: function (params) {
                var queryParameters = {
                    q: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: data.data
                };
            }
        }
    });

        $(function() {
            table = $(table).DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('user.table') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'get_roles.role_code',
                        name: 'get_roles.role_code'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });


        onEdit = (id) => {
            $("#user_id").val(id);
            $.ajax({
                url: "{{ url('user/show') }}",
                data: {
                    id
                },
                method: 'POST',
                success: function(data) {
                    $("#name").val(data.data.name);
                    $("#username").val(data.data.username);
                    $("#email").val(data.data.email);
                    $("#password").val(data.data.password);
                    $("#password2").val(data.data.password2);
                    $("#role").val(data.data.role_id);
                    $("#modalUser").modal('show');
                },
                error: function() {
                    Swal.fire({
                        success: false,
                        title: "Error",
                        message: "System error!"
                    });
                }
            });
        }

        onSave = () => {
            $.ajax({
                data: $('#form-user').serialize(),
                url: "{{ url('user') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#form-user').trigger("reset");
                    $("#modalUser").modal('hide');
                    $("#user_id").val('');

                    table.draw();
                },
                error: function(data) {
                    console.log('Error:', data);
                    Swal.fire({
                        success: false,
                        title: "Error",
                        message: "System error!"
                    });
                    // $('#saveBtn').html('Save Changes');
                }
            });
        };


        onDelete = (id) => {
            Swal.fire({
                icon: 'warning',
                title: 'Do you want to delete this data?',
                showCancelButton: true,
                confirmButtonText: 'Yes',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('user.destroy') }}",
                        data: {
                            id
                        },
                        type: "POST",
                        success: function(data) {
                            Swal.fire('Deleted data successfully');
                            table.draw()
                        }
                    });
                }
            })
        }
    </script>
@endpush
