<div class="row align-items-center">
    <div class="col-md-6">
        <div class="mb-3">
            <h5 class="card-title">Agenda de Contatos <span class="text-muted fw-normal ms-2"><?= $contacts.length ?></span></h5>
        </div>
    </div>
    <div class="col-md-6">
        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
            <div>
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a aria-current="page" href="#"
                            class="router-link-active router-link-exact-active nav-link active"
                            data-bs-toggle="tooltip" data-bs-placement="top" title data-bs-original-title="List"
                            aria-label="List">
                            <i class="bx bx-list-ul"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-bs-toggle="tooltip" data-bs-placement="top" title
                            data-bs-original-title="Grid" aria-label="Grid"><i class="bx bx-grid-alt"></i></a>
                    </li>
                </ul>
            </div>
            <div>
                <a href="#" data-bs-toggle="modal" data-bs-target=".add-new" class="btn btn-primary"><i
                        class="bx bx-plus me-1"></i> Adicionar</a>
            </div>
            <div class="dropdown">
                <a class="btn btn-link text-muted py-1 font-size-16 shadow-none dropdown-toggle" href="#"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false"><i
                        class="bx bx-dots-horizontal-rounded"></i></a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>