<script setup>
import { computed, ref } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { useJobUtils } from '@/composables/useJobUtils';

const { formatMoney, timeAgo } = useJobUtils();

const props = defineProps({
    job: {
        type: Object,
        required: true,
    },
});

const page = usePage();

const user = computed(() => page.props.auth?.user ?? null);
const isAuthenticated = computed(() => !!user.value);
const isReclutador = computed(() => !!user.value?.isReclutador);
const isCandidato = computed(() => !!user.value?.isCandidato);

const modal = ref(false);

const form = useForm({
    job_id: props.job.id,
    cover_letter: '',
});

function abrirModal() {
    modal.value = true;
}

function cerrarModal() {
    modal.value = false;
    form.clearErrors();
}

function submitAplicacion() {
    form.post(route('jobs.apply', props.job.id), {
        preserveScroll: true,
        onSuccess: () => {
            modal.value = false;
            form.reset('cover_letter');
        },
    });
}
</script>

<template>
    <PublicLayout>
        <template #header>
            <div>
                <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                    Detalle de oferta
                </p>

                <h1 class="mt-1 truncate text-xl font-black text-slate-950">
                    {{ job.name_job }}
                </h1>
            </div>
        </template>

        <div class="space-y-8">
            <!-- Breadcrumb -->
            <nav class="flex flex-wrap items-center gap-2 text-sm font-medium text-slate-500">
                <Link :href="route('jobs.index')" class="transition hover:text-red-600">
                    Ofertas
                </Link>

                <span>/</span>

                <span class="text-slate-800">
                    {{ job.name_job }}
                </span>
            </nav>

            <!-- Hero -->
            <section
                class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 px-6 py-8 text-white shadow-2xl shadow-slate-300/50 sm:px-8 lg:px-10">
                <div
                    class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-red-600/30 blur-3xl">
                </div>

                <div
                    class="pointer-events-none absolute -bottom-24 left-10 h-72 w-72 rounded-full bg-blue-600/20 blur-3xl">
                </div>

                <div class="relative grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                    <div>
                        <div
                            class="mb-5 inline-flex rounded-full bg-red-600/20 px-4 py-2 text-xs font-black uppercase tracking-[0.22em] text-red-100 ring-1 ring-red-400/20">
                            Vacante disponible
                        </div>

                        <h2 class="max-w-3xl text-3xl font-black leading-tight tracking-tight sm:text-4xl">
                            {{ job.name_job }}
                        </h2>

                        <!--<div class="mt-5 flex flex-wrap gap-2">
                            <span
                                class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-3 py-2 text-xs font-bold text-slate-100 ring-1 ring-white/10">
                                <svg class="h-4 w-4 text-red-300" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 21s7-5.2 7-11a7 7 0 1 0-14 0c0 5.8 7 11 7 11Z" stroke="currentColor"
                                        stroke-width="1.8" />
                                    <path d="M12 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" stroke="currentColor"
                                        stroke-width="1.8" />
                                </svg>

                                {{ job.branch?.name ?? 'Sin sede' }}
                            </span>

                            <span
                                class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-3 py-2 text-xs font-bold text-slate-100 ring-1 ring-white/10">
                                <svg class="h-4 w-4 text-red-300" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M12 3v18M17 7.5A4.5 4.5 0 0 0 12 5a4 4 0 0 0-4 4c0 2.2 1.8 3 4 3s4 .8 4 3a4 4 0 0 1-4 4 4.5 4.5 0 0 1-5-2.5"
                                        stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                                </svg>

                                $ {{ formatMoney(job.salary) }}
                            </span>

                            <span
                                class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-3 py-2 text-xs font-bold text-slate-100 ring-1 ring-white/10">
                                <svg class="h-4 w-4 text-red-300" viewBox="0 0 24 24" fill="none">
                                    <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" stroke="currentColor"
                                        stroke-width="1.8" stroke-linecap="round" />
                                    <path d="M4 9a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9Z"
                                        stroke="currentColor" stroke-width="1.8" />
                                </svg>

                                {{ job.contract_type }}
                            </span>

                            <span
                                class="inline-flex items-center gap-2 rounded-2xl bg-white/10 px-3 py-2 text-xs font-bold text-slate-100 ring-1 ring-white/10">
                                Publicado {{ timeAgo(job.created_at) }}
                            </span>
                        </div>-->
                    </div>

                    <!-- Acción principal -->
                    <div class="w-full lg:w-72">
                        <div class="rounded-3xl bg-white/10 p-4 shadow-xl ring-1 ring-white/10 backdrop-blur">
                            <Link v-if="isReclutador" :href="route('reclutador.jobs.show', job.id)"
                                class="inline-flex w-full items-center justify-center rounded-2xl bg-red-600 px-5 py-3.5 text-sm font-black text-white shadow-lg shadow-red-900/30 transition hover:bg-red-700">
                                Modificar oferta
                            </Link>

                            <button v-else-if="isCandidato" type="button"
                                class="inline-flex w-full items-center justify-center rounded-2xl bg-red-600 px-5 py-3.5 text-sm font-black text-white shadow-lg shadow-red-900/30 transition hover:bg-red-700"
                                @click="abrirModal">
                                Aplicar ahora
                            </button>

                            <Link v-else :href="route('login', { redirect: route('jobs.show', job.id) })"
                                class="inline-flex w-full items-center justify-center rounded-2xl bg-red-600 px-5 py-3.5 text-sm font-black text-white shadow-lg shadow-red-900/30 transition hover:bg-red-700">
                                Iniciar sesión para aplicar
                            </Link>

                            <p v-if="!isAuthenticated" class="mt-4 text-center text-xs leading-5 text-slate-300">
                                ¿No tienes cuenta?
                                <Link :href="route('register')" class="font-bold text-red-200 hover:underline">
                                    Regístrate gratis
                                </Link>
                            </p>
                        </div>
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

                <!-- Resumen lateral -->
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

                    <div class="rounded-[2rem] border border-red-100 bg-red-50 p-5">
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
                        <label class="block text-sm font-black text-slate-800" for="cover_letter">
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
    </PublicLayout>
</template>