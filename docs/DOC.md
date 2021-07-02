# Introdução

Este é um projeto com o intuito de apresentar um embrião de sistema para gerenciamento de vendas.

# Database

É necessário executar um script SQL que está dentro da pasta `docs` chamado `default.sql` que servirá como base para criação do DB e suas tabelas.

# Usuário Padrão

Para fins de testes, o sistema automaticamente cria um usuário padrão CASO não exista nenhum no database.

```JSON
{
    "email": "admin@admin.com",
    "senha": "123456"
}
```

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

## Barras de Navegação

Explicação breve sobre as barras de navegação presentes na interface:
- Esquerda: A barra de navegação esquerda conta com botões para acesso à Página principal, à tela de Perfil do usuário logado, à tela de listagem de Usuários, à tela de listagem de Produtos e à tela de listagem de Pedidos. Além disso, conta com um campo para buscar alguns itens contidos nela. 
- Superior: A barra de navegação superior possui um botão para maximizar a interface do sistema e um botão para exibir o Menu Lateral.
- Menu Lateral: O Menu Lateral possui um botão para acessar a tela de Perfil do usuário logado e um botão para encerrar a sessão do usuário logado.

## / - Página principal

Possuem algumas informações a respeito dos Pedidos e Produtos.

## /auth/login - Tela de login

Tela para realizar login ao sistema.

## /profile - Tela de edição de perfil do usuário logado

Tela para editar informações de perfil do usuário logado.

## /user - Tela de listagem de usuários

Tela com uma tabela para listagem de usuários existentes no sistema.

A tabela possui filtros por coluna para uma maior flexibilidade ao filtrar dados.

Para visualizar/editar um registro, basta clicar na linha desejada.

Um botão encontra-se na parte superior direita da tela para acessar a tela de criação de usuários.

## /user/create - Tela de criação de usuário

Tela para criação de usuário.

Consulte a seção `Portal: Regras de Negócio - Usuários` para compreender melhor seu funcionamento.

## /user/edit/(:id) - Tela de edição de usuário

Tela para edição de usuário.

Consulte a seção `Portal: Regras de Negócio - Usuários` para compreender melhor seu funcionamento.

## /product - Tela de listagem de produtos

Tela com uma tabela para listagem de produtos existentes no sistema.

A tabela possui filtros por coluna para uma maior flexibilidade ao filtrar dados.

Para visualizar/editar um registro, basta clicar na linha desejada.

Um botão encontra-se na parte superior direita da tela para acessar a tela de criação de produtos.

## /product/create - Tela de criação de produto

Tela para criação de produto.

Consulte a seção `Portal: Regras de Negócio - Produtos` para compreender melhor seu funcionamento.

## /product/edit/(:id) - Tela de edição de produto

Tela para edição de produto.

Consulte a seção `Portal: Regras de Negócio - Produtos` para compreender melhor seu funcionamento.

## /order - Tela de listagem de pedidos

Tela com uma tabela para listagem de pedidos existentes no sistema.

A tabela possui filtros por coluna para uma maior flexibilidade ao filtrar dados.

Para visualizar/editar um registro, basta clicar na linha desejada.

Um botão encontra-se na parte superior direita da tela para acessar a tela de criação de pedidos.

## /order/create - Tela de criação de pedido

Tela para criação de pedido.

Consulte a seção `Portal: Regras de Negócio - Pedidos` para compreender melhor seu funcionamento.

## /order/edit/(:id) - Tela de edição de pedido

Tela para edição de pedido.

Consulte a seção `Portal: Regras de Negócio - Pedidos` para compreender melhor seu funcionamento.

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

5 - Um Administrador PODE editar informações de QUALQUER usuário.

6 - Um usuário DESATIVADO NÃO terá acesso ao sistema.

7 - NÃO é possível excluir um usuário!

Recomendo um teste completo nas telas `/user/create`, `/user/edit/:ID` e `/profile` para melhor entendimento do que foi explicado até agora.

## Produtos

Os produtos são uma das entidades que compõem um Pedido.

As regras de negócio dos produtos são bem simples:
- NÃO é possível editar (`/product/edit/:ID`) um produto DESATIVADO: para editá-lo, ative o switch "Ativo" e envie o formulário;
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

A API conta com os seguintes recursos:

| Method | URI | Descrição |
| --- | --- | --- |
| POST | /api/v2/auth/create_session | Método para autenticação de usuário. |
| GET | /api/v2/order/list_finished | Método para listagem de Pedidos Finalizados. |

### Observações:
- As regras de acesso à API são exatamente as mesmas regras para o Portal. 

## POST /api/v2/auth/create_session

Método para autenticação de usuário.

Request (EXEMPLO):
```JSON
{
    "Headers": {
        "Content-Type": "multipart/form-data"
    },
    "Body": {
        "email": "email@email.com",
        "password": "senha"
    }
}
```

Response (EXEMPLO):
```JSON
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEiLCJlbWFpbCI6ImFkbWluQGFkbWluLmNvbSIsImV4cCI6MTYyNTIwNjEzNn0.gbZC8vfjAnAJSW420aHfVG6EXbQFHdlNwuZsckgfaUw"
}
```

### Observações:
- Para realizar a autenticação, poderá ser utilizado o email e senha de usuários Colaboradores e Administradores.

## GET /api/v2/order/list_finished

Método para listagem de Pedidos Finalizados.

Request (EXEMPLO):
```JSON
{
    "Headers": {
        "Authorization": "Bearer TOKEN_GERADA_NA_REQUEST_DE_AUTENTICAÇÃO"
    },
    "Query Params": {
        "limit": 10, // Máximo de pedidos que serão retornados por página.
        "page": 1 // Página atual.
    }
}
```

Response (EXEMPLO):
```JSON
[
    {
        "order": { // Dados do Pedido.
            "id": "2",
            "providerId": "2",
            "contributorId": "1",
            "observations": "",
            "createdAt": "2021-06-29 05:32:40",
            "updatedAt": "2021-06-30 05:59:40"
        },
        "products": [ // Array com os Items do Pedido.
            {
                "productId": "5",
                "name": "Longos - Chicken Caeser Salad",
                "description": "Darter, african",
                "quantity": "321",
                "unitPrice": "321111"
            }
        ],
        "provider": { // Dados do Fornecedor.
            "id": "2",
            "email": "batat@batata.com",
            "fullName": "Batata",
            "phone": "11912345678",
            "addresses": [
                {
                    "id": "47",
                    "zipCode": "07032170",
                    "address": "Rua Décio Antônio Ferroni",
                    "number": "88",
                    "complement": "Casa",
                    "neighborhood": "Vila São Luis",
                    "city": "Guarulhos",
                    "state": "SP",
                    "country": "brasil"
                },
                {
                    "id": "48",
                    "zipCode": "74366225",
                    "address": "Avenida Parque",
                    "number": "888",
                    "complement": "G",
                    "neighborhood": "Residencial Aquários II",
                    "city": "Goiânia",
                    "state": "GO",
                    "country": "brasil"
                }
            ]
        },
        "contributor": { // Dados do Colaborador que criou o Pedido.
            "id": "1",
            "email": "admin@admin.com",
            "fullName": "Administrador",
            "phone": "11111111251",
            "addresses": []
        }
    },
    {
        "order": {
            "id": "7",
            "providerId": "3",
            "contributorId": "1",
            "observations": "AAAAAAAAADASDASDASDAS",
            "createdAt": "2021-06-29 05:39:40",
            "updatedAt": "2021-06-30 05:53:28"
        },
        "products": [
            {
                "productId": "5",
                "name": "Longos - Chicken Caeser Salad",
                "description": "Darter, african",
                "quantity": "321",
                "unitPrice": "321111"
            }
        ],
        "provider": {
            "id": "3",
            "email": "teste@teste.com",
            "fullName": "Teste",
            "phone": "11912345678",
            "addresses": []
        },
        "contributor": {
            "id": "1",
            "email": "admin@admin.com",
            "fullName": "Administrador",
            "phone": "11111111251",
            "addresses": []
        }
    }
]
```

### Observações gerais da API:

1 - Para maiores informações, consulte a documentação POSTMAN `/docs/CodeIgniter3-WS-API.postman_collection.json`.

2 - O arquivo `/docs/CI3-WS-API-LOCAL.postman_environment.json` possuem variáveis de ambiente que são úteis no POSTMAN.

<br />

Projeto desenvolvido por [Claudio Onoue](https://github.com/claudioonoue).