<div class="w-100 row m-0 pb-2">
    <a href="/order"><button type="button" class="btn btn-block btn-warning btn-lg"><i class="fas fa-arrow-left"></i></button></a>
</div>
<div class="w-100 h-100 row flex-column align-items-center">
    <?php if ($this->session->flashdata('create_error') !== null) : ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Atenção!</h5>
            <?= $this->session->flashdata('create_error') ?>
        </div>
    <?php endif; ?>
    <div class="w-75 card card-primary">
        <div class="card-header">
            <h3 class="card-title">Novo pedido</h3>
        </div>
        <?= form_open('/order/create') ?>
        <div class="card-body">
            <div class="form-group">
                <label>Fornecedor*</label>
                <select name="providerId" class="form-control select2" id="formInpProvider" style="width: 100%;" required>
                    <option value="" selected="selected"></option>
                    <?php foreach ($providers as $provider) : ?>
                        <option value="<?= $provider->id ?>"><?= $provider->fullName ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="formInpObservations">Observações</label>
                <textarea name="observations" class="form-control" id="formInpObservations" rows="3" placeholder="Observações..."></textarea>
            </div>
        </div>

        <div id="divProductsList" class="callout callout-info ml-2 mr-2 mb-2 d-flex flex-column">
            <button type="button" id="btnAddProduct" class="btn btn-block btn-info w-25 align-self-end order-12"><i class="fas fa-plus-square"></i> Adicionar produto</button>
        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
        <?= form_close() ?>
    </div>
</div>