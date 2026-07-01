# announcement

CMS Orbit 공지사항(Announcement) 패키지. `cms-orbit/core`의 `DocumentModel` / `DocumentEntity` 엔진 위에 구축된 문서형 콘텐츠 타입입니다.

## 기능

- 중앙 `documents` / `document_contents` 테이블 기반의 다국어 공지 콘텐츠
- Orbit 관리자 CRUD (`orbit.entities.announcements.*`) 자동 등록
- 공개 목록/상세 페이지 (`announcements.index`, `announcements.show`)
- 갤러리(다중 첨부) 및 공개 시각(`public_at`) 지원
- 사이트맵/SEO 연동

## 설치

```bash
composer require cms-orbit/announcement
php artisan migrate
```

프론트엔드 페이지는 호스트 앱의 `resources/js/pages/announcement/*` 브릿지에서 `@cms-orbit/announcement`를 re-export 합니다.

## License

MIT
