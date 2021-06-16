<div class="w-100 row m-0 pb-2">
    <a href="/user"><button type="button" class="btn btn-block btn-warning btn-lg"><i class="fas fa-arrow-left"></i></button></a>
</div>
<div class="w-100 h-100 row flex-column align-items-center">
    <?php if ($this->session->flashdata('edit_success') !== null) : ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check-circle"></i> Atenção!</h5>
            <?= $this->session->flashdata('edit_success') ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('edit_error') !== null) : ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Atenção!</h5>
            <?= $this->session->flashdata('edit_error') ?>
        </div>
    <?php endif; ?>
    <?php $totalNeededAdresses = $user->isProvider === '1' ? 2 : ($user->isAdmin === '0' ? 1 : 0); ?>
    <?php if (intval($user->totalAddresses) < $totalNeededAdresses) : ?>
        <div class="w-50 callout callout-warning">
            <h5>Usuário incompleto!</h5>

            <p>
                Um usuário de tipo <b><?= $user->isProvider === '1' ? 'FORNECEDOR' : ($user->isAdmin === '0' ? 'COLABORADOR' : 'ADMIN') ?></b>
                deve possuir <?= $totalNeededAdresses ?> endereço(s).
            </p>
        </div>
    <?php endif; ?>
    <div class="w-50 card card-info">
        <div class="card-header">
            <h3 class="card-title">Editando usuário: <?= $user->fullName ?> (#<?= $user->id ?>)</h3>
        </div>
        <?= form_open('/user/edit/' . $user->id) ?>
        <div class="card-body">
            <div class="form-group">
                <label for="formInpEmail">Email</label>
                <input type="email" value="<?= $user->email ?>" class="form-control form-control-border" id="formInpEmail" disabled>
            </div>
            <div class="form-group">
                <label for="formInpPassword">Senha</label>
                <input type="password" name="password" class="form-control form-control-border" id="formInpPassword" placeholder="Senha" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="formInpNewPassword">Nova senha</label>
                <input type="password" name="newPassword" class="form-control form-control-border" id="formInpNewPassword" placeholder="Nova senha" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="formInpFullName">Nome*</label>
                <input type="text" name="fullName" value="<?= $user->fullName ?>" class="form-control form-control-border" id="formInpFullName" placeholder="Nome" required>
            </div>
            <div class="form-group">
                <label for="formInpPhone">Telefone*</label>
                <input type="text" name="phone" value="<?= $user->phone ?>" class="form-control form-control-border" id="formInpPhone" placeholder="Telefone" required>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="isAdmin" class="custom-control-input" id="formInpIsAdmin" <?= $user->isAdmin ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="formInpIsAdmin">Administrador</label>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="hasSystemAccess" class="custom-control-input" id="formInpHasSystemAccess" <?= $user->hasSystemAccess ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="formInpHasSystemAccess">Possui acesso ao sistema</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="isProvider" class="custom-control-input" id="formInpIsProvider" <?= $user->isProvider ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="formInpIsProvider">Fornecedor</label>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="active" class="custom-control-input" id="formInpAtivo" <?= $user->active ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="formInpAtivo">Ativo</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class=" ml-1 mr-1 card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Endereços</h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Endereço 1</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Endereço 2</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        Endereço 1
                    </div>
                    <div class="tab-pane" id="tab_2">
                        Endereço 2
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
        <?= form_close() ?>
    </div>
</div>