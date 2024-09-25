# Anotações da API

## Rota: /register
- **Descrição**: Esta rota permite o registro de um novo usuário no sistema.
- **Método**: POST
- **Recebe**:
  - `name`: string (nome do usuário)
  - `email`: string (endereço de e-mail do usuário)
  - `password`: string (senha do usuário)
- **RETORNA**:
  - `status`: string (success/error)
  - `message`: string (mensagem detalhando o resultado)

---

## Rota: /login
- **Descrição**: Esta rota permite que um usuário existente faça login no sistema.
- **Método**: POST
- **Recebe**:
  - `email`: string (endereço de e-mail do usuário)
  - `password`: string (senha do usuário)
- **RETORNA**:
  - `status`: string (success/error)
  - `message`: string (mensagem sobre o resultado do login)
  - `token`: string (token 64 bytes caso o login seja efetuado)

---

## Rota: /task
- **Descrição**: Esta rota permite a visualização de todas as tarefas cadastradas no sistema.
- **Método**: GET
- **RETORNA**:
  - `todos`: array (lista de tarefas)
  - `status`: string (success/error)

---

## Rota: /task
- **Descrição**: Esta rota permite a criação de uma nova tarefa.
- **Método**: POST
- **Cabeçalho**:
  - `Authorization`: string (Bearer token)
- **Recebe**:
  - `name`: string
- **RETORNA**:
  - `status`: string (success/error)
  - `message`: string (mensagem detalhando o resultado)

---

## Rota: /task
- **Descrição**: Esta rota permite a atualização de uma tarefa existente.
- **Método**: PUT
- **Cabeçalho**:
  - `Authorization`: string (Bearer token)
- **Recebe**:
  - `id`: integer (id da tarefa)
  - `name`: string (opcional)
  - `status`: string (opcional [pendente, em progresso, completa])
- **RETORNA**:
  - `status`: string (success/error/info)
  - `message`: string (mensagem detalhando o resultado)

---

## Rota: /task
- **Descrição**: Esta rota permite a deleção de uma tarefa existente.
- **Método**: DELETE
- **Cabeçalho**:
  - `Authorization`: string (Bearer token)
- **Recebe**:
  - `id`: integer (id da tarefa)
- **RETORNA**:
  - `status`: string (success/error/info)
  - `message`: string (mensagem detalhando o resultado)

---

## Problemas Conhecidos
- As rotas de criação e deleção ainda não funcionam corretamente.

---

## Considerações Finais
- A autenticação deve ser realizada em rotas que modificam dados.
- Adicionar tratamento de erros para entradas inválidas.