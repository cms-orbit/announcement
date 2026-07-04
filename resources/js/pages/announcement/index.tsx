import { Head, Link } from '@inertiajs/react';
import { useT } from '@cms-orbit/core/lib/i18n';

interface AnnouncementListItem {
    id: number;
    title: string | null;
    slug: string | null;
    description: string | null;
    is_notice: boolean;
    read_count: number;
    public_at: string | null;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Paginated<T> {
    data: T[];
    links: PaginationLink[];
}

interface AnnouncementIndexProps {
    announcements: Paginated<AnnouncementListItem>;
}

export default function AnnouncementIndex({ announcements }: AnnouncementIndexProps) {
    const t = useT();

    return (
        <>
            <Head title={t('Announcements')} />
            <div className="mx-auto max-w-3xl px-6 py-12">
                <h1 className="mb-8 text-2xl font-semibold text-neutral-900 dark:text-neutral-100">
                    {t('Announcements')}
                </h1>

                {announcements.data.length === 0 ? (
                    <p className="text-neutral-500">{t('No announcements have been posted yet.')}</p>
                ) : (
                    <ul className="divide-y divide-neutral-200 dark:divide-neutral-800">
                        {announcements.data.map((announcement) => (
                            <li key={announcement.id} className="py-4">
                                <Link
                                    href={`/announcements/${announcement.slug ?? ''}`}
                                    className="group flex items-start justify-between gap-4"
                                >
                                    <div>
                                        <div className="flex items-center gap-2">
                                            {announcement.is_notice && (
                                                <span className="rounded bg-red-100 px-2 py-0.5 text-xs font-medium text-red-700 dark:bg-red-900/40 dark:text-red-300">
                                                    {t('Notice')}
                                                </span>
                                            )}
                                            <span className="font-medium text-neutral-900 group-hover:underline dark:text-neutral-100">
                                                {announcement.title}
                                            </span>
                                        </div>
                                        {announcement.description && (
                                            <p className="mt-1 line-clamp-1 text-sm text-neutral-500">
                                                {announcement.description}
                                            </p>
                                        )}
                                    </div>
                                    <div className="shrink-0 text-right text-xs text-neutral-400">
                                        <div>{announcement.public_at?.slice(0, 10)}</div>
                                        <div>{t('Views :count', { count: announcement.read_count })}</div>
                                    </div>
                                </Link>
                            </li>
                        ))}
                    </ul>
                )}

                <nav className="mt-8 flex flex-wrap gap-1">
                    {announcements.links.map((link, index) =>
                        link.url ? (
                            <Link
                                key={index}
                                href={link.url}
                                className={`rounded px-3 py-1 text-sm ${
                                    link.active
                                        ? 'bg-neutral-900 text-white dark:bg-neutral-100 dark:text-neutral-900'
                                        : 'text-neutral-600 hover:bg-neutral-100 dark:text-neutral-300 dark:hover:bg-neutral-800'
                                }`}
                                dangerouslySetInnerHTML={{ __html: link.label }}
                            />
                        ) : (
                            <span
                                key={index}
                                className="rounded px-3 py-1 text-sm text-neutral-300"
                                dangerouslySetInnerHTML={{ __html: link.label }}
                            />
                        ),
                    )}
                </nav>
            </div>
        </>
    );
}
