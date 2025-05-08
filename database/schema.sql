-- admins(관리자 계정)
CREATE TABLE `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login_id` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `position` enum('staff','manager','executive','sys_admin') NOT NULL DEFAULT 'staff',
  `remember_token` varchar(255) DEFAULT NULL,
  `token_expires_at` datetime DEFAULT NULL,
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `login_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_id` (`login_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- 장르 코드
CREATE TABLE `genre_code` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `genre_name` varchar(30) NOT NULL COMMENT '장르명',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `genre_name` (`genre_name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- 테마
CREATE TABLE `thema` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL COMMENT '테마 이미지',
  `title` varchar(30) NOT NULL COMMENT '테마명',
  `description` varchar(500) DEFAULT NULL COMMENT '테마 줄거리',
  `level` decimal(2,1) NOT NULL COMMENT '난이도',
  `persons_min` tinyint NOT NULL DEFAULT '2' COMMENT '최소 플레이 인원',
  `persons_max` tinyint NOT NULL COMMENT '최대 플레이 인원',
  `play_time` tinyint NOT NULL COMMENT '플레이 시간',
  `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- 테마-장르 
CREATE TABLE `thema_genres` (
  `thema_id` int NOT NULL,
  `genre_id` tinyint NOT NULL,
  PRIMARY KEY (`thema_id`,`genre_id`),
  KEY `genre_id` (`genre_id`),
  CONSTRAINT `thema_genres_ibfk_1` FOREIGN KEY (`thema_id`) REFERENCES `thema` (`id`) ON DELETE CASCADE,
  CONSTRAINT `thema_genres_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genre_code` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- 테마별 가격
CREATE TABLE `thema_price` (
  `id` int NOT NULL AUTO_INCREMENT,
  `thema_id` int NOT NULL,
  `person` tinyint NOT NULL COMMENT '플레이 인원',
  `price` int NOT NULL COMMENT '가격',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- 테마별 스케줄
CREATE TABLE `thema_schedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `thema_id` int NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` enum('open','close') NOT NULL DEFAULT 'open' COMMENT '예약 가능:open, 불가:close',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_thema_date_time` (`thema_id`,`date`,`time`),
  CONSTRAINT `fk_thema_schedule_thema_id` FOREIGN KEY (`thema_id`) REFERENCES `thema` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- 스케줄별 예약정보
CREATE TABLE `reservation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `thema_schedule_id` int NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '비회원 이름',
  `email` varchar(100) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `persons` tinyint NOT NULL COMMENT '참가 인원수',
  `status` enum('pending','confirmed','canceled','denied') NOT NULL DEFAULT 'pending' COMMENT 'pending:신청(승인 대기), confirmed:확정(승인 완료), canceled:유저 취소, denied:관리자 거부',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_phone_created_at` (`phone`,`created_at`),
  KEY `fk_thema_reservation_schedule_id` (`thema_schedule_id`),
  CONSTRAINT `fk_thema_reservation_schedule_id` FOREIGN KEY (`thema_schedule_id`) REFERENCES `thema_schedule` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;