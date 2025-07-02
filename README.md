👋 Olá , eu sou o Samuel Souto dos Santos / @sassa-afk 👀 ..

Sou estudante de Sistemas de Informação e desenvolvedor em formação, com projetos voltados à aplicação prática dos conhecimentos adquiridos tanto na graduação quanto na experiência de trabalho.
Atualmente estudo e crio projetos com intenção aplicar meus conhecimentos passados ao longo de minha experiência academica e no mercado de trabalho
📫 Você consegue chegar até mim através do email samuelsouto21@gmail.com .


# Projeto backend de uma simples rede social criada em PHP
 

Esté é um projeto integrado que reúne diversas APIs úteis desenvolvido com o serviço node.js atraves de apis que desenvolvidas e aplicadas em trabalhos freelance. O objetivo foi centralizar e facilitar a comunicação com serviços externos por meio de uma estrutura em Node.js.

Serviços integrados:

# Projeto API PHP - Render Deployment

API RESTful em PHP orientada a objetos, projetada para servir postagens com upload e download de arquivos.  
Deploy simplificado via Render, com autenticação JWT e documentação Swagger integrada.

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

---

## Estrutura do Projeto

		 

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

1. Clone o repositório:
   ```bash
   git clone https://github.com/seu-usuario/seu-projeto.git
   cd seu-projeto

DB_NAME=seubanco
DB_USER=usuario
DB_PASS=senha
DB_HOST=localhost
DB_PORT=5432
JWT_SECRET=sua_chave_secreta_jwt



