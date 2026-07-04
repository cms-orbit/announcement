# CMS Orbit Announcement

`cms-orbit/announcement`는 Orbit 문서 엔진 위에 구축된 공지사항 패키지입니다.  
관리자에서는 `DocumentEntity` 기반 CRUD로 공지를 관리하고, 프런트에서는 목록/상세 공개 페이지와 사이트맵 URL을 함께 제공합니다.

## 주요 기능

- `cms-orbit/core` 기반 문서형 공지 콘텐츠
- 다국어 `documents` / `document_contents` 저장 구조
- Orbit 관리자 CRUD 자동 등록
- 공개 목록/상세 페이지 제공
- 갤러리 첨부, 공개 시각(`public_at`), 공지 여부(`is_notice`) 지원
- 사이트맵/SEO 노출용 공개 URL 제공

## 설치

```bash
composer require cms-orbit/announcement:^4.0@beta
php artisan migrate
```

패키지는 `cms-orbit/core`를 의존하며, 설치 시 문서 섹션과 엔티티 등록을 함께 연결합니다.

## 빠른 시작

### 1. 관리자에서 공지 관리

설치 후 Orbit 관리자 `Documents` 섹션에 공지 엔티티가 자동 등록됩니다.  
제목, 슬러그, 본문, 설명, 갤러리, 공개 시각, 승인 상태를 한 화면에서 관리할 수 있습니다.

### 2. 공개 페이지 연결

패키지는 다음 공개 라우트를 제공합니다.

- `announcements.index`
- `announcements.show`

기본 경로는 아래와 같습니다.

```text
/announcements
/announcements/{slug}
```

### 3. Inertia 페이지 브리지

호스트 앱에서 브리지 페이지를 두고 싶다면 아래처럼 패키지 페이지를 re-export 하면 됩니다.

```tsx
export { default } from '@cms-orbit/announcement/pages/announcement/index';
```

```tsx
export { default } from '@cms-orbit/announcement/pages/announcement/show';
```

## 어떤 데이터가 추가되나요?

- 공지 전용 마이그레이션
- 공지 모델과 팩토리
- 관리자 Entity 설명자
- 공개 컨트롤러와 웹 라우트
- 한국어 번역 리소스

## 운영 팁

- `slug`를 비워두면 자동 생성 흐름을 사용할 수 있게 설계되어 있습니다.
- 공개 상세 URL은 엔티티의 `showUrl()`과 사이트맵 URL 생성에 함께 사용됩니다.
- 공개 시각과 승인 상태를 같이 써두면 발행 시점을 맞춘 운영이 수월합니다.

## License

MIT
