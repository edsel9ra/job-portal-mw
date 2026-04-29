<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <!--<p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                        Currículum
                    </p>-->

                    <h2 class="mt-1 text-xl font-black uppercase tracking-tight text-slate-950">
                        Editar currículum
                    </h2>
                </div>

                <!--<div class="flex flex-wrap gap-2">
                    <Button :pt="ptButton" outlined
                        class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-sm !font-bold !text-slate-700 !shadow-sm hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
                        label="Ver " @click="go(route('candidato.resume.show'))">
                        <template #icon>
                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                        </template>
                    </Button>

                    <Button :pt="ptButton" outlined
                        class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-sm !font-bold !text-slate-700 !shadow-sm hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
                        label="Volver a Dashboard" @click="go(route('candidato.dashboard'))">
                        <template #icon>
                            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        </template>
                    </Button>
                </div>-->
            </div>
        </template>

        <div class="relative overflow-hidden px-8 py-8">
            <div class="pointer-events-none absolute left-[-160px] top-0 h-80 w-80 rounded-full bg-red-500/10 blur-3xl">
            </div>
            <div
                class="pointer-events-none absolute right-[-180px] top-40 h-96 w-96 rounded-full bg-blue-700/10 blur-3xl">
            </div>

            <div class="relative mx-auto max-w-6xl space-y-6">
                <!-- Breadcrumb -->
                <nav class="flex flex-wrap items-center gap-2 text-sm font-medium text-slate-500">
                    <Link :href="route('candidato.dashboard')" class="transition hover:text-red-600">
                        Dashboard
                    </Link>

                    <span>/</span>

                    <Link :href="route('candidato.resume.show')" class="transition hover:text-red-600">
                        Mi currículum
                    </Link>

                    <span>/</span>

                    <span class="text-slate-800">
                        Editar
                    </span>
                </nav>

                <Message v-if="$page.props.flash?.success" :pt="ptMessage" severity="success" :closable="false"
                    class="!rounded-2xl !border !border-green-200 !bg-green-50 !text-green-700">
                    {{ $page.props.flash.success }}
                </Message>

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
                                Actualización de perfil
                            </div>

                            <h1 class="max-w-3xl text-3xl font-black leading-tight tracking-tight sm:text-4xl">
                                Mantén tu currículum actualizado.
                            </h1>

                            <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-300">
                                Modifica tu experiencia, estudios, habilidades, certificaciones o PDF para que tu perfil
                                siempre
                                esté al día.
                            </p>
                        </div>

                        <div class="rounded-3xl bg-white/10 p-5 shadow-xl ring-1 ring-white/10 backdrop-blur">
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-600 text-white shadow-lg shadow-red-900/30">
                                    <span class="material-symbols-outlined">edit_document</span>
                                </div>

                                <div>
                                    <p class="text-sm font-black text-white">
                                        Perfil actualizado
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-300">
                                        Un currículum completo mejora la información disponible para el equipo de
                                        reclutamiento.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Formulario -->
                <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
                        <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                            Formulario
                        </p>

                        <h3 class="mt-2 text-xl font-black text-slate-950">
                            Editar información del currículum
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Realiza los cambios necesarios y guarda tu información.
                        </p>
                    </div>

                    <div class="p-6">
                        <ResumeForm :model-value="resume" :levels="levels"
                            :action="route('candidato.resume.update', resume.id)" method="put"
                            submit-text="Guardar cambios" />
                    </div>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ResumeForm from '@/Components/ResumeForm.vue';

import Button from 'primevue/button';
import Message from 'primevue/message';
import { ptButton, ptMessage } from '@/primevue/pt';

defineProps({
    resume: { type: Object, required: true },
    levels: { type: Array, default: () => [] },
});

function go(href) {
    router.visit(href);
}
</script>

<style scoped>
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}
</style>