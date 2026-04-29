<template>
    <AuthenticatedLayout>
        <template #header>
            <div>
                <!--<p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                    Detalle de oferta
                </p>-->

                <h2 class="mt-1 truncate text-xl font-black uppercase tracking-tight text-slate-950">
                    Detalle de oferta
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
                <!-- Breadcrumb -->
                <nav class="flex flex-wrap items-center gap-2 text-sm font-medium text-slate-500">
                    <Link :href="route('candidato.jobs.index')" class="transition hover:text-red-600">
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

                    <div class="relative grid gap-8 lg:grid-cols-[1fr_320px] lg:items-center">
                        <div>
                            <div class="mb-5 flex flex-wrap gap-2">
                                <!--<span
                                    class="inline-flex rounded-full bg-red-600/20 px-4 py-2 text-xs font-black uppercase tracking-[0.22em] text-red-100 ring-1 ring-red-400/20">
                                    Vacante activa
                                </span>-->

                                <span
                                    class="inline-flex rounded-full bg-white/10 px-4 py-2 text-xs font-bold text-slate-200 ring-1 ring-white/10">
                                    Publicado {{ timeAgo(job.created_at) }}
                                </span>
                            </div>

                            <h1 class="max-w-3xl text-3xl font-black leading-tight tracking-tight sm:text-4xl">
                                {{ job.name_job }}
                            </h1>

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

                        <!-- CTA principal -->
                        <div class="rounded-3xl bg-white/10 p-4 shadow-xl ring-1 ring-white/10 backdrop-blur">
                            <!-- Ya aplicó -->
                            <div v-if="aplicacion" class="text-center">
                                <span
                                    class="inline-flex w-full items-center justify-center rounded-2xl px-5 py-3 text-sm font-black"
                                    :class="pillClass(aplicacion.status)">
                                    {{ statusLabel(aplicacion.status) }}
                                </span>

                                <p class="mt-3 text-xs font-medium text-slate-300">
                                    Aplicaste {{ timeAgo(aplicacion.applied_at) }}
                                </p>

                                <p v-if="aplicacion.status === 'Rechazado' && aplicacion.rejection_reason"
                                    class="mt-3 rounded-2xl bg-red-500/10 px-4 py-3 text-xs leading-5 text-red-100 ring-1 ring-red-300/20">
                                    {{ aplicacion.rejection_reason }}
                                </p>
                            </div>

                            <!-- Sin curriculum -->
                            <div v-else-if="!tieneCurriculum" class="text-center">
                                <button disabled type="button"
                                    class="inline-flex w-full cursor-not-allowed items-center justify-center rounded-2xl bg-white/10 px-5 py-3 text-sm font-black text-slate-400 ring-1 ring-white/10">
                                    Aplicar ahora
                                </button>

                                <p class="mt-3 text-xs leading-5 text-amber-200">
                                    Necesitas un
                                    <Link :href="route('candidato.resume.create')" class="font-black underline">
                                        currículum
                                    </Link>
                                    para aplicar.
                                </p>
                            </div>

                            <!-- Puede aplicar -->
                            <button v-else type="button"
                                class="inline-flex w-full items-center justify-center rounded-2xl bg-red-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-red-900/30 transition hover:bg-red-700"
                                @click="abrirModal">
                                Aplicar ahora
                            </button>
                        </div>
                    </div>
                </section>

                <!-- Contenido -->
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <!-- Descripción -->
                    <section class="lg:col-span-2">
                        <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                            <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
                                <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                    Descripción y funciones
                                </p>

                                <h3 class="mt-2 text-xl font-black text-slate-950">
                                    Información de la vacante
                                </h3>
                            </div>

                            <div class="px-6 py-6">
                                <p class="whitespace-pre-line text-sm leading-7 text-slate-600">
                                    {{ job.description }}
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- Sidebar info -->
                    <aside class="space-y-4 lg:sticky lg:top-6 lg:self-start">
                        <div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-400">
                                Salario
                            </p>

                            <p class="mt-2 text-2xl font-black text-slate-950">
                                $ {{ formatMoney(job.salary) }}
                            </p>
                        </div>

                        <div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-400">
                                Tipo de contrato
                            </p>

                            <p class="mt-2 text-lg font-black text-slate-950">
                                {{ job.contract_type }}
                            </p>
                        </div>

                        <div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-400">
                                Sede
                            </p>

                            <p class="mt-2 text-lg font-black text-slate-950">
                                {{ job.branch?.name ?? 'Sin sede' }}
                            </p>
                        </div>

                        <div v-if="aplicacion" class="rounded-[2rem] border border-green-100 bg-green-50 p-5">
                            <p class="text-sm font-black text-green-800">
                                Ya aplicaste a esta oferta
                            </p>

                            <p class="mt-2 text-sm leading-6 text-green-700">
                                Puedes consultar el estado de tus postulaciones desde la sección Mis aplicaciones.
                            </p>

                            <Link :href="route('candidato.applications.index')"
                                class="mt-4 inline-flex rounded-2xl bg-green-700 px-4 py-2.5 text-sm font-black text-white transition hover:bg-green-800">
                                Ver mis aplicaciones
                            </Link>
                        </div>

                        <div v-else-if="!tieneCurriculum"
                            class="rounded-[2rem] border border-amber-200 bg-amber-50 p-5">
                            <p class="text-sm font-black text-amber-900">
                                Completa tu currículum
                            </p>

                            <p class="mt-2 text-sm leading-6 text-amber-700">
                                Antes de aplicar, debes registrar tu currículum en la plataforma.
                            </p>

                            <Link :href="route('candidato.resume.create')"
                                class="mt-4 inline-flex rounded-2xl bg-amber-900 px-4 py-2.5 text-sm font-black text-white transition hover:bg-amber-950">
                                Crear currículum
                            </Link>
                        </div>

                        <div v-else class="rounded-[2rem] border border-red-100 bg-red-50 p-5">
                            <p class="text-sm font-black text-red-700">
                                ¿Te interesa esta oferta?
                            </p>

                            <p class="mt-2 text-sm leading-6 text-red-700/80">
                                Revisa la descripción y postúlate si tu perfil se ajusta al cargo.
                            </p>
                        </div>
                    </aside>
                </div>
            </div>
        </div>

        <!-- Modal aplicar -->
        <div v-if="modal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 p-4 backdrop-blur-sm">
            <div class="w-full max-w-xl overflow-hidden rounded-[2rem] bg-white shadow-2xl shadow-black/40">
                <div
                    class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 px-6 py-6 text-white">
                    <div
                        class="pointer-events-none absolute -right-16 -top-16 h-40 w-40 rounded-full bg-red-600/30 blur-3xl">
                    </div>

                    <div class="relative flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.22em] text-red-200">
                                Aplicación
                            </p>

                            <h3 class="mt-2 text-xl font-black">
                                {{ job.name_job }}
                            </h3>

                            <p class="mt-2 text-sm text-slate-300">
                                Completa tu aplicación para enviar tu perfil al equipo de reclutamiento.
                            </p>
                        </div>

                        <button type="button"
                            class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-2xl bg-white/10 text-white transition hover:bg-white/20"
                            @click="cerrarModal">
                            ✕
                        </button>
                    </div>
                </div>

                <form class="space-y-5 px-6 py-6" @submit.prevent="submitAplicacion">
                    <div>
                        <label for="cover_letter" class="block text-sm font-black text-slate-800">
                            Carta de presentación
                            <span class="font-medium text-slate-400">
                                (opcional)
                            </span>
                        </label>

                        <textarea id="cover_letter" v-model="form.cover_letter"
                            class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm leading-6 text-slate-700 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:bg-white focus:ring-4 focus:ring-red-500/20"
                            rows="5"
                            placeholder="Cuéntale al reclutador por qué eres la persona ideal para esta vacante..." />

                        <p v-if="form.errors.cover_letter" class="mt-2 text-xs font-semibold text-red-500">
                            {{ form.errors.cover_letter }}
                        </p>

                        <p v-if="form.errors.job_id" class="mt-2 text-xs font-semibold text-red-500">
                            {{ form.errors.job_id }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm leading-6 text-slate-600">
                        <p class="font-black text-slate-800">
                            ¿Qué se enviará?
                        </p>

                        <p class="mt-1">
                            Se enviará tu currículum registrado en la plataforma junto con tu carta de presentación, si
                            decides
                            escribirla.
                        </p>
                    </div>

                    <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
                        <button type="button"
                            class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-50"
                            @click="cerrarModal">
                            Cancelar
                        </button>

                        <button type="submit"
                            class="rounded-2xl bg-red-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-red-600/25 transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-60"
                            :disabled="form.processing">
                            {{ form.processing ? 'Enviando...' : 'Enviar aplicación' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useJobUtils } from '@/composables/useJobUtils';

const { formatMoney, timeAgo } = useJobUtils();

const props = defineProps({
    job: { type: Object, required: true },
    aplicacion: { type: Object, default: null },
    tieneCurriculum: { type: Boolean, default: false },
});

const modal = ref(false);

function abrirModal() {
    modal.value = true;
}

function cerrarModal() {
    modal.value = false;
    form.clearErrors();
}

const form = useForm({
    job_id: props.job.id,
    cover_letter: '',
});

function submitAplicacion() {
    form.post(route('candidato.applications.store'), {
        preserveScroll: true,
        onSuccess: () => {
            modal.value = false;
            form.reset('cover_letter');
        },
    });
}

const STATUS_CONFIG = {
    Aplicado: {
        label: 'Pendiente de revisión',
        pill: 'bg-yellow-100 text-yellow-800',
    },
    'En Revisión': {
        label: 'En revisión',
        pill: 'bg-blue-100 text-blue-700',
    },
    Entrevista: {
        label: 'Convocado a entrevista',
        pill: 'bg-purple-100 text-purple-700',
    },
    Rechazado: {
        label: 'No seleccionado',
        pill: 'bg-red-100 text-red-600',
    },
    Contratado: {
        label: 'Seleccionado',
        pill: 'bg-green-100 text-green-700',
    },
};

function statusLabel(status) {
    return STATUS_CONFIG[status]?.label ?? status;
}

function pillClass(status) {
    return STATUS_CONFIG[status]?.pill ?? 'bg-slate-100 text-slate-600';
}
</script>

<style scoped>
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}
</style>