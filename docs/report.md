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



### `GET /api/report/ttotal-income-spending-every-period`
Mengembil total pemasukan (total_income) dan total pengeluaran (total_spending) perbulan (period).

**Contoh Request:**
http header
    "api-token": "[string-random]"

**Contoh Respon:** 
Status code: 200 success 
```json
{
    "data": {[
        {
            "period": {
                "id": 1234,
                "period_name": "januari 2026",
                "i_close": false,
                "created_at": "10:11, 01-10-2025",
                "updated_at": "10:11, 01-10-2025",
            },
            "data": {
                "total_income": 1234,
                "total_spending": 1234,
                "difference": 1234
            }
        }, 
        {
            "period": {
                "id": 1234,
                "period_name": "Februari 2026",
                "i_close": false,
                "created_at": "10:11, 01-10-2025",
                "updated_at": "10:11, 01-10-2025",
            },
            "data": {
                "total_income": 1234,
                "total_spending": 1234,
                "difference": 1234
            }
        } 
    ]}
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