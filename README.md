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

