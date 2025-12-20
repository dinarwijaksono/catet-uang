# Dokumentasi API
Berikut adalah dokumentasi untuk API bagian file.

### `POST /api/file/csv-format-download`
Mendownload format file csv untuk upload

**Contoh Request:**
http header
    "api-token": "[string-random]"

**Contoh Respon:** 
Status code: 200 Ok
```
[
    "Content-Type": "text/csv"
]
```

Status code: 401 Unauthorized
```json
{
    "Message": "Token tidak valid."
} 
```


### `POST /api/file/csv-upload`
Untuk mengupload file yang berformat csv

**Contoh Request:**
http header
    "api-token": "[string-random]"
multipart form
    "file": "[file-format-csv]"

**Contoh Respon:** 
Status code: 201 Created
```json
{
    "Message": "File berhasil diupload."
} 
```

Status code: 422 Unauthorized
```json
{
    "errors": {
        "file": "[-pesan-error-]"
    }
} 
```

Status code: 401 Unauthorized
```json
{
    "Message": "Token tidak valid."
} 
```



### `GET /api/file/get-all`
Menampilkan semua data file yang sudah diupload.

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
                "original_name": "[-file-name-]",
                "file_name": "[-file-name-]",
                "is_generate": false,
                "message": "[-string-]",
                "created_at": "10:11, 1 Januari 2026",
                "updated_at": "10:11, 1 Januari 2026",
            }
        ],
        [
            {
                "original_name": "[-file-name-]",
                "file_name": "[-file-name-]",
                "is_generate": false,
                "message": "[-string-]",
                "created_at": "10:11, 1 Januari 2026",
                "updated_at": "10:11, 1 Januari 2026",
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


### `PUT /api/file/csv-generate/{id-file}`
parsing data dari csv yang sudah diupload ke db.

**Contoh Request:**
http header
    "api-token": "[string-random]"

**Contoh Respon:** 
Status code: 200 Ok
```json
{
    "Message": "File berhasil digenerate."
}
```

Status code: 422 validate error
Format tidak sesuai
```json
{
    "Message": "[-isi-error-]"
} 
```

Status code: 400 Bad Request
File tidak ada di storage
```json
{
    "Message": "File rusak."
} 
```

Status code: 401 Unauthorized
```json
{
    "Message": "Token tidak valid."
} 
```