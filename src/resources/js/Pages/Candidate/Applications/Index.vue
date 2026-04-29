<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <!--<p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                        Portal del candidato
                    </p>-->

                    <h2 class="mt-1 text-xl font-black uppercase tracking-tight text-slate-950">
                        Mis aplicaciones
                    </h2>
                </div>

                <!--<Link :href="route('candidato.jobs.index')"
                    class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-600">
                    Buscar ofertas
                    <span class="ml-2">→</span>
                </Link>-->
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

                    <div class="relative grid gap-6 lg:grid-cols-[1fr_320px] lg:items-center">
                        <div>
                            <div
                                class="mb-5 inline-flex rounded-full bg-red-600/20 px-4 py-2 text-xs font-black uppercase tracking-[0.22em] text-red-100 ring-1 ring-red-400/20">
                                Seguimiento de postulaciones
                            </div>

                            <h1 class="max-w-3xl text-3xl font-black leading-tight tracking-tight sm:text-4xl">
                                Consulta el estado de tus aplicaciones.
                            </h1>

                            <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-300">
                                Revisa en qué etapa se encuentra cada postulación, consulta el proceso y retira una
                                aplicación
                                si aún está pendiente de revisión.
                            </p>
                        </div>

                        <div class="rounded-3xl bg-white/10 p-5 shadow-xl ring-1 ring-white/10 backdrop-blur">
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-600 text-white shadow-lg shadow-red-900/30">
                                    <span class="material-symbols-outlined">send</span>
                                </div>

                                <div>
                                    <p class="text-sm font-black text-white">
                                        Total de aplicaciones
                                    </p>

                                    <p class="mt-1 text-4xl font-black text-white">
                                        {{ totalAplicaciones }}
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-300">
                                        Postulaciones registradas en tu cuenta.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Flash -->
                <div v-if="$page.props.flash?.success"
                    class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-700 shadow-sm">
                    {{ $page.props.flash.success }}
                </div>

                <!-- Tabs por estado -->
                <section class="rounded-[2rem] border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="mb-4 flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                Filtros de Estado
                            </p>

                            <!--<h3 class="mt-1 text-lg font-black text-slate-950">
                                Estado de la aplicación
                            </h3>-->
                        </div>

                        <!--<p class="text-sm text-slate-500">
                            Estado actual:
                            <span class="font-black text-slate-800">
                                {{ activeTabLabel }}
                            </span>
                        </p>-->
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <button v-for="tab in tabs" :key="tab.value" type="button"
                            class="inline-flex items-center gap-2 rounded-2xl border px-4 py-2.5 text-sm font-bold transition"
                            :class="activeTab === tab.value
                                ? 'border-red-600 bg-red-600 text-white shadow-lg shadow-red-600/20'
                                : 'border-slate-200 bg-white text-slate-600 hover:border-red-200 hover:bg-red-50 hover:text-red-600'"
                            @click="setTab(tab.value)">
                            <span class="h-2 w-2 rounded-full"
                                :class="activeTab === tab.value ? 'bg-white' : statusDotClass(tab.value)"></span>

                            {{ tab.label }}

                            <span v-if="conteo[tab.value] !== undefined"
                                class="rounded-full px-2 py-0.5 text-xs font-black"
                                :class="activeTab === tab.value ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500'">
                                {{ conteo[tab.value] }}
                            </span>
                        </button>
                    </div>
                </section>

                <!-- Lista -->
                <section class="grid gap-5">
                    <article v-for="application in applicationList" :key="application.id"
                        class="group overflow-hidden rounded-[2rem] border bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/80"
                        :class="cardBorderClass(application.status)">
                        <div class="grid gap-5 p-6 lg:grid-cols-[1fr_auto] lg:items-center">
                            <div class="min-w-0">
                                <div class="mb-4 flex flex-wrap items-center gap-2">
                                    <span
                                        class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-black"
                                        :class="pillClass(application.status)">
                                        {{ statusLabel(application.status) }}
                                    </span>

                                    <span
                                        class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">
                                        Aplicaste {{ timeAgo(application.applied_at) }}
                                    </span>

                                    <span v-if="application.reviewed_at"
                                        class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">
                                        Revisado {{ timeAgo(application.reviewed_at) }}
                                    </span>
                                </div>

                                <h2
                                    class="text-xl font-black tracking-tight text-slate-950 transition group-hover:text-red-600">
                                    {{ application.job?.name_job }}
                                </h2>

                                <div class="mt-4 flex flex-wrap gap-2">
                                    <span
                                        class="inline-flex items-center gap-2 rounded-2xl bg-slate-50 px-3 py-2 text-xs font-bold text-slate-600 ring-1 ring-slate-200">
                                        <span
                                            class="material-symbols-outlined text-[16px] text-red-500">location_on</span>
                                        {{ application.job?.branch?.name ?? 'Sin sede' }}
                                    </span>

                                    <span
                                        class="inline-flex items-center gap-2 rounded-2xl bg-slate-50 px-3 py-2 text-xs font-bold text-slate-600 ring-1 ring-slate-200">
                                        <span class="material-symbols-outlined text-[16px] text-red-500">payments</span>
                                        $ {{ formatMoney(application.job?.salary) }}
                                    </span>

                                    <span
                                        class="inline-flex items-center gap-2 rounded-2xl bg-slate-50 px-3 py-2 text-xs font-bold text-slate-600 ring-1 ring-slate-200">
                                        <span class="material-symbols-outlined text-[16px] text-red-500">work</span>
                                        {{ application.job?.contract_type }}
                                    </span>
                                </div>

                                <div v-if="application.cover_letter"
                                    class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                    <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-400">
                                        Carta de presentación
                                    </p>

                                    <p class="mt-2 line-clamp-2 text-sm italic leading-6 text-slate-500">
                                        “{{ application.cover_letter }}”
                                    </p>
                                </div>

                                <div v-if="application.status === 'Rechazado' && application.rejection_reason"
                                    class="mt-4 rounded-2xl border border-red-100 bg-red-50 px-4 py-3 text-sm leading-6 text-red-700">
                                    <span class="font-black">Motivo:</span>
                                    {{ application.rejection_reason }}
                                </div>
                            </div>

                            <div class="flex flex-col items-stretch gap-2 lg:items-end">
                                <Link :href="route('candidato.applications.show', application.id)"
                                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-950 px-5 py-3 text-sm font-black text-white shadow-lg shadow-slate-300/70 transition hover:bg-red-600 hover:shadow-red-600/25">
                                    Ver proceso
                                    <span>→</span>
                                </Link>

                                <button v-if="application.status === 'Aplicado'" type="button"
                                    class="inline-flex items-center justify-center rounded-2xl border border-red-200 bg-white px-5 py-3 text-sm font-bold text-red-600 transition hover:bg-red-50"
                                    @click="retirar(application.id)">
                                    Retirar
                                </button>
                            </div>
                        </div>
                    </article>

                    <!-- Empty state -->
                    <div v-if="!applicationList.length"
                        class="rounded-[2rem] border border-dashed border-slate-300 bg-white px-6 py-14 text-center shadow-sm">
                        <div
                            class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-slate-100 text-slate-500">
                            <span class="material-symbols-outlined text-[32px]">inventory_2</span>
                        </div>

                        <h3 class="mt-5 text-lg font-black text-slate-950">
                            {{ activeTab === 'ALL'
                                ? 'No tienes aplicaciones aún'
                                : `Sin aplicaciones en estado "${activeTab}"` }}
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                            Explora las ofertas disponibles y postúlate a la vacante que mejor se ajuste a tu perfil.
                        </p>

                        <Link :href="route('candidato.jobs.index')"
                            class="mt-6 inline-flex rounded-2xl bg-red-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-red-600/25 transition hover:bg-red-700">
                            Explorar ofertas →
                        </Link>
                    </div>
                </section>

                <!-- Paginación -->
                <section v-if="aplicaciones.meta?.last_page > 1"
                    class="flex flex-col items-center justify-between gap-4 rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm sm:flex-row">
                    <p class="text-sm font-medium text-slate-500">
                        Mostrando página
                        <span class="font-black text-slate-800">{{ aplicaciones.meta.current_page }}</span>
                        de
                        <span class="font-black text-slate-800">{{ aplicaciones.meta.last_page }}</span>
                    </p>

                    <div class="flex items-center gap-2">
                        <button type="button"
                            class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-600 disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:border-slate-200 disabled:hover:bg-white disabled:hover:text-slate-700"
                            :disabled="!aplicaciones.links?.prev" @click="go(aplicaciones.meta.current_page - 1)">
                            ← Anterior
                        </button>

                        <div class="rounded-2xl bg-slate-950 px-4 py-2.5 text-sm font-black text-white">
                            {{ aplicaciones.meta.current_page }}
                        </div>

                        <button type="button"
                            class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-600 disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:border-slate-200 disabled:hover:bg-white disabled:hover:text-slate-700"
                            :disabled="!aplicaciones.links?.next" @click="go(aplicaciones.meta.current_page + 1)">
                            Siguiente →
                        </button>
                    </div>
                </section>
            </div>
        </div>

        <!-- Modal confirmar retiro -->
        <div v-if="retirarModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 p-4 backdrop-blur-sm">
            <div class="w-full max-w-md overflow-hidden rounded-[2rem] bg-white shadow-2xl shadow-black/40">
                <div
                    class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 px-6 py-6 text-white">
                    <div
                        class="pointer-events-none absolute -right-16 -top-16 h-40 w-40 rounded-full bg-red-600/30 blur-3xl">
                    </div>

                    <div class="relative flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.22em] text-red-200">
                                Confirmación
                            </p>

                            <h3 class="mt-2 text-xl font-black">
                                Retirar aplicación
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-slate-300">
                                Esta acción retirará tu postulación del proceso actual.
                            </p>
                        </div>

                        <button type="button"
                            class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-2xl bg-white/10 text-white transition hover:bg-white/20"
                            @click="retirarModal = false">
                            ✕
                        </button>
                    </div>
                </div>

                <div class="px-6 py-6">
                    <p class="text-sm leading-6 text-slate-600">
                        ¿Seguro que deseas retirar esta postulación? Esta acción no se puede deshacer.
                    </p>

                    <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <button type="button"
                            class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-50"
                            @click="retirarModal = false">
                            Cancelar
                        </button>

                        <button type="button"
                            class="rounded-2xl bg-red-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-red-600/25 transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-60"
                            :disabled="procesando" @click="confirmRetirar">
                            {{ procesando ? 'Retirando...' : 'Retirar aplicación' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { computed, ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useJobUtils } from '@/composables/useJobUtils';

const { formatMoney, timeAgo } = useJobUtils();

const props = defineProps({
    aplicaciones: { type: Object, required: true },
    conteo: { type: Object, default: () => ({}) },
    statuses: { type: Array, default: () => [] },
    filters: { type: Object, default: () => ({}) },
});

const tabs = computed(() => [
    { value: 'ALL', label: 'Todas' },
    ...props.statuses.map((status) => ({
        value: status,
        label: status,
    })),
]);

const applicationList = computed(() => props.aplicaciones?.data ?? []);
const totalAplicaciones = computed(() => props.conteo?.ALL ?? applicationList.value.length);

const activeTab = ref(props.filters?.status ?? 'ALL');

const activeTabLabel = computed(() => {
    return activeTab.value === 'ALL' ? 'Todas' : activeTab.value;
});

function setTab(value) {
    activeTab.value = value;
    go(1);
}

function go(page = 1) {
    const params = { page };

    if (activeTab.value !== 'ALL') {
        params.status = activeTab.value;
    }

    router.get(route('candidato.applications.index'), params, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
}

const retirarModal = ref(false);
const pendingId = ref(null);
const procesando = ref(false);

function retirar(id) {
    pendingId.value = id;
    retirarModal.value = true;
}

function confirmRetirar() {
    procesando.value = true;

    router.delete(route('candidato.applications.destroy', pendingId.value), {
        preserveScroll: true,
        onFinish: () => {
            procesando.value = false;
            retirarModal.value = false;
            pendingId.value = null;
        },
    });
}

const STATUS_CONFIG = {
    Aplicado: {
        label: 'Aplicado',
        pill: 'bg-yellow-100 text-yellow-800',
        dot: 'bg-yellow-500',
        card: 'border-yellow-200 hover:border-yellow-300',
    },
    'En Revisión': {
        label: 'En revisión',
        pill: 'bg-blue-100 text-blue-700',
        dot: 'bg-blue-500',
        card: 'border-blue-200 hover:border-blue-300',
    },
    Entrevista: {
        label: 'Entrevista',
        pill: 'bg-purple-100 text-purple-700',
        dot: 'bg-purple-500',
        card: 'border-purple-200 hover:border-purple-300',
    },
    Rechazado: {
        label: 'Rechazado',
        pill: 'bg-red-100 text-red-600',
        dot: 'bg-red-500',
        card: 'border-red-200 hover:border-red-300',
    },
    Contratado: {
        label: 'Contratado',
        pill: 'bg-green-100 text-green-700',
        dot: 'bg-green-500',
        card: 'border-green-200 hover:border-green-300',
    },
};

function statusLabel(status) {
    return STATUS_CONFIG[status]?.label ?? status;
}

function pillClass(status) {
    return STATUS_CONFIG[status]?.pill ?? 'bg-slate-100 text-slate-600';
}

function statusDotClass(status) {
    if (status === 'ALL') return 'bg-slate-400';

    return STATUS_CONFIG[status]?.dot ?? 'bg-slate-400';
}

function cardBorderClass(status) {
    return STATUS_CONFIG[status]?.card ?? 'border-slate-200 hover:border-red-200';
}
</script>

<style scoped>
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}
</style>