<template>
    <AuthenticatedLayout>
        <template #header>
            <div>
                <!--<p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                    Portal del reclutador
                </p>-->

                <h2 class="mt-1 text-xl font-black uppercase tracking-tight text-slate-950">
                    Editar oferta laboral
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
                    <Link :href="route('reclutador.jobs.index')" class="transition hover:text-red-600">
                        Ofertas
                    </Link>

                    <span>/</span>

                    <Link :href="route('reclutador.jobs.show', job.id)" class="transition hover:text-red-600">
                        {{ job.name_job }}
                    </Link>

                    <span>/</span>

                    <span class="text-slate-800">
                        Editar
                    </span>
                </nav>

                <!-- Flash success -->
                <div v-if="$page.props.flash?.success"
                    class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-700 shadow-sm">
                    {{ $page.props.flash.success }}
                </div>

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
                                Actualización de vacante
                            </div>

                            <h1 class="max-w-3xl text-3xl font-black leading-tight tracking-tight sm:text-4xl">
                                Edita la información de esta oferta laboral.
                            </h1>

                            <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-300">
                                Ajusta los datos de la vacante, cambia su estado o actualiza la descripción para
                                mantener
                                informados a los candidatos.
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
                                        Edición activa
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-300">
                                        El guardado automático permanece activo si tu formulario lo tiene configurado.
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
                            Modificar oferta
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Realiza los cambios necesarios y guarda la información.
                        </p>
                    </div>

                    <div class="p-6">
                        <JobForm :model-value="job" :branches="branches" submit-text="Guardar cambios"
                            :action="route('reclutador.jobs.update', job.id)" method="put" :autosave-enabled="true" />
                    </div>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import JobForm from '@/Components/JobForm.vue';

defineProps({
    job: { type: Object, required: true },
    branches: { type: Array, default: () => [] },
});
</script>

<style scoped>
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}
</style>