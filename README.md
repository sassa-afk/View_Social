👋 Olá , eu sou o Samuel Souto dos Santos / @sassa-afk 👀 ..

Sou estudante de Sistemas de Informação e desenvolvedor em formação, com projetos voltados à aplicação prática dos conhecimentos adquiridos tanto na graduação quanto na experiência de trabalho.

Atualmente estudo e crio projetos com intenção aplicar meus conhecimentos passados ao longo de minha experiência academica e no mercado de trabalho

**Você consegue chegar até mim através do email samuelsouto21@gmail.com .**

---
# Projeto backend de uma simples rede social empresarial criada em PHP
 
Este projeto consiste no desenvolvimento de uma API backend em PHP, seguindo os princípios da arquitetura RESTful, para uma rede social interna simples voltada ao ambiente corporativo.

A API permite funcionalidades básicas como criação de postagens com arquivos, autenticação JWT, e interação entre colaboradores dentro da empresa mostrando e colocando em pratica meus conhecimentos.

**OBS:** Neste primeiro momento, o foco está na estruturação do backend e na construção das APIs RESTful. O desenvolvimento da interface frontend será realizado em seguida, integrando com os serviços já preparados.

# Regra de negócio

- Qualquer usuário pode logar informando dados de nome, CPF, telefone, e-mail, cargo e senha de acesso.
- O processo de cadastro será realizado através de uma API simples REST sem autenticação.
- Será utilizado um token JWT que é gerado ao logar e confirmar usuário e senha no processo de login do usuário:
  + Todos os usuários autenticados gerarão um token que sempre será validado antes de fazer qualquer ação como visualização, inserção e atualização.
  
  + O login de acesso será o CPF informado e a senha cadastrada.
- Os usuários do sistema poderão realizar postes com títulos e arquivos (mensagens ou recados e um arquivo informativo) ou apenas legendas como mensagens (mensagens ou recados).
- Os usuários poderão editar apenas informações do seu próprio acesso, mas de forma limitada — o CPF não pode ser editado.
- Os postes dos usuários não poderão ser apagados, mas poderão ter sua visualização marcada como false, tornando os dados indisponíveis para o próprio usuário e para os demais usuários.

# Projeto disponivel no servidor free Render Deployment

API RESTful em PHP orientada a objetos, projetada para servir postagens com upload e download de arquivos. Deploy simplificado via Render, com autenticação JWT e documentação Swagger integrada.


---

## Índice

- [Estrutura do Projeto](#estrutura-do-projeto)  
- [Diagrama de classe](#diagrama-de-classe)  
- [Tecnologias](#tecnologias)  
- [Configuração do Ambiente](#configuração-do-ambiente)  
- [Variáveis de Ambiente](#variáveis-de-ambiente)  
- [Banco de Dados](#banco-de-dados)  
- [Armazenamento de Arquivos](#armazenamento-de-arquivos)  
- [Rotas Principais](#rotas-principais)  
- [Swagger](#swagger)  
- [Licença](#licença)


## Estrutura do Projeto

O projeto está organizado em camadas seguindo uma estrutura MVC adaptada para PHP puro com foco em APIs REST:

- `public/`: Entrada principal da aplicação, arquivos públicos , indexador e documentação swaggerWW.
- `src/rotas/`: Arquivos de roteamento organizados por método HTTP.
- `src/controllers/`: Controladores responsáveis pela lógica de negócio e retorno de resposta.
- `src/models/`: Models com acesso ao banco via PDO (PostgreSQL).
- `src/utis/`: Funções utilitárias (validações, JWT etc).
- `config/`: Arquivos de configuração e conexão ao banco.

---	 
	├── config →  **Camada de configuração**
	│   └── conexaoDB.php
	├── public → **Camada view**
	│   ├── assets
	│   │   ├── css
	│   │   ├── image
	│   │   └── js
	│   ├── index.php  → **Inicialização**
	│   ├── swagger
	│   │   ├── favicon-16x16.png
	│   │   ├── favicon-32x32.png
	│   │   ├── index.css
	│   │   ├── index.html
	│   │   ├── oauth2-redirect.html
	│   │   ├── README.md
	│   │   ├── swagger-initializer.js
	│   │   ├── swagger.json
	│   │   ├── swagger-ui-bundle.js
	│   │   ├── swagger-ui.css
	│   │   ├── swagger-ui-es-bundle-core.js
	│   │   ├── swagger-ui-es-bundle.js
	│   │   ├── swagger-ui.js
	│   │   └── swagger-ui-standalone-preset.js
	│   └── upload
	│       ├── foto_perfil
	│       └── postagens
	├── README.md
	└── src
	    ├── controllers  → **Camada de controle**
	    │   ├── controlPostes.php
	    │   └── controlUser.php
	    ├── models  → **Camada de modelagem**
	    │   ├── postagens.php
	    │   └── usuario.php
	    ├── rotas   → **Camada de dominio/roteamento**
	    │   ├── RotasGET.php
	    │   ├── RotasJWT.php
	    │   ├── RotasPATCH.php 
	    │   ├── Rotas.php
	    │   └── RotasPOST.php
	    ├── utis   → **Camada de utilidade padrão**
	    │   ├── Default.php
	    │   └── jwt.php
	    └── web
		└── pg1.php
---

**Fluxo de Inicialização (detalhado)**

- O ponto de entrada da aplicação é o arquivo `public/index.php`.
- Esse arquivo inicia a API e referencia o sistema de rotas.
- As rotas estão localizadas em `src/rotas/` e são divididas por método HTTP:
  - `RotasGET.php`
  - `RotasPOST.php`
  - `RotasPATCH.php`
  - `RotasJWT.php` (rotas protegidas)
  - `Rotas.php` (núcleo do roteador)

**Roteamento (detalhado)**

- As rotas fazem o direcionamento da requisição HTTP para os métodos nos controllers.
- Parâmetros são validados e organizados antes de chegar na camada de lógica.
- As rotas também identificam quais métodos aceitam `GET`, `POST` ou `PATCH`.
- Ele fica exclusivo para realizar aponta as rotas e tipos de passagem de dados ( string , files , inteiros e outros).

**Camada de Lógica – Controllers (detalhado)**

- Localizados em `src/controllers/`, os controllers recebem as requisições já tratadas e direcionam para os models.
- Formatam o retorno (mensagem + status HTTP) com base no resultado dos models a principios de execução de cruds.
- Também realizam validações de regra de negócio, se necessário.


**Camada de Dados – Models (detalhado)**

- Em `src/models/` estão os models que fazem o acesso direto ao banco de dados PostgreSQL de forma privada utilizandoencapsulada em métodos privados e exposta apenas por métodos públicos.
- Cada model herda a classe abstrata `conexaoDB` (em `config/conexaoDB.php`) que controla a conexão.
- A comunicação com o banco segue padrão orientado a objetos com métodos públicos chamando lógicas privadas.


**Utilitários (detalhado)**

- A pasta `src/utis/` contém funções e classes auxiliares:
  - `jwt.php`: validação e geração de tokens JWT.
  - `Default.php`: validações genéricas e tratadores padrão.


**Swagger – Documentação da API (detalhado)**

- A documentação interativa da API está em `public/swagger/`.
- A interface é exibida via `swagger/index.html`, utilizando o arquivo `swagger.json`.
- Permite testar endpoints, visualizar parâmetros e simular requisições com token.


**Upload de Arquivos (detalhado)**

- Arquivos enviados via endpoints (ex: imagens de postagens) são salvos em `public/upload/postagens/`.
- O acesso pode ser direto via URL ou por endpoints protegidos.
- Em ambiente como Render (plano gratuito), o armazenamento é temporário – a pasta pode ser apagada após reinício da instância.


**Segurança (detalhado)**

- A autenticação é feita via tokens JWT, obrigatórios para a maioria dos endpoints.
- O token deve ser enviado no header `Authorization: Bearer {token}`.
- Endpoints protegidos estão definidos principalmente em `RotasJWT.php`.



## Diagrama de classe
---

## Tecnologias

- PHP 8+ (Built-in Server para desenvolvimento)
- PostgreSQL como banco de dados
- JWT para autenticação e segurança
- Swagger para documentação interativa da API
- Deploy na plataforma Render.com (Free tier)

## Configuração do Ambiente

Configure variáveis de ambiente para conexão com o banco Postgres.

---
	1. Clone o repositório:
	   ```bash
	   git clone https://github.com/seu-usuario/seu-projeto.git
	   cd seu-projeto
---	   

Configure variáveis de ambiente para conexão com o banco Postgres.
Exemplo .env:
---
	DB_NAME=seubanco
	DB_USER=usuario
	DB_PASS=senha
	DB_HOST=localhost
	DB_PORT=5432
	JWT_SECRET=sua_chave_secreta_jwt

---

As Variáveis sensíveis deste projetos (como credenciais do banco) serão criadas e acessadas por `getenv()` e definidas como variáveis de ambiente no servidor RENDER onde o projeto será alocado . 


## Variáveis de Ambiente

	| Variável    | Descrição                     |
	| ----------- | ----------------------------- |
	| DB\_NAME    | Nome do banco Postgres        |
	| DB\_USER    | Usuário do banco              |
	| DB\_PASS    | Senha do banco                |
	| DB\_HOST    | Host do banco (ex: localhost) |
	| DB\_PORT    | Porta do banco (padrão 5432)  |
	| JWT\_SECRET | Chave secreta para JWT        |

## Banco de Dados 

Esta aplicação utilizar em sua modelagem o serviço Postgreas 



## Armazenamento de Arquivos

Os arquivos enviados pelos usuários são armazenados na pasta pública da aplicação, localizada em public/upload . Essa pasta contém duas subpastas específicas:

1. **`postagens/`**  
   - Armazena os arquivos enviados pelos usuários nas postagens.
   - Os arquivos são renomeados seguindo o padrão:  
     ```
     {cpf}_{id}_{timestamp}.{extensão}
     ```
     Exemplo:  
     ```
     00004753600_7_1751369311.mp3
     ```
2. **`foto_perfil/`**  
   - Armazena as fotos de perfil dos usuários.
   - Também segue um padrão de nome baseado no CPF ou ID do usuário.

Se o usuário **não tiver uma foto de perfil**, o sistema utiliza uma imagem padrão chamada:
Essa imagem fica armazenada na aplicação como fallback para usuários sem avatar.


## Rotas Principais


| Método | Rota                      | Descrição                                               |
| ------ | ------------------------- | ------------------------------------------------------- |
| POST   | `/user/add/newPostFile`   | Adiciona nova postagem com arquivo (upload multipart)   |
| POST   | `/postes/view/down/file`  | Retorna arquivo para download baseado no ID da postagem |
| GET    | `/swagger`                | Interface Swagger UI da API                             |
| ...    | (outras rotas GET, PATCH) | Conforme arquivos em `src/rotas`                        |




##Swagger

