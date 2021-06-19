<div class="w-100 row m-0 pb-2">
    <a href="/product"><button type="button" class="btn btn-block btn-warning btn-lg"><i class="fas fa-arrow-left"></i></button></a>
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
    <div class="w-50 card card-info">
        <div class="card-header">
            <h3 class="card-title">Editando produto: <?= $product->name ?> (#<?= $product->id ?>)</h3>
        </div>
        <?= form_open('/product/edit/' . $product->id) ?>
        <div class="card-body">
            <div class="form-group">
                <label for="formInpName">Nome*</label>
                <input type="text" name="name" value="<?= $product->name ?>" class="form-control form-control-border" id="formInpName" placeholder="Nome" required>
            </div>
            <div class="form-group">
                <label for="formInpDescription">Descrição*</label>
                <textarea name="description" class="form-control" id="formInpDescription" rows="3" placeholder="Descrição..." required><?= $product->description ?></textarea>
            </div>
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="active" class="custom-control-input" id="formInpActive" <?= $product->active ? 'checked' : '' ?>>
                    <label class="custom-control-label" for="formInpActive">Ativo</label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
        <?= form_close() ?>
    </div>
</div>