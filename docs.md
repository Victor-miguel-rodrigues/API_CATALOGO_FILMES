Desenvolvimento de api de filmes

cosumo configurado a partir do tipo de pesquisa e do nome
descentralizador para limpar, modificar e  traduzir via chatgpt os dados automaticamente

Claro. Para a **v1**, eu documentaria de forma honesta, mostrando o que ela faz hoje e também deixando claro que é uma versão de estudo/refatoração futura.

Você pode colocar isso direto no `README.md`:

````md
# API de Catálogo de Filmes - V1

API desenvolvida em PHP puro com o objetivo de praticar desenvolvimento backend, consumo de APIs externas, manipulação de dados, banco de dados, roteamento e organização de uma aplicação em camadas.

O projeto utiliza a API da OMDb como fonte de dados para pesquisas de filmes e séries. Os dados obtidos são tratados, armazenados em um banco de dados MySQL e posteriormente utilizados para novas consultas e filtros.

Esta é a primeira versão funcional do projeto, desenvolvida durante meus estudos de PHP e Programação Orientada a Objetos.

---

## Objetivo

O principal objetivo deste projeto foi desenvolver uma API de catálogo de filmes e séries sem utilizar frameworks backend, construindo manualmente grande parte do fluxo da aplicação.

Durante o desenvolvimento foram praticados conceitos como:

- PHP
- Programação Orientada a Objetos
- Namespaces
- Composer
- Autoload
- PDO
- MySQL
- Consumo de API REST
- Manipulação de arrays
- Tratamento e normalização de dados
- Roteamento
- Expressões regulares
- Prepared Statements
- Variáveis de ambiente
- Separação entre Controller, Service, Model e Utils

O projeto também serviu como exercício para entender como diferentes partes de uma aplicação backend se comunicam.

---

## Tecnologias utilizadas

- PHP 8
- MySQL
- PDO
- Composer
- SimpleRouter
- Dotenv
- OMDb API
- Apache
- XAMPP

---

## Arquitetura

A aplicação foi organizada utilizando uma separação básica de responsabilidades:

```text
API
│
├── Controller
│   └── Recebe as requisições e direciona as operações
│
├── Service
│   └── Contém regras de negócio e filtros
│
├── Models
│   └── Comunicação com o banco de dados
│
├── API
│   └── Comunicação com a OMDb
│
├── Utils
│   └── Tratamento e transformação dos dados
│
└── Configure
    └── Configuração da conexão com o banco
````

O fluxo básico da aplicação é:

```text
Requisição HTTP
       ↓
SimpleRouter
       ↓
Controller
       ↓
Service / Utils
       ↓
Model
       ↓
MySQL
       ↓
Resposta
```

Nas pesquisas realizadas diretamente na OMDb:

```text
Requisição
    ↓
Controller
    ↓
Service
    ↓
Consumo da OMDb
    ↓
Tratamento dos dados
    ↓
Resposta
```

---

# Funcionalidades

## Pesquisa de filme por nome

Permite pesquisar um filme pelo título.

```http
GET /api/filme/{nome}
```

Exemplo:

```http
GET /api/filme/The Big Bang Theory
```

O sistema consulta a OMDb, seleciona os dados necessários e realiza o processamento das informações.

---

## Pesquisa de série por nome

Permite realizar pesquisas específicas de séries.

```http
GET /api/serie/{nome}
```

Exemplo:

```http
GET /api/serie/Doctor Who
```

---

## Pesquisa por tipo

Permite consultar os registros armazenados no banco de acordo com seu tipo.

```http
GET /api/categoria/{tipo}
```

Exemplos:

```http
GET /api/categoria/movie
```

```http
GET /api/categoria/series
```

---

## Pesquisa por gênero

Permite buscar filmes e séries armazenados no banco de dados de acordo com um determinado gênero.

```http
GET /api/genero/{genero}
```

Exemplo:

```http
GET /api/genero/Action
```

O campo `genero` armazenado no banco pode possuir vários gêneros:

```text
Action, Drama, History
```

Durante a consulta, esses valores são separados e tratados para verificar se o gênero pesquisado está presente.

---

## Pesquisa combinando tipo e gênero

Permite realizar uma filtragem utilizando duas condições:

* tipo;
* gênero.

```http
GET /api/categoria/{tipo}/genero/{genero}
```

Exemplo:

```http
GET /api/categoria/series/genero/drama
```

O resultado retorna somente registros que:

```text
tipo = series
```

e possuem:

```text
Drama
```

entre seus gêneros.

Outro exemplo:

```http
GET /api/categoria/series/genero/crime
```

---

## Pesquisa ampla diretamente na OMDb

A aplicação também possui uma rota destinada a pesquisas diretamente na API externa.

```http
GET /api/filmes/{tipo}/{categoria}
```

Essa funcionalidade trabalha com os dados retornados pela OMDb e utiliza uma camada de tratamento para selecionar e organizar as informações.

---

# Armazenamento dos dados

Quando um filme ou série é pesquisado, os dados relevantes podem ser armazenados no banco de dados.

As informações utilizadas incluem:

```text
titulo
ano
idioma
data_completa
duracao
genero
image
avaliacao
tipo
```

Exemplo:

```text
titulo: Doctor Who
ano: 2005–2022
idioma: English
data_completa: 17 Mar 2006
duracao: 45 min
genero: Adventure, Drama, Sci-Fi
avaliacao: 8.5
tipo: series
```

---

# Prevenção de registros duplicados

Antes de inserir um novo registro, o sistema verifica se o título já está presente no banco de dados.

A verificação utiliza `SELECT EXISTS` com Prepared Statement.

Conceitualmente:

```sql
SELECT EXISTS(
    SELECT titulo
    FROM filmes
    WHERE titulo = ?
) AS existe;
```

Dessa forma, o sistema evita inserir novamente um filme que já esteja armazenado.

---

# Integração com a OMDb

A aplicação utiliza a OMDb API como fonte externa de informações.

Os dados recebidos pela API possuem uma estrutura diferente da estrutura utilizada internamente pela aplicação.

Por isso, existe uma etapa de transformação dos dados.

Exemplo de dados recebidos:

```text
Title
Year
Language
Released
Runtime
Genre
Poster
imdbRating
Type
```

Esses dados são transformados para a estrutura utilizada pela aplicação:

```php
[
    'titulo' => ...,
    'ano' => ...,
    'idioma' => ...,
    'data_completa' => ...,
    'duracao' => ...,
    'genero' => ...,
    'image' => ...,
    'avaliacao' => ...,
    'tipo' => ...
]
```

Essa transformação é realizada antes dos dados serem enviados para o Model.

---

# Manipulação dos gêneros

Como a OMDb retorna os gêneros em uma única string:

```text
Adventure, Drama, Sci-Fi
```

o sistema utiliza `explode()` para transformar essa informação em uma coleção de gêneros:

```text
[
    "Adventure",
    "Drama",
    "Sci-Fi"
]
```

Também é utilizado `trim()` para remover espaços desnecessários.

A comparação dos gêneros também é normalizada para letras minúsculas, permitindo consultas como:

```text
Drama
drama
DRAMA
```

sem alterar o resultado da pesquisa.

---

# Banco de dados

A aplicação utiliza MySQL para armazenar os filmes e séries pesquisados.

A tabela principal utilizada é:

```text
filmes
```

Com campos relacionados às informações recebidas da OMDb.

A persistência é realizada utilizando PDO e Prepared Statements.

---

# Segurança e boas práticas utilizadas

A primeira versão já utiliza alguns mecanismos importantes:

* Prepared Statements para consultas SQL;
* variáveis de ambiente para configurações sensíveis;
* Composer para gerenciamento de dependências;
* Dotenv para carregamento das variáveis do `.env`;
* separação de responsabilidades entre partes da aplicação;
* validação de parâmetros através das rotas;
* autoload através do Composer.

---

# Rotas

| Método | Endpoint                            | Função                       |
| ------ | ----------------------------------- | ---------------------------- |
| GET    | `/api/`                             | Entrada da API               |
| GET    | `/api/filme/{nome}`                 | Pesquisa filme               |
| GET    | `/api/filmes/{type}/{cat}`          | Pesquisa diretamente na OMDb |
| GET    | `/api/categoria/{cat}`              | Pesquisa por tipo no banco   |
| GET    | `/api/genero/{gen}`                 | Pesquisa por gênero          |
| GET    | `/api/categoria/{cat}/genero/{gen}` | Pesquisa por tipo e gênero   |
| GET    | `/api/serie/{nome}`                 | Pesquisa série               |

---

# Exemplo de resposta

Uma consulta por gênero pode retornar:

```text
[
    {
        "id": 14,
        "titulo": "Game of Thrones",
        "ano": "2011–2019",
        "idioma": "English",
        "data_completa": "17 Apr 2011",
        "duracao": "57 min",
        "genero": "Action, Adventure, Drama",
        "image": "...",
        "avaliacao": "9.2",
        "tipo": "series"
    }
]
```

---

# Estrutura do projeto

Uma representação simplificada:

```text
 API/
│   └── Filmes/
│       ├── API/
│       ├── configure/
│       ├── Controller/
│       ├── models/
│       ├── service/
│       └── utils/
│
 |
├── routs/
│   └── routs.php
│
├── vendor/
│
├── .env
├── .gitignore
├── composer.json
└── index.php
```

---

# Configuração

Clone o projeto:

```bash
git clone <URL_DO_REPOSITORIO>
```

Entre na pasta:

```bash
cd api
```

Instale as dependências:

```bash
composer install
```

Configure o arquivo `.env` com as informações necessárias para a aplicação e para o acesso à OMDb API.

Depois configure o banco de dados MySQL de acordo com a estrutura utilizada pelo projeto.

---

# Estado da V1

Esta versão representa uma primeira implementação funcional da API.

O objetivo principal da V1 foi aprendizado e construção prática. Algumas partes ainda podem ser melhoradas em versões futuras.

Entre os pontos planejados para uma futura refatoração estão:

* padronização das respostas em JSON;
* tratamento completo de erros;
* tratamento de resultados vazios;
* códigos HTTP mais adequados;
* validação mais robusta dos parâmetros;
* melhoria da arquitetura;
* testes automatizados;
* paginação;
* melhoria da organização das responsabilidades;
* estudo e aplicação de Design Patterns quando fizer sentido;
* implementação de autenticação e autorização;
* melhoria da documentação da API.

A V1 não busca representar uma arquitetura definitiva ou uma aplicação pronta para produção.

Ela representa o resultado de um processo de aprendizado prático em PHP, no qual os recursos foram implementados gradualmente através de desenvolvimento, testes, erros, pesquisas e resolução dos problemas encontrados durante a construção.

---

# Próximos passos

A evolução planejada para versões futuras inclui:

```text
V1
│
├── API funcional
├── OMDb
├── MySQL
├── PDO
├── Roteamento
├── Filtros
└── Persistência
        ↓
V2
│
├── JSON padronizado
├── Tratamento de erros
├── HTTP Status Codes
├── Validações
├── Testes
├── Paginação
└── Refatoração
        ↓
V3
│
├── Autenticação
├── Autorização
├── Middleware
├── Cache
└── Melhorias de arquitetura
```

---

# Sobre o projeto

Este projeto foi desenvolvido individualmente como parte do processo de aprendizado em desenvolvimento backend.

A proposta foi evitar depender de frameworks para entender melhor os fundamentos por trás de uma aplicação web, construindo manualmente o fluxo de requisições, roteamento, comunicação com APIs externas, tratamento dos dados, persistência no banco e filtragem das informações.

A V1 representa principalmente uma etapa de aprendizado e experimentação. O código será utilizado posteriormente como base para refatoração e evolução da aplicação conforme novos conceitos forem aprendidos.

```
```
