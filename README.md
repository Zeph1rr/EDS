<p align="center">
  ![logo](https://i.imgur.com/fR97Jyj.png)
</p>
# Система электронного документооборота

## Назначение проекта

Проект представляет собой упрощенную систему документооборота с возможность электронной подписи для внутренних документов Студенческой Коммерчиской Организации "Коммунизм"

## Техническое задание

Написать систему электронного документооборота. В системе должна быть возможность загрузить документ и подписать его электронной подписью. Требуется реализация маршрута согласования. Должна быть возможность отказать в согласовании и удалить документ. Так же должна быть реализована ролевая модель.

## Описание проекта

Основной средой разворачивания проекта является docker-compose. В каждом контейнере существует отдельный сервис - PHP, Nginx, PostgreSQL. За хранение данных в базе отвечает PostgreSQL, за серверную часть проекта - PHP, за визуальную - HTML, CSS, JS. Веб-сервер - Nginx - для возможности установки соединения. Внутри проекта реализованы стандартные функции системы электронного документооборота - загрузка, подпись, маршрут согласования, удаление документа. Правовой доступ к документам осуществляется в соответствии с ролевой иерархией.

### Стек технологий

- PHP: 7.3.2
- PostgreSQL: 13.3
- Nginx: 1.20.1
- Docker-Compose: 2.0 

### Ролевая модель

1. Администратор
  - Создание, удаление пользователей и отделов
  - Создание и выгрузка отчетности по документам

2. Генеральный секретарь
  - Возможность загрузки и подписи документов
  - Создание и выгрузка отчетности по всем документам компании
  - Последний пункт маршрута документа
  - Подписание документа директором автоматически переводит его в статус "Согласовано"

3. Начальник отдела
  - Возможность загрузки и подписи документов
  - Создание и выгрузка отчетности по всем документам вверенного отдела
  - Вторая стадия подписи документа (все документы, подписанные сотрудниками отправляются на подписание начальнику отдела)

4. Сотрудник
  - Возможность загрузки и подписи документов


### Шифрование

Пароли в базе данных хранятся в зашифрованном виде. Сессии в базе банных так же хранятся в зашифрованном виде для невозможности подмены сессии. Используется динамическая соль base 64 для Bcrypt - технологии шифрования. 

## Checklist репозитория

- [x] Логин
- [x] Ролевая модель
- [x] CRUD-операции с докементами
- [x] Генерация пары ключей
- [x] Электронная подпись
- [x] Маршрут документа
- [x] Возможность отказа в согласовании
- [x] Отчетсность с выгрузкой в csv
- [x] Админ-панель для CRUD операций с пользователями и отделами
