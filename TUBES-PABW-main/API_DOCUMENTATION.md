# API Documentation

## Authentication

All API endpoints require authentication using Laravel Sanctum tokens.

### Login
```
POST /api/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password"
}
```

Response:
```json
{
    "user": {...},
    "token": "1|abc123..."
}
```

### Register
```
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

### Logout
```
POST /api/logout
Authorization: Bearer {token}
```

## Berita (News)

### Get All Berita
```
GET /api/berita
```

### Get Single Berita
```
GET /api/berita/{id}
```

### Like Berita
```
POST /api/berita/{id}/like
Authorization: Bearer {token}
```

### Comment on Berita
```
POST /api/berita/{id}/comment
Authorization: Bearer {token}
Content-Type: application/json

{
    "comment": "This is my comment"
}
```

## Laporan (Reports)

### Get User Reports
```
GET /api/laporan
Authorization: Bearer {token}
```

### Create Report
```
POST /api/laporan
Authorization: Bearer {token}
Content-Type: multipart/form-data

{
    "notelp": "08123456789",
    "date": "2024-01-01",
    "time": "14:30",
    "polres": "Polres Jakarta",
    "alamat": "Jl. Sudirman No. 1",
    "foto": file,
    "deskripsi": "Description of the incident"
}
```

### Update Report
```
PUT /api/laporan/{id}
Authorization: Bearer {token}
```

### Delete Report
```
DELETE /api/laporan/{id}
Authorization: Bearer {token}
```

## Feedback

### Get User Feedback
```
GET /api/feedback
Authorization: Bearer {token}
```

### Create Feedback
```
POST /api/feedback
Authorization: Bearer {token}
Content-Type: application/json

{
    "nama": "John Doe",
    "email": "john@example.com",
    "notelp": "08123456789",
    "deskripsi": "Feedback description"
}
```

## Notifications

### Get User Notifications
```
GET /api/notifications
Authorization: Bearer {token}
```

### Mark Notification as Read
```
POST /api/notifications/{id}/read
Authorization: Bearer {token}
```