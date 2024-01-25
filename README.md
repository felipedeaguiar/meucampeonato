## Meu campeonato (BACK) 

Este é um projeto para simular um campeonato, foi divido entre app front e back end.


### Passo a passo para rodar back end
Crie o Arquivo .env
```sh
cp .env.example .env
```


Atualize as variáveis de ambiente do arquivo .env
```dosini
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=trade
DB_USERNAME=root
DB_PASSWORD=root
```

Suba os containers do projeto
```sh
docker-compose up -d
```

Acessar o container
```sh
docker-compose exec app bash
```

Instalar as dependências do projeto
```sh
composer install
```


Gerar a key do projeto Laravel
```sh
php artisan key:generate
```
### Passo a passo para rodar front


Acessar a pasta cd /trade-app-front

```sh
npm install
ng serve
```

### Para logar no sistema usar seguinte usuário

email: admin@example.org
senha: secret

