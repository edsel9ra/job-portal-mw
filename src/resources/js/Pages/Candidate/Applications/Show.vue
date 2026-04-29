<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                        Proceso de aplicación
                    </p>

                    <h2 class="mt-1 truncate text-xl font-black uppercase tracking-tight text-slate-950">
                        {{ aplicacion.job?.name_job }}
                    </h2>
                </div>

                <!--<Link :href="route('candidato.applications.index')"
                    class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-600">
                    ← Mis aplicaciones
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
                <!-- Breadcrumb -->
                <nav class="flex flex-wrap items-center gap-2 text-sm font-medium text-slate-500">
                    <Link :href="route('candidato.applications.index')" class="transition hover:text-red-600">
                        Mis aplicaciones
                    </Link>

                    <span>/</span>

                    <span class="text-slate-800">
                        {{ aplicacion.job?.name_job }}
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

                    <div class="relative grid gap-6 lg:grid-cols-[1fr_320px] lg:items-center">
                        <div>
                            <div class="mb-5 flex flex-wrap gap-2">
                                <!--<span
                                    class="inline-flex rounded-full bg-red-600/20 px-4 py-2 text-xs font-black uppercase tracking-[0.22em] text-red-100 ring-1 ring-red-400/20">
                                    Trazabilidad del proceso
                                </span>-->

                                <!--<span class="inline-flex rounded-full px-4 py-2 text-xs font-black ring-1"
                                    :class="statusPillClass(aplicacion.status)">
                                    {{ statusLabel(aplicacion.status) }}
                                </span>-->
                            </div>

                            <h1 class="max-w-3xl text-3xl font-black leading-tight tracking-tight sm:text-4xl">
                                {{ aplicacion.job?.name_job }}
                            </h1>

                            <div class="mt-5 flex flex-wrap gap-2">
                                <span
                                    class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-3 py-2 text-xs font-bold text-slate-100 ring-1 ring-white/10">
                                    <span class="material-symbols-outlined text-[16px] text-red-300">location_on</span>
                                    {{ aplicacion.job?.branch?.name ?? 'Sin sede' }}
                                </span>

                                <span v-if="aplicacion.job?.salary"
                                    class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-3 py-2 text-xs font-bold text-slate-100 ring-1 ring-white/10">
                                    <span class="material-symbols-outlined text-[16px] text-red-300">payments</span>
                                    $ {{ formatMoney(aplicacion.job?.salary) }}
                                </span>

                                <span v-if="aplicacion.job?.contract_type"
                                    class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-3 py-2 text-xs font-bold text-slate-100 ring-1 ring-white/10">
                                    <span class="material-symbols-outlined text-[16px] text-red-300">work</span>
                                    {{ aplicacion.job?.contract_type }}
                                </span>
                            </div>
                        </div>

                        <div class="rounded-3xl bg-white/10 p-5 shadow-xl ring-1 ring-white/10 backdrop-blur">
                            <p class="text-sm font-black text-white">
                                Estado actual
                            </p>

                            <div class="mt-3 rounded-2xl bg-white/10 px-4 py-4 ring-1 ring-white/10">
                                <p class="text-2xl font-black text-white">
                                    {{ statusLabel(aplicacion.status) }}
                                </p>

                                <p class="mt-2 text-xs leading-5 text-slate-300">
                                    Aplicaste {{ timeAgo(aplicacion.applied_at) }}
                                    <span v-if="aplicacion.reviewed_at">
                                        · Revisado {{ timeAgo(aplicacion.reviewed_at) }}
                                    </span>
                                </p>
                            </div>

                            <Link :href="route('candidato.jobs.show', aplicacion.job_id)"
                                class="mt-4 inline-flex w-full items-center justify-center rounded-2xl bg-red-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-red-900/30 transition hover:bg-red-700">
                                Ver oferta
                                <span class="ml-2">→</span>
                            </Link>

                            <button v-if="['Aplicado'].includes(aplicacion.status)"
                                class="mt-4 inline-flex w-full items-center justify-center rounded-2xl bg-red-600 px-5 py-3 text-sm font-black text-white shadow-lg shadow-red-900/30 transition hover:bg-red-700"
                                @click="retirarModal = true">
                                Retirar aplicación
                            </button>
                        </div>
                    </div>
                </section>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <!-- Timeline -->
                    <section class="lg:col-span-2">
                        <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                            <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
                                <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                    Seguimiento
                                </p>

                                <h3 class="mt-2 text-xl font-black text-slate-950">
                                    Trazabilidad del proceso
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Estado de tu postulación dentro del proceso de selección.
                                </p>
                            </div>

                            <div class="px-6 py-6">
                                <div class="relative">
                                    <div v-if="pasos.length > 1" class="absolute left-5 top-5 w-0.5 bg-slate-200"
                                        :style="{ height: `calc(100% - 40px)` }"></div>

                                    <div>
                                        <div v-for="(paso, index) in pasos" :key="index"
                                            class="relative flex gap-4 pb-7 last:pb-0">
                                            <!-- Ícono -->
                                            <div class="relative z-10 flex-shrink-0">
                                                <div class="flex h-10 w-10 items-center justify-center rounded-2xl shadow-sm"
                                                    :class="stepCircleClass(paso.estado)">
                                                    <span v-if="paso.estado === 'completado'"
                                                        class="material-symbols-outlined text-[20px]">
                                                        check
                                                    </span>

                                                    <span v-else-if="paso.estado === 'rechazado'"
                                                        class="material-symbols-outlined text-[20px]">
                                                        close
                                                    </span>

                                                    <span v-else-if="paso.estado === 'activo'"
                                                        class="material-symbols-outlined animate-pulse text-[20px]">
                                                        radio_button_checked
                                                    </span>

                                                    <span v-else class="material-symbols-outlined text-[20px]">
                                                        radio_button_unchecked
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Contenido -->
                                            <div class="min-w-0 flex-1">
                                                <div class="rounded-3xl border px-5 py-4"
                                                    :class="stepCardClass(paso.estado)">
                                                    <div
                                                        class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                                        <div>
                                                            <p class="text-sm font-black"
                                                                :class="stepTitleClass(paso.estado)">
                                                                {{ paso.titulo }}
                                                            </p>

                                                            <p class="mt-1 text-sm leading-6"
                                                                :class="stepTextClass(paso.estado)">
                                                                {{ paso.descripcion }}
                                                            </p>

                                                            <div v-if="paso.estado === 'rechazado' && aplicacion.rejection_reason"
                                                                class="mt-3 rounded-2xl border border-red-100 bg-red-50 px-4 py-3 text-sm leading-6 text-red-700">
                                                                <span class="font-black">Motivo:</span>
                                                                {{ aplicacion.rejection_reason }}
                                                            </div>

                                                            <div v-if="paso.estado === 'activo'" class="mt-3">
                                                                <!--<Link
                                                                    :href="route('candidato.jobs.show', aplicacion.job_id)"
                                                                    class="inline-flex rounded-2xl bg-red-600 px-4 py-2.5 text-xs font-black text-white shadow-lg shadow-red-600/20 transition hover:bg-red-700">
                                                                    Ver oferta →
                                                                </Link>-->
                                                            </div>
                                                        </div>

                                                        <span class="text-xs font-bold"
                                                            :class="paso.fecha ? 'text-slate-400' : 'text-slate-300 italic'">
                                                            {{ paso.fecha ? formatFecha(paso.fecha) : 'Pendiente' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Carta de presentación -->
                        
                    </section>

                    <!-- Aside -->
                    <aside class="space-y-4 lg:sticky lg:top-6 lg:self-start">
                        <!--div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-400">
                                Cargo
                            </p>

                            <p class="mt-2 text-lg font-black text-slate-950">
                                {{ aplicacion.job?.name_job }}
                            </p>
                        </div>

                        <div class="rounded-[2rem] border border-slate-200 bg-white p-5 shadow-sm">
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-400">
                                Sede
                            </p>

                            <p class="mt-2 text-lg font-black text-slate-950">
                                {{ aplicacion.job?.branch?.name ?? 'Sin sede' }}
                            </p>
                        </div>

                        <div 
                            class="rounded-[2rem] border border-red-100 bg-red-50 p-5">
                            <p class="text-sm font-black text-red-700">
                                Retirar postulación
                            </p>

                            <p class="mt-2 text-sm leading-6 text-red-700/80">
                                Puedes retirar esta aplicación mientras aún está pendiente de revisión.
                            </p>
                        </div>-->

                        <div v-if="aplicacion.cover_letter"
                            class="mt-6 overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                            <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
                                <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                    Carta de presentación
                                </p>
                            </div>

                            <div class="px-6 py-6">
                                <p class="text-sm italic leading-7 text-slate-600">
                                    “{{ aplicacion.cover_letter }}”
                                </p>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>

        <!-- Modal retirar -->
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
                                Esta acción no se puede deshacer.
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
                        ¿Seguro que deseas retirar esta postulación?
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
    aplicacion: { type: Object, required: true },
});

const PIPELINE = [
    {
        status: 'Aplicado',
        titulo: 'Postulación enviada',
        descripcion: 'Tu currículum fue recibido y está pendiente de revisión.',
    },
    {
        status: 'En Revisión',
        titulo: 'Revisión de currículum',
        descripcion: 'El equipo de RRHH está revisando tu perfil.',
    },
    {
        status: 'Entrevista',
        titulo: 'Entrevista',
        descripcion: 'Has sido convocado a una entrevista.',
    },
    {
        status: 'Contratado',
        titulo: 'Seleccionado',
        descripcion: 'Has sido seleccionado para el cargo.',
    },
];

const pasos = computed(() => {
    const status = props.aplicacion.status;
    const esRechazado = status === 'Rechazado';
    const indexActual = PIPELINE.findIndex((paso) => paso.status === status);

    const pipeline = esRechazado
        ? [
            ...PIPELINE.slice(0, Math.max(indexActual, 1)),
            {
                status: 'Rechazado',
                titulo: 'Proceso descartado',
                descripcion: 'El proceso no continuó.',
            },
        ]
        : PIPELINE;

    return pipeline.map((paso, index) => {
        if (esRechazado) {
            if (index < pipeline.length - 1) {
                return {
                    ...paso,
                    estado: 'completado',
                    fecha: fechaDePaso(paso.status),
                };
            }

            return {
                ...paso,
                estado: 'rechazado',
                fecha: props.aplicacion.reviewed_at,
            };
        }

        if (status === 'Contratado') {
            if (index <= indexActual) {
                return {
                    ...paso,
                    estado: 'completado',
                    fecha: fechaDePaso(paso.status),
                };
            }

            return {
                ...paso,
                estado: 'pendiente',
                fecha: null,
            };
        }

        if (index < indexActual) {
            return {
                ...paso,
                estado: 'completado',
                fecha: fechaDePaso(paso.status),
            };
        }

        if (index === indexActual) {
            return {
                ...paso,
                estado: 'activo',
                fecha: fechaDePaso(paso.status),
            };
        }

        return {
            ...paso,
            estado: 'pendiente',
            fecha: null,
        };
    });
});

function fechaDePaso(status) {
    if (status === 'Aplicado') {
        return props.aplicacion.applied_at;
    }

    return props.aplicacion.reviewed_at ?? null;
}

function formatFecha(dateStr) {
    if (!dateStr) return '';

    const date = new Date(dateStr);

    return date.toLocaleDateString('es-ES', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
}

const retirarModal = ref(false);
const procesando = ref(false);

function confirmRetirar() {
    procesando.value = true;

    router.delete(route('candidato.applications.destroy', props.aplicacion.id), {
        preserveScroll: true,
        onFinish: () => {
            procesando.value = false;
            retirarModal.value = false;
        },
    });
}

const STATUS_CONFIG = {
    Aplicado: {
        label: 'Aplicado',
        pill: 'bg-yellow-100 text-yellow-800 ring-yellow-200',
    },
    'En Revisión': {
        label: 'En revisión',
        pill: 'bg-blue-100 text-blue-700 ring-blue-200',
    },
    Entrevista: {
        label: 'Entrevista',
        pill: 'bg-purple-100 text-purple-700 ring-purple-200',
    },
    Rechazado: {
        label: 'Rechazado',
        pill: 'bg-red-100 text-red-600 ring-red-200',
    },
    Contratado: {
        label: 'Contratado',
        pill: 'bg-green-100 text-green-700 ring-green-200',
    },
};

function statusLabel(status) {
    return STATUS_CONFIG[status]?.label ?? status;
}

function statusPillClass(status) {
    return STATUS_CONFIG[status]?.pill ?? 'bg-slate-100 text-slate-600 ring-slate-200';
}

function stepCircleClass(status) {
    const classes = {
        completado: 'bg-green-600 text-white shadow-green-200',
        activo: 'bg-blue-600 text-white shadow-blue-200',
        rechazado: 'bg-red-600 text-white shadow-red-200',
        pendiente: 'bg-slate-100 text-slate-400 ring-1 ring-slate-200',
    };

    return classes[status] ?? classes.pendiente;
}

function stepCardClass(status) {
    const classes = {
        completado: 'border-green-100 bg-green-50/70',
        activo: 'border-blue-100 bg-blue-50/70',
        rechazado: 'border-red-100 bg-red-50',
        pendiente: 'border-slate-100 bg-slate-50',
    };

    return classes[status] ?? classes.pendiente;
}

function stepTitleClass(status) {
    const classes = {
        completado: 'text-green-800',
        activo: 'text-blue-700',
        rechazado: 'text-red-700',
        pendiente: 'text-slate-400',
    };

    return classes[status] ?? classes.pendiente;
}

function stepTextClass(status) {
    const classes = {
        completado: 'text-green-700',
        activo: 'text-blue-700/80',
        rechazado: 'text-red-700/80',
        pendiente: 'text-slate-400',
    };

    return classes[status] ?? classes.pendiente;
}
</script>

<style scoped>
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}
</style>