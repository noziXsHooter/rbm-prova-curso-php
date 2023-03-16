<div class="container-fluid">
    <div class="row justify-content-center">
        <!-- os meus clientes -->
        <div class="col-12 p-5 bg-white">
                <div class="col">
                    <h3><strong>Meus Cupons</strong></h3>
                </div>
            <div class="row">
                <div class="col">
                    <h5><i class="fa-solid fa-user-tie me-2"></i>Usuário: <strong><?= $user->name ?></strong></h5>
                </div>
<!--                 <div class="col text-end">
                    <a href="#" class="btn btn-secondary"><i class="fa-solid fa-upload me-2"></i></i>Carregar ficheiro</a>
                    <a href="?ct=agent&mt=new_client_frm" class="btn btn-secondary"><i class="fa-solid fa-plus me-2"></i>Novo cliente</a>
                </div> -->
            </div>
            <hr>
            <?php if(empty($clients) ): ?>
                <p class="my-5 text-center opacity-75">Não existem cupons registados.</p>
            <?php else: ?>
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Código</th>
                            <th class="text-center">Valor</th>
                            <th class="text-center">Loja</th>
                            <th class="text-center">Data</th>
                            <th class="text-center">Status</th>
<!--                             <th></th> -->
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><?= $client->code ?></td>
                            <td class="text-center">R$ <?= $client->valor ?></td>
                            <td class="text-center"><?= $client->store ?></td>
                            <td class="text-center"><?= $client->date_time ?></td>
                            <td class="text-center"><?= $client->status ? 'Ativo' : 'Inativo' ?></td>
<!--                             <td class="text-end">
                                <a href="?ct=coupon&mt=client_coupons&id=<?=$client->id?>"><i class="fa-regular fa-pen-to-square me-2"></i>Cupons</a>
                                <span class="mx-2 opacity-50">|</span>
                                <a href="?ct=agent&mt=edit_client&id=<?=$client->id?>"><i class="fa-regular fa-pen-to-square me-2"></i>Editar</a>
                                <span class="mx-2 opacity-50">|</span>
                                <a href="?ct=agent&mt=delete_client&id=<?=$client->id?>"><i class="fa-solid fa-trash-can me-2"></i>Eliminar</a>
                            </td> -->
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="row">
                    <div class="col">
                        <p class="mb-5">Total: <strong><?=count($clients)?></strong></p>
                    </div>
  <!--                   <div class="col text-end">
                        <a href="#" class="btn btn-secondary">
                            <i class="fa-regular fa-file-excel me-2"></i>Exportar para XLSX
                        </a>
                    </div> -->
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>