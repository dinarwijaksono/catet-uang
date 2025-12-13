# Dokumentasi API
Berikut adalah dokumentasi untuk API bagian kategori.

### `POST /api/category`
Membuat kategori baru.

**Contoh Request:**
http header
    "api-token": "[string-random]"
```json
{
    "name": "Makanan",
    "type": "spending"
}
```

**Contoh Respon:** 
Status code: 201 created
```json
{
    "data": {
        "code": "[string-random]",
        "name": "Makanan",
        "type": "spending",
        "created_at": "2025-12-14T14:43:36.721133Z",
        "updated_at": "2025-12-14T14:43:36.721133Z",
    }
}
```

Status code: 201 created
<!-- PR -->
<!-- ```json
{
    "data": {
        "code": "[string-random]",
        "name": "Makanan",
        "type": "spending",
        "created_at": "10:11, 01-01-2025",
        "updated_at": "10:11, 01-01-2025",
    }
}
``` -->

Status code: 401 Unauthorized
```json
{
    "Message": "Token tidak valid."
} 
```



### `GET /api/category/get-all`
Mengambil semua kategori.

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
                "code": "[string-random]",
                "name": "Makanan",
                "type": "spending",
                "created_at": "10:11, 1 Januari 2026",
                "updated_at": "10:11, 1 Januari 2026",
            }
        ],
        [
            {
                "code": "[string-random]",
                "name": "Makanan",
                "type": "spending",
                "created_at": "10:11, 1 Januari 2026",
                "updated_at": "10:11, 1 Januari 2026",
            }
        ]
    },
    "category_count": 
}
```

Status code: 401 Unauthorized
```json
{
    "Message": "Token tidak valid."
} 
```



### `GET /api/category/get-by-type/{type}`
Mengambil semua kategori berdasarkan type (income/spending).

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
                "code": "[string-random]",
                "name": "Makanan",
                "type": "spending",
                "created_at": "10:11, 1 Januari 2026",
                "updated_at": "10:11, 1 Januari 2026",
            }
        ],
        [
            {
                "code": "[string-random]",
                "name": "Makanan",
                "type": "spending",
                "created_at": "10:11, 1 Januari 2026",
                "updated_at": "10:11, 1 Januari 2026",
            }
        ]
    },
    "category_count": 
}
```

Status code: 401 Unauthorized
```json
{
    "Message": "Token tidak valid."
} 
```



### `DELETE /api/category/{code}`
Menghapus kategori berdasarkan kodenya

**Contoh Request:**
http header
    "api-token": "[string-random]"

**Contoh Respon:** 
Status code: 204 No Content

Status code: 400 Bad Request
- Jika kode kategori masih digunakan untuk transaksi
```json
{
    "Message": "Tidak bisa menghapus kategori yang masih digunakan."
} 
```

Status code: 422 Bad Request
- jika code kategori yang dikirim tidak ada di database
```json
{
    "Message": "Kategori tidak ditemukan."
} 
```

Status code: 401 Unauthorized
```json
{
    "Message": "Token tidak valid."
} 
```