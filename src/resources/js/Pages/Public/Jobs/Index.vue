<script setup>
import { ref, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { useJobUtils } from '@/composables/useJobUtils';

const { formatMoney, timeAgo } = useJobUtils();

const props = defineProps({
    jobs: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

const search = ref(props.filters?.q ?? '');

const jobList = computed(() => props.jobs?.data ?? []);
const hasJobs = computed(() => jobList.value.length > 0);
const meta = computed(() => props.jobs?.meta ?? null);
const links = computed(() => props.jobs?.links ?? null);

let debounceTimer = null;

function debouncedFetch() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => go(1), 350);
}

function clearSearch() {
    search.value = '';
    go(1);
}

function go(page = 1) {
    const params = { page };

    if (search.value?.trim()) {
        params.q = search.value.trim();
    }

    router.get(route('jobs.index'), params, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
}
</script>

<template>
    <PublicLayout>
        <template #header>
            <div>
                <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                    Portal de empleo
                </p>

                <h1 class="mt-1 truncate text-xl font-black uppercase text-slate-950">
                    Ofertas disponibles
                </h1>
            </div>
        </template>

        <div class="space-y-8">
            <!-- Hero -->
            <section
                class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 px-6 py-8 text-white shadow-2xl shadow-slate-300/50 sm:px-8 lg:px-10">
                <div
                    class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-red-600/30 blur-3xl">
                </div>

                <div
                    class="pointer-events-none absolute -bottom-24 left-10 h-72 w-72 rounded-full bg-blue-600/20 blur-3xl">
                </div>

                <div class="relative grid gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                    <div>
                        <h2 class="max-w-2xl text-3xl font-black leading-tight tracking-tight sm:text-4xl">
                            Encuentra tu próxima oportunidad laboral en Mister Wings.
                        </h2>

                        <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-300 sm:text-base">
                            Explora las vacantes disponibles, revisa los detalles de cada oferta y postúlate al cargo que mejor se ajuste a tu perfil.
                        </p>
                    </div>

                    <!-- Buscador -->
                    <div class="rounded-3xl bg-white/10 p-4 shadow-xl ring-1 ring-white/10 backdrop-blur">
                        <p class="mb-3 text-sm font-bold text-white">
                            Buscar ofertas
                        </p>

                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                    <path d="M10.5 18a7.5 7.5 0 1 1 5.303-2.197L20 20" stroke="currentColor"
                                        stroke-width="1.8" stroke-linecap="round" />
                                </svg>
                            </div>

                            <input v-model="search"
                                class="w-full rounded-2xl border border-white/10 bg-white py-3 pl-12 pr-12 text-sm font-medium text-slate-800 shadow-lg outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-4 focus:ring-red-500/20"
                                placeholder="Buscar cargo o descripción..." type="search" @input="debouncedFetch" />

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

            <!-- Resumen -->
            <!--<section
                class="flex flex-col gap-4 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-black text-slate-950">
                        Ofertas de empleo
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ hasJobs ? 'Estas son las oportunidades disponibles actualmente.' : 'No se encontraron ofertas con los filtros aplicados.' }}
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
                    class="group overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-red-200 hover:shadow-xl hover:shadow-slate-200/80">
                    <div class="grid gap-5 p-6 lg:grid-cols-[1fr_auto] lg:items-center">
                        <div class="min-w-0">
                            <!--<div class="mb-4 flex flex-wrap items-center gap-2">
                                <span
                                    class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-black uppercase tracking-wide text-red-600">
                                    Vacante activa
                                </span>

                                <span
                                    class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">
                                    Publicado {{ timeAgo(job.created_at) }}
                                </span>
                            </div>-->

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

                        <div class="flex lg:justify-end">
                            <Link :href="route('jobs.show', job.id)"
                                class="group/link inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-slate-950 px-5 py-3 text-sm font-black text-white shadow-lg shadow-slate-300/70 transition hover:bg-red-600 hover:shadow-red-600/25 sm:w-auto">
                                Ver oferta

                                <span class="transition group-hover/link:translate-x-1">
                                    →
                                </span>
                            </Link>
                        </div>
                    </div>
                </article>

                <!-- Empty state -->
                <div v-if="!hasJobs"
                    class="rounded-[2rem] border border-dashed border-slate-300 bg-white px-6 py-14 text-center shadow-sm">
                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-slate-100 text-slate-500">
                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none">
                            <path d="M10.5 18a7.5 7.5 0 1 1 5.303-2.197L20 20" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" />
                        </svg>
                    </div>

                    <h3 class="mt-5 text-lg font-black text-slate-950">
                        No hay ofertas disponibles
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                        En este momento no encontramos vacantes relacionadas con tu búsqueda. Intenta con otra palabra
                        clave.
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
                class="flex flex-col items-center justify-between gap-4 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:flex-row">
                <p class="text-sm font-medium text-slate-500">
                    Mostrando página
                    <span class="font-black text-slate-800">{{ meta.current_page }}</span>
                    de
                    <span class="font-black text-slate-800">{{ meta.last_page }}</span>
                </p>

                <div class="flex items-center gap-2">
                    <button
                        class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-600 disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:border-slate-200 disabled:hover:bg-white disabled:hover:text-slate-700"
                        :disabled="!links?.prev" type="button" @click="go(meta.current_page - 1)">
                        ← Anterior
                    </button>

                    <div class="rounded-2xl bg-slate-950 px-4 py-2.5 text-sm font-black text-white">
                        {{ meta.current_page }}
                    </div>

                    <button
                        class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-600 disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:border-slate-200 disabled:hover:bg-white disabled:hover:text-slate-700"
                        :disabled="!links?.next" type="button" @click="go(meta.current_page + 1)">
                        Siguiente →
                    </button>
                </div>
            </section>
        </div>
    </PublicLayout>
</template>
