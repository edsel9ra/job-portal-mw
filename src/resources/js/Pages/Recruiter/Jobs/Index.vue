<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <!-- <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                        Portal del reclutador
                    </p> -->

                    <h2 class="mt-1 text-xl font-black uppercase tracking-tight text-slate-950">
                        Ofertas laborales
                    </h2>
                </div>

                <!--<Button :pt="ptButton"
                    class="!rounded-2xl !border-red-600 !bg-red-600 !px-5 !py-3 !text-sm !font-black !text-white !shadow-lg !shadow-red-600/25 hover:!border-red-700 hover:!bg-red-700"
                    label="Nueva oferta" @click="goTo(route('reclutador.jobs.create'))">
                    <template #icon>
                        <span class="material-symbols-outlined text-[18px]">add</span>
                    </template>
</Button>-->
            </div>
        </template>

        <div class="relative overflow-hidden px-8 py-8">
            <div class="pointer-events-none absolute left-[-160px] top-0 h-80 w-80 rounded-full bg-red-500/10 blur-3xl">
            </div>
            <div
                class="pointer-events-none absolute right-[-180px] top-40 h-96 w-96 rounded-full bg-blue-700/10 blur-3xl">
            </div>

            <div class="relative mx-auto max-w-6xl space-y-6">
                <!-- Flash success -->
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

                    <div class="relative grid gap-8 lg:grid-cols-[1fr_390px] lg:items-center">
                        <div>
                            <div
                                class="mb-5 inline-flex rounded-full bg-red-600/20 px-4 py-2 text-xs font-black uppercase tracking-[0.22em] text-red-100 ring-1 ring-red-400/20">
                                Gestión de vacantes
                            </div>

                            <h1 class="max-w-3xl text-3xl font-black leading-tight tracking-tight sm:text-4xl">
                                Administra las ofertas laborales publicadas.
                            </h1>

                            <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-300">
                                Busca, filtra, edita, revisa o elimina ofertas desde un solo lugar.
                            </p>

                            <!--<div class="mt-5 flex flex-wrap gap-2">
                                <span
                                    class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-3 py-2 text-xs font-bold text-slate-100 ring-1 ring-white/10">
                                    <span class="material-symbols-outlined text-[16px] text-red-300">work</span>
                                    {{ jobs.meta?.total ?? jobs.data?.length ?? 0 }} ofertas
                                </span>

                                <span
                                    class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-3 py-2 text-xs font-bold text-slate-100 ring-1 ring-white/10">
                                    <span class="material-symbols-outlined text-[16px] text-red-300">filter_alt</span>
                                    Filtros por estado
                                </span>
                            </div>-->
                        </div>

                        <!-- Buscador -->
                        <div class="rounded-3xl bg-white/10 p-4 shadow-xl ring-1 ring-white/10 backdrop-blur">
                            <p class="mb-3 text-sm font-bold text-white">
                                Buscar oferta
                            </p>

                            <div class="relative">
                                <span
                                    class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                                    <span class="material-symbols-outlined text-[20px]">search</span>
                                </span>

                                <InputText v-model="search" :pt="ptInputText"
                                    class="!w-full !rounded-2xl !border-white/10 !bg-white !py-3 !pl-12 !pr-12 !text-sm !font-medium !text-slate-800 !shadow-lg placeholder:!text-slate-400 focus:!border-red-500 focus:!ring-4 focus:!ring-red-500/20"
                                    placeholder="Buscar cargo o descripción…" @input="debouncedFetch" />

                                <button v-if="search" type="button"
                                    class="absolute inset-y-0 right-4 flex items-center text-sm font-black text-slate-400 transition hover:text-red-600"
                                    @click="resetFilters">
                                    ×
                                </button>
                            </div>

                            <p class="mt-3 text-xs leading-5 text-slate-300">
                                Puedes buscar por cargo, descripción o palabras clave.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Filtros -->
                <section class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                Filtros de Estado
                            </p>

                            <!--<h3 class="mt-1 text-lg font-black text-slate-950">
                                Estado de las ofertas
                            </h3>-->

                            <p class="mt-1 text-sm leading-6 text-slate-600">
                                Filtra las ofertas según su estado actual.
                            </p>
                        </div>

                        <Button v-if="search.trim() || activeTab !== 'ALL'" :pt="ptButton" outlined
                            class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-sm !font-bold !text-slate-700 hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
                            label="Limpiar" @click="resetFilters">
                            <template #icon>
                                <span class="material-symbols-outlined text-[18px]">close</span>
                            </template>
                        </Button>

                    </div>

                    <div class="flex flex-wrap gap-2">
                        <button v-for="tab in TABS" :key="tab.value" type="button"
                            class="inline-flex items-center rounded-2xl border px-4 py-2.5 text-sm font-bold transition"
                            :class="activeTab === tab.value
                                ? 'border-red-600 bg-red-600 text-white shadow-lg shadow-red-600/20'
                                : 'border-slate-200 bg-white text-slate-600 hover:border-red-200 hover:bg-red-50 hover:text-red-600'"
                            @click="setTab(tab.value)">
                            {{ tab.label }}
                        </button>
                    </div>
                </section>

                <!-- Cards -->
                <section class="grid gap-5">
                    <Card v-for="job in jobs.data" :key="job.id" :pt="ptCard"
                        class="transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/80">
                        <template #content>
                            <div class="grid gap-5 p-6 lg:grid-cols-[1fr_auto] lg:items-center">
                                <div class="min-w-0">
                                    <div class="mb-4 flex flex-wrap items-center gap-2">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-black"
                                            :class="statusPillClass(job.status)">
                                            {{ statusLabel(job.status) }}
                                        </span>

                                        <span
                                            class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">
                                            Publicado {{ timeAgo(job.created_at) }}
                                        </span>
                                    </div>

                                    <h2 class="text-xl font-black tracking-tight text-slate-950">
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
                                            <span
                                                class="material-symbols-outlined text-[16px] text-red-500">payments</span>
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

                                <!-- Acciones -->
                                <div
                                    class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 p-2 lg:flex-shrink-0">
                                    <Button :pt="ptIconButton" outlined title="Ver detalle" aria-label="Ver detalle"
                                        @click="goTo(route('reclutador.jobs.show', job.id))">
                                        <template #icon>
                                            <span class="material-symbols-outlined">description</span>
                                        </template>
                                    </Button>

                                    <Button :pt="ptIconButton" outlined title="Editar oferta" aria-label="Editar oferta"
                                        @click="goTo(route('reclutador.jobs.edit', job.id))">
                                        <template #icon>
                                            <span class="material-symbols-outlined">edit</span>
                                        </template>
                                    </Button>

                                    <Button :pt="ptIconDanger" outlined title="Eliminar oferta"
                                        aria-label="Eliminar oferta" @click="confirmDestroy(job)">
                                        <template #icon>
                                            <span class="material-symbols-outlined">delete</span>
                                        </template>
                                    </Button>
                                </div>
                            </div>
                        </template>
                    </Card>

                    <!-- Empty -->
                    <div v-if="!jobs.data?.length"
                        class="rounded-[2rem] border border-dashed border-slate-300 bg-white px-6 py-14 text-center shadow-sm">
                        <div
                            class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-slate-100 text-slate-500">
                            <span class="material-symbols-outlined text-[34px]">work_off</span>
                        </div>

                        <h3 class="mt-5 text-lg font-black text-slate-950">
                            No hay ofertas para mostrar
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                            Crea una nueva oferta o modifica los filtros aplicados.
                        </p>
                    </div>
                </section>

                <!-- Paginación -->
                <section v-if="jobs.meta"
                    class="flex flex-col items-center justify-between gap-4 rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm sm:flex-row">
                    <p class="text-sm font-medium text-slate-500">
                        Página
                        <span class="font-black text-slate-800">{{ jobs.meta.current_page }}</span>
                        de
                        <span class="font-black text-slate-800">{{ jobs.meta.last_page }}</span>
                    </p>

                    <div class="flex items-center gap-2">
                        <Button :pt="ptButton" outlined
                            class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-sm !font-bold !text-slate-700 hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
                            label="← Anterior" :disabled="!jobs.links?.prev" @click="go(jobs.meta.current_page - 1)" />

                        <div class="rounded-2xl bg-slate-950 px-4 py-2.5 text-sm font-black text-white">
                            {{ jobs.meta.current_page }}
                        </div>

                        <Button :pt="ptButton" outlined
                            class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-sm !font-bold !text-slate-700 hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
                            label="Siguiente →" :disabled="!jobs.links?.next" @click="go(jobs.meta.current_page + 1)" />
                    </div>
                </section>
            </div>
        </div>

        <!-- Dialog vista rápida -->
        <Dialog v-model:visible="quick.show" modal :draggable="false" :pt="ptDialog" class="w-full max-w-2xl">
            <template #header>
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-3">
                        <h3 class="truncate text-lg font-black text-slate-950">
                            {{ quick.job?.name_job }}
                        </h3>

                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-black"
                            :class="statusPillClass(quick.job?.status)">
                            {{ statusLabel(quick.job?.status) }}
                        </span>
                    </div>

                    <p class="mt-1 text-sm text-slate-500">
                        Sede: {{ quick.job?.branch?.name ?? 'Sin sede' }}
                        • $ {{ formatMoney(quick.job?.salary) }}
                        • {{ quick.job?.contract_type }}
                    </p>
                </div>
            </template>

            <p class="whitespace-pre-line text-sm leading-7 text-slate-600">
                {{ quick.job?.description }}
            </p>

            <template #footer>
                <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                    <Button :pt="ptButton" outlined class="!rounded-2xl !px-4 !py-2.5 !text-sm" label="Cerrar"
                        @click="closeQuickView" />

                    <Button :pt="ptButton" outlined class="!rounded-2xl !px-4 !py-2.5 !text-sm" label="Ver detalle"
                        @click="goTo(route('reclutador.jobs.show', quick.job?.id))" />

                    <Button :pt="ptButton"
                        class="!rounded-2xl !bg-red-600 !px-4 !py-2.5 !text-sm !text-white hover:!bg-red-700"
                        label="Editar" @click="goTo(route('reclutador.jobs.edit', quick.job?.id))" />
                </div>
            </template>
        </Dialog>

        <!-- Dialog confirmar eliminación -->
        <Dialog v-model:visible="deleteModal.show" modal :draggable="false" :pt="ptDialog" class="w-full max-w-md">
            <template #header>
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-red-600">
                        Confirmación
                    </p>

                    <h3 class="mt-1 text-lg font-black text-slate-950">
                        Eliminar oferta
                    </h3>
                </div>
            </template>

            <p class="text-sm leading-6 text-slate-600">
                ¿Seguro que deseas eliminar <b>{{ deleteModal.job?.name_job }}</b>? Esta acción no se puede deshacer.
            </p>

            <template #footer>
                <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                    <Button :pt="ptButton" outlined class="!rounded-2xl !px-4 !py-2.5 !text-sm" label="Cancelar"
                        @click="deleteModal.show = false" />

                    <Button :pt="ptButton"
                        class="!rounded-2xl !border-red-600 !bg-red-600 !px-4 !py-2.5 !text-sm !font-black !text-white hover:!border-red-700 hover:!bg-red-700"
                        :disabled="deleteForm.processing" :label="deleteForm.processing ? 'Eliminando…' : 'Eliminar'"
                        @click="doDestroy" />
                </div>
            </template>
        </Dialog>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useJobUtils } from '@/composables/useJobUtils';

// PrimeVue
import Button from 'primevue/button';
import Message from 'primevue/message';
import Card from 'primevue/card';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';

// PT
import { ptButton, ptMessage, ptDialog, ptInputText } from '@/primevue/pt';

const { statusLabel, statusPillClass, formatMoney, timeAgo } = useJobUtils();

const props = defineProps({
    jobs: Object,
    filters: Object,
});

const TABS = [
    { value: 'ALL', label: 'Todas' },
    { value: 'Abierta', label: 'Abiertas' },
    { value: 'Pausada', label: 'Pausadas' },
    { value: 'Cerrada', label: 'Cerradas' },
];

const search = ref(props.filters?.q ?? '');
const activeTab = ref(props.filters?.status ?? 'ALL');

const ptCard = {
    root: () => ({
        class: 'overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm',
    }),
    body: () => ({ class: 'p-0' }),
    content: () => ({ class: 'p-0' }),
};

const ptIconButton = {
    root: () => ({
        class:
            'inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 ' +
            'shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500/20',
    }),
};

const ptIconDanger = {
    root: () => ({
        class:
            'inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-red-200 bg-white text-red-600 ' +
            'shadow-sm transition hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500/20',
    }),
};

// Filtros
let debounceTimer = null;

function debouncedFetch() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => go(1), 350);
}

function setTab(tab) {
    activeTab.value = tab;
    go(1);
}

function resetFilters() {
    search.value = '';
    activeTab.value = 'ALL';
    go(1);
}

function go(page = 1) {
    const params = { page };

    if (search.value?.trim()) params.q = search.value.trim();
    if (activeTab.value !== 'ALL') params.status = activeTab.value;

    router.get(route('reclutador.jobs.index'), params, {
        preserveState: true,
        replace: true,
        preserveScroll: true,
    });
}

function goTo(href) {
    router.visit(href);
}

// Quick view
const quick = ref({ show: false, job: null });

function openQuickView(job) {
    quick.value = { show: true, job };
}

function closeQuickView() {
    quick.value = { show: false, job: null };
}

// Delete
const deleteModal = ref({ show: false, job: null });
const deleteForm = useForm({});

function confirmDestroy(job) {
    deleteModal.value = { show: true, job };
}

function doDestroy() {
    deleteForm.delete(route('reclutador.jobs.destroy', deleteModal.value.job.id), {
        onSuccess: () => {
            deleteModal.value = { show: false, job: null };
        },
    });
}
</script>

<style scoped>
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}
</style>