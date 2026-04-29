<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>

    <Head title="Perfil" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                    Configuración
                </p>

                <h2 class="mt-1 text-xl font-black uppercase tracking-tight text-slate-950">
                    Mi cuenta
                </h2>
            </div>
        </template>

        <div class="relative overflow-hidden px-8 py-8">
            <div class="pointer-events-none absolute left-[-160px] top-0 h-80 w-80 rounded-full bg-red-500/10 blur-3xl">
            </div>
            <div
                class="pointer-events-none absolute right-[-180px] top-40 h-96 w-96 rounded-full bg-blue-700/10 blur-3xl">
            </div>

            <div class="relative mx-auto max-w-6xl space-y-6">
                <!-- Hero -->
                <section
                    class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 p-6 text-white shadow-2xl shadow-slate-300/60 sm:p-8">
                    <div
                        class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-red-600/30 blur-3xl">
                    </div>
                    <div
                        class="pointer-events-none absolute -bottom-24 left-10 h-72 w-72 rounded-full bg-blue-600/20 blur-3xl">
                    </div>

                    <div class="relative grid gap-6 lg:grid-cols-[1fr_340px] lg:items-center">
                        <div>
                            <div
                                class="mb-5 inline-flex rounded-full bg-red-600/20 px-4 py-2 text-xs font-black uppercase tracking-[0.22em] text-red-100 ring-1 ring-red-400/20">
                                Seguridad de cuenta
                            </div>

                            <h1 class="max-w-3xl text-3xl font-black leading-tight tracking-tight sm:text-4xl">
                                Administra la información y seguridad de tu cuenta.
                            </h1>

                            <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-300">
                                Actualiza tus datos personales, cambia tu contraseña o elimina tu cuenta si ya no deseas
                                continuar usando la plataforma.
                            </p>
                        </div>

                        <div class="rounded-3xl bg-white/10 p-5 shadow-xl ring-1 ring-white/10 backdrop-blur">
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-600 text-white shadow-lg shadow-red-900/30">
                                    <span class="material-symbols-outlined">manage_accounts</span>
                                </div>

                                <div>
                                    <p class="text-sm font-black text-white">
                                        Perfil de usuario
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-300">
                                        Mantén tu información actualizada para mejorar tu experiencia dentro del portal.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Secciones -->
                <div class="grid grid-cols-1 gap-6 xl:grid-cols-[1fr_420px]">
                    <div class="space-y-6">
                        <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" />

                        <UpdatePasswordForm />
                    </div>

                    <div>
                        <DeleteUserForm />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}
</style>