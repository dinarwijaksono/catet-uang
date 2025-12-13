# Dokumentasi API
Berikut adalah dokumentasi untuk API bagian transaksi.

### `POST /api/transaction`
Membuat transaksi baru.

**Contoh Request:**
http header
    "api-token": "[string-random]"
```json
{
    "date": "2025-12-01",
    "category": "[code-category]",
    "type": "spending",
    "value": 10000,
    "description": "Makanan",
}
```

**Contoh Respon:** 
Status code: 201 created 
```json
{
    "data": {
        "period": {
            "id": 12,
            "period_date": 123456,
            "period_name": "Desember 2025",
            "is_close": false,
            "created_at": "10:11, 01-01-2025",
            "updated_at": "10:11, 01-01-2025",
        },
        "category": {
            "code": "[string-random]",
            "name": "dikasih",
            "type": "income",
            "created_at": "10:11, 01-01-2025",
            "updated_at": "10:11, 01-01-2025",
        },
        "code": "[string-random]",
        "date": "1 Desember 2025",
        "income": 10000,
        "spending": 0,
        "description": "dikasih",
        "created_at": "10:11, 01-01-2025",
        "updated_at": "10:11, 01-01-2025",
    }
}
```

Status code: 401 Unauthorized
```json
{
    "Message": "Token tidak valid."
} 
```

Status code: 422 Unprocesssable Content
- jika validasi tidak terpenuhi
```json
{
    "errors": {
        "type": ["_message_"],
        "value": ["_message_"],
        }
} 
```



### `GET /api/transaction/{code}`
Mengambil 1 transaksi berdasarkan kodenya.

**Contoh Request:**
http header
    "api-token": "[string-random]"

**Contoh Respon:** 
Status code: 201 created 
```json
{
    "data": {
        "period": {
            "id": 12,
            "period_date": 123456,
            "period_name": "Desember 2025",
            "is_close": false,
            "created_at": "10:11, 01-01-2025",
            "updated_at": "10:11, 01-01-2025",
        },
        "category": {
            "code": "[string-random]",
            "name": "dikasih",
            "type": "income",
            "created_at": "10:11, 01-01-2025",
            "updated_at": "10:11, 01-01-2025",
        },
        "code": "[string-random]",
        "date": "1 Desember 2025",
        "income": 10000,
        "spending": 0,
        "description": "dikasih",
        "created_at": "10:11, 01-01-2025",
        "updated_at": "10:11, 01-01-2025",
    }
}
```

Status code: 422 Unprocesssable Content
- jika kode transaksi yang dikirim tidak ada di database
```json
{
    "Message": "Transaksi tidak ditemukan."
} 
```

Status code: 401 Unauthorized
```json
{
    "Message": "Token tidak valid."
} 
```



### `GET /api/transaction/get-by-date/{2025-10-20}`
Mengambil transaksi berdasarkan tanggal.

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
            "period": {
                "id": 12,
                "period_date": 123456,
                "period_name": "Desember 2025",
                "is_close": false,
                "created_at": "10:11, 01-01-2025",
                "updated_at": "10:11, 01-01-2025",
            },
            "category": {
                "code": "[string-random]",
                "name": "dikasih",
                "type": "income",
                "created_at": "10:11, 01-01-2025",
                "updated_at": "10:11, 01-01-2025",
            },
            "code": "[string-random]",
            "date": "1 Desember 2025",
            "income": 10000,
            "spending": 0,
            "description": "dikasih",
            "created_at": "10:11, 01-01-2025",
            "updated_at": "10:11, 01-01-2025",
            }
        ],
        [
            {
            "period": {
                "id": 12,
                "period_date": 123456,
                "period_name": "Desember 2025",
                "is_close": false,
                "created_at": "10:11, 01-01-2025",
                "updated_at": "10:11, 01-01-2025",
            },
            "category": {
                "code": "[string-random]",
                "name": "dikasih",
                "type": "income",
                "created_at": "10:11, 01-01-2025",
                "updated_at": "10:11, 01-01-2025",
            },
            "code": "[string-random]",
            "date": "1 Desember 2025",
            "income": 10000,
            "spending": 0,
            "description": "dikasih",
            "created_at": "10:11, 01-01-2025",
            "updated_at": "10:11, 01-01-2025",
            }
        ]
    }
}
```

Status code: 401 Unauthorized
```json
{
    "Message": "Token tidak valid."
} 
```


### `GET /api/transaction/all/{page}`
Mengambil semua transaksi tetapi di paging 50 transaksi.

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
            "period": {
                "id": 12,
                "period_date": 123456,
                "period_name": "Desember 2025",
                "is_close": false,
                "created_at": "10:11, 01-01-2025",
                "updated_at": "10:11, 01-01-2025",
            },
            "category": {
                "code": "[string-random]",
                "name": "dikasih",
                "type": "income",
                "created_at": "10:11, 01-01-2025",
                "updated_at": "10:11, 01-01-2025",
            },
            "code": "[string-random]",
            "date": "1 Desember 2025",
            "income": 10000,
            "spending": 0,
            "description": "dikasih",
            "created_at": "10:11, 01-01-2025",
            "updated_at": "10:11, 01-01-2025",
            }
        ],
        [
            {
            "period": {
                "id": 12,
                "period_date": 123456,
                "period_name": "Desember 2025",
                "is_close": false,
                "created_at": "10:11, 01-01-2025",
                "updated_at": "10:11, 01-01-2025",
            },
            "category": {
                "code": "[string-random]",
                "name": "dikasih",
                "type": "income",
                "created_at": "10:11, 01-01-2025",
                "updated_at": "10:11, 01-01-2025",
            },
            "code": "[string-random]",
            "date": "1 Desember 2025",
            "income": 10000,
            "spending": 0,
            "description": "dikasih",
            "created_at": "10:11, 01-01-2025",
            "updated_at": "10:11, 01-01-2025",
            }
        ]
    },
    "current_page": 1,
    "total_pages": 2
}
```

Status code: 401 Unauthorized
```json
{
    "Message": "Token tidak valid."
} 
```



### `PUT /api/transaction/{code}`
update transaksi berdasarkan kodenya.

**Contoh Request:**
http header
    "api-token": "[string-random]"
```json
{
    "date": "2025-12-01",
    "category": "[code-category]",
    "type": "spending",
    "value": 10000,
    "description": "Makanan",
}
```

**Contoh Respon:** 
Status code: 200 Ok
```json
{
    "data": {
        "period": {
            "id": 12,
            "period_date": 123456,
            "period_name": "Desember 2025",
            "is_close": false,
            "created_at": "10:11, 01-01-2025",
            "updated_at": "10:11, 01-01-2025",
        },
        "category": {
            "code": "[string-random]",
            "name": "dikasih",
            "type": "income",
            "created_at": "10:11, 01-01-2025",
            "updated_at": "10:11, 01-01-2025",
        },
        "code": "[string-random]",
        "date": "1 Desember 2025",
        "income": 10000,
        "spending": 0,
        "description": "dikasih",
        "created_at": "10:11, 01-01-2025",
        "updated_at": "10:11, 01-01-2025",
    }
}
```

Status code: 401 Unauthorized
```json
{
    "Message": "Token tidak valid."
} 
```

Status code: 422 Unprocesssable Content
- jika validasi tidak terpenuhi
```json
{
    "errors": {
        "type": ["_message_"],
        "value": ["_message_"],
        }
} 
```



### `Delete /api/transaction/{code}`
Menghapus transaksi berdasarkan kodenya.

**Contoh Request:**
http header
    "api-token": "[string-random]"

**Contoh Respon:** 
Status code: 204 No Content

Status code: 401 Unauthorized
```json
{
    "Message": "Token tidak valid."
} 
```

Status code: 422 Unprocesssable Content
- jika kode transaksi tidak ada di database
```json
{
    "message": "Transaksi tidak ditemukan."
} 
```