# Notas de Crédito - API RESTful

## Crear Nota de Crédito

Puedes crear una nota de crédito usando el endpoint POST existente:

**Endpoint:**
```
POST /credit_notes
```

**Headers:**
- Authorization: [API_KEY]
- Content-Type: application/x-www-form-urlencoded

**Body (ejemplo):**
```
order_id=123&user_id=4&amount=150.00&reason=Devolución parcial por producto defectuoso
```

**Respuesta exitosa:**
```json
{
  "lastId": 1,
  "comment": "The process was successful"
}
```

**Notas:**
- El endpoint POST es genérico y permite crear registros en cualquier tabla, incluyendo `credit_notes`.
- Asegúrate de enviar todos los campos requeridos: `order_id`, `user_id`, `amount`, `reason`.
- Si necesitas lógica adicional (ajuste de stock, contabilidad, etc.), deberás implementarla en el futuro.

---

## Ejemplo con curl

```
curl -X POST https://tudominio/api/credit_notes \
  -H "Authorization: TU_API_KEY" \
  -d "order_id=123&user_id=4&amount=150.00&reason=Devolución parcial por producto defectuoso"
```

---

## Seguridad
- El endpoint requiere autenticación por API KEY.
- No modifica la lógica de ventas ni stock.

---

## Para desarrolladores
- Si necesitas lógica de validación o automatización, agrégala en los controladores/models correspondientes.
