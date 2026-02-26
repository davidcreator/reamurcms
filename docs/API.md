# 📘 API Reference / Referência de API

> 🌐 **Language / Idioma:** [English](#english) | [Português Brasil](#português-brasil)

---

<a name="english"></a>

## 🇺🇸 English

This document serves as the REST API and code reference for ReamurCMS modules.

---

## 📚 Table of Contents

- [Authentication](#authentication)
- [CMS & Blog API](#cms--blog-api)
- [E-commerce API](#e-commerce-api)
- [Courses & Classrooms API](#courses--classrooms-api)
- [Landing Pages API](#landing-pages-api)
- [Users & Permissions API](#users--permissions-api)
- [Module Development Reference](#module-development-reference)

---

## 🔐 Authentication

ReamurCMS REST API uses **Bearer Token** authentication.

### Obtaining a Token

```http
POST /api/auth/token
Content-Type: application/json

{
  "username": "admin@example.com",
  "password": "your_password"
}
```

**Response:**
```json
{
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
  "expires_at": "2025-12-31T23:59:59Z"
}
```

### Using the Token

```http
GET /api/v1/products
Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...
```

---

## 📝 CMS & Blog API

### List Posts

```http
GET /api/v1/blog/posts
```

**Query Parameters:**

| Parameter  | Type    | Description                    |
|------------|---------|--------------------------------|
| `page`     | integer | Page number (default: 1)       |
| `limit`    | integer | Results per page (default: 20) |
| `category` | string  | Filter by category slug        |
| `status`   | string  | `published`, `draft`, `all`    |

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "title": "My First Post",
      "slug": "my-first-post",
      "status": "published",
      "category": "news",
      "published_at": "2025-01-01T10:00:00Z"
    }
  ],
  "meta": {
    "total": 50,
    "page": 1,
    "limit": 20
  }
}
```

### Get a Single Post

```http
GET /api/v1/blog/posts/{id}
```

### Create a Post

```http
POST /api/v1/blog/posts
Content-Type: application/json
Authorization: Bearer {token}

{
  "title": "New Post",
  "content": "<p>Content here...</p>",
  "category_id": 2,
  "status": "draft",
  "meta_title": "SEO Title",
  "meta_description": "SEO description"
}
```

### Update a Post

```http
PUT /api/v1/blog/posts/{id}
Authorization: Bearer {token}

{
  "title": "Updated Title",
  "status": "published"
}
```

### Delete a Post

```http
DELETE /api/v1/blog/posts/{id}
Authorization: Bearer {token}
```

---

## 📦 E-commerce API

### List Products

```http
GET /api/v1/products
```

**Query Parameters:**

| Parameter    | Type    | Description                           |
|--------------|---------|---------------------------------------|
| `page`       | integer | Page number                           |
| `limit`      | integer | Results per page                      |
| `category`   | integer | Filter by category ID                 |
| `min_price`  | float   | Minimum price filter                  |
| `max_price`  | float   | Maximum price filter                  |
| `in_stock`   | boolean | Filter by stock availability          |

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Product Name",
      "slug": "product-name",
      "price": 99.90,
      "stock": 50,
      "type": "physical",
      "status": "active"
    }
  ],
  "meta": { "total": 200, "page": 1, "limit": 20 }
}
```

### Create a Product

```http
POST /api/v1/products
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "New Product",
  "description": "Product description",
  "price": 149.90,
  "stock": 100,
  "type": "physical",
  "sku": "PROD-001",
  "category_id": 3
}
```

### Create an Order

```http
POST /api/v1/orders
Authorization: Bearer {token}
Content-Type: application/json

{
  "customer_id": 42,
  "items": [
    { "product_id": 1, "quantity": 2 },
    { "product_id": 5, "quantity": 1 }
  ],
  "shipping_address": {
    "street": "123 Main St",
    "city": "São Paulo",
    "state": "SP",
    "zip": "01310-100"
  },
  "payment_method": "credit_card"
}
```

### Get Order Status

```http
GET /api/v1/orders/{order_id}
Authorization: Bearer {token}
```

---

## 🎓 Courses & Classrooms API

### List Courses

```http
GET /api/v1/courses
```

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Introduction to PHP",
      "slug": "intro-to-php",
      "instructor": "Jane Doe",
      "price": 0,
      "is_free": true,
      "total_lessons": 12,
      "enrolled_students": 230,
      "status": "published"
    }
  ]
}
```

### Get Course Details

```http
GET /api/v1/courses/{id}
```

### Create a Course

```http
POST /api/v1/courses
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Advanced ReamurCMS Development",
  "description": "Learn to build modules and themes.",
  "price": 99.90,
  "is_free": false,
  "instructor_id": 5,
  "status": "draft"
}
```

### Add a Lesson to a Course

```http
POST /api/v1/courses/{course_id}/lessons
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Setting Up Your Environment",
  "type": "video",
  "content_url": "https://cdn.example.com/lesson-01.mp4",
  "duration_minutes": 15,
  "order": 1
}
```

### Enroll a Student

```http
POST /api/v1/courses/{course_id}/enrollments
Authorization: Bearer {token}
Content-Type: application/json

{
  "user_id": 100
}
```

### Get Student Progress

```http
GET /api/v1/courses/{course_id}/enrollments/{user_id}/progress
Authorization: Bearer {token}
```

**Response:**
```json
{
  "user_id": 100,
  "course_id": 1,
  "completed_lessons": 8,
  "total_lessons": 12,
  "progress_percent": 66.7,
  "certificate_issued": false
}
```

### Virtual Classroom — Create a Session

```http
POST /api/v1/classrooms/{classroom_id}/sessions
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Live Q&A — Module 3",
  "scheduled_at": "2025-06-15T14:00:00Z",
  "duration_minutes": 60,
  "recording_enabled": true
}
```

---

## 🏠 Landing Pages API

### List Landing Pages

```http
GET /api/v1/landing-pages
Authorization: Bearer {token}
```

### Create a Landing Page

```http
POST /api/v1/landing-pages
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Product Launch Page",
  "slug": "product-launch",
  "status": "draft",
  "sections": [
    {
      "type": "hero",
      "headline": "Introducing ReamurCMS 2.0",
      "subheadline": "The all-in-one platform.",
      "cta_text": "Get Started",
      "cta_url": "/install"
    }
  ]
}
```

---

## 👥 Users & Permissions API

### List Users

```http
GET /api/v1/users
Authorization: Bearer {token}
```

### Create a User

```http
POST /api/v1/users
Authorization: Bearer {token}
Content-Type: application/json

{
  "firstname": "John",
  "lastname": "Doe",
  "email": "john@example.com",
  "password": "SecurePass123!",
  "role": "editor"
}
```

### Available Roles

| Role          | Description                              |
|---------------|------------------------------------------|
| `superadmin`  | Full access to all modules and settings  |
| `admin`       | Access to all modules, no system config  |
| `editor`      | CMS, Blog, Landing Pages                 |
| `instructor`  | Course and classroom management          |
| `customer`    | E-commerce customer                      |
| `student`     | Course enrollment and access             |

---

## 🧩 Module Development Reference

### Controller Structure

```php
<?php
namespace Reamur\Controller\Extension\MyModule;

class MyModule extends \Reamur\System\Engine\Controller {

    public function index(): void {
        // Load model
        $this->load->model('extension/my_module/main');

        // Load language
        $this->load->language('extension/my_module/my_module');

        // Prepare data
        $data = [];
        $data['items'] = $this->model_extension_my_module_main->getItems();

        // Render view
        $this->response->setOutput(
            $this->load->view('extension/my_module/my_module', $data)
        );
    }
}
```

### Model Structure

```php
<?php
namespace Reamur\Model\Extension\MyModule;

class Main extends \Reamur\System\Engine\Model {

    public function getItems(array $filters = []): array {
        $sql = "SELECT * FROM `" . DB_PREFIX . "my_module_items`";

        if (!empty($filters['status'])) {
            $sql .= " WHERE status = '" . $this->db->escape($filters['status']) . "'";
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function addItem(array $data): int {
        $this->db->query("
            INSERT INTO `" . DB_PREFIX . "my_module_items`
            SET name = '" . $this->db->escape($data['name']) . "',
                status = '" . (int)$data['status'] . "',
                date_added = NOW()
        ");

        return $this->db->getLastId();
    }
}
```

### Event System

```php
// Register an event in your module's installer
$this->model_setting_event->addEvent(
    'my_module',
    'admin/view/catalog/product_form/after',
    'extension/my_module/my_module/addProductTab'
);

// The event callback method
public function addProductTab(string &$route, array &$data): void {
    // Inject custom tab into product form
    $data['tabs'][] = [
        'title'   => 'My Module Tab',
        'content' => $this->load->view('extension/my_module/product_tab', $data)
    ];
}
```

### REST API Endpoint Registration

```php
// In your module's controller, expose an API endpoint:
// Route: GET /api/v1/my-module/items

public function apiGetItems(): void {
    $this->response->addHeader('Content-Type: application/json');

    $items = $this->model_extension_my_module_main->getItems();

    $this->response->setOutput(json_encode([
        'data'   => $items,
        'status' => 'success'
    ]));
}
```

---

## 📚 Official Documentation

- [ReamurCMS Developer Guide](https://docs.reamurcms.com/developer-guide)
- [REST API Full Reference](https://docs.reamurcms.com/api)
- [Module Marketplace](https://extensions.reamurcms.com)

---
---

<a name="português-brasil"></a>

## 🇧🇷 Português Brasil

Este documento é a referência de API REST e código para os módulos do ReamurCMS.

---

## 📚 Índice

- [Autenticação](#autenticação)
- [API de CMS & Blog](#api-de-cms--blog)
- [API de E-commerce](#api-de-e-commerce)
- [API de Cursos & Salas Virtuais](#api-de-cursos--salas-virtuais)
- [API de Landing Pages](#api-de-landing-pages)
- [API de Usuários & Permissões](#api-de-usuários--permissões)
- [Referência para Desenvolvimento de Módulos](#referência-para-desenvolvimento-de-módulos)

---

## 🔐 Autenticação

A API REST do ReamurCMS utiliza autenticação **Bearer Token**.

### Obtendo um Token

```http
POST /api/auth/token
Content-Type: application/json

{
  "username": "admin@example.com",
  "password": "sua_senha"
}
```

**Resposta:**
```json
{
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
  "expires_at": "2025-12-31T23:59:59Z"
}
```

### Usando o Token

```http
GET /api/v1/products
Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...
```

---

## 📝 API de CMS & Blog

### Listar Posts

```http
GET /api/v1/blog/posts
```

**Parâmetros de Query:**

| Parâmetro  | Tipo    | Descrição                          |
|------------|---------|------------------------------------|
| `page`     | integer | Número da página (padrão: 1)       |
| `limit`    | integer | Resultados por página (padrão: 20) |
| `category` | string  | Filtrar por slug de categoria      |
| `status`   | string  | `published`, `draft`, `all`        |

### Criar um Post

```http
POST /api/v1/blog/posts
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Novo Post",
  "content": "<p>Conteúdo aqui...</p>",
  "category_id": 2,
  "status": "draft",
  "meta_title": "Título SEO",
  "meta_description": "Descrição SEO"
}
```

---

## 📦 API de E-commerce

### Listar Produtos

```http
GET /api/v1/products
```

### Criar um Produto

```http
POST /api/v1/products
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Novo Produto",
  "description": "Descrição do produto",
  "price": 149.90,
  "stock": 100,
  "type": "physical",
  "sku": "PROD-001",
  "category_id": 3
}
```

### Criar um Pedido

```http
POST /api/v1/orders
Authorization: Bearer {token}
Content-Type: application/json

{
  "customer_id": 42,
  "items": [
    { "product_id": 1, "quantity": 2 },
    { "product_id": 5, "quantity": 1 }
  ],
  "shipping_address": {
    "street": "Rua das Flores, 123",
    "city": "São Paulo",
    "state": "SP",
    "zip": "01310-100"
  },
  "payment_method": "credit_card"
}
```

---

## 🎓 API de Cursos & Salas Virtuais

### Listar Cursos

```http
GET /api/v1/courses
```

### Criar um Curso

```http
POST /api/v1/courses
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Desenvolvimento Avançado com ReamurCMS",
  "description": "Aprenda a criar módulos e temas.",
  "price": 99.90,
  "is_free": false,
  "instructor_id": 5,
  "status": "draft"
}
```

### Adicionar uma Aula ao Curso

```http
POST /api/v1/courses/{course_id}/lessons
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Configurando o Ambiente",
  "type": "video",
  "content_url": "https://cdn.example.com/aula-01.mp4",
  "duration_minutes": 15,
  "order": 1
}
```

### Matricular um Aluno

```http
POST /api/v1/courses/{course_id}/enrollments
Authorization: Bearer {token}
Content-Type: application/json

{
  "user_id": 100
}
```

### Consultar Progresso do Aluno

```http
GET /api/v1/courses/{course_id}/enrollments/{user_id}/progress
Authorization: Bearer {token}
```

**Resposta:**
```json
{
  "user_id": 100,
  "course_id": 1,
  "completed_lessons": 8,
  "total_lessons": 12,
  "progress_percent": 66.7,
  "certificate_issued": false
}
```

### Sala Virtual — Criar uma Sessão

```http
POST /api/v1/classrooms/{classroom_id}/sessions
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Tira-dúvidas ao Vivo — Módulo 3",
  "scheduled_at": "2025-06-15T14:00:00Z",
  "duration_minutes": 60,
  "recording_enabled": true
}
```

---

## 🏠 API de Landing Pages

### Criar uma Landing Page

```http
POST /api/v1/landing-pages
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Página de Lançamento",
  "slug": "lancamento",
  "status": "draft",
  "sections": [
    {
      "type": "hero",
      "headline": "ReamurCMS 2.0 chegou!",
      "subheadline": "A plataforma tudo em um.",
      "cta_text": "Começar agora",
      "cta_url": "/install"
    }
  ]
}
```

---

## 👥 API de Usuários & Permissões

### Criar Usuário

```http
POST /api/v1/users
Authorization: Bearer {token}
Content-Type: application/json

{
  "firstname": "João",
  "lastname": "Silva",
  "email": "joao@example.com",
  "password": "SenhaSegura123!",
  "role": "editor"
}
```

### Papéis Disponíveis

| Papel         | Descrição                                        |
|---------------|--------------------------------------------------|
| `superadmin`  | Acesso total a todos os módulos e configurações  |
| `admin`       | Todos os módulos, sem configurações do sistema   |
| `editor`      | CMS, Blog, Landing Pages                         |
| `instructor`  | Gestão de cursos e salas virtuais                |
| `customer`    | Cliente de e-commerce                            |
| `student`     | Matrícula e acesso a cursos                      |

---

## 🧩 Referência para Desenvolvimento de Módulos

### Estrutura de Controller

```php
<?php
namespace Reamur\Controller\Extension\MeuModulo;

class MeuModulo extends \Reamur\System\Engine\Controller {

    public function index(): void {
        $this->load->model('extension/meu_modulo/main');
        $this->load->language('extension/meu_modulo/meu_modulo');

        $data = [];
        $data['items'] = $this->model_extension_meu_modulo_main->getItems();

        $this->response->setOutput(
            $this->load->view('extension/meu_modulo/meu_modulo', $data)
        );
    }
}
```

### Estrutura de Model

```php
<?php
namespace Reamur\Model\Extension\MeuModulo;

class Main extends \Reamur\System\Engine\Model {

    public function getItems(array $filters = []): array {
        $sql = "SELECT * FROM `" . DB_PREFIX . "meu_modulo_items`";

        if (!empty($filters['status'])) {
            $sql .= " WHERE status = '" . $this->db->escape($filters['status']) . "'";
        }

        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function addItem(array $data): int {
        $this->db->query("
            INSERT INTO `" . DB_PREFIX . "meu_modulo_items`
            SET name = '" . $this->db->escape($data['name']) . "',
                status = '" . (int)$data['status'] . "',
                date_added = NOW()
        ");

        return $this->db->getLastId();
    }
}
```

---

## 📚 Documentação Oficial

- [Guia do Desenvolvedor ReamurCMS](https://docs.reamurcms.com/developer-guide)
- [Referência Completa da API REST](https://docs.reamurcms.com/api)
- [Marketplace de Módulos](https://extensions.reamurcms.com)
