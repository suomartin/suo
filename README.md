README
======

Система управления очередью "Ласточка"


Модели (описание классов)
=========================

Заявка
------
1. Идентификатор
2. Дата-время создания
3. Дата начала
4. Время начала
5. Состояние
    1) создана
    2) в очереди
    3) вызвана
    4) закрыта
6. Кабинет
7. Пользователь
    1) может быть не назначен
8. Талон

Кабинет
-------
1. Идентификатор
2. Номер
3. Описание
    1) не может быть пустым
4. Признак использования для записи
5. Терминалы
6. Пользователи


Пользователь
1. Идентификатор
2. Фамилия
    1) не может быть пустой
3. Имя
4. Отчество
5. Пароль
    1) не может быть пустым
6. Кабинеты
    1) может быть пустым
7. Признак работы с заявками
    1) по умолчанию да

Терминал
--------
1. Идентификатор
2. Сетевой адрес
    1) не может быть пустым
3. Описание
4. Кабинеты

Талон
-----
1. Идентификатор
2. День начала заявки
3. Порядковый номер
    1) Сбрасывается в 1 каждый день

Добавление заявки
-----------------
1. Поиск кабинета по идентификатору
2. Ошибка, если кабинет не найден


Рабочий процесс
===============

Добавление заявки
-----------------
Терминал
1. Пользователь выбирает кабинет
    1) Определение терминала по сетевому адресу
    2) Выбор списка кабинетов
    3) Вывод списка кабинетов (номер и описание)
2. Если установлена возможность записи на определенный день, пользователь может выбрать день посещения
3. Если установлена возможность записи на определенное время, пользователь может выбрать время посещения
4. Если к кабинету приписаны несколько сотрудников, пользователь может выбрать сотрудника
5. Пользователь получает талон с информацией о заявке

1. Адрес терминала должен быть в базе данных