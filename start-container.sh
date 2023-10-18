#!/bin/bash

# Отримуємо поточний USER_ID та GROUP_ID
USER_ID=$(id -u)
GROUP_ID=$(id -g)

# Експортуємо змінні середовища для docker-compose
export USER_ID
export GROUP_ID

# Запускаємо контейнери
docker-compose up --build
