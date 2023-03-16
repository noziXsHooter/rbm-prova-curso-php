<div class="container-fluid bng-navbar">
    <div class="row">

        <div class="col-6 d-flex align-content-center p-3">
            <div class="mb-1 text-center">
                <a href="?ct=main&mt=index" type="submit" class="btn btn-primary-bg btn-secondary px-4">Home</a>
<!--            <button type="submit" class="btn btn-primary-bg btn-secondary px-4">Usuários</button>
                <button type="submit" class="btn btn-primary-bg btn-secondary px-4">Meus Cupons</button>
                <button type="submit" class="btn btn-primary-bg btn-secondary px-4">Sorteio</button> -->
            </div>

        </div>

        <div class="col-6 text-end p-3">

            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-regular fa-user me-2"></i><?= $user->name ?>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-key me-2"></i>Alterar password</i></a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="?ct=main&mt=logout"><i class="fa-solid fa-right-from-bracket me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>

    </div>
</div>