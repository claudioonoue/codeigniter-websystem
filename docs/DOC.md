# Introdução

Este é um projeto com o intuito de apresentar um embrião de sistema para gerenciamento de vendas.

# Database

É necessário executar um script SQL que está dentro da pasta `docs` chamado `default.sql` que servirá como base para criação do DB e suas tabelas.

# Portal: Recursos

O portal conta com os seguintes recursos:

| URL | Descrição | Somente Admin |
| --- | --- | --- | 
| / | Página principal. | Não |
| /auth/login | Tela de login. | Não |
| /profile | Tela de edição de perfil do usuário logado. | Não |
| /user | Tela de listagem de usuários. | Sim |
| /user/create | Tela de criação de usuário. | Sim |
| /user/edit/(:id) | Tela de edição de usuário. | Sim |
| /product | Tela de listagem de produtos. | Não |
| /product/create | Tela de criação de produto. | Não |
| /product/edit/(:id) | Tela de edição de produto. | Não |
| /order | Tela de listagem de pedidos. | Não |
| /order/create | Tela de criação de pedido. | Não |
| /order/edit/(:id) | Tela de edição de pedido. | Não |

Mais abaixo será apresentada cada uma das telas.


## "/" - Página principal


# Portal: Regras de Negócio

Nesta seção serão apresentadas algumas regras de negócio presentes no portal.

## Usuários

Existem 3 tipos possíveis de usuários (ou pessoas) para o portal: Administrador, Colaborador e Fornecedor.
Cada um dos tipos de usuários citados possui um tipo específico de configuração.

### Fornecedor

Usuário sem acesso ao portal/API. <br />
Será utilizado somente durante a criação de um pedido na tela de criação de pedidos (`/order/create`).

Regras específicas do Fornecedor:
- É necessário cadastrar DOIS endereços para ser considerado um "Cadastro completo". OBS.: O cadastro de endereços é feito na tela de edição de usuário `/user/edit/:ID`.
- Apesar de não possuir acesso ao portal/API, deve-se preencher os campos email e senha para criar um Fornecedor.

Configuração para criação de um Fornecedor na tela `/user/create`:

![](/docs/img/Fornecedor-Config.jpeg "Config Fornecedor")

### Colaborador

Usuário com acesso ao portal/API. <br />
Pode acessar alguns recursos, com exceção dos recursos para administradores. (Consultar seção: `Portal: Recursos`)

Regras específicas do Colaborador:
- É necessário cadastrar UM endereço para ser considerado um "Cadastro completo". OBS.: O cadastro de endereços é feito na tela de edição de usuário `/user/edit/:ID`.

Configuração para criação de um Colaborador na tela `/user/create`:

![](/docs/img/Colaborador-Config.jpeg "Config Colaborador")

### Administrador

Usuário com acesso ao portal/API. <br />
Pode acessar recursos que o Colaborador não pode acessar, como as telas de listagem, criação e edição de usuários. (Consultar seção: `Portal: Recursos`)

Regras específicas do Administrador:
- NÃO é necessário cadastrar endereços para ser considerado um "Cadastro completo".

Configuração para criação de um Administrador na tela `/user/create`:

![](/docs/img/Administrador-Config.jpeg "Config Administrador")

### Observações:

1 - Apesar de parecer que os switches de configuração de tipo de usuário da tela `/user/create` podem ser ativados simultaneamente, 
o sistema está programado para desativá-los conforme cada um for ativado, ou seja, se um for ativado outro switch poderá ser desativado automaticamente. <br />
Exemplo: Para configurar um usuário Fornecedor, deve-se ativar o switch "Fornecedor". Entretanto, se o switch "Administrador" 
e/ou o switch "Possui acesso ao sistema" estiverem ligados, estes serão desativados automaticamente ao ativar o switch "Fornecedor",
visto que um usuário de tipo Fornecedor não é um administrador e nem deve possuir acesso ao portal/API.

2 - Alguns switches são opcionais dependendo do tipo do usuário que está sendo configurado:
- Fornecedor: O switch "Ativo" é opcional. NÃO permitidos: switches "Administrador" e "Possui acesso ao sistema".
- Colaborador: Os switches "Ativo" e "Possui acesso ao sistema" são opcionais. NÃO permitidos: switches "Fornecedor" e "Administrador". OBS.: Pode-se configurar um usuário Colaborador sem ativar nenhum switch.
- Administrador: Os switches "Ativo" e "Possui acesso ao sistema" são opcionais. NÃO permitidos: switch "Fornecedor".

3 - Além das regras citadas até aqui, a tela de edição de usuários (`/user/edit/:ID`) possui algumas regras adicionais:
- TODOS os campos ficarão DESATIVADOS se estiver editando um usuário que esteja DESATIVADO! Para editá-lo, basta ativar o switch "Ativo" e enviar o formulário.

4 - A tela de edição de perfil (`/profile`) possui as mesmas regras da tela de edição de usuário (`/user/edit/:ID`), com uma única diferença: o usuário que está sendo editado é o usuário que está logado.

5 - NÃO é possível excluir um usuário!

Recomendo um teste completo nas telas `/user/create`, `/user/edit/:ID` e `/profile` para melhor entendimento do que foi explicado até agora.

## Produtos

Os produtos são uma das entidades que compõem um Pedido.

As regras de negócio dos produtos são bem simples:
- NÃO é possível editar um produto DESATIVADO: para editá-lo, ative o switch "Ativo" e envie o formulário;
- NÃO é possível EXCLUIR um produto.

## Pedidos

Os pedidos são o motivo para o sistema existir.

Cada pedido é composto por:
- UM Fornecedor: No ato da criação (`/order/create`) ou edição (`/order/edit/:ID`) de um pedido, deve-se selecionar um Fornecedor;
- UM Colaborador: AUTOMATICAMENTE será anexado ao pedido o usuário que está LOGADO;
- UMA Observação: Uma breve observação sobre o Pedido, sendo OPCIONAL;
- UM ou MAIS DE UM Item: Cada Item é composto por: UM Produto, Valor Unitário desse Produto e a Quantidade desse Produto.

Regras de Negócio:
- Um Pedido possui DOIS estados: Finalizado e Não Finalizado. 
    - Finalizado: Pedido que já foi fechado, portanto NÃO poderá ser excluído nem editado.
    - Não Finalizado: Pedido que não foi fechado. Poderá ser editado, adicionado items, excluído, etc...
- Como mencionado anteriormente, um Pedido DEVE possuir UM ou MAIS DE UM item.
- Ao editar um Pedido, o Colaborador NÃO será alterado! Será mantido o que foi usado para a criação do Pedido.



# API: Recursos

| Method | URI | Descrição |
| --- | --- | --- |
| GET | aircraft/list | Tela de listagem de aeronaves. |
| GET | aircraft/create | Tela de criação de aeronaves. |
| POST | aircraft/create | POST de criação de aeronaves. |
| GET | aircraft/edit/(:num) | Tela de edição de aeronaves. |
| POST | aircraft/edit/(:num) | POST de edição de aeronaves. |
| GET | aircraft/delete/(:num) | Exclusão de aeronaves. |

<br />

Projeto desenvolvido por [Claudio Onoue](https://github.com/claudioonoue).