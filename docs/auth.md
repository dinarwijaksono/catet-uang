# Dokumentasi API
Berikut adalah dokumentasi untuk API bagian Autentikasi.

### `POST /api/register`
Mendaftarkan pengguna baru.

**Contoh Request:**
```json
{
    "name": "John Doe",
    "email": "budi@gmail.com",
    "password": "password",
    "confirmation_password": "password"
}
```

**Contoh Respon:**
```json
{
    "data": {
        "api_token": "[string-random]",
        "expired_token": "2025-12-14T14:43:36.721133Z",
        "name": "John Doe",
        "email": "budi@gmail.com"
    }
}
```
<!-- PR -->
<!-- ```json
{
    "data": {
        "name": "John Doe",
        "email": "budi@gmail.com"
        "created_at": "10:11, 01-10-2025",
        "updated_at": "10:11, 01-10-2025",
    },
    "token": {
        "api_token": "[string-random]",
        "expired_token": "2025-12-14T14:43:36.721133Z",
    }
}
``` -->
Status code: 201 Created



### `POST /api/login`
Login.

**Contoh Request:**
```json
{
    "email": "budi@gmail.com",
    "password": "password",
}
```

**Contoh Respon:**
```json
{
    "data": {
        "api_token": "[string-random]",
        "expired_token": "2025-12-14T14:43:36.721133Z",
        "name": "John Doe",
        "email": "budi@gmail.com"
    }
} 
```

<!-- PR -->
<!-- ```json
{
    "data": {
        "name": "John Doe",
        "email": "budi@gmail.com",
        "created_at": "10:11, 01-10-2025",
        "updated_at": "10:11, 01-10-2025",
    },
    "token": {
        "api_token": "[string-random]",
        "expired_at": "10:11, 01-10-2025",
    }
} 
``` -->
<!-- Status code: 201 Created -->



### `GET /api/user`
Mengambil informasi user berdasarkan api-token.

**Contoh Request:**
http header
    "api-token": "[string-random]"


**Contoh Respon:**
```json
{
    "data": {
        "name": "John Doe",
        "email": "budi@gmail.com",
        "created_at": "2025-12-14T14:43:36.721133Z",
    }
} 
```
Status code: 201 Created

<!-- PR -->
<!-- ```json
{
    "data": {
        "name": "John Doe",
        "email": "budi@gmail.com",
        "created_at": "10:11, 01-01-2025",
        "updated_at": "10:11, 01-01-2025",
    }
} 
```
<!-- Status code: 201 Created -->


```json
{
    "Message": "Token tidak valid."
} 
```
Status code: 401 Unauthorized



### `DELETE /api/logout`
Logout, dan menghapus api-token.

**Contoh Request:**
http header
    "api-token": "[string-random]"


**Contoh Respon:**
Status code: 204 No Content