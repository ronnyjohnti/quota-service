# Quota Service
Esse é um serviço criado para configurar e armazenar políticas afirmativas para o Mapas Culturais.

# Requisitos

> [!NOTE]
> Hyperf tem alguns requisitos de ambiente, podendo rodar apenas em ambientes Linux e Mac, mas também é possível a utilização de Docker em qualquer ambiente que suporte.

- PHP >= 8.1
- Qualquer uma das seguintes engines:
  - Extensão Swoole PHP ≥ 5.0，com `swoole.use_shortname` definido como `Off` no seu `php.ini`
  - Extensão Swow PHP >= 1.3
- Extensão JSON PHP
- Extensão Pcntl PHP
- Extensão OpenSSL PHP（Se você precisa utilizar HTTPS）
- Extensão PDO PHP
- Extensão Redis PHP
- Banco de Dados MariaDB ou MySQL (Caso não queira utilizar o configurado no [compose.yml](./compose.yml))

# Documentação
## Diagrama ER

```mermaid
erDiagram
  aqp }o..|| agent : references
  aqp }o..|| usr   : references
  aqp }o..|{ qp    : references
  qp  }o..|| usr   : references

  qp[quotas_policies]{
    integer           updated_at
    integer           id                 PK
    varchar(255)      name
    varchar(500)      description
    integer           validity_duration
    integer           status
    integer           created_by         FK
    integer           updated_by         FK
    integer           deleted_by         FK
    timestamp         created_at
    timestamp         updated_at
    timestamp         deleted_at
  }

  aqp[agent_quotas_policies]{
    integer           id                 PK
    integer           agent_id           FK
    integer           quotas_policy_id   FK
    timestamp         start_date
    timestamp         end_date
    integer           created_by         FK
    integer           deleted_by         FK
    timestamp         created_at
    timestamp         deleted_at
  }
```
