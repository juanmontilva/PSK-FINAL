<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Empresas</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand mb-0 h1">
                <i class="bi bi-building"></i> CRUD Empresas MVC
            </span>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Barra de herramientas -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group search-box">
                    <input type="text" id="searchInput" class="form-control" 
                        placeholder="Buscar por ID o Razón Social...">
                    <button class="btn btn-outline-secondary" type="button" id="btnSearch">
                        <i class="bi bi-search"></i>
                    </button>
                    <button class="btn btn-outline-secondary" type="button" id="btnClear">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-success" id="btnNew">
                    <i class="bi bi-plus-lg"></i> Nueva Empresa
                </button>
                <button class="btn btn-info" id="btnExportJson">
                    <i class="bi bi-filetype-json"></i> Exportar JSON
                </button>
                <button class="btn btn-danger" id="btnExportPdf">
                    <i class="bi bi-file-pdf"></i> Reporte PDF
                </button>
            </div>
        </div>

        <!-- Tabla de empresas -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>RIF</th>
                        <th>Razón Social</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="empresasTable">
                    <tr>
                        <td colspan="7" class="text-center">Cargando...</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="totalRegistros" class="text-muted"></div>
    </div>

    <!-- Modal Crear/Editar Empresa -->
    <div class="modal fade" id="empresaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Nueva Empresa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="empresaForm">
                        <input type="hidden" id="empresaId">
                        
                        <div class="mb-3">
                            <label class="form-label">RIF *</label>
                            <input type="text" class="form-control" id="rif" 
                                placeholder="J-12345678-9" required>
                            <div class="form-text">Formato: J-12345678-9</div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Razón Social *</label>
                            <input type="text" class="form-control" id="razon_social" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Dirección *</label>
                            <textarea class="form-control" id="direccion" rows="2" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Teléfono *</label>
                            <input type="text" class="form-control" id="telefono" 
                                placeholder="0212-1234567" required>
                        </div>
                    </form>
                    <div id="formError" class="alert alert-danger d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" id="btnSave">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmar Eliminación -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de eliminar la empresa <strong id="deleteEmpresaName"></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-danger" id="btnConfirmDelete">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- JavaScript personalizado -->
    <script src="/assets/js/app.js"></script>
</body>
</html>