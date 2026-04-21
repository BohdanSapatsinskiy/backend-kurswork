# API Documentation (AJAX Endpoints)

## Overview

У проєкті реалізовано асинхронну взаємодію між клієнтською та серверною частиною за допомогою AJAX-запитів до контролерів Yii2.

Усі запити виконуються без перезавантаження сторінки та повертають відповідь у форматі JSON. Основне використання AJAX зосереджено в адміністративній панелі для управління даними.

---

# 1. Admin API

## 1.1 Update Record (Inline Editing)

### Description

Асинхронне оновлення окремого поля запису в адміністративній панелі без перезавантаження сторінки.

### Endpoints

* POST /admin/update-comment
* POST /admin/update-service
* POST /admin/update-about
* POST /admin/update-project
* POST /admin/update-public-info

### Request Parameters

| Parameter | Type   | Description              |
| --------- | ------ | ------------------------ |
| id        | int    | Ідентифікатор запису     |
| field     | string | Назва поля для оновлення |
| value     | string | Нове значення            |

### Example Request

```json id="a1"
{
  "id": 1,
  "field": "tittle",
  "value": "Оновлена назва"
}
```

### Success Response

```json id="a2"
{
  "success": true
}
```

### Error Response

```json id="a3"
{
  "success": false,
  "message": "Невірні дані"
}
```

---

## 1.2 Delete Record

### Description

Асинхронне видалення записів з бази даних. У разі наявності пов’язаних файлів (зображень або документів) вони також видаляються з файлової системи.

### Endpoints

* POST /admin/delete-comment
* POST /admin/delete-service
* POST /admin/delete-about
* POST /admin/delete-project
* POST /admin/delete-public-info

### Request Example

```json id="b1"
{
  "id": 1
}
```

### Success Response

```json id="b2"
{
  "success": true
}
```

---

## 1.3 Create Service

### Description

Створення нового сервісу з можливістю завантаження зображення.

### Endpoint

POST /admin/create-service

### Request Type

multipart/form-data

### Fields

* tittle — назва сервісу
* about — опис
* img — зображення

### Success Response

```json id="c1"
{
  "success": true
}
```

---

## 1.4 Create Project

### Description

Створення нового проєкту з описом та зображенням.

### Endpoint

POST /admin/create-project

### Fields

* name
* text
* date
* img

---

## 1.5 Create About Section

### Description

Додавання інформації у розділ “Про нас”.

### Endpoint

POST /admin/create-about

### Fields

* tittle
* text
* img (optional)

---

## 1.6 Create Public Info

### Description

Завантаження публічних документів (pdf, doc, xls тощо).

### Endpoint

POST /admin/create-public-info

### Fields

* name
* date
* file

---

# 2. User API

## 2.1 Add Comment

### Description

Додавання коментаря авторизованим користувачем.

### Endpoint

POST /site/add-comment

### Request Parameters

* Mark
* Text

### Example Request

```json id="d1"
{
  "Mark": 5,
  "Text": "Дуже якісний сервіс"
}
```

### Success Response

```json id="d2"
{
  "success": true
}
```

### Unauthorized Response

```json id="d3"
{
  "success": false,
  "redirect": "/user/login"
}
```

---

# 3. Contact API

## Description

Відправка повідомлення через контактну форму на email адміністратора.

### Endpoint

POST /site/contacts

### Request Fields

* Name
* E-mail
* Phone
* Text
* admin_email
* form_subject
* project_name

### Success Response

```json id="e1"
{
  "success": true,
  "message": "Повідомлення успішно надіслано"
}
```

---

# 4. Implementation Notes

* Усі API реалізовані через Yii2 controller actions
* Використовується формат JSON для всіх AJAX відповідей
* Валідація даних виконується на рівні моделей
* Доступ до адміністративних API обмежено
* Підтримується завантаження файлів через multipart/form-data
* Реалізовано inline editing без перезавантаження сторінки
