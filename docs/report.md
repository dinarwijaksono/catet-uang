# Dokumentasi API
Berikut adalah dokumentasi untuk API bagian report.

### `GET /api/report/total-income-spending`
Mengembil total pemasukan (total_income) dan total pengeluaran (total_spending).

**Contoh Request:**
http header
    "api-token": "[string-random]"

**Contoh Respon:** 
Status code: 200 success 
```json
{
    "data": {
        "total_income": 10000,
		"total_spending": 1000
    }
}
```

Status code: 401 Unauthorized
```json
{
    "Message": "Token tidak valid."
} 
```

Status code: 419 
```json
{
    "Message": "Token sudah expired."
} 
```