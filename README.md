👋 Olá , eu sou o Samuel Souto dos Santos / @sassa-afk 👀 ..

Sou estudante de Sistemas de Informação e desenvolvedor em formação, com projetos voltados à aplicação prática dos conhecimentos adquiridos tanto na graduação quanto na experiência de trabalho.
Atualmente estudo e crio projetos com intenção aplicar meus conhecimentos passados ao longo de minha experiência academica e no mercado de trabalho
📫 Você consegue chegar até mim através do email samuelsouto21@gmail.com .

---
# Projeto backend de uma simples rede social empresarial criada em PHP
 
Este projeto consiste no desenvolvimento de uma API backend em PHP, seguindo os princípios da arquitetura RESTful, para uma rede social interna simples voltada ao ambiente corporativo.

A API permite funcionalidades básicas como criação de postagens com arquivos, autenticação JWT, e interação entre colaboradores dentro da empresa mostrando e colocando em pratica meus conhecimentos.

**OBS:** Neste primeiro momento, o foco está na estruturação do backend e na construção das APIs RESTful. O desenvolvimento da interface frontend será realizado em seguida, integrando com os serviços já preparados.

# Projeto API PHP - Render Deployment

API RESTful em PHP orientada a objetos, projetada para servir postagens com upload e download de arquivos. Deploy simplificado via Render, com autenticação JWT e documentação Swagger integrada.

# Regra de negócio

- Qualquer usuário pode logar informando dados de nome, CPF, telefone, e-mail, cargo e senha de acesso.
- O processo de cadastro será realizado através de uma API simples REST sem autenticação.
- Será utilizado um token JWT que é gerado ao logar e confirmar usuário e senha no processo de login do usuário:
  + Todos os usuários autenticados gerarão um token que sempre será validado antes de fazer qualquer ação como visualização, inserção e atualização.
  
  + O login de acesso será o CPF informado e a senha cadastrada.
- Os usuários do sistema poderão realizar postes com títulos e arquivos (mensagens ou recados e um arquivo informativo) ou apenas legendas como mensagens (mensagens ou recados).
- Os usuários poderão editar apenas informações do seu próprio acesso, mas de forma limitada — o CPF não pode ser editado.
- Os postes dos usuários não poderão ser apagados, mas poderão ter sua visualização marcada como false, tornando os dados indisponíveis para o próprio usuário e para os demais usuários.


---

## Índice

- [Estrutura do Projeto](#estrutura-do-projeto)  
- [Tecnologias](#tecnologias)  
- [Configuração do Ambiente](#configuração-do-ambiente)  
- [Variáveis de Ambiente](#variáveis-de-ambiente)  
- [Rotas Principais](#rotas-principais)  
- [Upload de Arquivos](#upload-de-arquivos)  
- [Download de Arquivos](#download-de-arquivos)  
- [Autenticação](#autenticação)  
- [Swagger](#swagger)  
- [Banco de Dados](#banco-de-dados)  
- [Considerações sobre Render (Free)](#considerações-sobre-render-free)  
- [Contribuição](#contribuição)  
- [Licença](#licença)


## Estrutura do Projeto



---	 

		├── config
		│   └── conexaoDB.php
		├── public
		│   ├── assets
		│   │   ├── css
		│   │   ├── image
		│   │   └── js
		│   ├── index.php
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
		│       └── postagens
		│           └── 12604753600_7_1751369311.mp3
		├── README.md
		└── src
		    ├── controllers
		    │   ├── controlPostes.php
		    │   └── controlUser.php
		    ├── models
		    │   ├── postagens.php
		    │   └── usuario.php
		    ├── rotas
		    │   ├── RotasGET.php
		    │   ├── RotasJWT.php
		    │   ├── RotasPATCH.php
		    │   ├── Rotas.php
		    │   └── RotasPOST.php
		    ├── utis
		    │   ├── Default.php
		    │   └── jwt.php
		    └── web
			└── pg1.php


 

## Tecnologias

- PHP 8+ (Built-in Server para desenvolvimento)
- PostgreSQL como banco de dados
- JWT para autenticação e segurança
- Swagger para documentação interativa da API
- Deploy na plataforma Render.com (Free tier)

---

## Configuração do Ambiente

Configure variáveis de ambiente para conexão com o banco Postgres.
Exemplo .env:
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

- Variáveis de Ambiente

	| Variável    | Descrição                     |
	| ----------- | ----------------------------- |
	| DB\_NAME    | Nome do banco Postgres        |
	| DB\_USER    | Usuário do banco              |
	| DB\_PASS    | Senha do banco                |
	| DB\_HOST    | Host do banco (ex: localhost) |
	| DB\_PORT    | Porta do banco (padrão 5432)  |
	| JWT\_SECRET | Chave secreta para JWT        |


## Rotas Principais


| Método | Rota                      | Descrição                                               |
| ------ | ------------------------- | ------------------------------------------------------- |
| POST   | `/user/add/newPostFile`   | Adiciona nova postagem com arquivo (upload multipart)   |
| POST   | `/postes/view/down/file`  | Retorna arquivo para download baseado no ID da postagem |
| GET    | `/swagger`                | Interface Swagger UI da API                             |
| ...    | (outras rotas GET, PATCH) | Conforme arquivos em `src/rotas`                        |




