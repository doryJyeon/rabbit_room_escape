-- admin insert
-- 입력된 password는 admin1234 입니다.
insert into rabbit_room_escape.admins
(login_id, password, position)
values
('admin1', '$2y$10$LXYdq6gVHYaFYuJkHKWEleYmHOzjY4NoH9iIRwDT/0/Rnpn4CKLPS', 'sys_admin')


-- 장르 insert
insert into rabbit_room_escape.genre_code 
(genre_name) 
values 
('스릴러'),('공포'),('호러'),('추리'),('수사'),
('판타지'),('동화'),('감성'),('드라마'),('미스터리'),
('힐링'),('미션'),('역사'),('시대극'),('SF'),
('모험'),('코미디'),('로맨스')


-- 테마 insert
-- ** AUTO_INCREMENT 1부터 시작해야 합니다.
INSERT INTO rabbit_room_escape.thema 
(image,title,description,`level`,persons_min,persons_max,play_time) 
VALUES
('last_treasure.jpg','마지막 보물','오늘은 놀이공원 마지막 운영일.
놀이공원 창시자가 "누구도 가질 수 없는 보물"을 숨겨뒀다고 하는데...
과연 놀이공원에 숨겨진 보물을 찾을 수 있을까요?',3.0,1,6,60),
('snow_white.jpg','백설 왕자','눈이 세차게 내리던 날 태어난 새하얀 피부에 칠흑 같은 머리카락을 가진 백설 왕자.
성년 생일 파티를 앞두고 새어머니가 자신을 위해 준비한 계획을 알게 됩니다.
심란한 마음을 달래기 위해 나간 사냥터에서 새어머니의 사냥꾼을 만나게 되는데..',4.5,2,4,75),
('the_little_match_girl.jpg','성냥팔이 소녀','모두 라이터를 사용해 성냥을 찾기 어려운 시대, 이 추운 날 길거리에서 성냥을 팔고 있는 소녀가 있습니다. 무심코 지나쳤던 당신은 문득 요즘 보기 드문 성냥이 궁금해졌습니다. 
소녀는 사람들 사이를 지나 어두운 골목으로 들어갔고, 당신 또한 소녀를 뒤쫓아 골목으로 들어갑니다.',3.5,1,5,75),
('cinderella.jpg','유리구두','마음씨 고운 신데렐라의 절친한 친구인 당신. 요정 대모의 마법을 도와 신데렐라가 무도회에 갈 수 있도록 도와주세요!',2.0,1,4,60),
('little_mermaid.jpg','보물선을 찾아서','해안가에서 바람을 맞으며 쉬던 중 바다 친구인 플렌더스로부터 흥미로운 얘기를 들었습니다. 바닷속 깊은 곳에 잠든 보물선이 있다는 이야기였죠. 플렌더스는 함께 그 보물선을 찾아가자고 했습니다. 바닷속에 들어가기 위해 특별한 준비를 합니다.',3.0,2,6,70),
('tiger.jpg','팥죽 할머니와 호랑이','산골에 혼자 사는 팥죽 할머니에게 어느 날 호랑이가 찾아와 "내일 할머니를 잡아먹겠다"며 선포했습니다. 할머니는 저녁으로 팥죽을 만들며 슬프게 울고 있었습니다. 할머니와 오랜 시간을 함께한 주방 도구들은 할머니의 눈물을 보고 그 이유를 물었고, 할머니를 구하기 위한 작전을 세우기로 결심합니다.',4.0,2,5,80),
('old_house.jpg','장화와 홍련','장화와 홍련, 두 어린 자매가 살고 있는 외딴 집. 스스로 목숨을 끊은 줄 알았던 새어머니의 타살 정황이 사건을 전혀 다른 방향으로 이끌어갑니다. 사건의 수사관으로 파견된 당신은 고요한 외딴 집에서 벌어진 충격적인 진실을 추적하기 시작합니다.',5.0,1,4,70),
('black_swan.jpg','어두운 무대','백조의 호수 공연 언더스터디인 당신. 무대를 향한 연습은 멈추지 않지만, 아직 그 위에 설 기회는 오지 않았습니다.
커튼 뒤 어둠 속, 끝나지 않는 박수 소리를 들으며 생각합니다.
‘언젠가, 내 차례가 오겠지.’
조용한 기다림 속에도, 희망은 무너지지 않습니다.',2.5,2,4,60),
('ice_princess.jpg','얼음의 성','북쪽 얼음성에는 마녀의 저주에 걸린 아름다운 공주가 살고 있습니다. 왕은 누군가 그 저주를 풀 수 있다면 공주와의 결혼은 물론 왕국까지 내리겠다고 선언합니다. 당신은 그 제안을 받아들이고, 저주를 풀어 공주를 만나기 위해 북쪽 얼음성으로 향합니다.',3.0,1,4,60);


-- 테마별 가격 insert
insert into rabbit_room_escape.thema_price
(thema_id, person, price)
values
(1, 1, 35000),(1, 2, 50000),(1, 3, 72000),(1, 4, 90000),(1, 5, 110000),(1, 6, 126000),
(2, 2, 56000),(2, 3, 81000),(2, 4, 104000),
(3, 1, 36000),(3, 2, 52000),(3, 3, 75000),(3, 4, 96000),(3, 5, 115000),
(4, 1, 33000),(4, 2, 46000),(4, 3, 66000),(4, 4, 84000),
(5, 2, 50000),(5, 3, 72000),(5, 4, 92000),(5, 5, 110000),(5, 6, 126000),
(6, 2, 56000),(6, 3, 81000),(6, 4, 104000),(6, 5, 125000),
(7, 1, 36000),(7, 2, 52000),(7, 3, 75000),(7, 4, 96000),
(8, 2, 50000),(8, 3, 72000),(8, 4, 92000),
(9, 1, 33000),(9, 2, 46000),(9, 3, 66000),(9, 4, 84000);


-- 테마별 스케줄 insert
-- date는 다음날로 입력됩니다.
insert into rabbit_room_escape.thema_schedule
(thema_id, date, time)
values
(1,date_add(curdate(), interval 1 day), '11:10'),(1,date_add(curdate(), interval 1 day), '12:40'),(1,date_add(curdate(), interval 1 day), '14:10'),(1,date_add(curdate(), interval 1 day), '15:40'),(1,date_add(curdate(), interval 1 day), '17:10'),(1,date_add(curdate(), interval 1 day), '18:40'),(1,date_add(curdate(), interval 1 day), '20:10'),(1,date_add(curdate(), interval 1 day), '21:40'),
(2,date_add(curdate(), interval 1 day), '11:10'),(2,date_add(curdate(), interval 1 day), '12:40'),(2,date_add(curdate(), interval 1 day), '14:10'),(2,date_add(curdate(), interval 1 day), '15:40'),(2,date_add(curdate(), interval 1 day), '17:10'),(2,date_add(curdate(), interval 1 day), '18:40'),(2,date_add(curdate(), interval 1 day), '20:10'),(2,date_add(curdate(), interval 1 day), '21:40'),
(3,date_add(curdate(), interval 1 day), '11:10'),(3,date_add(curdate(), interval 1 day), '12:40'),(3,date_add(curdate(), interval 1 day), '14:10'),(3,date_add(curdate(), interval 1 day), '15:40'),(3,date_add(curdate(), interval 1 day), '17:10'),(3,date_add(curdate(), interval 1 day), '18:40'),(3,date_add(curdate(), interval 1 day), '20:10'),(3,date_add(curdate(), interval 1 day), '21:40'),
(4,date_add(curdate(), interval 1 day), '11:10'),(4,date_add(curdate(), interval 1 day), '12:40'),(4,date_add(curdate(), interval 1 day), '14:10'),(4,date_add(curdate(), interval 1 day), '15:40'),(4,date_add(curdate(), interval 1 day), '17:10'),(4,date_add(curdate(), interval 1 day), '18:40'),(4,date_add(curdate(), interval 1 day), '20:10'),(4,date_add(curdate(), interval 1 day), '21:40'),
(5,date_add(curdate(), interval 1 day), '11:10'),(5,date_add(curdate(), interval 1 day), '12:40'),(5,date_add(curdate(), interval 1 day), '14:10'),(5,date_add(curdate(), interval 1 day), '15:40'),(5,date_add(curdate(), interval 1 day), '17:10'),(5,date_add(curdate(), interval 1 day), '18:40'),(5,date_add(curdate(), interval 1 day), '20:10'),(5,date_add(curdate(), interval 1 day), '21:40'),
(6,date_add(curdate(), interval 1 day), '11:10'),(6,date_add(curdate(), interval 1 day), '12:40'),(6,date_add(curdate(), interval 1 day), '14:10'),(6,date_add(curdate(), interval 1 day), '15:40'),(6,date_add(curdate(), interval 1 day), '17:10'),(6,date_add(curdate(), interval 1 day), '18:40'),(6,date_add(curdate(), interval 1 day), '20:10'),(6,date_add(curdate(), interval 1 day), '21:40'),
(7,date_add(curdate(), interval 1 day), '11:10'),(7,date_add(curdate(), interval 1 day), '12:40'),(7,date_add(curdate(), interval 1 day), '14:10'),(7,date_add(curdate(), interval 1 day), '15:40'),(7,date_add(curdate(), interval 1 day), '17:10'),(7,date_add(curdate(), interval 1 day), '18:40'),(7,date_add(curdate(), interval 1 day), '20:10'),(7,date_add(curdate(), interval 1 day), '21:40'),
(8,date_add(curdate(), interval 1 day), '11:10'),(8,date_add(curdate(), interval 1 day), '12:40'),(8,date_add(curdate(), interval 1 day), '14:10'),(8,date_add(curdate(), interval 1 day), '15:40'),(8,date_add(curdate(), interval 1 day), '17:10'),(8,date_add(curdate(), interval 1 day), '18:40'),(8,date_add(curdate(), interval 1 day), '20:10'),(8,date_add(curdate(), interval 1 day), '21:40'),
(9,date_add(curdate(), interval 1 day), '11:10'),(9,date_add(curdate(), interval 1 day), '12:40'),(9,date_add(curdate(), interval 1 day), '14:10'),(9,date_add(curdate(), interval 1 day), '15:40'),(9,date_add(curdate(), interval 1 day), '17:10'),(9,date_add(curdate(), interval 1 day), '18:40'),(9,date_add(curdate(), interval 1 day), '20:10'),(9,date_add(curdate(), interval 1 day), '21:40')


-- 테마별 장르
INSERT INTO rabbit_room_escape.thema_genres 
(thema_id,genre_id) 
VALUES
(1,4),(1,8),
(2,1),(2,2),(2,12),
(3,10),(3,4),(3,1),
(4,18),(4,11),(4,7),
(5,6),(5,5),(5,7),
(6,3),(6,12),(6,14),
(7,3),(7,5),(7,1),
(8,1),(8,8),(8,11),
(9,6),(9,7),(9,18);
