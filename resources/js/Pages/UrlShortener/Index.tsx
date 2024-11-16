import { FormEventHandler, useState } from "react";
import { Head, Link, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

import { UrlShortener, PaginatedData, PageProps } from "@/types";
import Modal from "@/Components/Modal";
import DangerButton from "@/Components/DangerButton";
import SecondaryButton from "@/Components/SecondaryButton";

export default function Index({
    urls,
}: PageProps<{ urls: PaginatedData<UrlShortener> }>) {
    const [confirmingDeletion, setConfirmingDeletion] = useState<number | null>(
        null
    );
    const {
        delete: destroy,
        processing,
        reset,
        errors,
        clearErrors,
    } = useForm({});

    const confirmUrlDeletion = (id: number) => {
        setConfirmingDeletion(id);
    };

    const deleteUrl: FormEventHandler = (e) => {
        e.preventDefault();

        destroy(route("url_shortener.destroy", confirmingDeletion!), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => {},
            onFinish: () => reset(),
        });
    };

    const closeModal = () => {
        setConfirmingDeletion(null);

        clearErrors();
        reset();
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Shortened Urls
                </h2>
            }
        >
            <Head title="Shortened Url" />
            <div className="py-12">
                <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                        <div className="flex justify-between  items-start gap-4 mb-6">
                            <h2 className="text-2xl font-medium text-gray-900">
                                Shortened Urls:
                            </h2>
                            <button
                                className="rounded-md border border-slate-300 p-2.5 text-center text-sm transition-all shadow-sm hover:shadow-lg text-slate-600 hover:text-white hover:bg-slate-800 hover:border-slate-800 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                type="button"
                                title="Shorten Url"
                            >
                                <Link href={route("url_shortener.create")}>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        strokeWidth={1.5}
                                        stroke="currentColor"
                                        className="size-7"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            d="M12 4.5v15m7.5-7.5h-15"
                                        />
                                    </svg>
                                </Link>
                            </button>
                        </div>

                        <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table className="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" className="px-6 py-3">
                                            ID
                                        </th>
                                        <th scope="col" className="px-6 py-3">
                                            Code
                                        </th>
                                        <th scope="col" className="px-6 py-3">
                                            Original Name
                                        </th>
                                        <th scope="col" className="px-6 py-3">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {urls.data.map((url) => (
                                        <tr
                                            className="bg-white border-b"
                                            key={url.id}
                                        >
                                            <td className="px-6 py-4">
                                                {url.id}
                                            </td>
                                            <td className="px-6 py-4">
                                                {url.code}
                                            </td>
                                            <td className="px-6 py-4">
                                                {url.original_url}
                                            </td>
                                            <td className="px-6 py-4 flex justify-evenly items-start">
                                                <Link
                                                    href={route(
                                                        "url_shortener.show",
                                                        url.code
                                                    )}
                                                >
                                                    <button
                                                        className="rounded-md border border-slate-300 p-2.5 text-center text-sm transition-all shadow-sm hover:shadow-lg text-slate-600 hover:text-white hover:bg-slate-800 hover:border-slate-800 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                                        type="button"
                                                        title="Redirect Url"
                                                    >
                                                        <svg
                                                            className="w-6 h-6 text-gray-800 dark:text-white"
                                                            aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24"
                                                            fill="currentColor"
                                                        >
                                                            <path
                                                                stroke="#000000"
                                                                strokeWidth="2"
                                                                d="M5.027 10.9a8.729 8.729 0 0 1 6.422-3.62v-1.2A2.061 2.061 0 0 1 12.61 4.2a1.986 1.986 0 0 1 2.104.23l5.491 4.308a2.11 2.11 0 0 1 .588 2.566 2.109 2.109 0 0 1-.588.734l-5.489 4.308a1.983 1.983 0 0 1-2.104.228 2.065 2.065 0 0 1-1.16-1.876v-.942c-5.33 1.284-6.212 5.251-6.25 5.441a1 1 0 0 1-.923.806h-.06a1.003 1.003 0 0 1-.955-.7A10.221 10.221 0 0 1 5.027 10.9Z"
                                                            />
                                                        </svg>
                                                    </button>
                                                </Link>
                                                <button
                                                    className="rounded-md border border-slate-300 p-2.5 text-center text-sm transition-all shadow-sm hover:shadow-lg text-slate-600 hover:text-white hover:bg-slate-800 hover:border-slate-800 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                                    type="button"

                                                    title="Delete Url"
                                                    onClick={() =>
                                                        confirmUrlDeletion(
                                                            url.id
                                                        )
                                                    }
                                                >
                                                    <svg
                                                        className="w-6 h-6 text-gray-800 dark:text-white"
                                                        viewBox="0 0 24 24"
                                                        fill="currentColor"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16"
                                                            stroke="#000000"
                                                            strokeWidth="2"
                                                            strokeLinecap="round"
                                                            strokeLinejoin="round"
                                                        />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                        <Modal
                            show={confirmingDeletion != null}
                            onClose={closeModal}
                        >
                            <form onSubmit={deleteUrl} className="p-6">
                                <h2 className="text-lg font-medium text-gray-900">
                                    Are you sure you want to delete this url
                                    with id # {confirmingDeletion}?
                                </h2>

                                <p className="mt-1 text-sm text-gray-600">
                                    Once the shortened url has been deleted, you
                                    will not be able to recover the information
                                    from it.
                                </p>

                                <div className="mt-6 flex justify-end">
                                    <SecondaryButton onClick={closeModal}>
                                        Cancel
                                    </SecondaryButton>

                                    <DangerButton
                                        className="ms-3"
                                        disabled={processing}
                                    >
                                        Delete Url
                                    </DangerButton>
                                </div>
                            </form>
                        </Modal>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
