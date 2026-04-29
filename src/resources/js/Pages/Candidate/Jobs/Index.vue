<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <!--<p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                        Portal del candidato
                    </p>-->
                    <h2 class="mt-1 text-xl font-black uppercase tracking-tight text-slate-950">
                        Ofertas de Empleo Disponibles
                    </h2>
                </div>

                <!--<Link :href="resumeCreateHref"
                    class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-600">
                    Mi currículum
                </Link>-->
            </div>
        </template>

        <div class="relative overflow-hidden px-4 py-8">
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

                    <div class="relative grid gap-8 lg:grid-cols-[1fr_390px] lg:items-center">
                        <div>
                            <!--<div
                                class="mb-5 inline-flex rounded-full bg-red-600/20 px-4 py-2 text-xs font-black uppercase tracking-[0.22em] text-red-100 ring-1 ring-red-400/20">
                                Vacantes disponibles
                            </div>-->

                            <h1 class="max-w-3xl text-3xl font-black leading-tight tracking-tight sm:text-4xl">
                                Encuentra la oportunidad que mejor se ajuste a tu perfil.
                            </h1>

                            <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-300">
                                Explora las ofertas activas, revisa sus detalles y postúlate con tu currículum
                                registrado en la
                                plataforma.
                            </p>
                        </div>

                        <!-- Buscador -->
                        <div class="rounded-3xl bg-white/10 p-4 shadow-xl ring-1 ring-white/10 backdrop-blur">
                            <p class="mb-3 text-sm font-bold text-white">
                                Buscar ofertas
                            </p>

                            <div class="relative">
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                        <path d="M10.5 18a7.5 7.5 0 1 1 5.303-2.197L20 20" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" />
                                    </svg>
                                </div>

                                <input v-model="search" type="search"
                                    class="w-full rounded-2xl border border-white/10 bg-white py-3 pl-12 pr-12 text-sm font-medium text-slate-800 shadow-lg outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-4 focus:ring-red-500/20"
                                    placeholder="Buscar cargo o descripción..." @input="debouncedFetch" />

                                <button v-if="search" type="button"
                                    class="absolute inset-y-0 right-4 flex items-center text-sm font-black text-slate-400 transition hover:text-red-600"
                                    @click="clearSearch">
                                    ×
                                </button>
                            </div>

                            <p class="mt-3 text-xs leading-5 text-slate-300">
                                Puedes buscar por cargo, descripción o palabras clave.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Alerta sin curriculum -->
                <section v-if="!hasResume" class="rounded-[2rem] border border-amber-200 bg-amber-50 p-5 shadow-sm">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex gap-3">
                            <div
                                class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-amber-100 text-amber-700">
                                <span class="material-symbols-outlined">warning</span>
                            </div>

                            <div>
                                <p class="text-sm font-black text-amber-900">
                                    Necesitas un currículum para aplicar
                                </p>

                                <p class="mt-1 text-xs leading-5 text-amber-700">
                                    Créalo antes de postularte a una oferta laboral.
                                </p>
                            </div>
                        </div>

                        <Link :href="resumeCreateHref"
                            class="inline-flex items-center justify-center rounded-2xl bg-amber-900 px-5 py-3 text-sm font-black text-white shadow-lg shadow-amber-900/20 transition hover:bg-amber-950">
                            Crear currículum →
                        </Link>
                    </div>
                </section>

                <!-- Resumen -->
                <!--<section
                    class="flex flex-col gap-4 rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-black text-slate-950">
                            Ofertas disponibles
                        </p>

                        <p class="mt-1 text-sm text-slate-500">
                            {{ hasJobs ? 'Estas son las vacantes activas para aplicar.' : 'No se encontraron ofertas con los filtros aplicados.' }}
                        </p>
                    </div>

                    <div v-if="meta"
                        class="inline-flex w-fit items-center rounded-2xl bg-slate-100 px-4 py-2 text-sm font-bold text-slate-700">
                        Página {{ meta.current_page }} de {{ meta.last_page }}
                    </div>
                </section>-->

                <!-- Cards -->
                <section class="grid gap-5">
                    <article v-for="job in jobList" :key="job.id"
                        class="group overflow-hidden rounded-[2rem] border bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/80"
                        :class="yaAplico(job.id) ? 'border-green-200 bg-green-50/40' : 'border-slate-200 hover:border-red-200'">
                        <div class="grid gap-5 p-6 lg:grid-cols-[1fr_auto] lg:items-center">
                            <div class="min-w-0">
                                <div class="mb-4 flex flex-wrap items-center gap-2">
                                    <!--<span
                                        class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-black uppercase tracking-wide text-red-600">
                                        Vacante activa
                                    </span>-->

                                    <span v-if="yaVio(job.id)"
                                        class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-3 py-1 text-xs font-black text-blue-700">
                                        <span class="material-symbols-outlined text-[14px]">visibility</span>
                                        Visto
                                    </span>

                                    <span v-if="yaAplico(job.id)"
                                        class="inline-flex items-center gap-1 rounded-full bg-green-50 px-3 py-1 text-xs font-black text-green-700">
                                        <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                        Ya aplicaste
                                    </span>

                                    <span
                                        class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">
                                        Publicado {{ timeAgo(job.created_at) }}
                                    </span>
                                </div>

                                <h2
                                    class="text-xl font-black tracking-tight text-slate-950 transition group-hover:text-red-600">
                                    {{ job.name_job }}
                                </h2>

                                <div class="mt-4 flex flex-wrap gap-2">
                                    <span
                                        class="inline-flex items-center gap-2 rounded-2xl bg-slate-50 px-3 py-2 text-xs font-bold text-slate-600 ring-1 ring-slate-200">
                                        <span
                                            class="material-symbols-outlined text-[16px] text-red-500">location_on</span>
                                        {{ job.branch?.name ?? 'Sin sede' }}
                                    </span>

                                    <span
                                        class="inline-flex items-center gap-2 rounded-2xl bg-slate-50 px-3 py-2 text-xs font-bold text-slate-600 ring-1 ring-slate-200">
                                        <span class="material-symbols-outlined text-[16px] text-red-500">payments</span>
                                        $ {{ formatMoney(job.salary) }}
                                    </span>

                                    <span
                                        class="inline-flex items-center gap-2 rounded-2xl bg-slate-50 px-3 py-2 text-xs font-bold text-slate-600 ring-1 ring-slate-200">
                                        <span class="material-symbols-outlined text-[16px] text-red-500">work</span>
                                        {{ job.contract_type }}
                                    </span>
                                </div>

                                <p class="mt-4 line-clamp-2 text-sm leading-6 text-slate-500">
                                    {{ job.description }}
                                </p>
                            </div>

                            <div class="flex flex-col items-stretch gap-2 lg:items-end">
                                <Link :href="route('candidato.jobs.show', job.id)"
                                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-950 px-5 py-3 text-sm font-black text-white shadow-lg shadow-slate-300/70 transition hover:bg-red-600 hover:shadow-red-600/25">
                                    Ver oferta
                                    <span>→</span>
                                </Link>

                                <span v-if="yaAplico(job.id)"
                                    class="text-center text-xs font-bold text-green-700 lg:text-right">
                                    Estado: {{ estadoAplicacion(job.id) }}
                                </span>
                            </div>
                        </div>
                    </article>

                    <!-- Empty state -->
                    <div v-if="!hasJobs"
                        class="rounded-[2rem] border border-dashed border-slate-300 bg-white px-6 py-14 text-center shadow-sm">
                        <div
                            class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-slate-100 text-slate-500">
                            <span class="material-symbols-outlined text-[32px]">search_off</span>
                        </div>

                        <h3 class="mt-5 text-lg font-black text-slate-950">
                            No hay ofertas disponibles
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                            En este momento no encontramos vacantes relacionadas con tu búsqueda.
                        </p>

                        <button v-if="search" type="button"
                            class="mt-6 rounded-2xl bg-red-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-red-600/25 transition hover:bg-red-700"
                            @click="clearSearch">
                            Limpiar búsqueda
                        </button>
                    </div>
                </section>

                <!-- Paginación -->
                <section v-if="meta && meta.last_page > 1"
                    class="flex flex-col items-center justify-between gap-4 rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm sm:flex-row">
                    <p class="text-sm font-medium text-slate-500">
                        Mostrando página
                        <span class="font-black text-slate-800">{{ meta.current_page }}</span>
                        de
                        <span class="font-black text-slate-800">{{ meta.last_page }}</span>
                    </p>

                    <div class="flex items-center gap-2">
                        <button type="button"
                            class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-600 disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:border-slate-200 disabled:hover:bg-white disabled:hover:text-slate-700"
                            :disabled="!links?.prev" @click="go(meta.current_page - 1)">
                            ← Anterior
                        </button>

                        <div class="rounded-2xl bg-slate-950 px-4 py-2.5 text-sm font-black text-white">
                            {{ meta.current_page }}
                        </div>

                        <button type="button"
                            class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-600 disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:border-slate-200 disabled:hover:bg-white disabled:hover:text-slate-700"
                            :disabled="!links?.next" @click="go(meta.current_page + 1)">
                            Siguiente →
                        </button>
                    </div>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useJobUtils } from '@/composables/useJobUtils';

const { formatMoney, timeAgo } = useJobUtils();

const props = defineProps({
    jobs: { type: Object, required: true },
    filters: { type: Object, default: () => ({}) },
    aplicacionesMap: { type: Object, default: () => ({}) },
    vistosMap: { type: Object, default: () => ({}) },
    tieneCurriculum: { type: Boolean, default: false },
});

const page = usePage();

const jobList = computed(() => props.jobs?.data ?? []);
const hasJobs = computed(() => jobList.value.length > 0);
const meta = computed(() => props.jobs?.meta ?? null);
const links = computed(() => props.jobs?.links ?? null);

const hasResume = computed(() => {
    if (props.tieneCurriculum === true) return true;
    return !!page.props.candidate?.hasResume;
});

const resumeCreateHref = computed(() => route('candidato.resume.create'));

function yaAplico(jobId) {
    return Object.prototype.hasOwnProperty.call(props.aplicacionesMap, String(jobId));
}

function yaVio(jobId) {
    return Object.prototype.hasOwnProperty.call(props.vistosMap, String(jobId));
}

function estadoAplicacion(jobId) {
    return props.aplicacionesMap[String(jobId)] ?? '';
}

const search = ref(props.filters?.q ?? '');

let debounceTimer = null;

function debouncedFetch() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => go(1), 350);
}

function clearSearch() {
    search.value = '';
    go(1);
}

function go(pageNumber = 1) {
    const params = { page: pageNumber };

    if (search.value?.trim()) {
        params.q = search.value.trim();
    }

    router.get(route('candidato.jobs.index'), params, {
        preserveState: true,
        replace: true,
        preserveScroll: true,
    });
}
</script>

<style scoped>
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}
</style>