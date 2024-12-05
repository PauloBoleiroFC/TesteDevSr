

## Teste para desenvolvedor PHP/Laravel Sênior

Autor: Paulo Sérgio  
Email: paulosergiophp@gmail.com  
Telefone: (11) 9 3027 3040

## Objetivo

Este repositório tem como objetivo realizar um teste para desenvolvedor PHP/Laravel Sênior, abordando o processo de instalação e configuração do ambiente de desenvolvimento.

## Instalação

Siga as instruções abaixo para configurar o projeto localmente:

1. Clone o repositório para sua máquina local:
   ```bash
   git clone https://github.com/PauloBoleiroFC/TesteDevSr.git

2. Acesse a pasta do projeto

3. Renomeio o arquivo .env.example para .env

4. Instale as dependências:
```bash
composer install
```

## Subir container
1. Criar um alias de shell que permita executar os comandos do Sail
```bash
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```
2. Subir container:
```bash
sail up -d
```

## Banco de dados
1. Para migrar a tabela, execute o comando: 
```bash
sail artisan migrate
```

2. Popular banco de dados, execute:
```bash
sail artisan db:seed
```

## Envio de emails
Para que o envio de emil seja realizados, é necessário configurar dados SMTP no arquivo .env

## Autenticar
```bash
{
    "email" : "super@admin.com",
    "password" : "password"
}
```
Para rodar a fila de envio dos e-mails, execute:
```bash
sail artisan queue:work`
```
## Documentação
A documentação pode ser acessada em:

http://localhost:88/api/documentation#/
