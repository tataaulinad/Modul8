$(document).ready(function () {
    let records = [];

    const urls = window.peminjamanUrls;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        }
    });

    const modal = new bootstrap.Modal(
        document.getElementById('peminjamanModal')
    );

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, function (char) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char];
        });
    }

    function showAlert(message, type = 'success') {
        const alert = $(`
            <div class="alert alert-${type} alert-dismissible fade show">
                ${escapeHtml(message)}
                <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
            </div>
        `);

        $('#alert-container').html(alert);

        setTimeout(function () {
            bootstrap.Alert.getOrCreateInstance(alert[0]).close();
        }, 4000);
    }

    function clearErrors() {
        $('#peminjamanForm .is-invalid').removeClass('is-invalid');
        $('#peminjamanForm .invalid-feedback').text('');
    }

    function showErrors(errors) {
        $.each(errors, function (field, messages) {
            const input = $(`#peminjamanForm [name="${field}"]`);
            input.addClass('is-invalid');
            input.next('.invalid-feedback').text(messages[0]);
        });
    }

    function renderTable() {
        const keyword = $('#search').val().toLowerCase();

        const rows = records.filter(item => {
            return [
                item.nama_peminjam,
                item.judul_buku,
                item.status
            ].some(value =>
                String(value ?? '').toLowerCase().includes(keyword)
            );
        });

        $('#total-count').text(records.length);

        if (rows.length === 0) {
            $('#peminjaman-table tbody').html(`
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        Tidak ada data peminjaman.
                    </td>
                </tr>
            `);
            return;
        }

        const html = rows.map((item, index) => `
            <tr>
                <td>${index + 1}</td>
                <td>${escapeHtml(item.nama_peminjam)}</td>
                <td>${escapeHtml(item.judul_buku)}</td>
                <td>${escapeHtml(item.tanggal_pinjam)}</td>
                <td>${escapeHtml(item.tanggal_kembali)}</td>
                <td>
                    <span class="badge ${
                        item.status === 'Dipinjam'
                            ? 'text-bg-warning'
                            : 'text-bg-success'
                    }">
                        ${escapeHtml(item.status)}
                    </span>
                </td>
                <td>
                    ${
                        item.berkas_url
                            ? `<a href="${escapeHtml(item.berkas_url)}"
                                target="_blank" rel="noopener">Buka Bukti</a>`
                            : '<span class="text-muted">Tidak ada</span>'
                    }
                </td>
                <td class="text-nowrap">
                    <button class="btn btn-sm btn-outline-primary edit"
                        data-id="${item.id}">Edit</button>
                    <button class="btn btn-sm btn-outline-danger delete"
                        data-id="${item.id}">Hapus</button>
                </td>
            </tr>
        `).join('');

        $('#peminjaman-table tbody').html(html);
    }

    function loadData() {
        $.ajax({
            url: urls.data,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                records = data;
                renderTable();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                showAlert('Gagal memuat data peminjaman.', 'danger');
            }
        });
    }

    function resetForm() {
        $('#peminjamanForm')[0].reset();
        $('#id').val('');
        $('#current-file').html('');
        clearErrors();
    }

    $('#addBtn').click(function () {
        resetForm();
        $('#peminjamanModalLabel').text('Tambah Peminjaman');
        modal.show();
    });

    $('#peminjamanModal').on('hidden.bs.modal', resetForm);

    $('#search').on('input', renderTable);

    $('#saveBtn').click(function () {
        const id = $('#id').val();
        const formData = new FormData(
            document.getElementById('peminjamanForm')
        );

        let url = urls.store;

        if (id) {
            url = urls.update.replace('__ID__', id);
            formData.append('_method', 'PUT');
        }

        const btn = $(this);
        btn.prop('disabled', true).text('Menyimpan...');
        clearErrors();

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,

            success: function (response) {
                modal.hide();
                showAlert(response.success);
                loadData();
            },

            error: function (xhr) {
                if (xhr.status === 422) {
                    showErrors(xhr.responseJSON.errors);
                } else {
                    showAlert(
                        xhr.responseJSON?.message || 'Terjadi kesalahan.',
                        'danger'
                    );
                }
            },

            complete: function () {
                btn.prop('disabled', false).text('Simpan');
            }
        });
    });

    $(document).on('click', '.edit', function () {
        const id = $(this).data('id');

        $.ajax({
            url: urls.edit.replace('__ID__', id),
            type: 'GET',

            success: function (item) {
                resetForm();

                $('#id').val(item.id);
                $('#nama_peminjam').val(item.nama_peminjam);
                $('#judul_buku').val(item.judul_buku);
                $('#tanggal_pinjam').val(item.tanggal_pinjam);
                $('#tanggal_kembali').val(item.tanggal_kembali);
                $('#status').val(item.status);

                if (item.berkas_url) {
                    $('#current-file').html(
                        `<a href="${escapeHtml(item.berkas_url)}"
                        target="_blank" rel="noopener">Buka bukti saat ini</a>`
                    );
                }

                $('#peminjamanModalLabel').text('Edit Peminjaman');
                modal.show();
            },

            error: function () {
                showAlert('Gagal mengambil data peminjaman.', 'danger');
            }
        });
    });

    $(document).on('click', '.delete', function () {
        const id = $(this).data('id');

        if (!confirm('Yakin ingin menghapus data peminjaman ini?')) {
            return;
        }

        $.ajax({
            url: urls.destroy.replace('__ID__', id),
            type: 'POST',
            data: {
                _method: 'DELETE'
            },

            success: function (response) {
                showAlert(response.success);
                loadData();
            },

            error: function () {
                showAlert('Gagal menghapus data.', 'danger');
            }
        });
    });

    loadData();
});
