/**
 * CRUD Empresas - Lógica JavaScript
 * Maneja todas las interacciones AJAX con la API
 */

$(document).ready(function() {
    // Configuración
    const API = '/api/empresas';
    let currentSearch = '';
    let deleteId = null;

    // Modales Bootstrap
    const empresaModal = new bootstrap.Modal('#empresaModal');
    const deleteModal = new bootstrap.Modal('#deleteModal');

    // FUNCIONES PRINCIPALES

    //Cargar lista de empresas
    
    function loadEmpresas(search = '') {
        currentSearch = search;
        const url = search ? `${API}?search=${encodeURIComponent(search)}` : API;
        
        $.get(url)
            .done(function(response) {
                renderTable(response.data);
                $('#totalRegistros').text(`Total: ${response.total} empresa(s)`);
            })
            .fail(function() {
                $('#empresasTable').html(
                    '<tr><td colspan="7" class="text-center text-danger">Error al cargar datos</td></tr>'
                );
            });
    }

    
    //Renderizar tabla de empresas
    
    function renderTable(empresas) {
        const tbody = $('#empresasTable');
        tbody.empty();
        
        if (empresas.length === 0) {
            tbody.append('<tr><td colspan="7" class="text-center">No se encontraron empresas</td></tr>');
            return;
        }
        
        empresas.forEach(function(e) {
            tbody.append(`
                <tr>
                    <td>${e.id_empresa}</td>
                    <td>${e.rif}</td>
                    <td>${escapeHtml(e.razon_social)}</td>
                    <td>${escapeHtml(e.direccion)}</td>
                    <td>${e.telefono}</td>
                    <td>${e.fecha_creacion}</td>
                    <td class="btn-group-actions">
                        <button class="btn btn-sm btn-warning btn-edit" data-id="${e.id_empresa}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="${e.id_empresa}" data-name="${escapeHtml(e.razon_social)}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
        });
    }


    //Escapar HTML para prevenir XSS
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // EVENTOS Y MANEJADORES

    // Buscar
    $('#btnSearch').click(function() {
        loadEmpresas($('#searchInput').val());
    });

    $('#searchInput').keypress(function(e) {
        if (e.which === 13) loadEmpresas($(this).val());
    });

    $('#btnClear').click(function() {
        $('#searchInput').val('');
        loadEmpresas();
    });

    // Nueva empresa
    $('#btnNew').click(function() {
        $('#modalTitle').text('Nueva Empresa');
        $('#empresaId').val('');
        $('#empresaForm')[0].reset();
        $('#formError').addClass('d-none');
        empresaModal.show();
    });

    // Editar empresa
    $(document).on('click', '.btn-edit', function() {
        const id = $(this).data('id');
        
        $.get(`${API}/${id}`)
            .done(function(response) {
                const e = response.data;
                $('#modalTitle').text('Editar Empresa');
                $('#empresaId').val(e.id_empresa);
                $('#rif').val(e.rif);
                $('#razon_social').val(e.razon_social);
                $('#direccion').val(e.direccion);
                $('#telefono').val(e.telefono);
                $('#formError').addClass('d-none');
                empresaModal.show();
            });
    });

    // Guardar (crear o actualizar)
    $('#btnSave').click(function() {
        const id = $('#empresaId').val();
        const data = {
            rif: $('#rif').val(),
            razon_social: $('#razon_social').val(),
            direccion: $('#direccion').val(),
            telefono: $('#telefono').val()
        };

        const isEdit = id !== '';
        const url = isEdit ? `${API}/${id}` : API;
        const method = isEdit ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            contentType: 'application/json',
            data: JSON.stringify(data)
        })
        .done(function() {
            empresaModal.hide();
            loadEmpresas(currentSearch);
        })
        .fail(function(xhr) {
            const resp = xhr.responseJSON;
            $('#formError')
                .removeClass('d-none')
                .text(resp?.error?.message || 'Error al guardar');
        });
    });

    // Mostrar modal de eliminación
    $(document).on('click', '.btn-delete', function() {
        deleteId = $(this).data('id');
        $('#deleteEmpresaName').text($(this).data('name'));
        deleteModal.show();
    });

    // Confirmar eliminación
    $('#btnConfirmDelete').click(function(){
        $.ajax({
            url: `${API}/${deleteId}`,
            method: 'DELETE'
        })
        .done(function(){
            deleteModal.hide();
            loadEmpresas(currentSearch);
        });
    });



    //Exportar JSON
    $('#btnExportJson').click(function(){
        const url = currentSearch ? `${API}/export.json?search=${encodeURIComponent(currentSearch)}` : `${API}/export.json`;
        window.location.href = url;
    });


        //Exportar PDF
    $('#btnExportPdf').click(function(){
        const url = currentSearch ? `${API}/report.pdf?search=${encodeURIComponent(currentSearch)}` : `${API}/report.pdf`;
        window.location.href = url;
    });

    //INICIALIZAR CARGA
    loadEmpresas();
});