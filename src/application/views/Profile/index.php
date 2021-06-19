<div class="w-100 row m-0 pb-2">
    <a href="/"><button type="button" class="btn btn-block btn-warning btn-lg"><i class="fas fa-arrow-left"></i></button></a>
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
            <h3 class="card-title">Editando perfil</h3>
        </div>
        <?= form_open('/profile/index') ?>
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
            <?php if ($user->isAdmin === '1') : ?>
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
            <?php endif; ?>
        </div>

        <?php if ($totalNeededAdresses > 0) : ?>
            <?php
            $firstAddress = isset($addresses[0]) ? $addresses[0] : NULL;
            $secondAddress = isset($addresses[1]) ? $addresses[1] : NULL;

            $states = [
                'AC' => 'Acre',
                'AL' => 'Alagoas',
                'AP' => 'Amapá',
                'AM' => 'Amazonas',
                'BA' => 'Bahia',
                'CE' => 'Ceará',
                'DF' => 'Distrito Federal',
                'ES' => 'Espírito Santo',
                'GO' => 'Goiás',
                'MA' => 'Maranhão',
                'MT' => 'Mato Grosso',
                'MS' => 'Mato Grosso do Sul',
                'MG' => 'Minas Gerais',
                'PA' => 'Pará',
                'PB' => 'Paraíba',
                'PR' => 'Paraná',
                'PE' => 'Pernambuco',
                'PI' => 'Piauí',
                'RJ' => 'Rio de Janeiro',
                'RN' => 'Rio Grande do Norte',
                'RS' => 'Rio Grande do Sul',
                'RO' => 'Rondônia',
                'RR' => 'Roraima',
                'SC' => 'Santa Catarina',
                'SP' => 'São Paulo',
                'SE' => 'Sergipe',
                'TO' => 'Tocantins'
            ];
            ?>
            <div class=" ml-1 mr-1 card">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Endereços</h3>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item"><a id="tab_link_1" class="nav-link active" href="#tab_1" data-toggle="tab">Endereço 1</a></li>
                        <?php if ($totalNeededAdresses > 1) : ?>
                            <li class="nav-item"><a id="tab_link_2" class="nav-link" href="#tab_2" data-toggle="tab">Endereço 2</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="form-group">
                                <label for="formInpFirstZipCode">CEP*</label>
                                <input type="text" name="firstZipCode" value="<?= isset($firstAddress) ? $firstAddress->zipCode : '' ?>" class="form-control form-control-border" id="formInpFirstZipCode" placeholder="CEP" required>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="formInpFirstAddress">Endereço*</label>
                                        <input type="text" name="firstAddress" value="<?= isset($firstAddress) ? $firstAddress->address : '' ?>" class="form-control form-control-border" id="formInpFirstAddress" placeholder="Rua, Avenida..." required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="formInpFirstNumber">Número*</label>
                                        <input type="text" name="firstNumber" value="<?= isset($firstAddress) ? $firstAddress->number : '' ?>" class="form-control form-control-border" id="formInpFirstNumber" placeholder="Número" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="formInpFirstComplement">Complemento</label>
                                <input type="text" name="firstComplement" value="<?= isset($firstAddress) ? $firstAddress->complement : '' ?>" class="form-control form-control-border" id="formInpFirstComplement" placeholder="Complemento">
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="formInpFirstNeighborhood">Bairro*</label>
                                        <input type="text" name="firstNeighborhood" value="<?= isset($firstAddress) ? $firstAddress->neighborhood : '' ?>" class="form-control form-control-border" id="formInpFirstNeighborhood" placeholder="Bairro" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="formInpFirstCity">Cidade*</label>
                                        <input type="text" name="firstCity" value="<?= isset($firstAddress) ? $firstAddress->city : '' ?>" class="form-control form-control-border" id="formInpFirstCity" placeholder="Cidade" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="formInpFirstState">Estado*</label>
                                        <select name="firstState" class="custom-select form-control-border" id="formInpFirstState" required>
                                            <option value="">Selecione...</option>
                                            <?php foreach ($states as $acronym => $name) : ?>
                                                <option value="<?= $acronym ?>" <?= isset($firstAddress) && $firstAddress->state === $acronym ? 'selected' : '' ?>><?= $name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="formInpFirstCountry">País*</label>
                                        <select name="firstCountry" class="custom-select form-control-border" id="formInpFirstCountry">
                                            <option value="brasil">Brasil</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($totalNeededAdresses > 1) : ?>
                            <div class="tab-pane" id="tab_2">
                                <div class="form-group">
                                    <label for="formInpSecondZipCode">CEP*</label>
                                    <input type="text" name="secondZipCode" value="<?= isset($secondAddress) ? $secondAddress->zipCode : '' ?>" class="form-control form-control-border" id="formInpSecondZipCode" placeholder="CEP" required>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="formInpSecondAddress">Endereço*</label>
                                            <input type="text" name="secondAddress" value="<?= isset($secondAddress) ? $secondAddress->address : '' ?>" class="form-control form-control-border" id="formInpSecondAddress" placeholder="Rua, Avenida..." required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="formInpSecondNumber">Número*</label>
                                            <input type="text" name="secondNumber" value="<?= isset($secondAddress) ? $secondAddress->number : '' ?>" class="form-control form-control-border" id="formInpSecondNumber" placeholder="Número" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="formInpSecondComplement">Complemento</label>
                                    <input type="text" name="secondComplement" value="<?= isset($secondAddress) ? $secondAddress->complement : '' ?>" class="form-control form-control-border" id="formInpSecondComplement" placeholder="Complemento">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="formInpSecondNeighborhood">Bairro*</label>
                                            <input type="text" name="secondNeighborhood" value="<?= isset($secondAddress) ? $secondAddress->neighborhood : '' ?>" class="form-control form-control-border" id="formInpSecondNeighborhood" placeholder="Bairro" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="formInpSecondCity">Cidade*</label>
                                            <input type="text" name="secondCity" value="<?= isset($secondAddress) ? $secondAddress->city : '' ?>" class="form-control form-control-border" id="formInpSecondCity" placeholder="Cidade" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="formInpSecondState">Estado*</label>
                                            <select name="secondState" class="custom-select form-control-border" id="formInpSecondState" required>
                                                <option value="">Selecione...</option>
                                                <?php foreach ($states as $acronym => $name) : ?>
                                                    <option value="<?= $acronym ?>" <?= isset($secondAddress) && $secondAddress->state === $acronym ? 'selected' : '' ?>><?= $name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="formInpSecondCountry">País*</label>
                                            <select name="secondCountry" class="custom-select form-control-border" id="formInpSecondCountry">
                                                <option value="brasil">Brasil</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
        <?= form_close() ?>
    </div>
</div>