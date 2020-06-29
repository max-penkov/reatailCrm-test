### Тестовое задание для retailCRM

## Installation

```bash
make init
make composer-install
make assets-install-build
make migrations-install
```

## Php-cs
```bash
composer cs-check
compose cs-fix
```

## Fixtures
```bash
make fixtures-load
```

## Api
```bash
make generate-api-doc
http://localhost:8000
```

## Run 
```bash
http://localhost:8080
```

##### P.S
Решил сделать красиво, используя vue, но не рассчитал время, поэтому
не успел вывести адрес ддя клиента, но учтя во внимание описание задания, 
вижу, что больше важна архитектура и технология контейниразации и следование
стандартам, так как ui можно улучшать еще бесконечно... 
MVP по подключению истории сделал и полный вывод по сущностоям можно 
посмотреть в api 