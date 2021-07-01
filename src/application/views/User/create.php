<div class="w-100 row m-0 pb-2">
    <a href="/user"><button type="button" class="btn btn-block btn-warning btn-lg"><i class="fas fa-arrow-left"></i></button></a>
</div>
<div class="w-100 h-100 row flex-column align-items-center">
    <?php if ($this->session->flashdata('create_error') !== null) : ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Atenção!</h5>
            <?= $this->session->flashdata('create_error') ?>
        </div>
    <?php endif; ?>
    <div class="w-50 card card-primary">
        <div class="card-header">
            <h3 class="card-title">Novo usuário</h3>
        </div>
        <?= form_open('/user/create') ?>
        <div class="card-body">
            <div class="form-group">
                <label for="formInpEmail">Email*</label>
                <input type="email" name="email" class="form-control form-control-border" id="formInpEmail" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="formInpPassword">Senha*</label>
                <input type="password" name="password" class="form-control form-control-border" id="formInpPassword" placeholder="Senha" required>
            </div>
            <div class="form-group">
                <label for="formInpFullName">Nome*</label>
                <input type="text" name="fullName" class="form-control form-control-border" id="formInpFullName" placeholder="Nome" required>
            </div>
            <div class="form-group">
                <label for="formInpPhone">Telefone*</label>
                <input type="text" name="phone" class="form-control form-control-border input-mask-phone" id="formInpPhone" placeholder="Telefone" required>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="isAdmin" class="custom-control-input" id="formInpIsAdmin">
                            <label class="custom-control-label" for="formInpIsAdmin">Administrador</label>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="hasSystemAccess" class="custom-control-input" id="formInpHasSystemAccess">
                            <label class="custom-control-label" for="formInpHasSystemAccess">Possui acesso ao sistema</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="isProvider" class="custom-control-input" id="formInpIsProvider">
                            <label class="custom-control-label" for="formInpIsProvider">Fornecedor</label>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="active" class="custom-control-input" id="formInpAtivo" checked>
                            <label class="custom-control-label" for="formInpAtivo">Ativo</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ml-1 mr-1 callout callout-info">
            <h5>OBSERVAÇÕES:</h5>

            <p>
                Para cadastrar um endereço, acesse a tela de edição do respectivo usuário.
            </p>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
        <?= form_close() ?>
    </div>
</div>