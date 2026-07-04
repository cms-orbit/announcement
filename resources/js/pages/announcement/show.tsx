import { Head, Link } from '@inertiajs/react';
import { useT } from '@cms-orbit/core/lib/i18n';

interface AnnouncementDetail {
    id: number;
    title: string | null;
    slug: string | null;
    description: string | null;
    content: string | null;
    gallery: unknown[];
    read_count: number;
    public_at: string | null;
}

interface AnnouncementShowProps {
    announcement: AnnouncementDetail;
}

export default function AnnouncementShow({ announcement }: AnnouncementShowProps) {
    const t = useT();

    return (
        <>
            <Head title={announcement.title ?? t('Announcements')} />
            <article className="mx-auto max-w-3xl px-6 py-12">
                <Link
                    href="/announcements"
                    className="mb-6 inline-block text-sm text-neutral-500 hover:underline"
                >
                    &larr; {t('Back to list')}
                </Link>

                <h1 className="mb-2 text-2xl font-semibold text-neutral-900 dark:text-neutral-100">
                    {announcement.title}
                </h1>
                <div className="mb-8 flex items-center gap-3 text-xs text-neutral-400">
                    <span>{announcement.public_at?.slice(0, 16)}</span>
                    <span>{t('Views :count', { count: announcement.read_count })}</span>
                </div>

                {announcement.content && (
                    <div
                        className="prose prose-neutral max-w-none dark:prose-invert"
                        dangerouslySetInnerHTML={{ __html: announcement.content }}
                    />
                )}
            </article>
        </>
    );
}
