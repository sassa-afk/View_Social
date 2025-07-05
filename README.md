👋 Olá , eu sou o Samuel Souto dos Santos / @sassa-afk 👀 ..

Sou estudante de Sistemas de Informação e desenvolvedor em formação, com projetos voltados à aplicação prática dos conhecimentos adquiridos tanto na graduação quanto na experiência de trabalho.

Atualmente estudo e crio projetos com intenção aplicar meus conhecimentos passados ao longo de minha experiência academica e no mercado de trabalho

**Você consegue chegar até mim através do email samuelsouto21@gmail.com .**

---
# Projeto backend (posteriormente fullstack) de uma simples rede social empresarial criada em PHP
 
Este projeto consiste no desenvolvimento de uma API backend em PHP, seguindo os princípios da arquitetura RESTful, para uma rede social interna simples voltada ao ambiente corporativo.

Primeiro séra criado uma API que permitira funcionalidades básicas como criação de postagens com arquivos, autenticação JWT, e interação entre colaboradores dentro da empresa mostrando e colocando em pratica meus conhecimentos.

**OBS:** Neste primeiro momento, o foco está na estruturação do backend e na construção das APIs RESTful. O desenvolvimento da interface frontend será realizado em seguida, integrando com os serviços já preparados.

# Regra de negócio

- Qualquer usuário pode se cadastrar informando dados de nome, CPF, telefone, e-mail, cargo e senha de acesso.
- O processo de cadastro será realizado através de uma API simples REST sem autenticação, mas as demais chamadas das APIS serão RESTFULL .

- Será utilizado um token JWT que é gerado ao logar e confirmar usuário e senha no processo de login do usuário:
  + Todos os usuários autenticados gerarão um token que sempre será validado antes de fazer qualquer ação como visualização, inserção e atualização.
  + O login de acesso será o CPF informado e a senha cadastrada.
  
- Os usuários do sistema poderão realizar criar postes com títulos e arquivos (mensagens ou recados e um arquivo informativo) ou apenas legendas como mensagens (mensagens ou recados).

- Os usuários poderão editar apenas informações do seu próprio acesso, mas de forma limitada — o CPF não pode ser editado.

- Os postes dos usuários não poderão ser apagados, mas poderão ter sua visualização marcada como false, tornando os dados indisponíveis para o próprio usuário e para os demais usuários.

- Os postes criados não poderam ser editados, mas poderam ficar indisponíveis 

# Projeto disponivel no servidor free Render Deployment

Sinta-se à vontade para testar a aplicação!

A API RESTful foi criada em PHP, projetada para servir postagens com upload e download de arquivos. Deploy simplificado via Render, com autenticação JWT e documentação Swagger integrada.

Acesse a documentação Swagger com todas as rotas implementadas até o momento:  
[https://view-sociald.onrender.com/swagger/](https://view-sociald.onrender.com/swagger/)


**obs:**

Este projeto está hospedado em um **servidor gratuito Render**, o qual entra em **modo de hibernação (sleep mode)** após um período de inatividade.

- O **primeiro acesso após o modo sleep** pode levar alguns segundos ou minutos extras.
- Após o servidor ser reativado, todas as requisições funcionam normalmente.

Além disso:

- Arquivos enviados através das rotas de upload ficam temporariamente disponíveis para acesso direto via link público **enquanto o servidor estiver ativo**.
- Caso o servidor entre novamente em modo sleep, os arquivos ainda existem, porém o link pode **não estar mais acessível imediatamente** até nova reativação.


---

## Índice

- [Tecnologias](#tecnologias)  
- [Estrutura do Projeto](#estrutura-do-projeto)  
- [Segurança (Autenticação JWT e HASH de senhas)](#segurança-autenticação-jwt-e-hash-de-senhas)
- [Diagrama de classe](#diagrama-de-classe)  
- [Configuração do Ambiente](#configuração-do-ambiente)  
- [Variáveis de Ambiente](#variáveis-de-ambiente)  
- [Banco de Dados](#banco-de-dados)  
- [Armazenamento de Arquivos](#armazenamento-de-arquivos)  
- [Rotas Principais](#rotas-principais)  
- [Swagger](#swagger)  
 



## Tecnologias

. PHP · PostgreSQL · JWT · CURL · Apache · Docker · Swagger · React (frontend em desenvolvimento) . Render.com (Free tier)

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


## Segurança ( Autenticação JWT e HASH de senhas )

- Segurança (Autenticação JWT e Hash de Senhas)
A autenticação é realizada por meio de tokens JWT, exigidos na maioria dos endpoints da API.
- O token deve ser enviado no cabeçalho HTTP como: Authorization: Bearer {token}.
- As rotas protegidas estão principalmente definidas no arquivo RotasJWT.php.
- Após a autenticação, é gerado um token JWT contendo o ID do usuário validado. Esse token é obrigatório em requisições que envolvem inserção, edição ou consulta de dados sensíveis no banco, garantindo que apenas usuários autorizados executem essas ações.
- Senhas são armazenadas utilizando criptografia via hash. A codificação é aplicada apenas nos processos de cadastro, autenticação e redefinição de senha, assegurando que os dados sensíveis não sejam expostos em nenhum momento.

## Diagrama de classe
---
---

## Configuração do Ambiente (Linux)

Configure variáveis de ambiente para conexão com o banco Postgres.


1. Clone o repositório via terminal :

	   git clone https://github.com/seu-usuario/seu-projeto.git
	   cd seu-projeto
	
2. Em seguida instale o postgreas e gerenciador psql via terminal: 
	
	   sudo apt update
	   sudo apt install postgresql postgresql-client
	   sudo systemctl start postgresql
	   sudo systemctl enable postgresql
	   
2. Para sistemas operacionais windonw vá para o site oficial:
	   https://www.postgresql.org/download/windows/
	   - Baixe o instalador do PostgreSQL (você pode usar o instalador do StackBuilder).
	   - Durante a instalação:
	   - Escolha a versão desejada
	   - Defina a senha do usuário postgres
	   - Instale o pgAdmin se quiser usar uma interface gráfica
		
3. Em seguida seu banco pelo psql pelo terminal 

	  sudo -u postgres createuser --interactive
	  sudo -u postgres createdb comunidade_1

4. Apos acessar seu banco postgres crie as tabelas conforme sqls dispiniveis em [Banco de Dados](#banco-de-dados) 
       
5. Por fim se for no linux acesse apasta public , e atraves do php nativo starte o index do php e no windonws incie no xamp ou outro sistema de execução do PHP
       
	   cd public
	   php -S localhost:8080
 	   

Configure variáveis de ambiente para conexão com o banco Postgres no render.
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


## Variáveis de Ambiente RENDER

| Variável    | Descrição                     |
| ----------- | ----------------------------- |
| DB\_NAME    | Nome do banco Postgres        |
| DB\_USER    | Usuário do banco              |
| DB\_PASS    | Senha do banco                |
| DB\_HOST    | Host do banco (ex: localhost) |
| DB\_PORT    | Porta do banco (padrão 5432)  |
| JWT\_SECRET | Chave secreta para JWT        |

## Banco de Dados 

Esta aplicação utilizar em sua modelagem o serviço Postgreas, seguindo o padrão abaixo de modelagem do banco :

---
	psql -U postgres -c "CREATE DATABASE comunidade_1  WITH OWNER = postgres ENCODING = 'UTF8' LC_COLLATE = 'pt_BR.UTF-8' LC_CTYPE = 'pt_BR.UTF-8' TABLESPACE = pg_default CONNECTION LIMIT = -1;"
---

As Criação das tabelas principais do projeto, estruturado e baseado nas tabelas: pessoa, acessos, postagem, comentario

**Tabela pessoa**

---
	CREATE TABLE IF NOT EXISTS pessoa (
	    cpf               VARCHAR(11) PRIMARY KEY,
	    nome              VARCHAR(100) NOT NULL,
	    email             VARCHAR(100) NOT NULL UNIQUE,
	    telefone          VARCHAR(15),
	    caminho_foto      TEXT,
	    sexo              VARCHAR(15),
	    funcao_na_empresa VARCHAR(100)
	);
---

**Tabela acessos**

---
	CREATE TABLE IF NOT EXISTS acessos (
	    id           SERIAL PRIMARY KEY,
	    login        VARCHAR(11) NOT NULL UNIQUE,
	    senha        VARCHAR(255) NOT NULL,
	    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	    CONSTRAINT acessos_login_fkey FOREIGN KEY (login) REFERENCES pessoa(cpf)
	);
---

**Tabela postagem**

---
	CREATE TABLE IF NOT EXISTS postagem (
	    id              SERIAL PRIMARY KEY,
	    id_autor        VARCHAR(11),
	    data_postagem   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	    caminho_arquivo TEXT,
	    legenda         TEXT,
	    ativo           BOOLEAN,

	    CONSTRAINT postagem_id_autor_fkey FOREIGN KEY (id_autor) REFERENCES pessoa(cpf)
	);
---

**Tabela comentario**

---
	CREATE TABLE IF NOT EXISTS comentario (
	    id_comentario   SERIAL PRIMARY KEY,
	    id_post         INTEGER NOT NULL,
	    cpf_comentador  VARCHAR(11) NOT NULL,
	    data_comentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	    comentario      TEXT NOT NULL,

	    CONSTRAINT comentario_id_post_fkey FOREIGN KEY (id_post) REFERENCES postagem(id),
	    CONSTRAINT comentario_cpf_comentador_fkey FOREIGN KEY (cpf_comentador) REFERENCES pessoa(cpf)
	);
---

**DER**

![image](https://github.com/user-attachments/assets/32119e07-ebb6-4919-b6e0-832d3f3badb4)


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

As rotas criadas até o momento estão listadas abaixo de forma simplificada. Toda a documentação detalhada será integrada e disponibilizada por meio do Swagger, cujo link também será incluído neste repositório assim que possível.

**Rotas GET**

| Rota                        | Descrição                                                                 | Quando usar                          |
|-----------------------------|---------------------------------------------------------------------------|--------------------------------------|
| `/usuarios/list/onlyUsers`  | Retorna dados informativos do usuário logado (nome, telefone, etc.)       | Painel de perfil                     |
| `/postes/view/all`          | Retorna todos os postes criados por todos os usuários (sem arquivos)      | Painel de feed principal             |
| `/postes/view/limit`        | Retorna os postes limitados conforme número informado (ex: últimos 4)     | Painel de feed principal             |
| `/postes/view/down/file`    | Verifica se o poste tem arquivo e, se sim, disponibiliza para download    | Feed principal e perfil do usuário   |
| `/pg/inicio`                | Pagina web inicial ( até o momento sem desenvolvimento)                   | Pagina inical de login               |

**Rotas PATH**

| Rota                        | Descrição                                                                                       | Quando usar         |
|-----------------------------|-------------------------------------------------------------------------------------------------|---------------------|
| `/user/update/selfPerfil`   | Atualiza dados do cadastro (nome, telefone, etc). Não permite alterar CPF nem senha             | Painel de perfil    |
| `/user/update/selfPass`     | Atualiza apenas a senha de acesso                                                               | Painel de perfil    |

**Rotas POST**

| Rota                          | Descrição                                                                                      | Quando usar                          |
|-------------------------------|------------------------------------------------------------------------------------------------|--------------------------------------|
| `/user/newUse`                | Adiciona novos usuários (rota pública, sem autenticação JWT)                                   | Página de cadastro                   |
| `/user/login`                 | Valida login e gera token JWT para uso nas demais rotas protegidas                             | Página inicial / Login               |
| `/user/add/newPostComentario` | Cria um novo post (sem arquivo) para o usuário logado                                          | Painéis de feed e perfil             |
| `/user/add/newPostFile`       | Cria um novo post com arquivo (imagem, áudio etc.) para o usuário logado                       | Painéis de feed e perfil             |


As rotas do back-end ainda não estão completas. Algumas funcionalidades básicas serão adicionadas nas próximas atualizações do projeto. A seguir, estão listadas as rotas que ainda serão implementadas:

- Comentar um poste
- Listar todos os comentários de um poste
- Desativar uma postagem
- Visualizar postagens exclusivas de um usuário

Podera haver também inserção de novas rotas que não estão listadas e as mesmas serão adicionadas as tabelas e ao Swagger.

## Swagger

A documentação das rotas criadas estão disponiveis no link https://view-sociald.onrender.com/swagger/#

