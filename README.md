# YSUS
YJSoft Secure Upload Service의 약자로, https://github.com/hletrd/YOTTA 의 fork 저장소입니다.
설정 페이지 추가와 같은 기능 개선을 할 계획으로, 목표는 일반 사용이 가능할 정도까지 구현하는 것입니다.

라이센스는 GPL v2입니다.

# 설치 방법
1. 현재까지는 MySQL 혹은 MySQL 호환 DBMS(MariadB)만을 지원합니다.
2. DB 연결 정보를 `config.inc.php`파일에 작성합니다.
3. 사이트 주 접속 주소를 하위 폴더와 마지막 슬래시까지 포함하여 `$site_url`의 값으로 설정합니다.
4. YOTTA를 설치한 폴더로 접속하면 인스톨러가 실행됩니다. 이제 `filedata`와 `filedata_big` 폴더를 생성후 쓰기 권한을 설정해 주세요.
5. 설치가 완료되었습니다!
