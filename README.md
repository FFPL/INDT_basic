# Interface em PHP para importação de autores e livros na Library App

Baseado no modelo de resposta para os metodos GET e POST de /api/authors
a interface permite duplicação de dados em campos como `firstName` e `lastName` e segue por padrão os campos:

```json
{
    firstName: string,
    lastName: string,
    id: integer
}
```

O mesmo vale para o modelo de respostas dos metodos GET e POST de /api/books

```json
{
    title:string,
    id:integer,
    authorId:integer,
}
```

