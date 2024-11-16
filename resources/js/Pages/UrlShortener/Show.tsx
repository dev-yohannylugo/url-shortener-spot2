import { useEffect, useState } from "react";
import { Head } from "@inertiajs/react";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { PageProps, UrlShortener } from "@/types";

export default function Show({
    url_shortened,
}: PageProps<{ url_shortened: UrlShortener }>) {
    const [count, setCount] = useState(5);

    useEffect(() => {
        const interval = setInterval(() => {
            setCount((prevCount) => prevCount - 1);
        }, 1000);
        if (count === 0) {
            clearInterval(interval);
            window.location.href = url_shortened.original_url;
        }

        return () => clearInterval(interval);
    }, [count]);

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Redirect Page
                </h2>
            }
        >
            <Head title="Redirect Page" />
            <div className="py-12">
                <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8 h-96 ">
                        Wait a moment... {count}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
