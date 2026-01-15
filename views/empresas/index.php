<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD-FINAL-EMPRESAS</title>


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- estilos css -->
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    
    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand mb-0 h1">
                <i class="bi bi-building"></i>CRUD EMPRESAS MVC - FINAL
            </span>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- BARRA DE HERRAMIENTAS -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group search-box">
                    <input type="text" id="searchInput" class="form-control"
                    placeholder="Buscar por ID o Razón Social...">
                    <button class="btn btn-outline-secondary" type="button" id="btnSearch"></button>
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
                    <i class="bi bi-file-pdf"></i> Exportar PDF
                </button>
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