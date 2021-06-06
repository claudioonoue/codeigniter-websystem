# Introdução

Este é um projeto simples com o intuito de demonstrar um CRUD de aeronaves.

# Database

É necessário executar um script SQL que está dentro da pasta `docs` chamado `default.sql` que servirá como base para criação do DB e suas tabelas.

# Recursos

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