# Documentação Swagger UI Local

## Passo a passo para usar Swagger UI localmente

1. Clone o repositório oficial do Swagger UI na pasta `public` (ou onde roda seu `index.php`):

```bash
git clone https://github.com/swagger-api/swagger-ui.git
```

2. Copie a pasta dist para dentro da pasta public e renomeie para swagger (ou nome que preferir):

```bash
mv public/swagger-ui/dist public/swagger
```

3. Em seguida delete a pasta original swagger-ui se quiser:

```bash
rm -rf public/swagger-ui
```

4. A estrutura mínima da pasta public/swagger deve conter:

---
Novo diretorio swagger :

	index.html  
	swagger-ui.css  
	swagger-ui-bundle.js  
	swagger-ui-standalone-preset.js  
	swagger-initializer.js  
	swagger.json  ← Seu arquivo de documentação OpenAPI  
---


## Passo a passo para configurar os arquivos e acessar

1. Edite o arquivo para apontar para seu `swagger.json` local:

```swagger.json
window.onload = function() {
  window.ui = SwaggerUIBundle({
    url: "swagger.json",
    dom_id: '#swagger-ui',
    deepLinking: true,
    presets: [
      SwaggerUIBundle.presets.apis,
      SwaggerUIStandalonePreset
    ],
    plugins: [
      SwaggerUIBundle.plugins.DownloadUrl
    ],
    layout: "StandaloneLayout"
  });
};
```

2. Crie suas rotas swg como no exemplo base 

```swagger.json
{
  "openapi": "3.0.0",
  "info": {
    "title": "Minha API",
    "version": "1.0.0"
  },
  
  "paths": {
    "/user/login": {
      "post": {
        "summary": "Login do usuário",
        "requestBody": {
          "required": true,
          "content": {
            "application/json": {
              "schema": {
                "type": "object",
                "properties": {
                  "user": { "type": "string" },
                  "pass": { "type": "string" }
                },
                "required": ["user", "pass"]
              }
            }
          }
        },
        "responses": {
          "200": {
            "description": "Login bem-sucedido"
          },
          "401": {
            "description": "Falha na autenticação"
          }
        }
      }
    }
  }
}

```

3. Por fim acesse seu swagger atraves do link

http://<link_pg_php>:<porta>/swagger/

