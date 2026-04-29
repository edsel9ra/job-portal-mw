<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <!--<p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                        Portal del reclutador
                    </p>-->

                    <h2 class="mt-1 text-xl font-black uppercase tracking-tight text-slate-950">
                        Panel Principal Reclutador
                    </h2>
                </div>

                <!--<div class="flex flex-wrap gap-2">
                    <Button
                        :pt="ptButton"
                        outlined
                        class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-sm !font-bold !text-slate-700 !shadow-sm hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
                        label="Ver ofertas"
                        @click="go(route('reclutador.jobs.index'))"
                    >
                        <template #icon>
                            <span class="material-symbols-outlined text-[18px]">work</span>
                        </template>
                    </Button>

                    <Button
                        :pt="ptButton"
                        class="!rounded-2xl !border-red-600 !bg-red-600 !px-4 !py-2.5 !text-sm !font-black !text-white !shadow-lg !shadow-red-600/25 hover:!border-red-700 hover:!bg-red-700"
                        label="Nueva oferta"
                        @click="go(route('reclutador.jobs.create'))"
                    >
                        <template #icon>
                            <span class="material-symbols-outlined text-[18px]">add</span>
                        </template>
                    </Button>
                </div>-->
            </div>
        </template>

        <div class="relative overflow-hidden px-8 py-8">
            <div class="pointer-events-none absolute left-[-160px] top-0 h-80 w-80 rounded-full bg-red-500/10 blur-3xl"></div>
            <div class="pointer-events-none absolute right-[-180px] top-40 h-96 w-96 rounded-full bg-blue-700/10 blur-3xl"></div>

            <div class="relative mx-auto max-w-6xl space-y-6">
                <!-- HERO -->
                <Card :pt="ptCard" class="overflow-hidden">
                    <template #content>
                        <div class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 p-6 text-white sm:p-8">
                            <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-red-600/30 blur-3xl"></div>
                            <div class="pointer-events-none absolute -bottom-24 left-10 h-72 w-72 rounded-full bg-blue-600/20 blur-3xl"></div>

                            <div class="relative grid gap-8 lg:grid-cols-[1fr_340px] lg:items-center">
                                <div class="min-w-0">
                                    <div class="mb-5 inline-flex rounded-full bg-red-600/20 px-4 py-2 text-xs font-black uppercase tracking-[0.22em] text-red-100 ring-1 ring-red-400/20">
                                        Resumen de reclutamiento
                                    </div>

                                    <h1 class="max-w-3xl text-3xl font-black leading-tight tracking-tight text-white sm:text-4xl">
                                        Hola, {{ user.name }} 👋
                                    </h1>

                                    <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-300">
                                        Aquí tienes un resumen de tus ofertas, candidatos registrados y aplicaciones pendientes por revisar.
                                    </p>

                                    <!--<div class="mt-5 flex flex-wrap gap-2">
                                        <div class="inline-flex items-center rounded-2xl bg-white/10 px-4 py-2 text-sm font-semibold text-slate-100 ring-1 ring-white/10">
                                            <span class="material-symbols-outlined mr-2 text-[18px] text-red-300">work</span>
                                            <span>Ofertas:&nbsp;</span>
                                            <b>{{ totalOfertas }}</b>
                                        </div>

                                        <div class="inline-flex items-center rounded-2xl bg-white/10 px-4 py-2 text-sm font-semibold text-slate-100 ring-1 ring-white/10">
                                            <span class="material-symbols-outlined mr-2 text-[18px] text-red-300">groups</span>
                                            <span>Candidatos:&nbsp;</span>
                                            <b>{{ totalCandidatos }}</b>
                                        </div>

                                        <div class="inline-flex items-center rounded-2xl bg-white/10 px-4 py-2 text-sm font-semibold text-slate-100 ring-1 ring-white/10">
                                            <span class="material-symbols-outlined mr-2 text-[18px] text-red-300">hourglass_top</span>
                                            <span>Pendientes:&nbsp;</span>
                                            <b>{{ aplicacionesPendientes }}</b>
                                        </div>
                                    </div>-->
                                </div>

                                <!-- CTA -->
                                <div class="rounded-3xl bg-white/10 p-4 shadow-xl ring-1 ring-white/10 backdrop-blur">
                                    <p class="mb-4 text-sm font-black text-white">
                                        Acciones principales
                                    </p>

                                    <div class="space-y-3">
                                        <Button
                                            :pt="ptButton"
                                            class="!w-full !rounded-2xl !border-red-600 !bg-red-600 !px-5 !py-3 !text-sm !font-black !text-white !shadow-lg !shadow-red-900/30 hover:!border-red-700 hover:!bg-red-700"
                                            label="Crear nueva oferta"
                                            @click="go(route('reclutador.jobs.create'))"
                                        >
                                            <template #icon>
                                                <span class="material-symbols-outlined text-[18px]">add</span>
                                            </template>
                                        </Button>

                                        <Button
                                            :pt="ptButton"
                                            outlined
                                            class="!w-full !rounded-2xl !border-white/15 !bg-white/10 !px-5 !py-3 !text-sm !font-bold !text-white hover:!bg-white/15"
                                            label="Gestionar ofertas"
                                            @click="go(route('reclutador.jobs.index'))"
                                        >
                                            <template #icon>
                                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                            </template>
                                        </Button>

                                        <!--<Button
                                            :pt="ptButton"
                                            outlined
                                            class="!w-full !rounded-2xl !border-white/15 !bg-white/10 !px-5 !py-3 !text-sm !font-bold !text-white hover:!bg-white/15"
                                            label="Ver portal público"
                                            @click="openNewTab(route('jobs.index'))"
                                        >
                                            <template #icon>
                                                <span class="material-symbols-outlined text-[18px]">public</span>
                                            </template>
                                        </Button>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </Card>

                <!-- KPIs -->
                <section class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <Card :pt="ptCard" class="transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/80">
                        <template #content>
                            <div class="p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-bold text-slate-500">
                                            Ofertas Totales
                                        </p>

                                        <p class="mt-3 text-4xl font-black text-slate-950">
                                            {{ totalOfertas }}
                                        </p>
                                    </div>

                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                                        <span class="material-symbols-outlined">work</span>
                                    </div>
                                </div>

                                <Button
                                    :pt="ptButton"
                                    outlined
                                    class="mt-5 !rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-xs !font-bold !text-slate-700 hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
                                    label="Ver todas las ofertas"
                                    @click="go(route('reclutador.jobs.index'))"
                                />
                            </div>
                        </template>
                    </Card>

                    <Card :pt="ptCard" class="transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/80">
                        <template #content>
                            <div class="p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-bold text-slate-500">
                                            Candidatos
                                        </p>

                                        <p class="mt-3 text-4xl font-black text-slate-950">
                                            {{ totalCandidatos }}
                                        </p>
                                    </div>

                                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-950 text-white">
                                        <span class="material-symbols-outlined">groups</span>
                                    </div>
                                </div>

                                <Button
                                    :pt="ptButton"
                                    outlined
                                    class="mt-5 !rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-xs !font-bold !text-slate-700 hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
                                    label="Ver candidatos"
                                    @click="go(route('reclutador.candidates.index'))"
                                />
                            </div>
                        </template>
                    </Card>

                    <Card :pt="ptCard" class="transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/80">
                        <template #content>
                            <div class="p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-bold text-slate-500">
                                            Aplicaciones pendientes
                                        </p>

                                        <p class="mt-3 text-4xl font-black text-slate-950">
                                            {{ aplicacionesPendientes }}
                                        </p>
                                    </div>

                                    <div
                                        class="flex h-12 w-12 items-center justify-center rounded-2xl"
                                        :class="aplicacionesPendientes > 0 ? 'bg-amber-50 text-amber-700' : 'bg-green-50 text-green-600'"
                                    >
                                        <span class="material-symbols-outlined">
                                            {{ aplicacionesPendientes > 0 ? 'hourglass_top' : 'check_circle' }}
                                        </span>
                                    </div>
                                </div>

                                <p
                                    class="mt-5 rounded-2xl px-4 py-2.5 text-xs font-bold"
                                    :class="aplicacionesPendientes > 0 ? 'bg-amber-50 text-amber-700' : 'bg-green-50 text-green-700'"
                                >
                                    {{ aplicacionesPendientes > 0 ? 'Tienes aplicaciones para revisar' : 'No tienes aplicaciones pendientes' }}
                                </p>
                            </div>
                        </template>
                    </Card>
                </section>

                <!-- Acciones rápidas -->
                <!--<Card :pt="ptCard">
                    <template #content>
                        <div class="p-6">
                            <div class="mb-5 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                        Acciones rápidas
                                    </p>

                                    <h3 class="mt-1 text-lg font-black text-slate-950">
                                        Gestiona tu proceso de reclutamiento
                                    </h3>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <button
                                    type="button"
                                    class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 p-5 text-left text-white shadow-xl shadow-slate-300/60 transition duration-300 hover:-translate-y-1"
                                    @click="go(route('reclutador.jobs.create'))"
                                >
                                    <div class="pointer-events-none absolute -right-12 -top-12 h-32 w-32 rounded-full bg-red-600/30 blur-2xl"></div>

                                    <div class="relative flex items-center gap-4">
                                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 ring-1 ring-white/10">
                                            <span class="material-symbols-outlined text-[30px]">add</span>
                                        </div>

                                        <div class="min-w-0">
                                            <p class="text-sm font-black">
                                                Nueva oferta
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-slate-300">
                                                Publica una nueva vacante para que los candidatos puedan aplicar.
                                            </p>
                                        </div>

                                        <span class="material-symbols-outlined ml-auto text-slate-300 transition group-hover:translate-x-1">
                                            arrow_forward
                                        </span>
                                    </div>
                                </button>

                                <button
                                    type="button"
                                    class="group rounded-3xl border border-slate-200 bg-white p-5 text-left shadow-sm transition duration-300 hover:-translate-y-1 hover:border-red-200 hover:shadow-xl hover:shadow-slate-200/80"
                                    @click="go(route('reclutador.jobs.index'))"
                                >
                                    <div class="flex items-center gap-4">
                                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                                            <span class="material-symbols-outlined text-[30px]">edit</span>
                                        </div>

                                        <div class="min-w-0">
                                            <p class="text-sm font-black text-slate-950">
                                                Gestionar ofertas
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                                Edita, pausa, revisa o cierra las ofertas publicadas.
                                            </p>
                                        </div>

                                        <span class="material-symbols-outlined ml-auto text-slate-400 transition group-hover:translate-x-1 group-hover:text-red-600">
                                            arrow_forward
                                        </span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </template>
                </Card>-->

                <!-- Portal público -->
                <Card :pt="ptCard">
                    <template #content>
                        <div class="grid gap-5 p-6 lg:grid-cols-[1fr_auto] lg:items-center">
                            <div class="flex gap-4">
                                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-slate-950 text-white">
                                    <span class="material-symbols-outlined">public</span>
                                </div>

                                <div>
                                    <p class="text-sm font-black text-slate-950">
                                        Portal público de empleos
                                    </p>

                                    <p class="mt-1 text-sm leading-6 text-slate-500">
                                        Revisa cómo ven los candidatos las ofertas publicadas en el portal.
                                    </p>
                                </div>
                            </div>

                            <Button
                                :pt="ptButton"
                                outlined
                                class="!rounded-2xl !border-slate-200 !bg-white !px-5 !py-3 !text-sm !font-bold !text-slate-700 !shadow-sm hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
                                label="Ver portal"
                                @click="openNewTab(route('jobs.index'))"
                            >
                                <template #icon>
                                    <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                                </template>
                            </Button>
                        </div>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// PrimeVue
import Button from 'primevue/button';
import Card from 'primevue/card';

// PT
import { ptButton } from '@/primevue/pt';

const props = defineProps({
    totalOfertas: { type: Number, default: 0 },
    totalCandidatos: { type: Number, default: 0 },
    aplicacionesPendientes: { type: Number, default: 0 },
});

const user = computed(() => usePage().props.auth.user);

function go(href) {
    router.visit(href);
}

function openNewTab(url) {
    window.open(url, '_blank', 'noopener,noreferrer');
}

const ptCard = {
    root: () => ({
        class: 'rounded-[2rem] border border-slate-200 bg-white shadow-sm overflow-hidden',
    }),
    body: () => ({
        class: 'p-0',
    }),
    content: () => ({
        class: 'p-0',
    }),
};
</script>

<style scoped>
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}
</style>