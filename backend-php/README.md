# Backend PHP - Amazon Creators API

API REST en PHP para buscar y comparar productos de Amazon Creators API sin exponer credenciales en el frontend.

## 1. Configuración

1. Copia el ejemplo de variables:

```bash
cp backend-php/.env.example backend-php/.env
```

2. Completa:

- `CREDENTIAL_ID`
- `CREDENTIAL_SECRET`
- `VERSION` (`V3.1`, `V3.2`, `V3.3`, etc.)
- `MARKETPLACE` (ej: `www.amazon.com`)
- `PARTNER_TAG` (ej: `carlosgti000b-20`)

## 2. Ejecutar local

```bash
php -S 127.0.0.1:8080 -t backend-php/public
```

## 3. Endpoints

### `GET /health`

Verifica que el backend responde.

### `POST /api/search`

Busca productos y devuelve ranking comparativo inicial.

Ejemplo:

```bash
curl -X POST http://127.0.0.1:8080/api/search \
  -H "Content-Type: application/json" \
  -d '{
    "keywords": "laptop",
    "searchIndex": "Electronics",
    "itemCount": 5
  }'
```

### `POST /api/compare`

Compara ASINs específicos y sugiere el mejor.

Ejemplo:

```bash
curl -X POST http://127.0.0.1:8080/api/compare \
  -H "Content-Type: application/json" \
  -d '{
    "asins": ["B09B2SBHQK", "B09B8V1LZ3"],
    "weights": { "price": 0.5, "features": 0.2, "quality": 0.3 }
  }'
```

## 4. Notas

- El enlace de afiliado lo entrega Amazon en `detailPageURL`.
- Este backend aplica un scoring heurístico ("IA inicial") basado en precio, features y señales de calidad.
- El frontend Angular debe consumir estos endpoints, no la API de Amazon directamente.
