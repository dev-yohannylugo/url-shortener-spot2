import { FormEvent } from "react";
import { Head } from "@inertiajs/react";
import { useForm } from "@inertiajs/react";
import { Transition } from "@headlessui/react";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";

export default function Create() {
    const { data, setData, post, processing, errors, recentlySuccessful } =
        useForm({
            url: "",
        });

    const submit = (e: FormEvent) => {
        e.preventDefault();
        post("/url-shortener/shorten");
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Create New Url
                </h2>
            }
        >
            <Head title="Shorten Url" />
            <div className="py-12">
                <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                    <div className="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                        <section className="max-w-xl">
                            <header>
                                <h2 className="text-lg font-medium text-gray-900">
                                    Url to Shortener
                                </h2>

                                <p className="mt-1 text-sm text-gray-600">
                                    Ingrese la url que desea acortar.
                                </p>
                            </header>
                            <form onSubmit={submit} className="mt-6 space-y-6">
                                <div>
                                    <InputLabel
                                        htmlFor="url"
                                        value="Original Url"
                                    />

                                    <TextInput
                                        id="url"
                                        className="mt-1 block w-full"
                                        value={data.url}
                                        onChange={(e) =>
                                            setData("url", e.target.value)
                                        }
                                        required
                                        isFocused
                                        autoComplete="url"
                                    />

                                    <InputError
                                        className="mt-2"
                                        message={errors.url}
                                    />
                                </div>
                                <div className="flex items-center gap-4">
                                    <PrimaryButton disabled={processing}>
                                        Shorten
                                    </PrimaryButton>

                                    <Transition
                                        show={recentlySuccessful}
                                        enter="transition ease-in-out"
                                        enterFrom="opacity-0"
                                        leave="transition ease-in-out"
                                        leaveTo="opacity-0"
                                    >
                                        <p className="text-sm text-gray-600">
                                            Saved.
                                        </p>
                                    </Transition>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
