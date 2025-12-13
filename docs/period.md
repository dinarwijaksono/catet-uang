# Dokumentasi API
Berikut adalah dokumentasi untuk API bagian period.


### `GET /api/period/get-all`
Mengambil semua period.

**Contoh Request:**
http header
    "api-token": "[string-random]"

**Contoh Respon:** 
Status code: 200 Ok
```json
{
    "data": {
        [
            {
                "id": "[id]",
                "period_date": 1234656,
                "perid_name": "Desember 2025",
                "is_close": false,
                "created_at": "10:11, 1 Januari 2026",
                "updated_at": "10:11, 1 Januari 2026",
            }
        ],
        [
            {
                "id": "[id]",
                "period_date": 1234656,
                "perid_name": "Desember 2025",
                "is_close": false,
                "created_at": "10:11, 1 Januari 2026",
                "updated_at": "10:11, 1 Januari 2026",
            }
        ]
    },
    "period_count": 12
}
```

Status code: 401 Unauthorized
```json
{
    "Message": "Token tidak valid."
} 
```