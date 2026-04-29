<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex min-w-0 flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div class="min-w-0">
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                        Detalle de oferta
                    </p>

                    <h2 class="mt-1 truncate text-xl font-black tracking-tight text-slate-950">
                        {{ job.name_job }}
                    </h2>
                </div>

                <!--<span class="inline-flex w-fit rounded-full px-3 py-1 text-xs font-black"
                    :class="statusPillClass(job.status)">
                    {{ statusLabel(job.status) }}
                </span>-->
            </div>
        </template>

        <div class="relative overflow-hidden px-8 py-8">
            <div class="pointer-events-none absolute left-[-160px] top-0 h-80 w-80 rounded-full bg-red-500/10 blur-3xl">
            </div>
            <div
                class="pointer-events-none absolute right-[-180px] top-40 h-96 w-96 rounded-full bg-blue-700/10 blur-3xl">
            </div>

            <div class="relative mx-auto max-w-6xl space-y-6">
                <!-- Flash -->
                <Message v-if="$page.props.flash?.success" :pt="ptMessage" severity="success" :closable="false"
                    class="!rounded-2xl !border !border-green-200 !bg-green-50 !text-green-700">
                    {{ $page.props.flash.success }}
                </Message>

                <!-- Toast simple -->
                <Message v-if="toast.show" :pt="ptMessage" :severity="toast.type" :closable="false"
                    class="!rounded-2xl">
                    {{ toast.message }}
                </Message>

                <!-- Breadcrumb -->
                <nav class="flex flex-wrap items-center gap-2 text-sm font-medium text-slate-500">
                    <Link :href="route('reclutador.jobs.index')" class="transition hover:text-red-600">
                        Ofertas
                    </Link>

                    <span>/</span>

                    <span class="text-slate-800">
                        {{ job.name_job }}
                    </span>
                </nav>

                <!-- Hero -->
                <section
                    class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 p-6 text-white shadow-2xl shadow-slate-300/60 sm:p-8">
                    <div
                        class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-red-600/30 blur-3xl">
                    </div>
                    <div
                        class="pointer-events-none absolute -bottom-24 left-10 h-72 w-72 rounded-full bg-blue-600/20 blur-3xl">
                    </div>

                    <div class="relative grid gap-8 lg:grid-cols-[1fr_360px] lg:items-center">
                        <div>
                            <div class="mb-5 flex flex-wrap gap-2">
                                <span
                                    class="inline-flex rounded-full bg-red-600/20 px-4 py-2 text-xs font-black uppercase tracking-[0.22em] text-red-100 ring-1 ring-red-400/20">
                                    Administración de vacante
                                </span>

                                <span class="inline-flex rounded-full px-4 py-2 text-xs font-black"
                                    :class="statusPillClass(job.status)">
                                    {{ statusLabel(job.status) }}
                                </span>
                            </div>

                            <h1 class="max-w-3xl text-3xl font-black leading-tight tracking-tight sm:text-4xl">
                                {{ job.name_job }}
                            </h1>
                            <p class="mt-4 text-sm leading-7 text-slate-300">
                                Administra esta oferta: estado, edición, duplicado, enlace público o eliminación.
                            </p>

                            <!--<div class="mt-5 flex flex-wrap gap-2">
                                <span
                                    class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-3 py-2 text-xs font-bold text-slate-100 ring-1 ring-white/10">
                                    <span class="material-symbols-outlined text-[16px] text-red-300">location_on</span>
                                    {{ job.branch?.name ?? 'Sin sede' }}
                                </span>

                                <span
                                    class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-3 py-2 text-xs font-bold text-slate-100 ring-1 ring-white/10">
                                    <span class="material-symbols-outlined text-[16px] text-red-300">payments</span>
                                    $ {{ formatMoney(job.salary) }}
                                </span>

                                <span
                                    class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-3 py-2 text-xs font-bold text-slate-100 ring-1 ring-white/10">
                                    <span class="material-symbols-outlined text-[16px] text-red-300">work</span>
                                    {{ job.contract_type }}
                                </span>
                            </div>-->
                        </div>

                        <!-- Acciones -->
                        <div class="rounded-3xl bg-white/10 p-4 shadow-xl ring-1 ring-white/10 backdrop-blur">
                            <div class="grid grid-cols-1 gap-3">
                                <Button :pt="ptButton"
                                    class="!w-full !rounded-2xl !border-red-600 !bg-red-600 !px-5 !py-3 !text-sm !font-black !text-white !shadow-lg !shadow-red-900/30 hover:!border-red-700 hover:!bg-red-700"
                                    label="Editar oferta" @click="go(route('reclutador.jobs.edit', job.id))">
                                    <template #icon>
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </template>
                                </Button>

                                <Button :pt="ptButton" outlined
                                    class="!w-full !rounded-2xl !border-white/15 !bg-white/10 !px-5 !py-3 !text-sm !font-bold !text-white hover:!bg-white/15"
                                    :disabled="duplicateForm.processing"
                                    :label="duplicateForm.processing ? 'Duplicando…' : 'Duplicar oferta'"
                                    @click="duplicateJob">
                                    <template #icon>
                                        <span class="material-symbols-outlined text-[18px]">content_copy</span>
                                    </template>
                                </Button>

                                <Button :pt="ptButton" outlined
                                    class="!w-full !rounded-2xl !border-white/15 !bg-white/10 !px-5 !py-3 !text-sm !font-bold !text-white hover:!bg-white/15"
                                    label="Copiar link público" @click="copyLink">
                                    <template #icon>
                                        <span class="material-symbols-outlined text-[18px]">link</span>
                                    </template>
                                </Button>

                                <Button :pt="ptButton" outlined
                                    class="!w-full !rounded-2xl !border-red-300/20 !bg-red-500/10 !px-5 !py-3 !text-sm !font-bold !text-red-100 hover:!bg-red-500/20"
                                    label="Eliminar oferta" @click="deleteModal = true">
                                    <template #icon>
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </template>
                                </Button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Botón volver -->
                <div>
                    <Button :pt="ptButton" outlined
                        class="!rounded-2xl !border-slate-200 !bg-white !px-4 !py-2.5 !text-sm !font-bold !text-slate-700 !shadow-sm hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600"
                        label="Volver a ofertas" @click="go(route('reclutador.jobs.index'))">
                        <template #icon>
                            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        </template>
                    </Button>
                </div>

                <!-- Layout -->
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <!-- Main -->
                    <section class="space-y-4 lg:col-span-2">
                        <Card :pt="ptCard">
                            <template #content>
                                <div class="p-6">
                                    <!-- Estado inline -->
                                    <div
                                        class="mb-5 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                        <div class="text-xs font-medium text-slate-400">
                                            Publicado {{ timeAgo(job.created_at) }}
                                            <span v-if="job.updated_at">
                                                • Actualizado {{ timeAgo(job.updated_at) }}
                                            </span>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="text-xs font-black uppercase tracking-[0.18em] text-slate-400">
                                                Estado
                                            </span>

                                            <Select v-model="statusDraft" :pt="ptSelect" :options="statusOptions"
                                                class="w-40" :disabled="statusForm.processing" @change="saveStatus" />

                                            <span v-if="statusForm.processing"
                                                class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-500">
                                                Guardando…
                                            </span>
                                        </div>
                                    </div>

                                    <hr class="mb-5 border-slate-100" />

                                    <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                        Descripción y funciones
                                    </p>

                                    <p class="mt-4 whitespace-pre-line text-sm leading-7 text-slate-600">
                                        {{ job.description }}
                                    </p>
                                </div>
                            </template>
                        </Card>
                    </section>

                    <!-- Sidebar -->
                    <aside class="space-y-4 lg:sticky lg:top-6 lg:self-start">
                        <Card :pt="ptCard">
                            <template #content>
                                <div class="p-5">
                                    <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-400">
                                        Salario
                                    </p>

                                    <p class="mt-2 text-2xl font-black text-slate-950">
                                        $ {{ formatMoney(job.salary) }}
                                    </p>
                                </div>
                            </template>
                        </Card>

                        <Card :pt="ptCard">
                            <template #content>
                                <div class="p-5">
                                    <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-400">
                                        Tipo de contrato
                                    </p>

                                    <p class="mt-2 text-lg font-black text-slate-950">
                                        {{ job.contract_type }}
                                    </p>
                                </div>
                            </template>
                        </Card>

                        <Card :pt="ptCard">
                            <template #content>
                                <div class="p-5">
                                    <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-400">
                                        Sede
                                    </p>

                                    <p class="mt-2 text-lg font-black text-slate-950">
                                        {{ job.branch?.name ?? 'Sin sede' }}
                                    </p>
                                </div>
                            </template>
                        </Card>
                    </aside>
                </div>
            </div>
        </div>

        <!-- Dialog eliminar -->
        <Dialog v-model:visible="deleteModal" modal :draggable="false" :pt="ptDialog" class="w-full max-w-md">
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
                ¿Seguro que deseas eliminar esta oferta? Esta acción no se puede deshacer.
            </p>

            <template #footer>
                <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                    <Button :pt="ptButton" outlined class="!rounded-2xl !px-4 !py-2.5 !text-sm" label="Cancelar"
                        @click="deleteModal = false" />

                    <Button :pt="ptButton"
                        class="!rounded-2xl !border-red-600 !bg-red-600 !px-4 !py-2.5 !text-sm !font-black !text-white hover:!border-red-700 hover:!bg-red-700"
                        :disabled="deleteForm.processing" :label="deleteForm.processing ? 'Eliminando…' : 'Eliminar'"
                        @click="doDelete" />
                </div>
            </template>
        </Dialog>
    </AuthenticatedLayout>
</template>

<script setup>
import { computed, ref } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useJobUtils } from '@/composables/useJobUtils';

// PrimeVue
import Button from 'primevue/button';
import Message from 'primevue/message';
import Card from 'primevue/card';
import Dialog from 'primevue/dialog';
import Select from 'primevue/select';

// PT
import { ptButton, ptMessage, ptDialog, ptSelect } from '@/primevue/pt';

const { statusLabel, statusPillClass, formatMoney, timeAgo } = useJobUtils();

const props = defineProps({
    job: { type: Object, required: true },
});

const job = props.job;

const ptCard = {
    root: () => ({
        class: 'overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm',
    }),
    body: () => ({ class: 'p-0' }),
    content: () => ({ class: 'p-0' }),
};

// Links
const publicLink = computed(() => `${window.location.origin}/ofertas/${job.id}`);

function go(href) {
    router.visit(href);
}

function openNewTab(url) {
    window.open(url, '_blank', 'noopener,noreferrer');
}

// Estado inline
const statusOptions = ['Abierta', 'Pausada', 'Cerrada'];
const statusDraft = ref(job.status);
const statusForm = useForm({ status: job.status });

function saveStatus() {
    statusForm.status = statusDraft.value;

    statusForm.patch(route('reclutador.jobs.updateStatus', job.id), {
        preserveScroll: true,
        onError: () => {
            statusDraft.value = job.status;
        },
        onSuccess: () => {
            job.status = statusDraft.value;
        },
    });
}

// Duplicar
const duplicateForm = useForm({});

function duplicateJob() {
    duplicateForm.post(route('reclutador.jobs.duplicate', job.id));
}

// Eliminar
const deleteModal = ref(false);
const deleteForm = useForm({});

function doDelete() {
    deleteForm.delete(route('reclutador.jobs.destroy', job.id));
}

// Copiar link
const toast = ref({ show: false, type: 'success', message: '' });
let toastTimer = null;

function showToast(type, message) {
    toast.value = { show: true, type, message };
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => {
        toast.value.show = false;
    }, 2200);
}

async function copyLink() {
    const url = publicLink.value;

    try {
        await navigator.clipboard.writeText(url);
        showToast('success', 'Link copiado ✅');
    } catch {
        showToast('error', 'No se pudo copiar el link');
    }
}
</script>

<style scoped>
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}
</style>