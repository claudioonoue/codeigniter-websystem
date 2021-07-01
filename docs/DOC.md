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

![aa](/docs/img/home.png =250x250)

![](https://gyazo.com/eb5c5741b6a9a16c692170a41a49c858.png =250x250)

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