# 🗝 Rabbit room escape

방탈출 카페 예약/관리 사이트입니다.


## 🛠 사용 기술
|분야|사용기술|
|-----|-----|
|BE|PHP 8.2.12 이상, Composer 기반 OOP 구조|
|FE|Bootstrap5, JavaScript|
|DB|MySQL8|


## 📦 프로젝트 설치 및 실행 방법
1. PHP 8.2.12 이상, MySQL 8 이상, Composer 설치
```
// php.ini 수정
//  아래 내용 주석 해제
extension=pdo_mysql
extension=gd
extension=openssl
extension=fileinfo
```
2. 프로젝트 클론
```
git clone https://github.com/doryJyeon/rabbit_room_escape.git
```
3. 의존성 설치
```
composer install
```
4. .env 파일 제작
```
// /.env
DB_HOST=your_host
DB_NAME=rabbit_room_escape
DB_USER=your_user
DB_PASS=your_password
```
5. MySQL 데이터베이스 생성
```
-- MySQL 접속 후 실행
CREATE DATABASE rabbit_room_escape DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```
6. 데이터베이스 스키마 및 더미 데이터 입력
```
mysql -u root -p rabbit_room_escape < database/schema.sql
mysql -u root -p rabbit_room_escape < database/seed.sql
```
7. 웹 서버 실행
```
php -S localhost:8000 -t public
```

## 구현 화면
### user
- main  
![캡처_4](https://github.com/user-attachments/assets/154e7114-e901-4398-8394-274a6fe60333)

---
- thema  
![캡처_5](https://github.com/user-attachments/assets/4f16373c-f914-405b-9673-7221a42f1439)

---
- main_mobile  
![캡처_1](https://github.com/user-attachments/assets/7917c1c9-4a43-4042-8686-6106c0456a3d)

---
- thema_mobile  
![캡처_2](https://github.com/user-attachments/assets/ee408892-ab6b-400e-b080-bec6d33897f8)

---
- reserve_mobile  
![캡처_3](https://github.com/user-attachments/assets/86501a36-820a-4fd4-9ffc-2cb790b1bf27)

### admin
- main  
![캡처_6](https://github.com/user-attachments/assets/4bd4f25d-6da2-4c46-818c-369b5bcdff6c)

---
- thema list  
![캡처_7](https://github.com/user-attachments/assets/ac33d3a5-bb2c-4157-9292-2aa0836b2b8d)

---
- thema detail  
![캡처_8](https://github.com/user-attachments/assets/427450f7-8120-462b-aa1a-c12887691d54)

---
- thema schedule  
![캡처_9](https://github.com/user-attachments/assets/df8d2686-37e6-4af2-8679-163b8d183e58)




