<div class="w-100 row m-0 pb-2">
    <a href="/order"><button type="button" class="btn btn-block btn-warning btn-lg"><i class="fas fa-arrow-left"></i></button></a>
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
    <?php if ($order->finished !== '0') : ?>
        <div class="alert alert-warning w-75 d-flex flex-column align-items-center">
            <h5><i class="icon fas fa-exclamation-triangle"></i> Atenção! &nbsp;<i class="icon fas fa-exclamation-triangle mr-0"></i></h5>
            Pedido finalizado!
        </div>
    <?php endif; ?>
    <div class="w-75 card card-primary">
        <div class="card-header">
            <h3 class="card-title">Editando pedido: #<?= $order->id ?></h3>
        </div>
        <?= form_open('/order/edit/' . $order->id) ?>
        <div class="card-body">
            <div class="form-group">
                <label>Fornecedor*</label>
                <select name="providerId" class="form-control select2" id="formInpProvider" style="width: 100%;" required <?= $order->finished !== '0' ? 'disabled' : '' ?>>
                    <option value=""></option>
                    <?php foreach ($providers as $provider) : ?>
                        <option value="<?= $provider->id ?>" <?= $order->providerId === $provider->id ? 'selected' : '' ?>><?= $provider->fullName ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="formInpObservations">Observações</label>
                <textarea name="observations" class="form-control" id="formInpObservations" rows="3" placeholder="Observações..." <?= $order->finished !== '0' ? 'disabled' : '' ?>><?= $order->observations ?></textarea>
            </div>
        </div>

        <div id="divProductsList" class="callout callout-info ml-2 mr-2 mb-2 d-flex flex-column">

            <?php foreach ($orderProducts as $index => $orderProduct) : ?>
                <?php
                $sequence = $index + 1;
                ?>
                <div id="divProduct-<?= $sequence ?>" class="w-100 row div-products" data-sequence="<?= $sequence  ?>">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Produto*</label>
                            <select name="inpSelectProduct-<?= $sequence ?>" class="form-control select2 product-input" id="inpSelectProduct-<?= $sequence ?>" style="width: 100%;" required <?= $order->finished !== '0' ? 'disabled' : '' ?>>
                                <option value=""></option>
                                <?php foreach ($products as $product) : ?>
                                    <option value="<?= $product->id ?>" <?= $orderProduct->productId === $product->id ? 'selected' : '' ?>><?= $product->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Valor*</label>
                            <input type="text" value="<?= $orderProduct->unitPrice ?>" name="inpValue-<?= $sequence ?>" id="inpValue-<?= $sequence ?>" class="form-control form-control-border product-input" placeholder="Valor" required <?= $order->finished !== '0' ? 'disabled' : '' ?>>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Quantidade*</label>
                            <input type="text" value="<?= $orderProduct->quantity ?>" name="inpQuantity-<?= $sequence ?>" id="inpQuantity-<?= $sequence ?>" class="form-control form-control-border product-input" placeholder="Quantidade" required <?= $order->finished !== '0' ? 'disabled' : '' ?>>
                        </div>
                    </div>
                    <?php if ($order->finished === '0') : ?>
                        <div class="col-auto">
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                <i id="btnRemove-<?= $sequence ?>" class="fas fa-trash-alt remove-btn" style="font-size: 35px; cursor: pointer;"></i>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <?php if ($order->finished === '0') : ?>
                <button type="button" id="btnAddProduct" class="btn btn-block btn-info w-25 align-self-end order-12"><i class="fas fa-plus-square"></i> Adicionar produto</button>
            <?php endif; ?>
        </div>

        <style>
            .card-footer::after {
                content: none;
            }
        </style>
        <div class="card-footer d-flex justify-content-between">
            <?php if ($order->finished === '0') : ?>
                <button type="submit" class="btn btn-primary">Enviar</button>
                <div>
                    <a id="btnFinishOrder" href="/order/finish/<?= $order->id ?>"><button type="button" class="btn btn-warning">Finalizar pedido</button></a>
                    <a id="btnDeleteOrder" href="/order/delete/<?= $order->id ?>"><button type="button" class="btn btn-danger">Deletar</button></a>
                </div>
            <?php endif; ?>
        </div>
        <?= form_close() ?>
    </div>
</div>