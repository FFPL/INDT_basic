# Interface em PHP para importação de autores e livros na Library App

Baseado no modelo de resposta para os metodos GET e POST de /api/authors
a interface permite duplicação de dados em campos como `firstName` e `lastName` e segue por padrão os campos:

```json
{
    firstName: string (required),
    lastName: string (required),
    id: integer
}
```

O mesmo vale para o modelo de respostas dos metodos GET e POST de /api/books

```json
{
    title:string (required),
    id:integer,
    authorId:integer (fk)(required),
}
```

Sendo assim a sugestão para um arquivo em formato json que contemple ambos:

```json
{
"author": [
    {
      "firstName": "string",
      "lastName": "string",
      "books": [{ "title": "string" },{ "title": "string" }, {...}]
    },
    {
        "firstName": "string",
        "lastName": "string",
        "books": [{ "title": "string" }, {...}]
    }
  ]
}
```

## Dependências

* PHP >= 5.6
* php-curl extension
* Composer

## Instalando

Abra um terminal e faça o clone deste repositorio:

>$ git clone https://github.com/FFPL/INDT_basic.git

vá até a pasta do clone

> $ cd INDT_basic

execute o composer para instalar as dependencias

> $ composer install

após o download das dependencias execute o comando

>php -S localhost:777

abra o navegador e digite na url

>localhost:777

Dentro da pasta do projeto existe um arquivo nomeado de [test.json](test.json) que pode ser utilizado como modelo para testes.