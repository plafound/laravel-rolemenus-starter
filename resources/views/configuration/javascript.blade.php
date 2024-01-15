@push('after-script')
    <script type="text/javascript">
        var table = ".data-table";

        $(() => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            index();
        });

        index = async () => {
            await initInput();
            await HELPER.unblock(500);
        }


        onEdit = (id) => {
            $("#configuration_id").val(id);
            $.ajax({
                url: '{{ url('configuration/show') }}',
                data: {
                    id
                },
                method: 'POST',
                success: function(data) {
                    $("#title").val(data.data.title);
                    $("#description").val(data.data.description);
                    $("#modalConfiguration").modal('show');
                },
                error: function() {
                    Swal.fire({
                        success: false,
                        title: "Error",
                        text: "System error!"
                    });
                }
            });
        }

        onSave = () => {
            $.ajax({
                data: $('#form-configuration').serialize(),
                url: "{{ url('configuration') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            success: true,
                            title: 'Success',
                            text: "Configuration saved successfully"
                        })
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                    Swal.fire({
                        success: false,
                        title: "Error",
                        text: "System error!"
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
                        url: "{{ route('configuration.destroy') }}",
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


        initInput = () => {
            return new Promise((resolve) => {
                HELPER.block();
                HELPER.ajax({
                    url: "{{ route('configuration.getConfig') }}",
                    type: "GET",
                    success: (response) => {
                        $.each(response.config, (i, v) => {
                            var code = String(v.config_code).replace(".", "_");
                            $("#" + code).val(v.config_value);
                            if (code == 'app_logo') {
                                $("#img-logo").attr('src', '{{ asset('uploads/') }}' + '/' +
                                    v.config_value);
                            }
                        });
                    },
                    complete: (response) => {
                        HELPER.unblock(500);
                    }
                })
            });
        }



        onInputLogo = () => {
            document.getElementById('logo').click();
        }

        $("#logo").change(function() {
            var fd = new FormData();
            var files = this.files[0];
            fd.append('logo', files);

            HELPER.block();
            HELPER.ajax({
                url: "{{ route('configuration.uploadLogo') }}",
                data: fd,
                type: "POST",
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        HELPER.showMessage({
                            success: true,
                            title: 'Sukses',
                            message: 'Logo berhasil diganti'
                        })
                        HELPER.reloadPage();

                    } else {
                        HELPER.showMessage({
                            success: false,
                            title: 'Gagal',
                            message: response.message
                        })
                    }

                },
                complete: function(response) {
                    HELPER.unblock();
                }
            });
        });
    </script>
@endpush
